<?php
declare(strict_types=1);

  switch($folder['3']) {
    default:

    	$thn = $folder['4'];
    
  	$unit = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM level WHERE user='$folder[3]' "));
  	    
	header("Content-type: application/msword");
	header("Content-disposition: attachment; filename=KontrakKinerja".$thn.$unit['nama_unit_singkat'].".doc");
  	
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
  	$cek_ind = mysqli_num_rows(mysqli_query($con,"SELECT id FROM indikator WHERE tahun='$thn' AND unit='$unit[user]' AND valid!='2' "));
	if($cek_ind>0) {
	  echo"
		<h3 style='color:red;'>KONTRAK KINERJA INI BELUM SEPENUHNYA DISETUJUI PIMPINAN, BELUM MENJADI DOKUMEN YANG SAH</h3>
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
							</tr>
						";
						$no = 1;
						$qi = mysqli_query($con,"SELECT * FROM indikator WHERE tahun='$thn' AND jenis='1' AND unit='$unit[user]' ");
						while($i=mysqli_fetch_array($qi)) {
							$luaran = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='luaran' AND value='$i[luaran]' "));
						echo"
							<tr class='text-xs'>
								<td class='tengah'>$no</td>
								<td><p><b>$i[topik]</b><br>$i[nama]</p><p><b>Kriteria</b>$i[kriteria]</p></td>
								<td class='tengah'>$i[standar] $i[skala]</td>
								<td class='tengah'>$i[capaian_before]</td>
								<td class='tengah'>$i[target_after]</td>
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
							</tr>
						";
						$no2 = 1;
						$qi2 = mysqli_query($con,"SELECT * FROM indikator WHERE tahun='$thn' AND jenis='2' AND unit='$unit[user]' ");
						while($i2=mysqli_fetch_array($qi2)) {
							$luaran2 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='luaran' AND value='$i2[luaran]' "));

						echo"
							<tr class='text-xs'>
								<td class='tengah'>$no2</td>
								<td>$i2[nama]</td>
								<td class='tengah'>$i2[standar]</td>
								<td class='tengah'>$i2[capaian_before]</td>
								<td class='tengah'>$i2[target_after]</td>
							</tr>
						";
						$no2++;
						}
						echo"
							<tr>
								<td colspan='5'></td>
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
<?php
    break;
    
    case 'laporan':
    
       	$thn = $folder['5'];

  	$unit = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM level WHERE user='$folder[4]' "));
  	    
	header("Content-type: application/msword");
  	header("Content-disposition: attachment; filename=LaporanKinerja".$unit['nama_unit_singkat'].".doc");
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
<h3>TAHUN 2025</h3>
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
						$qi = mysqli_query($con,"SELECT * FROM indikator WHERE jenis='1' AND tahun='$thn' AND unit='$folder[4]' ");
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
								<th>Capaian</th>
								<th>Target</th>
								<th>Capaian</th>
								<th>Status</th>
								<th>Lampiran</th>
							</tr>
						";
						$no2 = 1;
						$qi2 = mysqli_query($con,"SELECT * FROM indikator WHERE jenis='2' AND tahun='$thn' AND unit='$folder[4]' ");
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
								<td class='tengah'>$i2[standar]</td>
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
<?php
    break;
    
    case 'rekap':
    	$per = simple_bln($now_date);
	header("Content-type: application/msword");
	header("Content-disposition: attachment; filename=RekapKinerja".$per."-Jam".$cu_h.".doc");
  	
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
  .tengah, .text-center {
  	text-align: center;
  }
  
</style>
<p>
<h3>REKAPITULASI KONTRAK KINERJA DAN PROGRAM KERJA</h3>
<h3>PER <?php echo indo_date($tgl_sekarang); ?> PUKUL <?php echo $cu_h; ?></h3>
<h3>UNIVERSITAS MUHAMMADIYAH KUNINGAN</h3>
<h3>TAHUN <?=$folder['4'];?></h3>
</p>
<br>

				<table class='box'>
<?php
						echo"
						<tr class='text-center'>
						<th rowspan='2'>No</th>
						<th rowspan='2'>Nama Unit</th>
						<th colspan='2' class='text-center'>Jumlah</th>
						<th colspan='2' class='text-center'>% Isian</th>
						<th rowspan='2' class='text-center'>Keterangan</th>
						</tr>
						<tr class='table-info'>
						<th class='text-center'>IKU</th>
						<th class='text-center'>IKT</th>
						<th class='text-center'>IKU/IKT</th>
						<th class='text-center'>Proker</th>
						</tr>
						";
						$no = 1;
						$qu = mysqli_query($con,"SELECT * FROM level ORDER BY id ");
						while($u=mysqli_fetch_array($qu)) {
							$iku = mysqli_num_rows(mysqli_query($con,"SELECT id FROM indikator WHERE jenis='1' AND unit='$u[user]' AND tahun='$folder[4]' "));
							$ikt = mysqli_num_rows(mysqli_query($con,"SELECT id FROM indikator WHERE jenis='2' AND unit='$u[user]' AND tahun='$folder[4]' "));
							$ik = $iku + $ikt;
							$isi_iku = mysqli_num_rows(mysqli_query($con,"SELECT id FROM indikator WHERE jenis='1' AND unit='$u[user]' AND valid!='' AND tahun='$folder[4]' "));
							$isi_ikt = mysqli_num_rows(mysqli_query($con,"SELECT id FROM indikator WHERE jenis='2' AND unit='$u[user]' AND valid!='' AND tahun='$folder[4]' "));
							$isi = $isi_iku + $isi_ikt;
							$persen_ik = ROUND($isi / $ik * 100,0);
							$jproker = mysqli_num_rows(mysqli_query($con,"SELECT * FROM indikator,proker WHERE indikator.id=proker.id_indikator AND indikator.unit='$u[user]' AND indikator.tahun='$folder[4]' GROUP BY indikator.id "));
							$persen_proker = ROUND($jproker / $ik * 100,0);
							if($persen_ik=='100' AND $persen_proker=='100') {
								$bg = '#39fc03';
							}
							else {
								$bg = '#db140d';
							}

							
							echo"
							<tr class='text-sm'>
							<td>$no</td>
							<td>$u[nama_unit_singkat]</td>
							<td class='text-center'>$iku</td>
							<td class='text-center'>$ikt</td>
							<td class='text-center'>$persen_ik %</td>
							<td class='text-center'>$persen_proker %</td>
							<td class='text-center' style='background-color:$bg'>
							";
							if($persen_ik=='100' AND $persen_proker=='100') {
								echo"
								Sudah Mengisi
								";
							}
							else {
								echo"
								<span class='text-xs'>isian belum 100%</span>
								";
							}
							
							echo"
							</td>
							</tr>
							";
						$no++;
						}
?>
				</table>
<?php
    break;
    

    
    }
?>