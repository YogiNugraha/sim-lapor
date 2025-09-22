<?php

ob_start();

if (empty($_SESSION['ses_user']) and empty($_SESSION['ses_pass']) and empty($_SESSION['ses_level'])) {
	header('location:/login');
} else {
?>


<?php

	$action = isset($folder[2]) ? $folder[2] : 'default';

	switch ($action) {

		default:
			include "submit.php";
			break;

		case 'masuk':
			include "masuk.php";
			break;

		case 'edit':
			include "edit.php";
			break;
	}
}
?>