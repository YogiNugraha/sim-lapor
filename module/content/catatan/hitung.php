<?php
declare(strict_types=1);


function hitung($data,$unit) {
	define ('host' , 'localhost');
	define ('user' , 'akreditasi');
	define ('pass' , 'Atsaqif7!');
	define ('dbase', 'akreditasi');
	$con = mysqli_connect(host, user, pass) OR DIE (" Koneksi Gagal ");
	mysqli_select_db($con,dbase) OR DIE ("Cannot connect to database ");
										
	define ('host2' , 'localhost');
	define ('user2' , 'siamik');
	define ('pass2' , '5Tk1pmKn6');
	define ('dbase2', 'siamik');
	$con2 = mysqli_connect(host2, user2, pass2) OR DIE (" Koneksi Gagal ");
	mysqli_select_db($con2,dbase2) OR DIE ("Cannot connect to database ");
										
	define ('host3' , 'localhost');
	define ('user3' , 'simpeg');
	define ('pass3' , 'n4ru70kuns4n');
	define ('dbase3', 'simpeg');
	$con3 = mysqli_connect(host3, user3, pass3) OR DIE (" Koneksi Gagal ");
	mysqli_select_db($con3,dbase3) OR DIE ("Cannot connect to database ");
	
	define ('host4' , 'localhost');
	define ('user4' , 'pmb');
	define ('pass4' , 'n4ru70kuns4n');
	define ('dbase4', 'pmb');
	$con4 = mysqli_connect(host4, user4, pass4) OR DIE (" Connection Failed with server. ");
	mysqli_select_db($con4,dbase4) OR DIE ("Cannot connect to database ");
											
	switch($data) {

		case '36':
			$dosen = mysqli_num_rows(mysqli_query($con2,"SELECT dosen.nik FROM dosen,kontrak,ta WHERE dosen.nik=kontrak.dosen AND kontrak.ta=ta.kode AND ta.active='Y' AND dosen.nik!='' AND dosen.ikatan='A' GROUP BY dosen.nik,kontrak.prodi "));
			$prodi = mysqli_fetch_array(mysqli_query($con2,"SELECT COUNT(*) AS j FROM prodi WHERE 1 "));
			$capaian = ROUND($dosen/$prodi['j'],0);
		break;
		case '37':
			$dosen = mysqli_fetch_array(mysqli_query($con2,"SELECT COUNT(*) AS j FROM dosen WHERE ikatan='A' AND status='A' "));
			$mhs = mysqli_num_rows(mysqli_query($con2,"SELECT trakm.nim FROM trakm,ta WHERE trakm.ta=ta.kode AND ta.active='Y' AND trakm.status='A' "));
			$capaian = ROUND($mhs/$dosen['j'],0);
		break;

		case '38':
			$dosens3 = mysqli_fetch_array(mysqli_query($con2,"SELECT COUNT(*) AS j FROM dosen WHERE ikatan='A' AND status='A' AND jenjang_pendidikan>='G' "));
			$dosen = mysqli_fetch_array(mysqli_query($con2,"SELECT COUNT(*) AS j FROM dosen WHERE ikatan='A' AND status='A' "));
			$capaian = ROUND(($dosens3['j']/$dosen['j'])*100,0);
		break;
				
		case '39':
			$dosenjafung = mysqli_fetch_array(mysqli_query($con2,"SELECT COUNT(*) AS j FROM dosen WHERE ikatan='A' AND status='A' AND jafung>='3' "));
			$dosen = mysqli_fetch_array(mysqli_query($con2,"SELECT COUNT(*) AS j FROM dosen WHERE ikatan='A' AND status='A' "));
			$capaian = ROUND(($dosenjafung['j']/$dosen['j'])*100,0);
		break;
		
		case '40':
			$dosentt = mysqli_num_rows(mysqli_query($con2,"SELECT dosen.nik FROM dosen,kontrak,ta WHERE dosen.nik=kontrak.dosen AND kontrak.ta=ta.kode AND ta.active='Y' AND dosen.nik!='' AND dosen.ikatan!='A' GROUP BY dosen.nik "));
			$dosen = mysqli_fetch_array(mysqli_query($con2,"SELECT COUNT(*) AS j FROM dosen WHERE ikatan='A' AND status='A' "));
			$capaian = ROUND(($dosentt/$dosen['j'])*100,0);
		break;

	
		case '178':
			$semprop = mysqli_num_rows(mysqli_query($con2,"SELECT kegiatan.id FROM kegiatan,trakm,ta,mhs WHERE mhs.nim=trakm.nim AND kegiatan.nim=trakm.nim AND trakm.ta=ta.kode AND ta.active='Y' AND kegiatan.jenis='4' AND kegiatan.finish!='N' AND mhs.prodi='$unit' "));
			$dosen = mysqli_fetch_array(mysqli_query($con2,"SELECT COUNT(*) AS j FROM dosen WHERE ikatan='A' AND status='A' AND homebase='$unit' "));
			$capaian = ROUND($semprop/$dosen['j'],0);
		break;

		case '9':
			$capaian = 0;
		break;

		case '10':
			$jmlh = mysqli_fetch_array(mysqli_query($con4,"SELECT COUNT(*) AS j FROM pendaftar WHERE ta='20221' AND spam!='Y' AND prodi!='' "));
			$sebelumnya = mysqli_fetch_array(mysqli_query($con4,"SELECT COUNT(*) AS j FROM pendaftar WHERE ta='20211' AND spam!='Y' AND prodi!='' "));
			$selisih = $jmlh['j'] - $sebelumnya['j'];
			$capaian = ROUND(($selisih/$sebelumnya['j'])*100,0);
		break;
	}
		return $capaian;							
}
?>