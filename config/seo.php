<?php
declare(strict_types=1);




if (empty($_SESSION['ses_user']) AND empty($_SESSION['ses_pass']) AND empty($_SESSION['ses_level']) ){

	header('Location: /login');
	exit;

}



else {



	function seo_title($s) {

		$c = array (' ');

		$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');



		$s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d

    

		$s = strtolower(str_replace($c, '.', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua

		return $s;

	}



}



?>