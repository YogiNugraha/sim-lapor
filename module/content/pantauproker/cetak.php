<?php
declare(strict_types=1);

  	$unit = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM level WHERE user='$folder[3]' "));
	header("Content-type: application/msword");
  	header("Content-disposition: attachment; filename=ProgramKerja".$unit['nama_unit_singkat'].".doc");

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
  .kiri {
  	text-align: left;
  } 
.kecil td {
	font-size: 11pt;
} 
</style>
<?php
  	$jind = mysqli_num_rows(mysqli_query($con,"SELECT id FROM indikator WHERE unit='$unit[user]' AND tahun='$folder[4]' AND valid!='' "));
  	$jproker = mysqli_num_rows(mysqli_query($con,"SELECT proker.id FROM proker,indikator WHERE proker.id_indikator=indikator.id AND indikator.unit='$unit[user]' AND indikator.tahun='$folder[4]' GROUP BY indikator.id "));
	if($jproker<$jind) {
	  echo"
		<h3 style='color:red;'>PROGRAM KERJA INI BELUM SEPENUHNYA DISETUJUI PIMPINAN, BELUM MENJADI DOKUMEN YANG SAH</h3>
	  ";
	}
?>
<p>
<h3>PROGRAM KERJA</h3>
<h3><?php echo strtoupper($unit['nama_unit']); ?></h3>
<h3>UNIVERSITAS MUHAMMADIYAH KUNINGAN</h3>
<h3>TAHUN <?=$folder['4'];?></h3>
</p>
<br>
				<table class='box'>
<?php

						$no = 1;
						$qi = mysqli_query($con,"SELECT proker.*,indikator.nama,indikator.jenis,indikator.standar,indikator.skala,indikator.capaian_before,indikator.target_after FROM proker,indikator WHERE proker.id_indikator=indikator.id AND indikator.unit='$unit[user]' AND indikator.tahun='$folder[4]' ORDER BY indikator.jenis,indikator.id,proker.id ");
						echo"
							<tr>
								<th>No</th>
								<th>Indikator/Tujuan</th>
								<th>Nama Kegiatan</th>
								<th>Deskripsi Kegiatan</th>
								<th>Waktu Pelaksanaan</th>
								<th>Sasaran</th>
								<th>Anggaran</th>
							</tr>
						";

						while($i=mysqli_fetch_array($qi)) {
							if($i['jenis']=='1') {
								$ik = 'IKU';
							}
							elseif($i['jenis']=='2') {
								$ik = 'IKT';
							}
							else {
								$ik = '';
							}
							$anggaran = rupiah($i['anggaran']);
							$waktu_mulai = simple_bln($i['waktu_mulai']);
							$waktu_selesai = simple_bln($i['waktu_selesai']);
						echo"
							<tr class='kecil'>
								<td>$no</td>
								<td>
								    <p>[$ik] $i[nama]</p>
								    Standar: $i[standar]  $i[skala]<br>
								    Baseline: $i[capaian_before]<br>
								    Target: $i[target_after]
								</td>

								<td>$i[bentuk]</td>
								<td>$i[deskripsi]</td>
								<td>$waktu_mulai s.d $waktu_selesai</td>
								<td>$i[sasaran]</td>
								<td>$anggaran</td>
							</tr>
						";
						$no++;
						}
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
						
