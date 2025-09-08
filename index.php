<?php

declare(strict_types=1);

// Report simple running errors
error_reporting(E_ERROR | E_PARSE);

ob_start();
session_start();

if (empty($_SESSION['ses_user']) and empty($_SESSION['ses_pass']) and empty($_SESSION['ses_level'])) {
	header('Location:  /login');
	exit;
} else {

	include "timeout.php";

	if ($_SESSION['ses_login'] == 1) {
		if (!validation()) {
			$_SESSION['ses_login'] = 0;
		}
	}

	if ($_SESSION['ses_login'] == 0) {
		header('Location:  /logout');
		exit;
	} else {

		define('valid', '1');

		include "config/anti_inj.php";


		include "config/db.php";
		include "config/date.php";
		include "config/library.php";
		include "config/system.php";
		include "config/time_stamp.php";
		include "config/config.php";
		include "config/combobox.php";
		include "template/adminlte/template.php";
	}
}
