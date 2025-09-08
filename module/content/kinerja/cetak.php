<?php
declare(strict_types=1);

  switch($folder['3']) {
    default:
    
    	$thn = $folder['4'];
    
  	$unit = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM level WHERE user='$_SESSION[ses_user]' "));
  	    
	header("Content-type: application/msword");
  	header("Content-disposition: attachment; filename=KontrakKinerja".$thn.$unit['nama_unit_singkat'].".doc");
  	
  	$cek_isian = mysqli_num_rows(mysqli_query($con,"SELECT id FROM indikator WHERE tahun='$thn' AND unit='$_SESSION[ses_user]' AND valid='' "));
  	if($cek_isian>1000) {
  		echo"<h1>Silakan lengkapi terlebih dahulu semua isian kontrak kinerja</h1>";
  	}
 
  	$cek_ind = mysqli_num_rows(mysqli_query($con,"SELECT id FROM indikator WHERE tahun='$thn' AND unit='$_SESSION[ses_user]' AND valid!='2' "));
?>
<style>
.box table, .box tr, .box td, .box th {
	border: 1px solid black;
	border-collapse: collapse;
	padding: 5px;
  }
.box th {
  	background-color: #ccc ;
  }
  h3 {
  	text-align: center;
  	font-size: 12pt;
  	margin:2px;
  }
  .tengah {
  	text-align: center;
  }
  
</style>
<?php
	if($cek_ind>0) {
	  echo"
		<h3 style='color:red;'>KONTRAK KINERJA INI SEPENUHNYA BELUM DISETUJUI PIMPINAN, BELUM MENJADI DOKUMEN YANG SAH</h3>
	  ";
	}
?>
<p>
<h3>KONTRAK KINERJA</h3>
<h3><?php echo strtoupper($unit['nama_unit']); ?></h3>
<h3>UNIVERSITAS MUHAMMADIYAH KUNINGAN</h3>
<h3>TAHUN <?php echo $thn; ?></h3>
</p>
<br>
						<table class='box'>
<?php
						echo"
							<tr class='table-primary'>
								<th>No</th>
								<th>Indikator Kinerja Utama (IKU)</th>
								<th>Standar</th>
								<th>Baseline</th>
								<th>Target</th>
								<th>Luaran</th>
							</tr>
						";
						$no = 1;
						$qi = mysqli_query($con,"SELECT * FROM indikator WHERE tahun='$thn' AND jenis='1' AND unit='$_SESSION[ses_user]' ");
						while($i=mysqli_fetch_array($qi)) {
							$luaran = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='luaran' AND value='$i[luaran]' "));

							echo"
								<tr class='text-xs'>
									<td class='tengah'>$no</td>
									<td><p><b>$i[topik]</b><br>$i[nama]</p><p><b>Kriteria</b>$i[kriteria]</p></td>
									<td class='tengah'>$i[standar] $i[skala]</td>
									<td class='tengah'>$i[capaian_before]</td>
									<td class='tengah'>$i[target_after]</td>
									<td class='tengah'>$luaran[desc]</td>
								</tr>
							";
						$no++;
						}
?>

<?php
						echo"
							<tr class='table-primary'>
								<th>No</th>
								<th>Indikator Kinerja Tambahan (IKT)</th>
								<th>Standar</th>
								<th>Baseline</th>
								<th>Target</th>
								<th>Luaran</th>
							</tr>
						";
						$no2 = 1;
						$qi2 = mysqli_query($con,"SELECT * FROM indikator WHERE tahun='$thn' AND jenis='2' AND unit='$_SESSION[ses_user]' ");
						while($i2=mysqli_fetch_array($qi2)) {
							$luaran2 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='luaran' AND value='$i2[luaran]' "));

							echo"
								<tr class='text-xs'>
									<td class='tengah'>$no2</td>
									<td><p>$i2[nama]</p></td>
									<td class='tengah'>$i2[standar]</td>
									<td class='tengah'>$i2[capaian_before]</td>
									<td class='tengah'>$i2[target_after]</td>
									<td class='tengah'>$luaran2[desc]</td>
								</tr>
							";
							$no2++;
						}
						echo"
							<tr>
								<td colspan='6'></td>
							</tr>
						";
?>
						</table>
						<br><br>
						<table width="100%">
						<tr>
						<td width="65%">
						</td>
						<td width="35%">
						Kuningan, ........<br>
						<?php echo $unit['jabatan_unit']; ?> <?php echo $unit['nama_unit_singkat']; ?>,<br>
						<br>
						<br>
						<br>
						<b><?php echo $unit['pejabat_unit']; ?></b><br>
						NIK. <?php echo $unit['nik_unit']; ?>
						</td>
						</table>
<?php

    break;
    
    case 'laporan':
    
    	$thn = $folder['4'];

  	$unit = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM level WHERE user='$_SESSION[ses_user]' "));
  	    
	header("Content-type: application/msword");
  	header("Content-disposition: attachment; filename=LaporanKinerja".$thn.$unit['nama_unit_singkat'].".doc");
?>
<style>
.box table, .box tr, .box td, .box th {
	border: 1px solid black;
	border-collapse: collapse;
	padding: 5px;
  }
.box th {
  	background-color: #ccc ;
  }
  h3 {
  	text-align: center;
  	font-size: 12pt;
  	margin:2px;
  }
  .tengah {
  	text-align: center;
  }
  
</style>
<p>
<h3>LAPORAN KINERJA</h3>
<h3><?php echo strtoupper($unit['nama_unit']); ?></h3>
<h3>UNIVERSITAS MUHAMMADIYAH KUNINGAN</h3>
<h3>TAHUN <?php echo $thn; ?></h3>
</p>
<br>
						<table class='box'>
<?php
						echo"
							<tr class='table-primary'>
								<th>No</th>
								<th>Indikator Kinerja Utama (IKU)</th>
								<th>Standar</th>
								<th>Baseline</th>
								<th>Target</th>
								<th>Capaian</th>
								<th>Status</th>
								<th>Lampiran</th>
							</tr>
						";
						$no = 1;
						$qi = mysqli_query($con,"SELECT * FROM indikator WHERE tahun='$thn' AND jenis='1' AND unit='$_SESSION[ses_user]' ");
						while($i=mysqli_fetch_array($qi)) {

							$ivalid = $i['status_monev'];
							if($ivalid=='1') {
								$valid = "Belum diriviu</span>";
							}
							elseif($ivalid=='2') {
								$valid = "Tercapai";
							}
							elseif($ivalid=='3') {
								$valid = "Belum Tercapai";
							}
							else {
								$valid = "";
							}
							
							if($i['dokumen']=='') {
								$dokumen = '';
							}
							else {
								$dokumen = "<a href='".$i[dokumen]."'>Bukti Pendukung</a>";
							}

							$luaran = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='luaran' AND value='$i[luaran]' "));


						echo"
							<tr class='text-xs'>
								<td class='tengah'>$no</td>
								<td>
									<p>$i[nama]</p>
									<p><b>Analisis Ketercapaian/Ketidaktercapaian:</b> <br>$i[analisis]</p>
									<p><b>Rencana Tindak Lanjut:</b> <br>$i[rtl]</p>
									<p><b>Hasil Monev:</b> <br>$i[hasil_monev]</p>
									<p><b>Rekomendasi:</b> <br>$i[rekomendasi_monev]</p>
								</td>
								<td class='tengah'>$i[standar] $i[skala]</td>
								<td class='tengah'>$i[capaian_before]</td>
								<td class='tengah'>$i[target_after]</td>
								<td class='tengah'>$i[capaian_after]</td>
								<td class='tengah'>$valid</td>
								<td class='tengah'>$dokumen</td>
							</tr>
						";
						$no++;
						}
?>

<?php
						echo"
							<tr class='table-primary'>
								<th>No</th>
								<th>Indikator Kinerja Tambahan (IKT)</th>
								<th>Standar</th>
								<th>Baseline</th>
								<th>Target</th>
								<th>Capaian</th>
								<th>Lampiran</th>
							</tr>
						";
						$no2 = 1;
						$qi2 = mysqli_query($con,"SELECT * FROM indikator WHERE tahun='$thn' AND jenis='2' AND unit='$_SESSION[ses_user]' ");
						while($i2=mysqli_fetch_array($qi2)) {

							$ivalid2 = $i2['status_monev'];
							if($ivalid2=='1') {
								$valid2 = "<span class='badge badge-warning'>In Review</span>";
							}
							elseif($ivalid2=='2') {
								$valid2 = "<span class='badge badge-success'>Tercapai</span>";
							}
							elseif($ivalid2=='3') {
								$valid2 = "<span class='badge badge-danger'>Belum Tercapai</span>";
							}
							else {
								$valid2 = "";
							}
							
							if($i2['dokumen']=='') {
								$dokumen2 = '';
							}
							else {
								$dokumen2 = "<a href='".$i2[dokumen]."'>Bukti Pendukung</a>";
							}

							$luaran2 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='luaran' AND value='$i2[luaran]' "));

						echo"
							<tr class='text-xs'>
								<td class='tengah'>$no2</td>
								<td>
									<p>$i2[nama]</p>
									<p><b>Analisis Ketercapaian/Ketidaktercapaian:</b> <br>$i2[analisis]</p>
									<p><b>Rencana Tindak Lanjut:</b> <br>$i2[rtl]</p>
									<p><b>Hasil Monev:</b> <br>$i2[hasil_monev]</p>
									<p><b>Rekomendasi:</b> <br>$i2[rekomendasi_monev]</p>
								</td>
								<td class='tengah'>$i2[standar] $i[skala]</td>
								<td class='tengah'>$i2[capaian_before]</td>
								<td class='tengah'>$i2[target_after]</td>
								<td class='tengah'>$i2[capaian_after]</td>
								<td class='tengah'>$valid2</td>
								<td class='tengah'>$dokumen2</td>
							</tr>
						";
						$no2++;
						}
						echo"
							<tr>
								<td colspan='8'></td>
							</tr>
						";
?>
						</table>
						<br><br>
						<table width="100%">
						<tr>
						<td width="65%">
						</td>
						<td width="35%">
						Kuningan, ........<br>
						<?php echo $unit['jabatan_unit']; ?> <?php echo $unit['nama_unit_singkat']; ?>,<br>
						<br>
						<br>
						<br>
						<b><?php echo $unit['pejabat_unit']; ?></b><br>
						NIK. <?php echo $unit['nik_unit']; ?>
						</td>
						</table>
<?php
    break;
    
    }
?>