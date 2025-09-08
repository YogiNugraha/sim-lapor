<?php

declare(strict_types=1);


ob_start();

if (empty($_SESSION['ses_user']) and empty($_SESSION['ses_pass']) and empty($_SESSION['ses_level'])) {
	header('Location: /login');
	exit;
} else {

	define('valid', '1');
	include "config/upload.php";

	if ($folder['2'] == 'kinerja') {
		$id		= mysqli_real_escape_string($con, $_POST['id']);
		$jenis	= mysqli_real_escape_string($con, $_POST['jenis']);
		$nama	= mysqli_real_escape_string($con, $_POST['nama']);
		$standar = mysqli_real_escape_string($con, $_POST['standar']);

		$topik = mysqli_real_escape_string($con, $_POST['topik']);
		$kriteria = mysqli_real_escape_string($con, $_POST['kriteria']);
		$skala = mysqli_real_escape_string($con, $_POST['skala']);

		$capaian_before	= mysqli_real_escape_string($con, $_POST['capaian_before']);
		$target_after	= mysqli_real_escape_string($con, $_POST['target_after']);

		mysqli_query($con, "UPDATE indikator SET nama='$nama', standar='$standar', capaian_before='$capaian_before', target_after='$target_after', valid='1', topik='$topik', kriteria='$kriteria', skala='$skala' WHERE id='$id' AND unit='$_SESSION[ses_user]' AND valid!='2' ");

		header('Location: /kinerja/?m=updated');
		exit;
	} elseif ($folder['2'] == 'proker') {
		$id = mysqli_real_escape_string($con, $_POST['id']);
		$id_indikator	= mysqli_real_escape_string($con, $_POST['id_indikator']);
		$bentuk	= mysqli_real_escape_string($con, $_POST['bentuk']);
		$deskripsi = mysqli_real_escape_string($con, $_POST['deskripsi']);
		$waktu_mulai	= mysqli_real_escape_string($con, $_POST['waktu_mulai']);
		$waktu_selesai	= mysqli_real_escape_string($con, $_POST['waktu_selesai']);
		$sasaran	= mysqli_real_escape_string($con, $_POST['sasaran']);
		$tujuan	= mysqli_real_escape_string($con, $_POST['tujuan']);
		$anggaran	= mysqli_real_escape_string($con, $_POST['anggaran']);
		$kebijakan	= mysqli_real_escape_string($con, $_POST['kebijakan']);
		$luaran	= mysqli_real_escape_string($con, $_POST['luaran']);

		mysqli_query($con, "UPDATE proker SET id_indikator='$id_indikator',bentuk='$bentuk',deskripsi='$deskripsi',waktu_mulai='$waktu_mulai',waktu_selesai='$waktu_selesai',sasaran='$sasaran',tujuan='$tujuan',anggaran='$anggaran',kebijakan='$kebijakan',luaran='$luaran',valid='1' WHERE id='$id' AND valid!='2222' ");

		header('Location: /proker/?m=updated');
		exit;
	} elseif ($folder['2'] == 'catatan') {
		$id = mysqli_real_escape_string($con, $_POST['id']);
		$capaian	= mysqli_real_escape_string($con, $_POST['capaian']);
		$id_indikator	= mysqli_real_escape_string($con, $_POST['id_indikator']);
		$upaya	= mysqli_real_escape_string($con, $_POST['upaya']);
		$kendala = mysqli_real_escape_string($con, $_POST['kendala']);
		$rtl	= mysqli_real_escape_string($con, $_POST['rtl']);

		$lokasi_file = $_FILES['fupload']['tmp_name'];
		$file   = $_FILES['fupload']['name'];
		$time = time();
		$file_extension = strtolower(substr(strrchr($file, "."), 1));
		$nama_file = $_SESSION['ses_user'] . $time . '.' . $file_extension;

		if (!empty($lokasi_file)) {
			if ($file_extension != 'php') {
				UploadFile($nama_file);
				$short_file = 'https://sim.umkuningan.ac.id/file/' . $nama_file;

				mysqli_query($con, "UPDATE catatan SET capaian='$capaian',upaya='$upaya',kendala='$kendala',rtl='$rtl',url_file='$short_file' WHERE id='$id' ");

				header('Location: /catatan/?m=updated');
				exit;
			} else {
				header('Location: /catatan/?m=not_updated');
				exit;
			}
		} else {
			mysqli_query($con, "UPDATE catatan SET capaian='$capaian', upaya='$upaya',kendala='$kendala',rtl='$rtl' WHERE id='$id' ");
			header('Location: /catatan/?m=updated');
			exit;
		}
	} elseif ($folder['2'] == 'kinerja_laporan') {
		$id		= mysqli_real_escape_string($con, $_POST['id']);
		$capaian_after	= mysqli_real_escape_string($con, $_POST['capaian_after']);
		$analisis	= mysqli_real_escape_string($con, $_POST['analisis']);
		$rtl	= mysqli_real_escape_string($con, $_POST['rtl']);

		$short_file	= mysqli_real_escape_string($con, $_POST['dokumen']);

		mysqli_query($con, "UPDATE indikator SET capaian_after='$capaian_after',dokumen='$short_file',analisis='$analisis',rtl='$rtl',status_monev='1' WHERE id='$id' AND unit='$_SESSION[ses_user]' ");
		header('Location: /kinerja/laporan/?m=updated');
		exit;
	} elseif ($folder['2'] == 'monev_laporan') {
		$id		= mysqli_real_escape_string($con, $_POST['id']);
		$hasil_monev	= mysqli_real_escape_string($con, $_POST['hasil_monev']);
		$rekomendasi_monev	= mysqli_real_escape_string($con, $_POST['rekomendasi_monev']);
		$status_monev	= mysqli_real_escape_string($con, $_POST['status_monev']);

		$qi = mysqli_query($con, "SELECT * FROM indikator WHERE id='$id' ");
		$i = mysqli_fetch_array($qi);

		mysqli_query($con, "UPDATE indikator SET hasil_monev='$hasil_monev',rekomendasi_monev='$rekomendasi_monev',status_monev='$status_monev' WHERE id='$id' ");
		header('Location: /pantaukinerja/laporan/' . $i['unit'] . '/' . $i['tahun'] . '/?m=updated');
		exit;
	}


	/*		
		elseif($folder['2']=='suratmasuk') {
			$id	= mysqli_real_escape_string($con,$_POST[id]);
			$id_jenis= mysqli_real_escape_string($con,$_POST[id_jenis]);
			$nomor	= mysqli_real_escape_string($con,$_POST[nomor]);
			$tgl	= mysqli_real_escape_string($con,$_POST[tgl]);
			$tgl_diterima	= mysqli_real_escape_string($con,$_POST[tgl_diterima]);
			$keterangan	= mysqli_real_escape_string($con,$_POST[keterangan]);
			$asal	= mysqli_real_escape_string($con,$_POST[asal]);
			$perihal= mysqli_real_escape_string($con,$_POST[perihal]);

			$lokasi_file = $_FILES['fupload']['tmp_name'];
			$file   = $_FILES['fupload']['name'];
			$time = time();
			$file_extension = strtolower(substr(strrchr($file,"."),1));
			$nama_file = $_SESSION[ses_user].$time.'.'.$file_extension;
	
	 		if (!empty($lokasi_file)){
				if ($file_extension!='php') {
					UploadSURATMASUK($nama_file);
					$short_file = 'file/suratmasuk/'.$nama_file;
					mysqli_query($con,"UPDATE suratmasuk SET id_jenis='$id_jenis',asal='$asal',perihal='$perihal',nomor='$nomor',tgl='$tgl',tgl_diterima='$tgl_diterima',keterangan='$keterangan',url_file='$short_file' WHERE id='$id' AND tujuan='$_SESSION[ses_user]' LIMIT 1");
					header('Location: /suratmasuk/jenis/'.$id_jenis.'/?m=updated');
	exit;
				}
				else {
					header('Location: /suratmasuk/jenis/'.$id_jenis.'/?m=not_updated');
	exit;
				}
			}
			else {
				mysqli_query($con,"UPDATE suratmasuk SET id_jenis='$id_jenis',asal='$asal',perihal='$perihal',nomor='$nomor',tgl='$tgl',tgl_diterima='$tgl_diterima',keterangan='$keterangan' WHERE id='$id' AND tujuan='$_SESSION[ses_user]' LIMIT 1");
				header('Location: /suratmasuk/jenis/'.$id_jenis.'/?m=updated');
	exit;
			}
		}


		elseif($folder['2']=='suratkeluar') {
			$id	= mysqli_real_escape_string($con,$_POST[id]);
			$id_jenis= mysqli_real_escape_string($con,$_POST[id_jenis]);
			$nomor	= mysqli_real_escape_string($con,$_POST[nomor]);
			$tgl	= mysqli_real_escape_string($con,$_POST[tgl]);
			$keterangan	= mysqli_real_escape_string($con,$_POST[keterangan]);
			$tujuan	= mysqli_real_escape_string($con,$_POST[tujuan]);
			$perihal= mysqli_real_escape_string($con,$_POST[perihal]);
			
			$tembusan_struktural	= $_POST[tembusan_struktural];
			foreach($tembusan_struktural as $data_struktural) {
				$val_struktural = $data_struktural.','.$val_struktural;
			}
			$tembusan_dosen	= $_POST[tembusan_dosen];
			foreach($tembusan_dosen as $data_dosen) {
				$val_dosen = $data_dosen.','.$val_dosen;
			}
			$tembusan_karyawan	= $_POST[tembusan_karyawan];
			foreach($tembusan_karyawan as $data_karyawan) {
				$val_karyawan = $data_karyawan.','.$val_karyawan;
			}

			$lokasi_file = $_FILES['fupload']['tmp_name'];
			$file   = $_FILES['fupload']['name'];
			$time = time();
			$file_extension = strtolower(substr(strrchr($file,"."),1));
			$nama_file = $_SESSION[ses_user].$time.'.'.$file_extension;
	
	 		if (!empty($lokasi_file)){
				if ($file_extension!='php') {
					UploadSURATKELUAR($nama_file);
					$short_file = 'file/suratkeluar/'.$nama_file;
					mysqli_query($con,"UPDATE suratkeluar SET id_jenis='$id_jenis',tujuan='$tujuan',perihal='$perihal',nomor='$nomor',tgl='$tgl',keterangan='$keterangan',tembusan_struktural='$val_struktural',tembusan_dosen='$val_dosen',tembusan_karyawan='$val_karyawan',url_file='$short_file' WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1");
					header('Location: /suratkeluar/jenis/'.$id_jenis.'/?m=updated');
	exit;
				}
				else {
					header('Location: /suratkeluar/jenis/'.$id_jenis.'/?m=not_updated');
	exit;
				}
			}
			else {
				mysqli_query($con,"UPDATE suratkeluar SET id_jenis='$id_jenis',tujuan='$tujuan',perihal='$perihal',nomor='$nomor',tgl='$tgl',keterangan='$keterangan',tembusan_struktural='$val_struktural',tembusan_dosen='$val_dosen',tembusan_karyawan='$val_karyawan' WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1");
				header('Location: /suratkeluar/jenis/'.$id_jenis.'/?m=updated');
	exit;
			}
		}
		
		elseif($folder['2']=='tgs') {
			$id	= mysqli_real_escape_string($con,$_POST[id]);
			$id_jenis= mysqli_real_escape_string($con,$_POST[id_jenis]);
			$judul	= mysqli_real_escape_string($con,$_POST[judul]);
			$nomor	= mysqli_real_escape_string($con,$_POST[nomor]);
			$tgl_sk	= mysqli_real_escape_string($con,$_POST[tgl_sk]);
			$tembusan_struktural	= $_POST[tembusan_struktural];
			foreach($tembusan_struktural as $data_struktural) {
				$val_struktural = $data_struktural.','.$val_struktural;
			}
			$tembusan_dosen	= $_POST[tembusan_dosen];
			foreach($tembusan_dosen as $data_dosen) {
				$val_dosen = $data_dosen.','.$val_dosen;
			}
			$tembusan_karyawan	= $_POST[tembusan_karyawan];
			foreach($tembusan_karyawan as $data_karyawan) {
				$val_karyawan = $data_karyawan.','.$val_karyawan;
			}

			$lokasi_file = $_FILES['fupload']['tmp_name'];
			$file   = $_FILES['fupload']['name'];
			$time = time();
			$file_extension = strtolower(substr(strrchr($file,"."),1));
			$nama_file = $_SESSION[ses_user].$time.'.'.$file_extension;
	
	 		if (!empty($lokasi_file)){
				if ($file_extension!='php') {
					UploadTGS($nama_file);
					$short_file = 'file/tgs/'.$nama_file;
					mysqli_query($con,"UPDATE tgs SET id_jenis='$id_jenis',judul='$judul',nomor='$nomor',tgl_sk='$tgl_sk',tembusan_struktural='$val_struktural',tembusan_dosen='$val_dosen',tembusan_karyawan='$val_karyawan',url_file='$short_file' WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1");
					header('Location: /tgs/jenis/'.$id_jenis.'/?m=updated');
	exit;
				}
				else {
					header('Location: /tgs/jenis/'.$id_jenis.'/?m=not_updated');
	exit;
				}
			}
			else {
				mysqli_query($con,"UPDATE tgs SET id_jenis='$id_jenis',judul='$judul',nomor='$nomor',tgl_sk='$tgl_sk',tembusan_struktural='$val_struktural',tembusan_dosen='$val_dosen',tembusan_karyawan='$val_karyawan' WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1");
				header('Location: /tgs/jenis/'.$id_jenis.'/?m=updated');
	exit;
			}
		}
		
		elseif($folder['2']=='ins') {
			$id	= mysqli_real_escape_string($con,$_POST[id]);
			$id_jenis= mysqli_real_escape_string($con,$_POST[id_jenis]);
			$judul	= mysqli_real_escape_string($con,$_POST[judul]);
			$nomor	= mysqli_real_escape_string($con,$_POST[nomor]);
			$tgl_sk	= mysqli_real_escape_string($con,$_POST[tgl_sk]);
			$tembusan_struktural	= $_POST[tembusan_struktural];
			foreach($tembusan_struktural as $data_struktural) {
				$val_struktural = $data_struktural.','.$val_struktural;
			}
			$tembusan_dosen	= $_POST[tembusan_dosen];
			foreach($tembusan_dosen as $data_dosen) {
				$val_dosen = $data_dosen.','.$val_dosen;
			}
			$tembusan_karyawan	= $_POST[tembusan_karyawan];
			foreach($tembusan_karyawan as $data_karyawan) {
				$val_karyawan = $data_karyawan.','.$val_karyawan;
			}

			$lokasi_file = $_FILES['fupload']['tmp_name'];
			$file   = $_FILES['fupload']['name'];
			$time = time();
			$file_extension = strtolower(substr(strrchr($file,"."),1));
			$nama_file = $_SESSION[ses_user].$time.'.'.$file_extension;
	
	 		if (!empty($lokasi_file)){
				if ($file_extension!='php') {
					UploadINS($nama_file);
					$short_file = 'file/ins/'.$nama_file;
					mysqli_query($con,"UPDATE ins SET id_jenis='$id_jenis',judul='$judul',nomor='$nomor',tgl_sk='$tgl_sk',tembusan_struktural='$val_struktural',tembusan_dosen='$val_dosen',tembusan_karyawan='$val_karyawan',url_file='$short_file' WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1");
					header('Location: /ins/jenis/'.$id_jenis.'/?m=updated');
	exit;
				}
				else {
					header('Location: /ins/jenis/'.$id_jenis.'/?m=not_updated');
	exit;
				}
			}
			else {
				mysqli_query($con,"UPDATE ins SET id_jenis='$id_jenis',judul='$judul',nomor='$nomor',tgl_sk='$tgl_sk',tembusan_struktural='$val_struktural',tembusan_dosen='$val_dosen',tembusan_karyawan='$val_karyawan' WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1");
				header('Location: /ins/jenis/'.$id_jenis.'/?m=updated');
	exit;
			}
		}

		elseif($folder['2']=='edr') {
			$id	= mysqli_real_escape_string($con,$_POST[id]);
			$id_jenis= mysqli_real_escape_string($con,$_POST[id_jenis]);
			$judul	= mysqli_real_escape_string($con,$_POST[judul]);
			$nomor	= mysqli_real_escape_string($con,$_POST[nomor]);
			$tgl_sk	= mysqli_real_escape_string($con,$_POST[tgl_sk]);
			$tembusan_struktural	= $_POST[tembusan_struktural];
			foreach($tembusan_struktural as $data_struktural) {
				$val_struktural = $data_struktural.','.$val_struktural;
			}
			$tembusan_dosen	= $_POST[tembusan_dosen];
			foreach($tembusan_dosen as $data_dosen) {
				$val_dosen = $data_dosen.','.$val_dosen;
			}
			$tembusan_karyawan	= $_POST[tembusan_karyawan];
			foreach($tembusan_karyawan as $data_karyawan) {
				$val_karyawan = $data_karyawan.','.$val_karyawan;
			}

			$lokasi_file = $_FILES['fupload']['tmp_name'];
			$file   = $_FILES['fupload']['name'];
			$time = time();
			$file_extension = strtolower(substr(strrchr($file,"."),1));
			$nama_file = $_SESSION[ses_user].$time.'.'.$file_extension;
	
	 		if (!empty($lokasi_file)){
				if ($file_extension!='php') {
					UploadEDR($nama_file);
					$short_file = 'file/edr/'.$nama_file;
					mysqli_query($con,"UPDATE edr SET id_jenis='$id_jenis',judul='$judul',nomor='$nomor',tgl_sk='$tgl_sk',tembusan_struktural='$val_struktural',tembusan_dosen='$val_dosen',tembusan_karyawan='$val_karyawan',url_file='$short_file' WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1");
					header('Location: /edr/jenis/'.$id_jenis.'/?m=updated');
	exit;
				}
				else {
					header('Location: /edr/jenis/'.$id_jenis.'/?m=not_updated');
	exit;
				}
			}
			else {
				mysqli_query($con,"UPDATE edr SET id_jenis='$id_jenis',judul='$judul',nomor='$nomor',tgl_sk='$tgl_sk',tembusan_struktural='$val_struktural',tembusan_dosen='$val_dosen',tembusan_karyawan='$val_karyawan' WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1");
				header('Location: /edr/jenis/'.$id_jenis.'/?m=updated');
	exit;
			}
		}

		elseif($folder['2']=='mlm') {
			$id	= mysqli_real_escape_string($con,$_POST[id]);
			$id_jenis= mysqli_real_escape_string($con,$_POST[id_jenis]);
			$judul	= mysqli_real_escape_string($con,$_POST[judul]);
			$nomor	= mysqli_real_escape_string($con,$_POST[nomor]);
			$tgl_sk	= mysqli_real_escape_string($con,$_POST[tgl_sk]);
			$tembusan_struktural	= $_POST[tembusan_struktural];
			foreach($tembusan_struktural as $data_struktural) {
				$val_struktural = $data_struktural.','.$val_struktural;
			}
			$tembusan_dosen	= $_POST[tembusan_dosen];
			foreach($tembusan_dosen as $data_dosen) {
				$val_dosen = $data_dosen.','.$val_dosen;
			}
			$tembusan_karyawan	= $_POST[tembusan_karyawan];
			foreach($tembusan_karyawan as $data_karyawan) {
				$val_karyawan = $data_karyawan.','.$val_karyawan;
			}

			$lokasi_file = $_FILES['fupload']['tmp_name'];
			$file   = $_FILES['fupload']['name'];
			$time = time();
			$file_extension = strtolower(substr(strrchr($file,"."),1));
			$nama_file = $_SESSION[ses_user].$time.'.'.$file_extension;
	
	 		if (!empty($lokasi_file)){
				if ($file_extension!='php') {
					UploadMLM($nama_file);
					$short_file = 'file/mlm/'.$nama_file;
					mysqli_query($con,"UPDATE mlm SET id_jenis='$id_jenis',judul='$judul',nomor='$nomor',tgl_sk='$tgl_sk',tembusan_struktural='$val_struktural',tembusan_dosen='$val_dosen',tembusan_karyawan='$val_karyawan',url_file='$short_file' WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1");
					header('Location: /mlm/jenis/'.$id_jenis.'/?m=updated');
	exit;
				}
				else {
					header('Location: /mlm/jenis/'.$id_jenis.'/?m=not_updated');
	exit;
				}
			}
			else {
				mysqli_query($con,"UPDATE mlm SET id_jenis='$id_jenis',judul='$judul',nomor='$nomor',tgl_sk='$tgl_sk',tembusan_struktural='$val_struktural',tembusan_dosen='$val_dosen',tembusan_karyawan='$val_karyawan' WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1");
				header('Location: /mlm/jenis/'.$id_jenis.'/?m=updated');
	exit;
			}
		}


		elseif($folder['2']=='per') {
			$id	= mysqli_real_escape_string($con,$_POST[id]);
			$id_jenis= mysqli_real_escape_string($con,$_POST[id_jenis]);
			$judul	= mysqli_real_escape_string($con,$_POST[judul]);
			$nomor	= mysqli_real_escape_string($con,$_POST[nomor]);
			$tgl_sk	= mysqli_real_escape_string($con,$_POST[tgl_sk]);
			$tembusan_struktural	= $_POST[tembusan_struktural];
			foreach($tembusan_struktural as $data_struktural) {
				$val_struktural = $data_struktural.','.$val_struktural;
			}
			$tembusan_dosen	= $_POST[tembusan_dosen];
			foreach($tembusan_dosen as $data_dosen) {
				$val_dosen = $data_dosen.','.$val_dosen;
			}
			$tembusan_karyawan	= $_POST[tembusan_karyawan];
			foreach($tembusan_karyawan as $data_karyawan) {
				$val_karyawan = $data_karyawan.','.$val_karyawan;
			}

			$lokasi_file = $_FILES['fupload']['tmp_name'];
			$file   = $_FILES['fupload']['name'];
			$time = time();
			$file_extension = strtolower(substr(strrchr($file,"."),1));
			$nama_file = $_SESSION[ses_user].$time.'.'.$file_extension;
	
	 		if (!empty($lokasi_file)){
				if ($file_extension!='php') {
					UploadPER($nama_file);
					$short_file = 'file/per/'.$nama_file;
					mysqli_query($con,"UPDATE per SET id_jenis='$id_jenis',judul='$judul',nomor='$nomor',tgl_sk='$tgl_sk',tembusan_struktural='$val_struktural',tembusan_dosen='$val_dosen',tembusan_karyawan='$val_karyawan',url_file='$short_file' WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1");
					header('Location: /per/jenis/'.$id_jenis.'/?m=updated');
	exit;
				}
				else {
					header('Location: /per/jenis/'.$id_jenis.'/?m=not_updated');
	exit;
				}
			}
			else {
				mysqli_query($con,"UPDATE per SET id_jenis='$id_jenis',judul='$judul',nomor='$nomor',tgl_sk='$tgl_sk',tembusan_struktural='$val_struktural',tembusan_dosen='$val_dosen',tembusan_karyawan='$val_karyawan' WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1");
				header('Location: /per/jenis/'.$id_jenis.'/?m=updated');
	exit;
			}
		}

		elseif($folder['2']=='ket') {
			$id	= mysqli_real_escape_string($con,$_POST[id]);
			$id_jenis= mysqli_real_escape_string($con,$_POST[id_jenis]);
			$judul	= mysqli_real_escape_string($con,$_POST[judul]);
			$nomor	= mysqli_real_escape_string($con,$_POST[nomor]);
			$tgl_sk	= mysqli_real_escape_string($con,$_POST[tgl_sk]);
			$tembusan_struktural	= $_POST[tembusan_struktural];
			foreach($tembusan_struktural as $data_struktural) {
				$val_struktural = $data_struktural.','.$val_struktural;
			}
			$tembusan_dosen	= $_POST[tembusan_dosen];
			foreach($tembusan_dosen as $data_dosen) {
				$val_dosen = $data_dosen.','.$val_dosen;
			}
			$tembusan_karyawan	= $_POST[tembusan_karyawan];
			foreach($tembusan_karyawan as $data_karyawan) {
				$val_karyawan = $data_karyawan.','.$val_karyawan;
			}

			$lokasi_file = $_FILES['fupload']['tmp_name'];
			$file   = $_FILES['fupload']['name'];
			$time = time();
			$file_extension = strtolower(substr(strrchr($file,"."),1));
			$nama_file = $_SESSION[ses_user].$time.'.'.$file_extension;
	
	 		if (!empty($lokasi_file)){
				if ($file_extension!='php') {
					UploadKET($nama_file);
					$short_file = 'file/ket/'.$nama_file;
					mysqli_query($con,"UPDATE ket SET id_jenis='$id_jenis',judul='$judul',nomor='$nomor',tgl_sk='$tgl_sk',tembusan_struktural='$val_struktural',tembusan_dosen='$val_dosen',tembusan_karyawan='$val_karyawan',url_file='$short_file' WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1");
					header('Location: /ket/jenis/'.$id_jenis.'/?m=updated');
	exit;
				}
				else {
					header('Location: /ket/jenis/'.$id_jenis.'/?m=not_updated');
	exit;
				}
			}
			else {
				mysqli_query($con,"UPDATE ket SET id_jenis='$id_jenis',judul='$judul',nomor='$nomor',tgl_sk='$tgl_sk',tembusan_struktural='$val_struktural',tembusan_dosen='$val_dosen',tembusan_karyawan='$val_karyawan' WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1");
				header('Location: /ket/jenis/'.$id_jenis.'/?m=updated');
	exit;
			}
		}


		elseif($folder['2']=='rek') {
			$id	= mysqli_real_escape_string($con,$_POST[id]);
			$id_jenis= mysqli_real_escape_string($con,$_POST[id_jenis]);
			$judul	= mysqli_real_escape_string($con,$_POST[judul]);
			$nomor	= mysqli_real_escape_string($con,$_POST[nomor]);
			$tgl_sk	= mysqli_real_escape_string($con,$_POST[tgl_sk]);
			$tembusan_struktural	= $_POST[tembusan_struktural];
			foreach($tembusan_struktural as $data_struktural) {
				$val_struktural = $data_struktural.','.$val_struktural;
			}
			$tembusan_dosen	= $_POST[tembusan_dosen];
			foreach($tembusan_dosen as $data_dosen) {
				$val_dosen = $data_dosen.','.$val_dosen;
			}
			$tembusan_karyawan	= $_POST[tembusan_karyawan];
			foreach($tembusan_karyawan as $data_karyawan) {
				$val_karyawan = $data_karyawan.','.$val_karyawan;
			}

			$lokasi_file = $_FILES['fupload']['tmp_name'];
			$file   = $_FILES['fupload']['name'];
			$time = time();
			$file_extension = strtolower(substr(strrchr($file,"."),1));
			$nama_file = $_SESSION[ses_user].$time.'.'.$file_extension;
	
	 		if (!empty($lokasi_file)){
				if ($file_extension!='php') {
					UploadREK($nama_file);
					$short_file = 'file/rek/'.$nama_file;
					mysqli_query($con,"UPDATE rek SET id_jenis='$id_jenis',judul='$judul',nomor='$nomor',tgl_sk='$tgl_sk',tembusan_struktural='$val_struktural',tembusan_dosen='$val_dosen',tembusan_karyawan='$val_karyawan',url_file='$short_file' WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1");
					header('Location: /rek/jenis/'.$id_jenis.'/?m=updated');
	exit;
				}
				else {
					header('Location: /rek/jenis/'.$id_jenis.'/?m=not_updated');
	exit;
				}
			}
			else {
				mysqli_query($con,"UPDATE rek SET id_jenis='$id_jenis',judul='$judul',nomor='$nomor',tgl_sk='$tgl_sk',tembusan_struktural='$val_struktural',tembusan_dosen='$val_dosen',tembusan_karyawan='$val_karyawan' WHERE id='$id' AND asal='$_SESSION[ses_user]' LIMIT 1");
				header('Location: /rek/jenis/'.$id_jenis.'/?m=updated');
	exit;
			}
		}
*/ elseif ($folder['2'] == 'lapor') {
		$id		= mysqli_real_escape_string($con, $folder['3']);
		mysqli_query($con, "UPDATE lapor SET status='3' WHERE id='$id' AND user='$_SESSION[ses_user]' ");
		header('Location: /lapor/disposisi/?m=updated');
		exit;
	}
}
