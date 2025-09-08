<?php
declare(strict_types=1);

/**
 * Input helpers (do NOT rely on DB escaping; use prepared statements)
 * Kept compatible with legacy usage.
 */

if (!function_exists('anti_inj')) {
    function anti_inj($data): string {
        // Normalize to string
        $data = is_array($data) ? '' : (string) $data;
        $data = strip_tags($data);
        $data = trim($data);

        if ($data === '%') {
            return 'Kata Kunci Salah';
        }

        // If a DB connection exists, reuse its escaping for legacy SQL usage.
        if (isset($GLOBALS['con']) && $GLOBALS['con'] instanceof mysqli) {
            return $GLOBALS['con']->real_escape_string($data);
        }

        return $data;
    }
}

if (!function_exists('anti_xss')) {
    function anti_xss($data): string {
        $data = is_array($data) ? '' : (string) $data;
        return htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('no_xss')) {
    function no_xss($data): string {
        $data = is_array($data) ? '' : (string) $data;
        // Keep only text; handy for routing parts
        return strip_tags($data);
    }
}
