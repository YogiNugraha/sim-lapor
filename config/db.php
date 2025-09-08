<?php
declare(strict_types=1);

/**
 * Database bootstrap (PHP 8 compatible)
 * - Uses mysqli with strict error reporting
 * - Sets utf8mb4 charset
 * - Exposes $con (mysqli) for backward compatibility
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ---- Configure here (or via environment variables) ----
$DB_HOST = getenv('DB_HOST') ?: 'localhost';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: '';
$DB_NAME = getenv('DB_NAME') ?: 'akreditasi';
$DB_PORT = (int) (getenv('DB_PORT') ?: 3306);
$DB_CHARSET = getenv('DB_CHARSET') ?: 'utf8mb4';

// Back-compat: keep old constant names if some legacy code references them
if (!defined('host')) { define('host', $DB_HOST); }
if (!defined('user')) { define('user', $DB_USER); }
if (!defined('pass')) { define('pass', $DB_PASS); }
if (!defined('dbase')) { define('dbase', $DB_NAME); }

// Turn on mysqli exceptions (PHP 8 best practice)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);
    if (!@$con->set_charset($DB_CHARSET)) {
        // Fallback to utf8 if utf8mb4 is not available
        @$con->set_charset('utf8');
    }
} catch (Throwable $e) {
    http_response_code(500);
    // Avoid leaking credentials
    die('Database connection failed.');
}

// Helper for getting the connection (optional)
if (!function_exists('db')) {
    /**
     * @return mysqli
     */
    function db(): mysqli {
        /** @var mysqli $con */
        global $con;
        return $con;
    }
}
