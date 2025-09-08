<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Harden legacy 'valid' check for PHP 8
if (!defined('valid') || valid !== '1') {
    if (empty($_SESSION['ses_user']) || empty($_SESSION['ses_level'])) {
        header('Location:  /login');
        exit;
    }
}

$url = no_xss($_SERVER['REQUEST_URI'] ?? '/');
$folder = explode('/', $url);
$jumlah_folder = count($folder);
$http = 'http:/';
// TODO: move this to a config/env file
$surat = 'http://asamurat2.upmk.ac.id';

$seo_folder = $jumlah_folder - 1;
if ($jumlah_folder > 1) {
    $module = $folder[1] ?? '';
    $seo = $folder[$seo_folder] ?? '';
}

if (empty($folder[1])) {
    $module = 'dashboard';
} else {
    $module = $folder[1];
}
