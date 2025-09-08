<?php
declare(strict_types=1);

session_start();
if (empty($_SESSION['ses_user']) || empty($_SESSION['ses_level'])) {
    http_response_code(403);
    exit('Forbidden');
}
phpinfo();
