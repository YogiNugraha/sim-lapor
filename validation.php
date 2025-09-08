<?php

declare(strict_types=1);

define('valid', '1');

require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/config/anti_inj.php";
require_once __DIR__ . "/config/library.php";
require_once __DIR__ . "/timeout.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

// Basic input retrieval with fallback
$inputUser = $_POST['username'] ?? '';
$inputPass = $_POST['password'] ?? '';
$inputCaptcha = $_POST['captcha'] ?? '';

$username = anti_inj($inputUser);
$plainPassword = (string) $inputPass; // keep original for hashing comparison

// Validate captcha
if (!isset($_SESSION['captcha']) || $inputCaptcha !== $_SESSION['captcha']) {
    header('Location:  /login?m=captcha');
    exit;
}

// Lookup user (excluding certain levels, keep legacy behavior)
try {
    $stmt = $con->prepare("SELECT username, name, password, level, active, bp FROM user WHERE username = ? AND level NOT IN ('mahasiswa','dosen') LIMIT 1");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res ? $res->fetch_assoc() : null;
} catch (Throwable $e) {
    // Avoid leaking details
    header('Location:  /login?m=error');
    exit;
    exit;
}

if ($user) {
    // Legacy: compare against md5 hash stored in DB
    $inputHash = md5($plainPassword);
    if (isset($user['password']) && hash_equals((string)$user['password'], $inputHash)) {
        if (!empty($user['active']) && (string)$user['active'] === '1') {
            // Success: set session state
            $_SESSION['ses_user']  = (string)$user['username'];
            $_SESSION['ses_name']  = (string)($user['name'] ?? '');
            $_SESSION['ses_pass']  = (string)$user['password'];
            $_SESSION['ses_level'] = (string)($user['level'] ?? '');
            $_SESSION['ses_ip']    = $ip;
            $_SESSION['ses_login'] = 1;

            // Start/refresh inactivity timer
            if (!function_exists('timer')) {
                function timer()
                {
                    $_SESSION['ses_timeout'] = time() + 200000;
                }
            }
            timer();

            header('Location:  /dashboard');
            exit;
        } else {
            header('Location:  /login?m=not_active');
            exit;
        }
    } else {
        header('Location:  /login?m=wrong');
        exit;
    }
}

// User not found
header('Location:  /login?m=wrong');
exit;
