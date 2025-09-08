<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Past code relied on a 'valid' constant; harden for PHP 8:
if (!defined('valid') || valid !== '1') {
    // Optional: allow through if user already authenticated
    if (empty($_SESSION['ses_user']) || empty($_SESSION['ses_level'])) {
        header('Location:  /login');
	exit;
        exit;
    }
}

$globalvar = [];
$globalvar['news'] = 'read';
$globalvar['page'] = 'page';
$globalvar['cat']  = 'cat';
