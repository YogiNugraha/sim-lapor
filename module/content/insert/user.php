<?php
declare(strict_types=1);
 

ob_start();	

	if (empty($_SESSION['ses_user']) AND empty($_SESSION['ses_pass']) AND empty($_SESSION['ses_level']) ){
		header('Location: /login');
	exit;
	}
	else {
	
		define('valid','1');	
		include "config/upload.php";

		
		if($folder['2']=='kinerja') {
			$jenis	= mysqli_real_escape_string($con,$_POST['jenis']);
			$nama	= mysqli_real_escape_string($con,$_POST['nama']);
			$standar= mysqli_real_escape_string($con,$_POST['standar']);
			$luaran= mysqli_real_escape_string($con,$_POST['luaran']);
			$kriteria= mysqli_real_escape_string($con,$_POST['kriteria']);
			$skala= mysqli_real_escape_string($con,$_POST['skala']);
			$topik= mysqli_real_escape_string($con,$_POST['topik']);
			$capaian_before	= mysqli_real_escape_string($con,$_POST['capaian_before']);
			$target_after	= mysqli_real_escape_string($con,$_POST['target_after']);

			mysqli_query($con,"INSERT INTO indikator(unit,jenis,nama,standar,luaran,kriteria,skala,topik,capaian_before,target_after,valid) VALUES('$_SESSION[ses_user]','$jenis','$nama','$standar','$luaran','$kriteria','$skala','$topik','$capaian_before','$target_after','1')");

			header('Location: /kinerja/?m=inserted');
	exit;
		}
		
		elseif($folder['2']=='proker') {
			$id_indikator	= mysqli_real_escape_string($con,$_POST['id_indikator']);
			$bentuk	= mysqli_real_escape_string($con,$_POST['bentuk']);
			$deskripsi = mysqli_real_escape_string($con,$_POST['deskripsi']);
			$waktu_mulai	= mysqli_real_escape_string($con,$_POST['waktu_mulai']);
			$waktu_selesai	= mysqli_real_escape_string($con,$_POST['waktu_selesai']);
			$sasaran	= mysqli_real_escape_string($con,$_POST['sasaran']);
			$tujuan	= mysqli_real_escape_string($con,$_POST['tujuan']);
			$anggaran	= mysqli_real_escape_string($con,$_POST['anggaran']);
			$kebijakan	= mysqli_real_escape_string($con,$_POST['kebijakan']);
			$luaran	= mysqli_real_escape_string($con,$_POST['luaran']);

			mysqli_query($con,"INSERT INTO proker(id_indikator,bentuk,deskripsi,waktu_mulai,waktu_selesai,sasaran,tujuan,anggaran,kebijakan,luaran,valid) VALUES('$id_indikator','$bentuk','$deskripsi','$waktu_mulai','$waktu_selesai','$sasaran','$tujuan','$anggaran','$kebijakan','$luaran','1')");

			header('Location: /proker/?m=inserted');
	exit;
		}
		
		elseif($folder['2']=='catatan') {
			$id_bulan	= mysqli_real_escape_string($con,$_POST['id_bulan']);
			$id_indikator	= mysqli_real_escape_string($con,$_POST['id_indikator']);
			$upaya = mysqli_real_escape_string($con,$_POST['upaya']);
			$kendala	= mysqli_real_escape_string($con,$_POST['kendala']);
			$rtl	= mysqli_real_escape_string($con,$_POST['rtl']);
			$capaian	= mysqli_real_escape_string($con,$_POST['capaian']);
			
			$indikator = mysqli_fetch_array(mysqli_query($con,"SELECT tahun FROM indikator WHERE id='$id_indikator' "));

			$lokasi_file = $_FILES['fupload']['tmp_name'];
			$file   = $_FILES['fupload']['name'];
			$time = time();
			$file_extension = strtolower(substr(strrchr($file,"."),1));
			$nama_file = $_SESSION['ses_user'].$time.'.'.$file_extension;
	
	 		if (!empty($lokasi_file)){
				if ($file_extension!='php') {
					UploadFile($nama_file);
					$short_file = 'https://sim.umkuningan.ac.id/file/'.$nama_file;
					mysqli_query($con,"INSERT INTO catatan(id_indikator,id_bulan,upaya,kendala,rtl,capaian,url_file) VALUES('$id_indikator','$id_bulan','$upaya','$kendala','$rtl','$capaian','$short_file')");
					header('Location: /catatan/periode/'.$id_bulan.'/'.$indikator['tahun'].'/?m=inserted');
	exit;
				}
				else {
					header('Location: /catatan/periode/'.$id_bulan.'/'.$indikator['tahun'].'/?m=not_inserted');
	exit;
				}
			}
			else {
				mysqli_query($con,"INSERT INTO catatan(id_indikator,id_bulan,upaya,kendala,rtl,capaian) VALUES('$id_indikator','$id_bulan','$upaya','$kendala','$rtl','$capaian')");
				header('Location: /catatan/periode/'.$id_bulan.'/'.$indikator['tahun'].'/?m=inserted');
	exit;
			}
		}
		
		elseif($folder['2']=='agenda') {
			$id_kegiatan = mysqli_real_escape_string($con,$_POST['id_kegiatan']);
			$nama = mysqli_real_escape_string($con,$_POST['nama']);
			$tgl_mulai = mysqli_real_escape_string($con,$_POST['tgl_mulai']);
			$tgl_selesai = mysqli_real_escape_string($con,$_POST['tgl_selesai']);
			$jam_mulai = mysqli_real_escape_string($con,$_POST['jam_mulai']);
			$jam_selesai = mysqli_real_escape_string($con,$_POST['jam_selesai']);
			$lokasi = mysqli_real_escape_string($con,$_POST['lokasi']);
			$narasumber = mysqli_real_escape_string($con,$_POST['narasumber']);
			$peserta = mysqli_real_escape_string($con,$_POST['peserta']);
			$deskripsi = mysqli_real_escape_string($con,$_POST['deskripsi']);
			$url_file = mysqli_real_escape_string($con,$_POST['id_kegiatan']);
			
			mysqli_query($con,"INSERT INTO kegiatan(id_kegiatan,nama,tgl_mulai,tgl_selesai,jam_mulai,jam_selesai,lokasi,narasumber,peserta,deskripsi)
			VALUES('$id_kegiatan','$nama','$tgl_mulai','$tgl_selesai','$jam_mulai','$jam_selesai','$lokasi','$narasumber','$peserta','$deskripsi')
			");
			
			header('Location: /agenda/jenis/'.$id_kegiatan.'/?m=inserted');
	exit;
			
		}


		elseif($folder['2']=='lapor') {
			$tipe = mysqli_real_escape_string($con,$_POST['tipe']);
			$judul = mysqli_real_escape_string($con,$_POST['judul']);
			$isi = mysqli_real_escape_string($con,$_POST['isi']);
			$jenis = mysqli_real_escape_string($con,$_POST['jenis']);
			$visibilitas = mysqli_real_escape_string($con,$_POST['visibilitas']);


			$lokasi_file = $_FILES['fupload']['tmp_name'];
			$file   = $_FILES['fupload']['name'];
			$time = time();
			$file_extension = strtolower(substr(strrchr($file,"."),1));
			$nama_file = $time.'.'.$file_extension;
	
	 		if (!empty($lokasi_file)){
				if ($file_extension!='php') {
					UploadLapor($nama_file);
					$short_file = 'https://sim.umkuningan.ac.id/file/lapor/'.$nama_file;
					mysqli_query($con,"INSERT INTO lapor(user,tipe,judul,isi,jenis,visibilitas,url_lampiran,status,date,time) 
					VALUES('$_SESSION[ses_user]','$tipe','$judul','$isi','$jenis','$visibilitas','$short_file','1','$tgl_sekarang','$jam_sekarang')");
					header('Location: /lapor/submit/?m=inserted');
	exit;
				}
				else {
					header('Location: /lapor/submit/?m=not_inserted');
	exit;
				}
			}
			else {
				mysqli_query($con,"INSERT INTO lapor(user,tipe,judul,isi,jenis,visibilitas,status,date,time) 
				VALUES('$_SESSION[ses_user]','$tipe','$judul','$isi','$jenis','$visibilitas','1','$tgl_sekarang','$jam_sekarang')");
				header('Location: /lapor/submit/?m=inserted');
	exit;
			}
		}

/*
		elseif($folder['2']=='suratmasuk') {
			$id_jenis	= mysqli_real_escape_string($con,$_POST['id_jenis']);
			$asal	= mysqli_real_escape_string($con,$_POST['asal']);
			$perihal= mysqli_real_escape_string($con,$_POST['perihal']);
			$nomor	= mysqli_real_escape_string($con,$_POST['nomor']);
			$tgl	= mysqli_real_escape_string($con,$_POST['tgl']);
			$tgl_diterima	= mysqli_real_escape_string($con,$_POST['tgl_diterima']);
			$keterangan	= mysqli_real_escape_string($con,$_POST['keterangan']);
		
			$lokasi_file = $_FILES['fupload']['tmp_name'];
			$file   = $_FILES['fupload']['name'];
			$time = time();
			$file_extension = strtolower(substr(strrchr($file,"."),1));
			$nama_file = $_SESSION[ses_user].$time.'.'.$file_extension;
	
	 		if (!empty($lokasi_file)){
				if ($file_extension!='php') {
					UploadSURATMASUK($nama_file);
					$short_file = 'file/suratmasuk/'.$nama_file;
					mysqli_query($con,"INSERT INTO suratmasuk(id_jenis,asal,tujuan,perihal,nomor,tgl,tgl_diterima,keterangan,url_file) VALUES('$id_jenis','$asal','$_SESSION[ses_user]','$perihal','$nomor','$tgl','$tgl_diterima','$keterangan','$short_file') ");
					header('Location: /suratmasuk/jenis/'.$id_jenis.'/?m=inserted');
	exit;
				}
				else {
					header('Location: /suratmasuk/jenis/'.$id_jenis.'/?m=not_inserted');
	exit;
				}
			}
			else {
				header('Location: /suratmasuk/jenis/'.$id_jenis.'/?m=not_inserted');
	exit;
			}
		}
		
		elseif($folder['2']=='suratkeluar') {
			$id_jenis	= mysqli_real_escape_string($con,$_POST['id_jenis']);
			$tujuan	= mysqli_real_escape_string($con,$_POST['tujuan']);
			$perihal= mysqli_real_escape_string($con,$_POST['perihal']);
			$nomor	= mysqli_real_escape_string($con,$_POST['nomor']);
			$tgl	= mysqli_real_escape_string($con,$_POST['tgl']);
			$keterangan	= mysqli_real_escape_string($con,$_POST['keterangan']);
			
			$tembusan_struktural	= $_POST['tembusan_struktural'];
			foreach($tembusan_struktural as $data_struktural) {
				$val_struktural = $data_struktural.','.$val_struktural;
			}
			$tembusan_dosen	= $_POST['tembusan_dosen'];
			foreach($tembusan_dosen as $data_dosen) {
				$val_dosen = $data_dosen.','.$val_dosen;
			}
			$tembusan_karyawan	= $_POST['tembusan_karyawan'];
			foreach($tembusan_karyawan as $data_karyawan) {
				$val_karyawan = $data_karyawan.','.$val_karyawan;
			}
			
			
			$dt	= mysqli_real_escape_string($con,$_POST['dt']);
			if($dt=='Y') {
				$qd = mysqli_query($con2,"SELECT nik FROM dosen WHERE ikatan='A' AND status='A' ");
				while($d=mysqli_fetch_array($qd)) {
					$val_dt = $d[nik].','.$val_dt;
				}
				$val_dosen = $val_dosen.$val_dt;
			}


			$dtt	= mysqli_real_escape_string($con,$_POST['dtt']);
			if($dtt=='Y') {
				$qdtt = mysqli_query($con2,"SELECT nik FROM dosen WHERE ikatan!='A' AND status='A' ");
				while($dttt=mysqli_fetch_array($qdtt)) {
					$val_dtt = $dttt[nik].','.$val_dtt;
				}
				$val_dosen = $val_dosen.$val_dtt;
			}
			
			$kt	= mysqli_real_escape_string($con,$_POST['kt']);
			if($kt=='Y') {
				$qk = mysqli_query($con3,"SELECT nik FROM karyawan WHERE ikatan='A' AND status='A' ");
				while($k=mysqli_fetch_array($qk)) {
					$val_kt = $k[nik].','.$val_kt;
				}
				$val_karyawan = $val_karyawan.$val_kt;
			}


			$ktt	= mysqli_real_escape_string($con,$_POST['ktt']);
			if($ktt=='Y') {
				$qktt = mysqli_query($con3,"SELECT nik FROM karyawan WHERE ikatan!='A' AND status='A' ");
				while($kttt=mysqli_fetch_array($qktt)) {
					$val_ktt = $kttt[nik].','.$val_ktt;
				}
				$val_karyawan = $val_karyawan.$val_ktt;
			}
			
			$struktural_all	= mysqli_real_escape_string($con,$_POST['struktural_all']);
			if($struktural_all=='Y') {
				$qstruktural_all = mysqli_query($con,"SELECT `user` FROM level ");
				while($all=mysqli_fetch_array($qstruktural_all)) {
					$val_all = $all['user'].','.$val_all;
				}
				$val_struktural = $val_struktural.$val_all;
			}

			$struktural_lembaga	= mysqli_real_escape_string($con,$_POST['struktural_lembaga']);
			if($struktural_lembaga=='Y') {
				$qstruktural_lembaga = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='lembaga' ");
				while($lembaga=mysqli_fetch_array($qstruktural_lembaga)) {
					$val_lembaga = $lembaga['user'].','.$val_lembaga;
				}
				$val_struktural = $val_struktural.$val_lembaga;
			}

			$struktural_bagian	= mysqli_real_escape_string($con,$_POST['struktural_bagian']);
			if($struktural_bagian=='Y') {
				$qstruktural_bagian = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='bagian' ");
				while($bagian=mysqli_fetch_array($qstruktural_bagian)) {
					$val_bagian = $bagian['user'].','.$val_bagian;
				}
				$val_struktural = $val_struktural.$val_bagian;
			}

			$struktural_upt	= mysqli_real_escape_string($con,$_POST['struktural_upt']);
			if($struktural_upt=='Y') {
				$qstruktural_upt = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='upt' ");
				while($upt=mysqli_fetch_array($qstruktural_upt)) {
					$val_upt = $upt['user'].','.$val_upt;
				}
				$val_struktural = $val_struktural.$val_upt;
			}


			$struktural_prodi = mysqli_real_escape_string($con,$_POST['struktural_prodi']);
			if($struktural_prodi=='Y') {
				$qstruktural_prodi = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='prodi' ");
				while($prodi=mysqli_fetch_array($qstruktural_prodi)) {
					$val_prodi = $prodi['user'].','.$val_prodi;
				}
				$val_struktural = $val_struktural.$val_prodi;
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
					mysqli_query($con,"INSERT INTO suratkeluar(id_jenis,asal,tujuan,perihal,nomor,tgl,keterangan,url_file,tembusan_struktural,tembusan_dosen,tembusan_karyawan) VALUES('$id_jenis','$_SESSION[ses_user]','$tujuan','$perihal','$nomor','$tgl','$keterangan','$short_file','$val_struktural','$val_dosen','$val_karyawan') ");
					header('Location: /suratkeluar/jenis/'.$id_jenis.'/?m=inserted');
	exit;
				}
				else {
					header('Location: /suratkeluar/jenis/'.$id_jenis.'/?m=not_inserted');
	exit;
				}
			}
			else {
				header('Location: /suratkeluar/jenis/'.$id_jenis.'/?m=not_inserted');
	exit;
			}
		}
		
		elseif($folder['2']=='tgs') {
			$id_jenis	= mysqli_real_escape_string($con,$_POST['id_jenis']);
			$judul	= mysqli_real_escape_string($con,$_POST['judul']);
			$nomor	= mysqli_real_escape_string($con,$_POST['nomor']);
			$tgl_sk	= mysqli_real_escape_string($con,$_POST['tgl_sk']);
			$tembusan_struktural	= $_POST['tembusan_struktural'];
			foreach($tembusan_struktural as $data_struktural) {
				$val_struktural = $data_struktural.','.$val_struktural;
			}
			$tembusan_dosen	= $_POST['tembusan_dosen'];
			foreach($tembusan_dosen as $data_dosen) {
				$val_dosen = $data_dosen.','.$val_dosen;
			}
			$tembusan_karyawan	= $_POST['tembusan_karyawan'];
			foreach($tembusan_karyawan as $data_karyawan) {
				$val_karyawan = $data_karyawan.','.$val_karyawan;
			}
			
			
			$dt	= mysqli_real_escape_string($con,$_POST['dt']);
			if($dt=='Y') {
				$qd = mysqli_query($con2,"SELECT nik FROM dosen WHERE ikatan='A' AND status='A' ");
				while($d=mysqli_fetch_array($qd)) {
					$val_dt = $d[nik].','.$val_dt;
				}
				$val_dosen = $val_dosen.$val_dt;
			}


			$dtt	= mysqli_real_escape_string($con,$_POST['dtt']);
			if($dtt=='Y') {
				$qdtt = mysqli_query($con2,"SELECT nik FROM dosen WHERE ikatan!='A' AND status='A' ");
				while($dttt=mysqli_fetch_array($qdtt)) {
					$val_dtt = $dttt[nik].','.$val_dtt;
				}
				$val_dosen = $val_dosen.$val_dtt;
			}
			
			$kt	= mysqli_real_escape_string($con,$_POST['kt']);
			if($kt=='Y') {
				$qk = mysqli_query($con3,"SELECT nik FROM karyawan WHERE ikatan='A' AND status='A' ");
				while($k=mysqli_fetch_array($qk)) {
					$val_kt = $k[nik].','.$val_kt;
				}
				$val_karyawan = $val_karyawan.$val_kt;
			}


			$ktt	= mysqli_real_escape_string($con,$_POST['ktt']);
			if($ktt=='Y') {
				$qktt = mysqli_query($con3,"SELECT nik FROM karyawan WHERE ikatan!='A' AND status='A' ");
				while($kttt=mysqli_fetch_array($qktt)) {
					$val_ktt = $kttt[nik].','.$val_ktt;
				}
				$val_karyawan = $val_karyawan.$val_ktt;
			}
			
			$struktural_all	= mysqli_real_escape_string($con,$_POST['struktural_all']);
			if($struktural_all=='Y') {
				$qstruktural_all = mysqli_query($con,"SELECT `user` FROM level ");
				while($all=mysqli_fetch_array($qstruktural_all)) {
					$val_all = $all['user'].','.$val_all;
				}
				$val_struktural = $val_struktural.$val_all;
			}

			$struktural_lembaga	= mysqli_real_escape_string($con,$_POST['struktural_lembaga']);
			if($struktural_lembaga=='Y') {
				$qstruktural_lembaga = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='lembaga' ");
				while($lembaga=mysqli_fetch_array($qstruktural_lembaga)) {
					$val_lembaga = $lembaga['user'].','.$val_lembaga;
				}
				$val_struktural = $val_struktural.$val_lembaga;
			}

			$struktural_bagian	= mysqli_real_escape_string($con,$_POST['struktural_bagian']);
			if($struktural_bagian=='Y') {
				$qstruktural_bagian = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='bagian' ");
				while($bagian=mysqli_fetch_array($qstruktural_bagian)) {
					$val_bagian = $bagian['user'].','.$val_bagian;
				}
				$val_struktural = $val_struktural.$val_bagian;
			}

			$struktural_upt	= mysqli_real_escape_string($con,$_POST['struktural_upt']);
			if($struktural_upt=='Y') {
				$qstruktural_upt = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='upt' ");
				while($upt=mysqli_fetch_array($qstruktural_upt)) {
					$val_upt = $upt['user'].','.$val_upt;
				}
				$val_struktural = $val_struktural.$val_upt;
			}


			$struktural_prodi = mysqli_real_escape_string($con,$_POST['struktural_prodi']);
			if($struktural_prodi=='Y') {
				$qstruktural_prodi = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='prodi' ");
				while($prodi=mysqli_fetch_array($qstruktural_prodi)) {
					$val_prodi = $prodi['user'].','.$val_prodi;
				}
				$val_struktural = $val_struktural.$val_prodi;
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
					mysqli_query($con,"INSERT INTO tgs(id_jenis,asal,judul,nomor,tgl_sk,url_file,tembusan_struktural,tembusan_dosen,tembusan_karyawan) VALUES('$id_jenis','$_SESSION[ses_user]','$judul','$nomor','$tgl_sk','$short_file','$val_struktural','$val_dosen','$val_karyawan') ");
					header('Location: /tgs/jenis/'.$id_jenis.'/?m=inserted');
	exit;
				}
				else {
					header('Location: /tgs/jenis/'.$id_jenis.'/?m=not_inserted');
	exit;
				}
			}
			else {
				header('Location: /tgs/jenis/'.$id_jenis.'/?m=not_inserted');
	exit;
			}
		}
		

		elseif($folder['2']=='ins') {
			$id_jenis	= mysqli_real_escape_string($con,$_POST['id_jenis']);
			$judul	= mysqli_real_escape_string($con,$_POST['judul']);
			$nomor	= mysqli_real_escape_string($con,$_POST['nomor']);
			$tgl_sk	= mysqli_real_escape_string($con,$_POST['tgl_sk']);
			$tembusan_struktural	= $_POST['tembusan_struktural'];
			foreach($tembusan_struktural as $data_struktural) {
				$val_struktural = $data_struktural.','.$val_struktural;
			}
			$tembusan_dosen	= $_POST['tembusan_dosen'];
			foreach($tembusan_dosen as $data_dosen) {
				$val_dosen = $data_dosen.','.$val_dosen;
			}
			$tembusan_karyawan	= $_POST['tembusan_karyawan'];
			foreach($tembusan_karyawan as $data_karyawan) {
				$val_karyawan = $data_karyawan.','.$val_karyawan;
			}
			
			
			$dt	= mysqli_real_escape_string($con,$_POST['dt']);
			if($dt=='Y') {
				$qd = mysqli_query($con2,"SELECT nik FROM dosen WHERE ikatan='A' AND status='A' ");
				while($d=mysqli_fetch_array($qd)) {
					$val_dt = $d[nik].','.$val_dt;
				}
				$val_dosen = $val_dosen.$val_dt;
			}


			$dtt	= mysqli_real_escape_string($con,$_POST['dtt']);
			if($dtt=='Y') {
				$qdtt = mysqli_query($con2,"SELECT nik FROM dosen WHERE ikatan!='A' AND status='A' ");
				while($dttt=mysqli_fetch_array($qdtt)) {
					$val_dtt = $dttt[nik].','.$val_dtt;
				}
				$val_dosen = $val_dosen.$val_dtt;
			}
			
			$kt	= mysqli_real_escape_string($con,$_POST['kt']);
			if($kt=='Y') {
				$qk = mysqli_query($con3,"SELECT nik FROM karyawan WHERE ikatan='A' AND status='A' ");
				while($k=mysqli_fetch_array($qk)) {
					$val_kt = $k[nik].','.$val_kt;
				}
				$val_karyawan = $val_karyawan.$val_kt;
			}


			$ktt	= mysqli_real_escape_string($con,$_POST['ktt']);
			if($ktt=='Y') {
				$qktt = mysqli_query($con3,"SELECT nik FROM karyawan WHERE ikatan!='A' AND status='A' ");
				while($kttt=mysqli_fetch_array($qktt)) {
					$val_ktt = $kttt[nik].','.$val_ktt;
				}
				$val_karyawan = $val_karyawan.$val_ktt;
			}
			
			$struktural_all	= mysqli_real_escape_string($con,$_POST['struktural_all']);
			if($struktural_all=='Y') {
				$qstruktural_all = mysqli_query($con,"SELECT `user` FROM level ");
				while($all=mysqli_fetch_array($qstruktural_all)) {
					$val_all = $all['user'].','.$val_all;
				}
				$val_struktural = $val_struktural.$val_all;
			}

			$struktural_lembaga	= mysqli_real_escape_string($con,$_POST['struktural_lembaga']);
			if($struktural_lembaga=='Y') {
				$qstruktural_lembaga = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='lembaga' ");
				while($lembaga=mysqli_fetch_array($qstruktural_lembaga)) {
					$val_lembaga = $lembaga['user'].','.$val_lembaga;
				}
				$val_struktural = $val_struktural.$val_lembaga;
			}

			$struktural_bagian	= mysqli_real_escape_string($con,$_POST['struktural_bagian']);
			if($struktural_bagian=='Y') {
				$qstruktural_bagian = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='bagian' ");
				while($bagian=mysqli_fetch_array($qstruktural_bagian)) {
					$val_bagian = $bagian['user'].','.$val_bagian;
				}
				$val_struktural = $val_struktural.$val_bagian;
			}

			$struktural_upt	= mysqli_real_escape_string($con,$_POST['struktural_upt']);
			if($struktural_upt=='Y') {
				$qstruktural_upt = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='upt' ");
				while($upt=mysqli_fetch_array($qstruktural_upt)) {
					$val_upt = $upt['user'].','.$val_upt;
				}
				$val_struktural = $val_struktural.$val_upt;
			}


			$struktural_prodi = mysqli_real_escape_string($con,$_POST['struktural_prodi']);
			if($struktural_prodi=='Y') {
				$qstruktural_prodi = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='prodi' ");
				while($prodi=mysqli_fetch_array($qstruktural_prodi)) {
					$val_prodi = $prodi['user'].','.$val_prodi;
				}
				$val_struktural = $val_struktural.$val_prodi;
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
					mysqli_query($con,"INSERT INTO ins(id_jenis,asal,judul,nomor,tgl_sk,url_file,tembusan_struktural,tembusan_dosen,tembusan_karyawan) VALUES('$id_jenis','$_SESSION[ses_user]','$judul','$nomor','$tgl_sk','$short_file','$val_struktural','$val_dosen','$val_karyawan') ");
					header('Location: /ins/jenis/'.$id_jenis.'/?m=inserted');
	exit;
				}
				else {
					header('Location: /ins/jenis/'.$id_jenis.'/?m=not_inserted');
	exit;
				}
			}
			else {
				header('Location: /ins/jenis/'.$id_jenis.'/?m=not_inserted');
	exit;
			}
		}
		
		elseif($folder['2']=='edr') {
			$id_jenis	= mysqli_real_escape_string($con,$_POST['id_jenis']);
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
			
			
			$dt	= mysqli_real_escape_string($con,$_POST[dt]);
			if($dt=='Y') {
				$qd = mysqli_query($con2,"SELECT nik FROM dosen WHERE ikatan='A' AND status='A' ");
				while($d=mysqli_fetch_array($qd)) {
					$val_dt = $d[nik].','.$val_dt;
				}
				$val_dosen = $val_dosen.$val_dt;
			}


			$dtt	= mysqli_real_escape_string($con,$_POST[dtt]);
			if($dtt=='Y') {
				$qdtt = mysqli_query($con2,"SELECT nik FROM dosen WHERE ikatan!='A' AND status='A' ");
				while($dttt=mysqli_fetch_array($qdtt)) {
					$val_dtt = $dttt[nik].','.$val_dtt;
				}
				$val_dosen = $val_dosen.$val_dtt;
			}
			
			$kt	= mysqli_real_escape_string($con,$_POST[kt]);
			if($kt=='Y') {
				$qk = mysqli_query($con3,"SELECT nik FROM karyawan WHERE ikatan='A' AND status='A' ");
				while($k=mysqli_fetch_array($qk)) {
					$val_kt = $k[nik].','.$val_kt;
				}
				$val_karyawan = $val_karyawan.$val_kt;
			}


			$ktt	= mysqli_real_escape_string($con,$_POST[ktt]);
			if($ktt=='Y') {
				$qktt = mysqli_query($con3,"SELECT nik FROM karyawan WHERE ikatan!='A' AND status='A' ");
				while($kttt=mysqli_fetch_array($qktt)) {
					$val_ktt = $kttt[nik].','.$val_ktt;
				}
				$val_karyawan = $val_karyawan.$val_ktt;
			}
			
			$struktural_all	= mysqli_real_escape_string($con,$_POST[struktural_all]);
			if($struktural_all=='Y') {
				$qstruktural_all = mysqli_query($con,"SELECT `user` FROM level ");
				while($all=mysqli_fetch_array($qstruktural_all)) {
					$val_all = $all['user'].','.$val_all;
				}
				$val_struktural = $val_struktural.$val_all;
			}

			$struktural_lembaga	= mysqli_real_escape_string($con,$_POST[struktural_lembaga]);
			if($struktural_lembaga=='Y') {
				$qstruktural_lembaga = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='lembaga' ");
				while($lembaga=mysqli_fetch_array($qstruktural_lembaga)) {
					$val_lembaga = $lembaga['user'].','.$val_lembaga;
				}
				$val_struktural = $val_struktural.$val_lembaga;
			}

			$struktural_bagian	= mysqli_real_escape_string($con,$_POST[struktural_bagian]);
			if($struktural_bagian=='Y') {
				$qstruktural_bagian = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='bagian' ");
				while($bagian=mysqli_fetch_array($qstruktural_bagian)) {
					$val_bagian = $bagian['user'].','.$val_bagian;
				}
				$val_struktural = $val_struktural.$val_bagian;
			}

			$struktural_upt	= mysqli_real_escape_string($con,$_POST[struktural_upt]);
			if($struktural_upt=='Y') {
				$qstruktural_upt = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='upt' ");
				while($upt=mysqli_fetch_array($qstruktural_upt)) {
					$val_upt = $upt['user'].','.$val_upt;
				}
				$val_struktural = $val_struktural.$val_upt;
			}


			$struktural_prodi = mysqli_real_escape_string($con,$_POST[struktural_prodi]);
			if($struktural_prodi=='Y') {
				$qstruktural_prodi = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='prodi' ");
				while($prodi=mysqli_fetch_array($qstruktural_prodi)) {
					$val_prodi = $prodi['user'].','.$val_prodi;
				}
				$val_struktural = $val_struktural.$val_prodi;
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
					mysqli_query($con,"INSERT INTO edr(id_jenis,asal,judul,nomor,tgl_sk,url_file,tembusan_struktural,tembusan_dosen,tembusan_karyawan) VALUES('$id_jenis','$_SESSION[ses_user]','$judul','$nomor','$tgl_sk','$short_file','$val_struktural','$val_dosen','$val_karyawan') ");
					header('Location: /edr/jenis/'.$id_jenis.'/?m=inserted');
	exit;
				}
				else {
					header('Location: /edr/jenis/'.$id_jenis.'/?m=not_inserted');
	exit;
				}
			}
			else {
				header('Location: /edr/jenis/'.$id_jenis.'/?m=not_inserted');
	exit;
			}
		}
		
		elseif($folder['2']=='mlm') {
			$id_jenis	= mysqli_real_escape_string($con,$_POST[id_jenis]);
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
			
			
			$dt	= mysqli_real_escape_string($con,$_POST[dt]);
			if($dt=='Y') {
				$qd = mysqli_query($con2,"SELECT nik FROM dosen WHERE ikatan='A' AND status='A' ");
				while($d=mysqli_fetch_array($qd)) {
					$val_dt = $d[nik].','.$val_dt;
				}
				$val_dosen = $val_dosen.$val_dt;
			}


			$dtt	= mysqli_real_escape_string($con,$_POST[dtt]);
			if($dtt=='Y') {
				$qdtt = mysqli_query($con2,"SELECT nik FROM dosen WHERE ikatan!='A' AND status='A' ");
				while($dttt=mysqli_fetch_array($qdtt)) {
					$val_dtt = $dttt[nik].','.$val_dtt;
				}
				$val_dosen = $val_dosen.$val_dtt;
			}
			
			$kt	= mysqli_real_escape_string($con,$_POST[kt]);
			if($kt=='Y') {
				$qk = mysqli_query($con3,"SELECT nik FROM karyawan WHERE ikatan='A' AND status='A' ");
				while($k=mysqli_fetch_array($qk)) {
					$val_kt = $k[nik].','.$val_kt;
				}
				$val_karyawan = $val_karyawan.$val_kt;
			}


			$ktt	= mysqli_real_escape_string($con,$_POST[ktt]);
			if($ktt=='Y') {
				$qktt = mysqli_query($con3,"SELECT nik FROM karyawan WHERE ikatan!='A' AND status='A' ");
				while($kttt=mysqli_fetch_array($qktt)) {
					$val_ktt = $kttt[nik].','.$val_ktt;
				}
				$val_karyawan = $val_karyawan.$val_ktt;
			}
			
			$struktural_all	= mysqli_real_escape_string($con,$_POST[struktural_all]);
			if($struktural_all=='Y') {
				$qstruktural_all = mysqli_query($con,"SELECT `user` FROM level ");
				while($all=mysqli_fetch_array($qstruktural_all)) {
					$val_all = $all['user'].','.$val_all;
				}
				$val_struktural = $val_struktural.$val_all;
			}

			$struktural_lembaga	= mysqli_real_escape_string($con,$_POST[struktural_lembaga]);
			if($struktural_lembaga=='Y') {
				$qstruktural_lembaga = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='lembaga' ");
				while($lembaga=mysqli_fetch_array($qstruktural_lembaga)) {
					$val_lembaga = $lembaga['user'].','.$val_lembaga;
				}
				$val_struktural = $val_struktural.$val_lembaga;
			}

			$struktural_bagian	= mysqli_real_escape_string($con,$_POST[struktural_bagian]);
			if($struktural_bagian=='Y') {
				$qstruktural_bagian = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='bagian' ");
				while($bagian=mysqli_fetch_array($qstruktural_bagian)) {
					$val_bagian = $bagian['user'].','.$val_bagian;
				}
				$val_struktural = $val_struktural.$val_bagian;
			}

			$struktural_upt	= mysqli_real_escape_string($con,$_POST[struktural_upt]);
			if($struktural_upt=='Y') {
				$qstruktural_upt = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='upt' ");
				while($upt=mysqli_fetch_array($qstruktural_upt)) {
					$val_upt = $upt['user'].','.$val_upt;
				}
				$val_struktural = $val_struktural.$val_upt;
			}


			$struktural_prodi = mysqli_real_escape_string($con,$_POST[struktural_prodi]);
			if($struktural_prodi=='Y') {
				$qstruktural_prodi = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='prodi' ");
				while($prodi=mysqli_fetch_array($qstruktural_prodi)) {
					$val_prodi = $prodi['user'].','.$val_prodi;
				}
				$val_struktural = $val_struktural.$val_prodi;
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
					mysqli_query($con,"INSERT INTO mlm(id_jenis,asal,judul,nomor,tgl_sk,url_file,tembusan_struktural,tembusan_dosen,tembusan_karyawan) VALUES('$id_jenis','$_SESSION[ses_user]','$judul','$nomor','$tgl_sk','$short_file','$val_struktural','$val_dosen','$val_karyawan') ");
					header('Location: /mlm/jenis/'.$id_jenis.'/?m=inserted');
	exit;
				}
				else {
					header('Location: /mlm/jenis/'.$id_jenis.'/?m=not_inserted');
	exit;
				}
			}
			else {
				header('Location: /mlm/jenis/'.$id_jenis.'/?m=not_inserted');
	exit;
			}
		}
		
		elseif($folder['2']=='per') {
			$id_jenis	= mysqli_real_escape_string($con,$_POST[id_jenis]);
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
			
			
			$dt	= mysqli_real_escape_string($con,$_POST[dt]);
			if($dt=='Y') {
				$qd = mysqli_query($con2,"SELECT nik FROM dosen WHERE ikatan='A' AND status='A' ");
				while($d=mysqli_fetch_array($qd)) {
					$val_dt = $d[nik].','.$val_dt;
				}
				$val_dosen = $val_dosen.$val_dt;
			}


			$dtt	= mysqli_real_escape_string($con,$_POST[dtt]);
			if($dtt=='Y') {
				$qdtt = mysqli_query($con2,"SELECT nik FROM dosen WHERE ikatan!='A' AND status='A' ");
				while($dttt=mysqli_fetch_array($qdtt)) {
					$val_dtt = $dttt[nik].','.$val_dtt;
				}
				$val_dosen = $val_dosen.$val_dtt;
			}
			
			$kt	= mysqli_real_escape_string($con,$_POST[kt]);
			if($kt=='Y') {
				$qk = mysqli_query($con3,"SELECT nik FROM karyawan WHERE ikatan='A' AND status='A' ");
				while($k=mysqli_fetch_array($qk)) {
					$val_kt = $k[nik].','.$val_kt;
				}
				$val_karyawan = $val_karyawan.$val_kt;
			}


			$ktt	= mysqli_real_escape_string($con,$_POST[ktt]);
			if($ktt=='Y') {
				$qktt = mysqli_query($con3,"SELECT nik FROM karyawan WHERE ikatan!='A' AND status='A' ");
				while($kttt=mysqli_fetch_array($qktt)) {
					$val_ktt = $kttt[nik].','.$val_ktt;
				}
				$val_karyawan = $val_karyawan.$val_ktt;
			}
			
			$struktural_all	= mysqli_real_escape_string($con,$_POST[struktural_all]);
			if($struktural_all=='Y') {
				$qstruktural_all = mysqli_query($con,"SELECT `user` FROM level ");
				while($all=mysqli_fetch_array($qstruktural_all)) {
					$val_all = $all['user'].','.$val_all;
				}
				$val_struktural = $val_struktural.$val_all;
			}

			$struktural_lembaga	= mysqli_real_escape_string($con,$_POST[struktural_lembaga]);
			if($struktural_lembaga=='Y') {
				$qstruktural_lembaga = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='lembaga' ");
				while($lembaga=mysqli_fetch_array($qstruktural_lembaga)) {
					$val_lembaga = $lembaga['user'].','.$val_lembaga;
				}
				$val_struktural = $val_struktural.$val_lembaga;
			}

			$struktural_bagian	= mysqli_real_escape_string($con,$_POST[struktural_bagian]);
			if($struktural_bagian=='Y') {
				$qstruktural_bagian = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='bagian' ");
				while($bagian=mysqli_fetch_array($qstruktural_bagian)) {
					$val_bagian = $bagian['user'].','.$val_bagian;
				}
				$val_struktural = $val_struktural.$val_bagian;
			}

			$struktural_upt	= mysqli_real_escape_string($con,$_POST[struktural_upt]);
			if($struktural_upt=='Y') {
				$qstruktural_upt = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='upt' ");
				while($upt=mysqli_fetch_array($qstruktural_upt)) {
					$val_upt = $upt['user'].','.$val_upt;
				}
				$val_struktural = $val_struktural.$val_upt;
			}


			$struktural_prodi = mysqli_real_escape_string($con,$_POST[struktural_prodi]);
			if($struktural_prodi=='Y') {
				$qstruktural_prodi = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='prodi' ");
				while($prodi=mysqli_fetch_array($qstruktural_prodi)) {
					$val_prodi = $prodi['user'].','.$val_prodi;
				}
				$val_struktural = $val_struktural.$val_prodi;
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
					mysqli_query($con,"INSERT INTO per(id_jenis,asal,judul,nomor,tgl_sk,url_file,tembusan_struktural,tembusan_dosen,tembusan_karyawan) VALUES('$id_jenis','$_SESSION[ses_user]','$judul','$nomor','$tgl_sk','$short_file','$val_struktural','$val_dosen','$val_karyawan') ");
					header('Location: /per/jenis/'.$id_jenis.'/?m=inserted');
	exit;
				}
				else {
					header('Location: /per/jenis/'.$id_jenis.'/?m=not_inserted');
	exit;
				}
			}
			else {
				header('Location: /per/jenis/'.$id_jenis.'/?m=not_inserted');
	exit;
			}
		}
		
		elseif($folder['2']=='ket') {
			$id_jenis	= mysqli_real_escape_string($con,$_POST[id_jenis]);
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
			
			
			$dt	= mysqli_real_escape_string($con,$_POST[dt]);
			if($dt=='Y') {
				$qd = mysqli_query($con2,"SELECT nik FROM dosen WHERE ikatan='A' AND status='A' ");
				while($d=mysqli_fetch_array($qd)) {
					$val_dt = $d[nik].','.$val_dt;
				}
				$val_dosen = $val_dosen.$val_dt;
			}


			$dtt	= mysqli_real_escape_string($con,$_POST[dtt]);
			if($dtt=='Y') {
				$qdtt = mysqli_query($con2,"SELECT nik FROM dosen WHERE ikatan!='A' AND status='A' ");
				while($dttt=mysqli_fetch_array($qdtt)) {
					$val_dtt = $dttt[nik].','.$val_dtt;
				}
				$val_dosen = $val_dosen.$val_dtt;
			}
			
			$kt	= mysqli_real_escape_string($con,$_POST[kt]);
			if($kt=='Y') {
				$qk = mysqli_query($con3,"SELECT nik FROM karyawan WHERE ikatan='A' AND status='A' ");
				while($k=mysqli_fetch_array($qk)) {
					$val_kt = $k[nik].','.$val_kt;
				}
				$val_karyawan = $val_karyawan.$val_kt;
			}


			$ktt	= mysqli_real_escape_string($con,$_POST[ktt]);
			if($ktt=='Y') {
				$qktt = mysqli_query($con3,"SELECT nik FROM karyawan WHERE ikatan!='A' AND status='A' ");
				while($kttt=mysqli_fetch_array($qktt)) {
					$val_ktt = $kttt[nik].','.$val_ktt;
				}
				$val_karyawan = $val_karyawan.$val_ktt;
			}
			
			$struktural_all	= mysqli_real_escape_string($con,$_POST[struktural_all]);
			if($struktural_all=='Y') {
				$qstruktural_all = mysqli_query($con,"SELECT `user` FROM level ");
				while($all=mysqli_fetch_array($qstruktural_all)) {
					$val_all = $all['user'].','.$val_all;
				}
				$val_struktural = $val_struktural.$val_all;
			}

			$struktural_lembaga	= mysqli_real_escape_string($con,$_POST[struktural_lembaga]);
			if($struktural_lembaga=='Y') {
				$qstruktural_lembaga = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='lembaga' ");
				while($lembaga=mysqli_fetch_array($qstruktural_lembaga)) {
					$val_lembaga = $lembaga['user'].','.$val_lembaga;
				}
				$val_struktural = $val_struktural.$val_lembaga;
			}

			$struktural_bagian	= mysqli_real_escape_string($con,$_POST[struktural_bagian]);
			if($struktural_bagian=='Y') {
				$qstruktural_bagian = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='bagian' ");
				while($bagian=mysqli_fetch_array($qstruktural_bagian)) {
					$val_bagian = $bagian['user'].','.$val_bagian;
				}
				$val_struktural = $val_struktural.$val_bagian;
			}

			$struktural_upt	= mysqli_real_escape_string($con,$_POST[struktural_upt]);
			if($struktural_upt=='Y') {
				$qstruktural_upt = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='upt' ");
				while($upt=mysqli_fetch_array($qstruktural_upt)) {
					$val_upt = $upt['user'].','.$val_upt;
				}
				$val_struktural = $val_struktural.$val_upt;
			}


			$struktural_prodi = mysqli_real_escape_string($con,$_POST[struktural_prodi]);
			if($struktural_prodi=='Y') {
				$qstruktural_prodi = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='prodi' ");
				while($prodi=mysqli_fetch_array($qstruktural_prodi)) {
					$val_prodi = $prodi['user'].','.$val_prodi;
				}
				$val_struktural = $val_struktural.$val_prodi;
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
					mysqli_query($con,"INSERT INTO ket(id_jenis,asal,judul,nomor,tgl_sk,url_file,tembusan_struktural,tembusan_dosen,tembusan_karyawan) VALUES('$id_jenis','$_SESSION[ses_user]','$judul','$nomor','$tgl_sk','$short_file','$val_struktural','$val_dosen','$val_karyawan') ");
					header('Location: /ket/jenis/'.$id_jenis.'/?m=inserted');
	exit;
				}
				else {
					header('Location: /ket/jenis/'.$id_jenis.'/?m=not_inserted');
	exit;
				}
			}
			else {
				header('Location: /ket/jenis/'.$id_jenis.'/?m=not_inserted');
	exit;
			}
		}
		
		elseif($folder['2']=='rek') {
			$id_jenis	= mysqli_real_escape_string($con,$_POST[id_jenis]);
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
			
			
			$dt	= mysqli_real_escape_string($con,$_POST[dt]);
			if($dt=='Y') {
				$qd = mysqli_query($con2,"SELECT nik FROM dosen WHERE ikatan='A' AND status='A' ");
				while($d=mysqli_fetch_array($qd)) {
					$val_dt = $d[nik].','.$val_dt;
				}
				$val_dosen = $val_dosen.$val_dt;
			}


			$dtt	= mysqli_real_escape_string($con,$_POST[dtt]);
			if($dtt=='Y') {
				$qdtt = mysqli_query($con2,"SELECT nik FROM dosen WHERE ikatan!='A' AND status='A' ");
				while($dttt=mysqli_fetch_array($qdtt)) {
					$val_dtt = $dttt[nik].','.$val_dtt;
				}
				$val_dosen = $val_dosen.$val_dtt;
			}
			
			$kt	= mysqli_real_escape_string($con,$_POST[kt]);
			if($kt=='Y') {
				$qk = mysqli_query($con3,"SELECT nik FROM karyawan WHERE ikatan='A' AND status='A' ");
				while($k=mysqli_fetch_array($qk)) {
					$val_kt = $k[nik].','.$val_kt;
				}
				$val_karyawan = $val_karyawan.$val_kt;
			}


			$ktt	= mysqli_real_escape_string($con,$_POST[ktt]);
			if($ktt=='Y') {
				$qktt = mysqli_query($con3,"SELECT nik FROM karyawan WHERE ikatan!='A' AND status='A' ");
				while($kttt=mysqli_fetch_array($qktt)) {
					$val_ktt = $kttt[nik].','.$val_ktt;
				}
				$val_karyawan = $val_karyawan.$val_ktt;
			}
			
			$struktural_all	= mysqli_real_escape_string($con,$_POST[struktural_all]);
			if($struktural_all=='Y') {
				$qstruktural_all = mysqli_query($con,"SELECT `user` FROM level ");
				while($all=mysqli_fetch_array($qstruktural_all)) {
					$val_all = $all['user'].','.$val_all;
				}
				$val_struktural = $val_struktural.$val_all;
			}

			$struktural_lembaga	= mysqli_real_escape_string($con,$_POST[struktural_lembaga]);
			if($struktural_lembaga=='Y') {
				$qstruktural_lembaga = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='lembaga' ");
				while($lembaga=mysqli_fetch_array($qstruktural_lembaga)) {
					$val_lembaga = $lembaga['user'].','.$val_lembaga;
				}
				$val_struktural = $val_struktural.$val_lembaga;
			}

			$struktural_bagian	= mysqli_real_escape_string($con,$_POST[struktural_bagian]);
			if($struktural_bagian=='Y') {
				$qstruktural_bagian = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='bagian' ");
				while($bagian=mysqli_fetch_array($qstruktural_bagian)) {
					$val_bagian = $bagian['user'].','.$val_bagian;
				}
				$val_struktural = $val_struktural.$val_bagian;
			}

			$struktural_upt	= mysqli_real_escape_string($con,$_POST[struktural_upt]);
			if($struktural_upt=='Y') {
				$qstruktural_upt = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='upt' ");
				while($upt=mysqli_fetch_array($qstruktural_upt)) {
					$val_upt = $upt['user'].','.$val_upt;
				}
				$val_struktural = $val_struktural.$val_upt;
			}


			$struktural_prodi = mysqli_real_escape_string($con,$_POST[struktural_prodi]);
			if($struktural_prodi=='Y') {
				$qstruktural_prodi = mysqli_query($con,"SELECT `user` FROM level WHERE kelompok='prodi' ");
				while($prodi=mysqli_fetch_array($qstruktural_prodi)) {
					$val_prodi = $prodi['user'].','.$val_prodi;
				}
				$val_struktural = $val_struktural.$val_prodi;
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
					mysqli_query($con,"INSERT INTO rek(id_jenis,asal,judul,nomor,tgl_sk,url_file,tembusan_struktural,tembusan_dosen,tembusan_karyawan) VALUES('$id_jenis','$_SESSION[ses_user]','$judul','$nomor','$tgl_sk','$short_file','$val_struktural','$val_dosen','$val_karyawan') ");
					header('Location: /rek/jenis/'.$id_jenis.'/?m=inserted');
	exit;
				}
				else {
					header('Location: /rek/jenis/'.$id_jenis.'/?m=not_inserted');
	exit;
				}
			}
			else {
				header('Location: /rek/jenis/'.$id_jenis.'/?m=not_inserted');
	exit;
			}
		}
*/		
		elseif($folder['2']=='filekegiatan') {
			$id	= mysqli_real_escape_string($con,$_POST['id']);
			$id_kegiatan	= mysqli_real_escape_string($con,$_POST['id_kegiatan']);
			$id_jenis_file	= mysqli_real_escape_string($con,$_POST['id_jenis_file']);

			$lokasi_file = $_FILES['fupload']['tmp_name'];
			$file   = $_FILES['fupload']['name'];
			$time = time();
			$file_extension = strtolower(substr(strrchr($file,"."),1));
			$nama_file = $_SESSION[ses_user].$time.'.'.$file_extension;			

	 		if (!empty($lokasi_file)){
				if ($file_extension!='php') {
					UploadKegiatan($nama_file);
					$short_file = 'https://sim.umkuningan.ac.id/file/kegiatan/'.$nama_file;
					mysqli_query($con,"INSERT INTO file_kegiatan(id_kegiatan,id_jenis_file,url_file) VALUES('$id','$id_jenis_file','$short_file') ");
					header('Location: /agenda/jenis/'.$id_kegiatan.'/?m=inserted');
	exit;
				}
				else {
					header('Location: /agenda/jenis/'.$id_kegiatan.'/?m=not_inserted');
	exit;
				}
			}
			else {
				header('Location: /agenda/jenis/'.$id_kegiatan.'/?m=not_inserted');
	exit;
			}		
			
			echo"<h1>";	
		}
		
		elseif($folder['2']=='presensikegiatan') {
			$id		= mysqli_real_escape_string($con,$_POST['id']);
			$id_kegiatan	= mysqli_real_escape_string($con,$_POST['id_kegiatan']);

			$q = mysqli_query($con2,"SELECT nik,name_glr FROM dosen WHERE status='A' AND ikatan='A' ");
			while ($r=mysqli_fetch_array($q)) {
			
			$presensi = $_POST[$r['nik']];
			
				if($presensi!='') {
			
					$cek = mysqli_num_rows(mysqli_query($con,"SELECT id FROM presensi WHERE id_kegiatan='$id' AND nik='$r[nik]' "));
					if($cek>0) {
						mysqli_query($con,"UPDATE presensi SET presensi='$presensi' WHERE id_kegiatan='$id' AND nik='$r[nik]' ");
					}
					else {
						mysqli_query($con,"INSERT INTO presensi(id_kegiatan,nik,presensi) VALUES('$id','$r[nik]','$presensi') ");				
					}
				}

			}



			header('Location: /agenda/presensi/'.$id.'/?m=inserted');
	exit;
		}		

	}
?>