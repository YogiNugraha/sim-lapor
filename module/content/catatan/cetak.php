<?php
declare(strict_types=1);

  	$unit = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM level WHERE user='$_SESSION[ses_user]' "));
	$bulan = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='bulan' AND value='$folder[3]' AND keterangan='$folder[4]' "));
	$prev = $bulan['value']-1;
	$bulan_prev = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='bulan' AND value='$prev' AND keterangan='$folder[4]' "));
	header("Content-type: application/msword");
  	header("Content-disposition: attachment; filename=BA".$bulan['desc']."-".$unit['nama_unit_singkat'].".doc");

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
  	$jind = mysqli_num_rows(mysqli_query($con,"SELECT id FROM indikator WHERE unit='$_SESSION[ses_user]' AND tahun='$folder[4]' "));
  	$jcatatan = mysqli_num_rows(mysqli_query($con,"SELECT catatan.id FROM catatan,indikator WHERE catatan.id_indikator=indikator.id AND indikator.unit='$unit[user]' AND catatan.id_bulan='$folder[3]' AND indikator.tahun='$folder[4]' GROUP BY indikator.id "));
	if($jind!=$jcatatan) { 
  		echo"<h1 style='color:red';>Silakan lengkapi terlebih dahulu semua isian laporan bulanan</h1>";
	}
	
?>
<img src="https://sim.umkuningan.ac.id/dist/img/kop.png" width="100px">
<p>
<h3>BERITA ACARA</h3>

</p>
<br>
<p>
Pada hari ............. tanggal ................... telah dilaksanakan Laporan Kinerja Bulan <b><?php echo $bulan['desc']; ?> 2025</b> untuk <b><?php echo $unit['nama_unit']; ?></b> dengan hasil:
</p>
				<table class='box'>
<?php

						$no = 1;
						$qi = mysqli_query($con,"SELECT indikator.* FROM indikator WHERE indikator.unit='$unit[user]' AND tahun='$folder[4]' ORDER BY indikator.jenis,indikator.id ");
						echo"
							<tr>
								<th>No.</th>
								<th>IKU / IKT</th>
								<th>Standar</th>
								<th>Target</th>
								<th>Capaian $bulan_prev[desc]</th>
								<th>Capaian $bulan[desc]</th>
								<th>Lampiran</th>
							</tr>
						";

						while($i=mysqli_fetch_array($qi)) {
						$c = mysqli_fetch_array(mysqli_query($con,"SELECT catatan.* FROM catatan WHERE catatan.id_indikator='$i[id]' AND catatan.id_bulan='$folder[3]' "));
						if($c['capaian']=='') {
							$capaian = '';
						}
						else {
							$capaian = $c['capaian'];
						}
						$c_prev = mysqli_fetch_array(mysqli_query($con,"SELECT catatan.* FROM catatan WHERE catatan.id_indikator='$i[id]' AND catatan.id_bulan='$bulan_prev[value]' "));
						if($c_prev['capaian']=='') {
							$capaian_prev = '';
						}
						else {
							$capaian_prev = $c_prev['capaian'];
						}

						echo"
							<tr class='kecil'>
								<td>$no</td>
								<td><b>$i[topik]</b><br>$i[nama]</td>
								<td class='tengah'>$i[standar] $i[skala]</td>
								<td class='tengah'>$i[target_after]</td>
								<td class='tengah'>$capaian_prev</td>
								<td class='tengah'>$capaian</td>
								<td class='tengah'>
						";
							if($c['url_file']!='') { echo"
								Ada
							"; }
							else { echo " 
								Tidak ada
							"; }
						echo"
								</td>
							</tr>
						";
						$no++;
						}
?>
				</table>
				<p><b>Komentar Pimpinan</b><p>
				<p>.................................................</p>
				

						<br><br>
						<table width="100%">
						<tr>
						<td width="65%">
						<br>
						Rektor,<br>
						<br>
						<br>
						<br>
						<b>Dr. apt. Wawang Anwarudin, M.Sc.</b><br>
						NIDN. 0419067803
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
						
