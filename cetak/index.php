<?php
declare(strict_types=1);
 

ob_start();	
session_start();

	if (empty($_SESSION['ses_user']) AND empty($_SESSION['ses_pass']) AND empty($_SESSION['ses_level']) ){
		header('Location:  /login');
	exit;
		exit;
	}
	else {

		include "../timeout.php";

		if($_SESSION['ses_login']==1){
			if(!validation()){
				$_SESSION['ses_login'] = 0;
			}
		}

		if($_SESSION['ses_login']==0){
			header('Location: /logout');
	exit;
		}

		else {
	
		define('valid','1');
		include "../config/library.php";
		include "../config/date.php";
		include "../config/anti_inj.php";
		include "../config/db.php";
		$url = no_xss($_SERVER['REQUEST_URI']);
		$folder = explode("/",$url);
		$jumlah_folder = count($folder);
		$http = 'http:/';

		$seo_folder = $jumlah_folder - 1;
		if($jumlah_folder>'1') {
			$module = $folder['2'] ;
			$seo = $folder[$seo_folder];
		}

		if($folder['2']=='') {
			$module = 'dashboard';
		}
		else {
			$module = $folder['2'];
		}


						if ($module=='kinerja'){
							include "../module/content/kinerja/cetak.php";
						}
						elseif ($module=='pantaukinerja'){
							include "../module/content/pantaukinerja/cetak.php";
						}
						elseif ($module=='pantauproker'){
							include "../module/content/pantauproker/cetak.php";
						}
						elseif ($module=='proker'){
							include "../module/content/proker/cetak.php";
						}
						elseif ($module=='catatan'){
							include "../module/content/catatan/cetak.php";
						}
						elseif ($module=='agenda_kerja'){
							include "../module/content/proker/agenda.php";
						}

						else {
							include "../module/content/error/404.php";
						}



		
		
		
		
		}

}
?>