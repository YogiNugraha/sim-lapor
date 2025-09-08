<?php
declare(strict_types=1);
 

ob_start();	

	if (empty($_SESSION['ses_user']) AND empty($_SESSION['ses_pass']) AND empty($_SESSION['ses_level']) ){
		header('Location: /login');
	exit;
	}
	else {
	
		define('valid','1');	


		if($folder['2']=='kinerja') {
			$id		= mysqli_real_escape_string($con,$folder['3']);

			mysqli_query($con,"DELETE FROM indikator WHERE id='$id' AND valid!='2' AND unit='$_SESSION[ses_user]' LIMIT 1 ");

			header('Location: /kinerja/?m=deleted');
	exit;
		}
		
		elseif($folder['2']=='proker') {
			$id		= mysqli_real_escape_string($con,$folder['3']);

			mysqli_query($con,"DELETE FROM proker WHERE id='$id' AND valid!='2' LIMIT 1 ");

			header('Location: /proker/?m=deleted');
	exit;
		}

		elseif($folder['2']=='catatan') {
			$id		= mysqli_real_escape_string($con,$folder['3']);

			mysqli_query($con,"DELETE FROM catatan WHERE id='$id' LIMIT 1 ");

			header('Location: /catatan/?m=deleted');
	exit;
		}

		
		elseif($folder['2']=='suratmasuk') {
			$id		= mysqli_real_escape_string($con,$folder['3']);
			mysqli_query($con,"DELETE FROM suratmasuk WHERE id='$id' AND tujuan='$_SESSION[ses_user]' LIMIT 1 ");
			header('Location: /suratmasuk/jenis/'.$folder[4].'/?m=deleted');
	exit;
		}

		elseif($folder['2']=='suratkeluar') {
			$id		= mysqli_real_escape_string($con,$folder['3']);
			mysqli_query($con,"DELETE FROM suratkeluar WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1 ");
			header('Location: /suratkeluar/jenis/'.$folder[4].'/?m=deleted');
	exit;
		}
		
		elseif($folder['2']=='tgs') {
			$id		= mysqli_real_escape_string($con,$folder['3']);
			mysqli_query($con,"DELETE FROM tgs WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1 ");
			header('Location: /tgs/jenis/'.$folder[4].'/?m=deleted');
	exit;
		}
		
		elseif($folder['2']=='ins') {
			$id		= mysqli_real_escape_string($con,$folder['3']);
			mysqli_query($con,"DELETE FROM ins WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1 ");
			header('Location: /ins/jenis/'.$folder[4].'/?m=deleted');
	exit;
		}

		elseif($folder['2']=='edr') {
			$id		= mysqli_real_escape_string($con,$folder['3']);
			mysqli_query($con,"DELETE FROM edr WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1 ");
			header('Location: /edr/jenis/'.$folder[4].'/?m=deleted');
	exit;
		}

		elseif($folder['2']=='mlm') {
			$id		= mysqli_real_escape_string($con,$folder[3]);
			mysqli_query($con,"DELETE FROM mlm WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1 ");
			header('Location: /mlm/jenis/'.$folder[4].'/?m=deleted');
	exit;
		}

		elseif($folder['2']=='per') {
			$id		= mysqli_real_escape_string($con,$folder['3']);
			mysqli_query($con,"DELETE FROM per WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1 ");
			header('Location: /per/jenis/'.$folder[4].'/?m=deleted');
	exit;
		}

		elseif($folder['2']=='ket') {
			$id		= mysqli_real_escape_string($con,$folder['3']);
			mysqli_query($con,"DELETE FROM ket WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1 ");
			header('Location: /ket/jenis/'.$folder[4].'/?m=deleted');
	exit;
		}

		elseif($folder['2']=='rek') {
			$id		= mysqli_real_escape_string($con,$folder['3']);
			mysqli_query($con,"DELETE FROM rek WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1 ");
			header('Location: /rek/jenis/'.$folder[4].'/?m=deleted');
	exit;
		}

		elseif($folder['2']=='lapor') {
			$id		= mysqli_real_escape_string($con,$folder['3']);
			mysqli_query($con,"DELETE FROM lapor WHERE id='$id' AND user='$_SESSION[ses_user]' LIMIT 1 ");
			header('Location: /lapor/submit/?m=deleted');
	exit;
		}






	}
?>