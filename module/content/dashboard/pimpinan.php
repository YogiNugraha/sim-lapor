<?php
declare(strict_types=1);
 

ob_start();	

	if (empty($_SESSION['ses_user']) AND empty($_SESSION['ses_pass']) AND empty($_SESSION['ses_level']) ){
		header('Location: /login');
	exit;
	}
	else {
?>

<?php
	switch($folder['2']) {

		default:

		if($folder['3']=='') {
			$thn = '2025';
		}
		else {
			$thn = $folder['3'];
		}
?>

		<div class='card'>
			<div class='card-body'>
				<select onchange="window.document.location.href=this.options[this.selectedIndex].value;" class='form-control' name='ta'>
				<option value='#'>-- Pilih Tahun --</option> 
					<?php
			
					$qp = mysqli_query($con2,"SELECT * FROM periode ");
					while($p = mysqli_fetch_array($qp)) {
					if($p['thn']==$folder['3']) { $selected = 'selected'; } 
					else { 
						if($p['thn']=='2025' AND $folder['3']=='') {
							$selected = 'selected';
						}
						else {
							$selected = '';
						}
					}
						echo "
							<option value='/pantaukinerja/default/$p[thn]' $selected>$p[thn]</option>
						";
					}
					?>
				</select>
			</div>
		</div>

		<div class='card'>
			<div class='card-header with-border'>
				<h3 class='card-title'>Rekapitulasi Kontrak  Kinerja</h3>
			        <div class="card-tools">
		                      <a class="btn btn-danger btn-sm" href="/cetak/pantaukinerja/rekap/<?=$folder['3'];?>"><i class="fa fa-file-word"></i> Save as Word</a>
		                 </div>	
			</div>
			<div class="card-body">
			<div class='table-responsive'>
				<table class='table table-striped'>
<?php
						echo"
						<tr class='table-primary'>
						<th rowspan='2'>No</th>
						<th rowspan='2'>Nama Unit</th>
						<th colspan='2' class='text-center'>Jumlah</th>
						<th colspan='3' class='text-center'>% Isian</th>
						<th rowspan='2' class='text-center'>Kontrak</th>
						<th rowspan='2' class='text-center'>Laporan Akhir</th>
						</tr>
						<tr class='table-info'>
						<th class='text-center'>IKU</th>
						<th class='text-center'>IKT</th>
						<th class='text-center'>Kontrak</th>
						<th class='text-center'>Proker</th>
						<th class='text-center'>Laporan Akhir</th>
						</tr>
						";
						$no = 1;
						$qu = mysqli_query($con2,"SELECT * FROM level ORDER BY susun ");
						while($u=mysqli_fetch_array($qu)) {
							$iku = mysqli_num_rows(mysqli_query($con2,"SELECT id FROM indikator WHERE tahun='$thn' AND jenis='1' AND unit='$u[user]' "));
							$ikt = mysqli_num_rows(mysqli_query($con2,"SELECT id FROM indikator WHERE tahun='$thn' AND jenis='2' AND unit='$u[user]' "));
							$ik = $iku + $ikt;
							$isi_iku = mysqli_num_rows(mysqli_query($con2,"SELECT id FROM indikator WHERE tahun='$thn' AND jenis='1' AND unit='$u[user]' AND valid!='' "));
							$isi_ikt = mysqli_num_rows(mysqli_query($con2,"SELECT id FROM indikator WHERE tahun='$thn' AND jenis='2' AND unit='$u[user]' AND valid!='' "));
							$isi = $isi_iku + $isi_ikt;
							$persen_ik = ROUND($isi / $ik * 100,0);
							$jproker = mysqli_num_rows(mysqli_query($con2,"SELECT * FROM indikator,proker WHERE indikator.tahun='$thn' AND indikator.id=proker.id_indikator AND indikator.unit='$u[user]' GROUP BY indikator.id "));
							$persen_proker = ROUND($jproker / $ik * 100,0);

							$isi_laporan = mysqli_num_rows(mysqli_query($con2,"SELECT id FROM indikator WHERE tahun='$thn' AND unit='$u[user]' AND capaian_after!='' "));
							$persen_laporan = ROUND($isi_laporan / $ik * 100,0);


							if($persen_ik=='100') {
								$bg_ik = 'success';
							}
							elseif($persen_ik=='0') {
								$bg_ik = 'danger';
							}
							else {
								$bg_ik = 'warning';
							}
							if($persen_proker=='100') {
								$bg_proker = 'success';
							}
							elseif($persen_proker=='0') {
								$bg_proker = 'danger';
							}
							else {
								$bg_proker = 'warning';
							}
							if($persen_laporan=='100') {
								$bg_laporan = 'success';
							}
							elseif($persen_laporan=='0') {
								$bg_laporan = 'danger';
							}
							else {
								$bg_laporan = 'warning';
							}
							
							echo"
							<tr class='text-sm'>
							<td>$no</td>
							<td>$u[nama_unit_singkat]</td>
							<td class='text-center'>$iku</td>
							<td class='text-center'>$ikt</td>
							<td class='text-center'><span class='badge badge-$bg_ik'>$persen_ik %</span></td>
							<td class='text-center'><span class='badge badge-$bg_proker'>$persen_proker %</span></td>
							<td class='text-center'><span class='badge badge-$bg_laporan'>$persen_laporan %</span></td>
							<td class='text-center'>
							";
							if($persen_ik>0) {
								echo"
								<a href='/pantaukinerja/validasi/$u[user]/$thn' class='btn btn-primary btn-xs'><i class='fa fa-eye'></i> Vallidasi
								";
							}
							else {
								echo"
								<span class='text-xs'>belum ada isian</span>
								";
							}
							
							echo"
							</td>
							<td class='text-center'>
							";
							if($persen_laporan=='100') {
								echo"
								<a href='/pantaukinerja/laporan/$u[user]/$thn' class='btn btn-primary btn-xs'><i class='fa fa-eye'></i> Lihat
								";
							}
							else {
								echo"
								<span class='text-xs'>isian laporan akhir belum 100%</span>
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
			</div>
					
			</div>
		</div>


		<div class='card card-danger card-outline card-outline-tabs'>
			<div class='card-header border-bottom-0'>
			        <div class="card-tools">
		                      <a class="btn btn-danger btn-sm" href="/cetak/catatan/rekap/<?=$folder['3'];?>"><i class="fa fa-file-word"></i> Save as Word</a>
		                 </div>	
			                <ul class="nav nav-tabs" id="tab" role="tablist">
			                  <li class="nav-item">
			                    <a class="nav-link active" id="satu-tab" data-toggle="pill" href="#satu" role="tab" aria-controls="satu" aria-selected="true">Rekapitulasi Pengisian</a>
			                  </li>
			                </ul>
			</div>
			<div class="card-body table-responsive text-sm">
	                   <div class="tab-content" id="tab">
	                     <div class="tab-pane fade show active" id="satu" role="tabpanel" aria-labelledby="satu-tab">
	                     
	                <p>     
			<select onchange="window.document.location.href=this.options[this.selectedIndex].value;" class='select2bs4 select2-primary form-control' name='level'>
			<option value=''>-- Pilih Unit/Lembaga--</option>
			<?php
	
			$ql = mysqli_query($con2,"SELECT * FROM level ORDER BY id ");
			while($l = mysqli_fetch_array($ql)) {
				if($l['user']==$folder['4']) { $selected3 = 'selected'; } else { $selected3 = '';}
				echo "
					<option value='/pantaukinerja/default/$folder[3]/$l[user]' $selected3>$l[nama_unit_singkat]</option>
				";
			}
			?>
	
			</select>
			</p>
	                     
				<table class='table table-striped'>
<?php
						echo"
						<tr class='table-primary'>
						<th rowspan='2'>No</th>
						<th rowspan='2'>Nama Unit</th>
						<th colspan='2' class='text-center'>Jumlah</th>
						<th colspan='12' class='text-center'>% Isian</th>
						</tr>
						<tr class='table-info'>
						<th class='text-center'>IKU</th>
						<th class='text-center'>IKT</th>
						<th class='text-center'>Jan</th>
						<th class='text-center'>Feb</th>
						<th class='text-center'>Mar</th>
						<th class='text-center'>Apr</th>
						<th class='text-center'>Mei</th>
						<th class='text-center'>Jun</th>
						<th class='text-center'>Jul</th>
						<th class='text-center'>Ags</th>
						<th class='text-center'>Sep</th>
						<th class='text-center'>Okt</th>
						<th class='text-center'>Nov</th>
						<th class='text-center'>Des</th>
						</tr>
						";
						$no = 1;
						$qu = mysqli_query($con2,"SELECT * FROM level WHERE 1 ORDER BY id ");
						while($u=mysqli_fetch_array($qu)) {
							$iku = mysqli_num_rows(mysqli_query($con2,"SELECT id FROM indikator WHERE tahun='$thn' AND jenis='1' AND unit='$u[user]' "));
							$ikt = mysqli_num_rows(mysqli_query($con2,"SELECT id FROM indikator WHERE tahun='$thn' AND jenis='2' AND unit='$u[user]' "));
							$ik = $iku + $ikt;

							
							echo"
							<tr class='text-sm'>
							<td>$no</td>
							<td>$u[nama_unit_singkat]</td>
							<td class='text-center'>$iku</td>
							<td class='text-center'>$ikt</td>
							";
							
							$qbulan = mysqli_query($con2,"SELECT * FROM kode WHERE kelompok='bulan' AND keterangan='$thn' ");
							while($bulan=mysqli_fetch_array($qbulan)) {
								$jcatatan = mysqli_num_rows(mysqli_query($con2,"SELECT * FROM indikator,catatan WHERE indikator.tahun='$thn' AND indikator.id=catatan.id_indikator AND indikator.unit='$u[user]' AND catatan.id_bulan='$bulan[value]' GROUP BY indikator.id "));
								$persen_catatan = ROUND($jcatatan / $ik * 100,0);
									if($persen_catatan=='100') {
										$bg_catatan = 'success';
									}
									elseif($persen_catatan=='0') {
										$bg_catatan = 'danger';
									}
									else {
										$bg_catatan = 'warning';
									}
	
								echo"
								<td class='text-center'><a href='/pantaukinerja/catatan/$u[user]/$bulan[value]/$bulan[keterangan]' target='_blank'><span class='badge badge-$bg_catatan'>$persen_catatan %</span></a></td>
								";
							}
							
							echo"
							</tr>
							";
						$no++;
						}
?>
				</table>
			    </div>
				<div class="tab-pane fade" id="dua" role="tabpanel" aria-labelledby="dua-tab">
				<table class='table table-striped'>
<?php
						echo"
						<tr class='table-primary'>
						<th rowspan='2'>No</th>
						<th rowspan='2'>Nama Unit</th>
						<th colspan='2' class='text-center'>Jumlah</th>
						<th colspan='12' class='text-center'>% Isian</th>
						</tr>
						<tr class='table-info'>
						<th class='text-center'>IKU</th>
						<th class='text-center'>IKT</th>
						<th class='text-center'>Jan</th>
						<th class='text-center'>Feb</th>
						<th class='text-center'>Mar</th>
						<th class='text-center'>Apr</th>
						<th class='text-center'>Mei</th>
						<th class='text-center'>Jun</th>
						<th class='text-center'>Jul</th>
						<th class='text-center'>Ags</th>
						<th class='text-center'>Sep</th>
						<th class='text-center'>Okt</th>
						<th class='text-center'>Nov</th>
						<th class='text-center'>Des</th>
						</tr>
						";
						$no = 1;
						$qu = mysqli_query($con2,"SELECT * FROM level ORDER BY id ");
						while($u=mysqli_fetch_array($qu)) {
							$iku = mysqli_num_rows(mysqli_query($con2,"SELECT id FROM indikator WHERE tahun='$thn' AND jenis='1' AND unit='$u[user]' "));
							$ikt = mysqli_num_rows(mysqli_query($con2,"SELECT id FROM indikator WHERE tahun='$thn' AND jenis='2' AND unit='$u[user]' "));
							$ik = $iku + $ikt;

							
							echo"
							<tr class='text-sm'>
							<td>$no</td>
							<td>$u[nama_unit_singkat]</td>
							<td class='text-center'>$iku</td>
							<td class='text-center'>$ikt</td>
							";
							
							$qbulan2 = mysqli_query($con2,"SELECT * FROM kode WHERE kelompok='bulan' AND keterangan='$thn' ");
							while($bulan2=mysqli_fetch_array($qbulan2)) {
								if($bulan2['value']<=$bln_sekarang) {
								$jcatatan2 = mysqli_fetch_array(mysqli_query($con2,"SELECT SUM(capaian) AS j FROM indikator,catatan WHERE indikator.tahun='$thn' AND indikator.id=catatan.id_indikator AND indikator.unit='$u[user]' AND catatan.id_bulan='$bulan2[value]' "));
								$persen_catatan2 = ROUND($jcatatan2['j'] / $ik,0);
								if($persen_catatan2=='100') {
									$bg_catatan2 = 'success';
								}
								elseif($persen_catatan2=='0') {
									$bg_catatan2 = 'danger';
								}
								else {
									$bg_catatan2 = 'warning';
								}
	
								echo"
								<td class='text-center'><a href='/pantaukinerja/catatan/$u[user]/$bulan2[value]/$bulan[keterangan]' target='_blank'><span class='badge badge-$bg_catatan2'>$persen_catatan2 %</span></a></td>
								";
								}
								else {
								echo"
								<td class='text-center'></td>
								";
								}
							}
							
							echo"
							</tr>
							";

						$no++;
						}
?>
				</table>
				</div>
  			  </div>	
			</div>
		</div>

<?php
		break;
		
		case 'validasi': 
  			$unit = mysqli_fetch_array(mysqli_query($con2,"SELECT * FROM level WHERE user='$folder[3]' "));
			$thn = $folder['4'];
?>

		<div class='card'>
			<div class='card-header with-border'>
				<h3 class='card-title'><?php echo $thn; ?> Kontrak  Kinerja: <?php echo $unit['nama_unit']; ?></h3>
			                <div class="card-tools">
			                      <a class="btn btn-danger btn-sm" href="/cetak/pantaukinerja/<?php echo $unit['user']; ?>/<?php echo $thn; ?>"><i class="fa fa-file-word"></i> Save as Word</a>
			                 </div>	
			</div>
			<div class="card-body">
			<div class='table-responsive'>
				<table class='table table-striped'>
<?php
						echo"
							<tr>
								<td colspan='7' class='table-primary'><b>Indikator Kinerja Utama (IKU)</b></td>
							</tr>
							<tr class='table-primary'>
								<th>No</th>
								<th>Indikator</th>
								<th>Standar</th>
								<th>Baseline</th>
								<th>Target</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						";
						$no = 1;
						$qi = mysqli_query($con2,"SELECT * FROM indikator WHERE tahun='$thn' AND jenis='1' AND unit='$unit[user]' ");
						while($i=mysqli_fetch_array($qi)) {
							$ivalid = $i['valid'];
							if($ivalid=='1') {
								$valid = "<span class='badge badge-warning'>In Review</span>";
							}
							elseif($ivalid=='2') {
								$valid = "<span class='badge badge-success'>Aproved</span>";
							}
							elseif($ivalid=='3') {
								$valid = "<span class='badge badge-danger'>To be Revised</span>";
							}
							else {
								$valid = "";
							}
						echo"
							<tr class='text-xs'>
								<td>$no</td>
								<td><p><b>$i[topik]</b><br>$i[nama]</p><p><b>Kriteria</b><br>$i[kriteria]</p></td>
								<td>$i[standar] $i[skala]</td>
								<td>$i[capaian_before]</td>
								<td>$i[target_after]</td>
								<td>$valid</td>
								<td>
									<a href='#' data-toggle='dropdown'><i class='fa fa-ellipsis-v'></i></a>
									<div class='dropdown-menu text-xs'>
						";
						if($ivalid!='') {
							echo"
										<a class='dropdown-item bg-success' href='/update/acc_kinerja/2/$i[id]/$unit[user]/$i[tahun]'>Approve</a>
										<a class='dropdown-item bg-danger' href='/update/acc_kinerja/3/$i[id]/$unit[user]/$i[tahun]'>To be Revised</a>
							";
						}
						echo"
										<a class='dropdown-item' href='/pantaukinerja/edit/$i[id]'>Edit</a>
									</div>
								</td>
							</tr>
						";
						$no++;
						}
?>
<?php
						echo"
							<tr>
								<td colspan='7' class='table-info'><b>Indikator Kinerja Tambahan (IKT)</b></td>
							</tr>
							<tr class='table-info'>
								<th>No</th>
								<th>Indikator</th>
								<th>Standar</th>
								<th>Baseline</th>
								<th>Target</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						";
						$no2 = 1;
						$qi2 = mysqli_query($con2,"SELECT * FROM indikator WHERE tahun='$thn' AND jenis='2' AND unit='$unit[user]' ");
						while($i2=mysqli_fetch_array($qi2)) {
							$ivalid2 = $i2['valid'];
							if($ivalid2=='1') {
								$valid2 = "<span class='badge badge-warning'>In Review</span>";
							}
							elseif($ivalid2=='2') {
								$valid2 = "<span class='badge badge-success'>Aproved</span>";
							}
							elseif($ivalid2=='3') {
								$valid2 = "<span class='badge badge-danger'>To be Revised</span>";
							}
							else {
								$valid2 = "";
							}
						echo"
							<tr class='text-xs'>
								<td>$no2</td>
								<td><p><b>$i2[topik]</b><br>$i2[nama]</p><p><b>Kriteria</b><br>$i2[kriteria]</p></td>
								<td>$i2[standar]</td>
								<td>$i2[capaian_before]</td>
								<td>$i2[target_after]</td>
								<td>$valid2</td>
								<td>
									<a href='#' data-toggle='dropdown'><i class='fa fa-ellipsis-v'></i></a>
									<div class='dropdown-menu text-xs'>
						";
						if($ivalid2!='') {
							echo"
										<a class='dropdown-item bg-success' href='/update/acc_kinerja/2/$i2[id]/$unit[user]/$i2[tahun]'>Approve</a>
										<a class='dropdown-item bg-danger' href='/update/acc_kinerja/3/$i2[id]/$unit[user]/$i2[tahun]'>To be Revised</a>
							";
						}
						echo"
										<a class='dropdown-item' href='/pantaukinerja/edit/$i2[id]'>Edit</a>
									</div>
								</td>
							</tr>
						";
						$no2++;
						}
?>
				
				</table>
			</div>
					
			</div>
		</div>
		
		<div class='card'>
			<div class='card-header with-border'>
				<h3 class='card-title'>Program Kerja</h3>
			                <div class="card-tools">
			                      <a class="btn btn-danger btn-sm" href="/cetak/proker/<?php echo $unit['user']; ?>/<?php echo $thn; ?>"><i class="fa fa-file-word"></i> Save as Word</a>
			                 </div>	
			</div>
			<div class="card-body">
			<div class='table-responsive'>
				<table class='table'>
<?php
						$qind = mysqli_query($con2,"SELECT * FROM indikator WHERE tahun='$thn' AND unit='$unit[user]' ORDER BY jenis,id ");
						while($ind=mysqli_fetch_array($qind)) {
							if($ind['jenis']=='1') {
								$ik = 'IKU';
							}
							elseif($ind['jenis']=='2') {
								$ik = 'IKT';
							}
							else {
								$ik = '';
							}
						echo"
							<tr class='table-primary text-sm'>
								<td colspan='9'>
								<span class='text-md'>[$ik] $ind[nama] <br> </span>
						";
						if($ind['valid']!='') {
						echo"
								Standar: $ind[standar] $ind[skala] &nbsp;&nbsp;&nbsp;
								Baseline: $ind[capaian_before] &nbsp;&nbsp;&nbsp;
								Target: $ind[target_after]
								</td>
						";
						}
						echo"
							</tr>
						";
						
						$no = 1;
						$qi = mysqli_query($con2,"SELECT proker.* FROM proker WHERE proker.id_indikator='$ind[id]' ORDER BY id ");
						if(mysqli_num_rows($qi)<1) {
						echo"
							<tr class='text-xs'>
								<td colspan='9' class='text-danger'>Belum ada program kerja diinput</td>
							</tr>
						";
						}
						else {
						echo"
							<tr class='text-xs'>
								<th>Kebijakan</th>
								<th>Nama Kegiatan</th>
								<th>Deskripsi Kegiatan</th>
								<th>Waktu Pelaksanaan</th>
								<th>Sasaran</th>
								<th>Tolak Ukur/Luaran</th>
								<th>Anggaran</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						";
						}
						while($i=mysqli_fetch_array($qi)) {
							$ivalid = $i['valid'];
							if($ivalid=='1') {
								$valid = "<span class='badge badge-warning'>In Review</span>";
							}
							elseif($ivalid=='2') {
								$valid = "<span class='badge badge-success'>Aproved</span>";
							}
							elseif($ivalid=='3') {
								$valid = "<span class='badge badge-danger'>To be Revised</span>";
							}
							else {
								$valid = "";
							}
							
							$anggaran = rupiah($i['anggaran']);
							$waktu_mulai = simple_bln($i['waktu_mulai']);
							$waktu_selesai = simple_bln($i['waktu_selesai']);
						echo"
							<tr class='text-xs'>
								<td>$i[kebijakan]</td>
								<td>$i[bentuk]</td>
								<td>$i[deskripsi]</td>
								<td>$waktu_mulai s.d $waktu_selesai</td>
								<td>$i[sasaran]</td>
								<td>$i[luaran]</td>
								<td>$anggaran</td>
								<td>$valid</td>
								<td>
									<a href='#' data-toggle='dropdown'><i class='fa fa-ellipsis-v'></i></a>
									<div class='dropdown-menu text-xs'>
										<a class='dropdown-item bg-success' href='/update/acc_proker/2/$i[id]/$unit[user]/$i[tahun]'>Approve</a>
										<a class='dropdown-item bg-danger' href='/update/acc_proker/3/$i[id]/$unit[user]/$i[tahun]'>To be Revised</a>
									</div>
								</td>
							</tr>
						";
						$no++;
						}
						echo"
							<tr class=''>
								<td colspan='9'></td>
							</tr>
						";
						}
?>
				</table>
			</div>
					
			</div>
		</div>

<?php		
		break;


		case 'laporan': 
  			$unit = mysqli_fetch_array(mysqli_query($con2,"SELECT * FROM level WHERE user='$folder[3]' "));
			$thn = $folder['4'];
?>

		<div class='card'>
			<div class='card-header with-border'>
				<h3 class='card-title'><?php echo $thn; ?> Laporan Akhir Tahun Kinerja: <?php echo $unit['nama_unit']; ?></h3>
			                <div class="card-tools">
<!--			                      <a class="btn btn-danger btn-sm" href="/cetak/pantaukinerja/<?php echo $unit['user']; ?>/<?php echo $thn; ?>"><i class="fa fa-file-word"></i> Save as Word</a>
!-->			                 </div>	
			</div>
			<div class="card-body">
			<div class='table-responsive'>
				<table class='table table-striped'>
<?php
						echo"
							<tr>
								<td colspan='10' class='table-primary'><b>Indikator Kinerja Utama (IKU)</b></td>
							</tr>
							<tr class='table-primary'>
								<th>No</th>
								<th>Indikator</th>
								<th>Standar</th>
								<th>Baseline</th>
								<th>Target</th>
								<th>Capaian</th>
								<th>Luaran</th>
								<th>Dokumen Luaran</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						";
						$no = 1;
						$qi = mysqli_query($con2,"SELECT * FROM indikator WHERE tahun='$thn' AND jenis='1' AND unit='$unit[user]' ");
						while($i=mysqli_fetch_array($qi)) {
							$ivalid = $i['valid_laporan'];
							if($ivalid=='1') {
								$valid = "<span class='badge badge-warning'>In Review</span>";
							}
							elseif($ivalid=='2') {
								$valid = "<span class='badge badge-success'>Aproved</span>";
							}
							elseif($ivalid=='3') {
								$valid = "<span class='badge badge-danger'>To be Revised</span>";
							}
							else {
								$valid = "";
							}

							if($i['dokumen']=='') {
								$dokumen = '';
							}
							else {
								$dokumen = "<a href='https://sim.umkuningan.ac.id/$i[dokumen]' target='_blank'><i class='fa fa-file'> Bukti</i></a>";
							}
							
							$luaran = mysqli_fetch_array(mysqli_query($con2,"SELECT * FROM kode WHERE kelompok='luaran' AND value='$i[luaran]' "));

						echo"
							<tr class='text-xs'>
								<td>$no</td>
								<td><p>$i[nama]</p><p><b>Analisis Ketercapaian/Ketidaktercapaian:</b> <br>$i[analisis]</p></td>
								<td>$i[standar] $i[skala]</td>
								<td>$i[capaian_before]</td>
								<td>$i[target_after]</td>
								<td>$i[capaian_after]</td>
								<td>$luaran[desc]</td>
								<td>$dokumen</td>
								<td>$valid</td>
								<td>
									<a href='#' data-toggle='dropdown'><i class='fa fa-ellipsis-v'></i></a>
									<div class='dropdown-menu text-xs'>
						";
						if($ivalid!='') {
							echo"
										<a class='dropdown-item bg-success' href='/update/acc_kinerja/2/$i[id]/$unit[user]'>Approve</a>
										<a class='dropdown-item bg-danger' href='/update/acc_kinerja/3/$i[id]/$unit[user]'>To be Revised</a>
							";
						}
						echo"
										<a class='dropdown-item' href='/pantaukinerja/edit/$i[id]'>Edit</a>
									</div>
								</td>
							</tr>
						";
						$no++;
						}
?>
<?php
						echo"
							<tr>
								<td colspan='10' class='table-info'><b>Indikator Kinerja Tambahan (IKT)</b></td>
							</tr>
							<tr class='table-info'>
								<th>No</th>
								<th>Indikator</th>
								<th>Standar</th>
								<th>Baseline</th>
								<th>Target</th>
								<th>Capaian</th>
								<th>Luaran</th>
								<th>Dokumen Luaran</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						";
						$no2 = 1;
						$qi2 = mysqli_query($con2,"SELECT * FROM indikator WHERE tahun='$thn' AND jenis='2' AND unit='$unit[user]' ");
						while($i2=mysqli_fetch_array($qi2)) {
							$ivalid2 = $i2['valid_laporan'];
							if($ivalid2=='1') {
								$valid2 = "<span class='badge badge-warning'>In Review</span>";
							}
							elseif($ivalid2=='2') {
								$valid2 = "<span class='badge badge-success'>Aproved</span>";
							}
							elseif($ivalid2=='3') {
								$valid2 = "<span class='badge badge-danger'>To be Revised</span>";
							}
							else {
								$valid2 = "";
							}

							if($i2['dokumen']=='') {
								$dokumen2 = '';
							}
							else {
								$dokumen2 = "<a href='https://sim.umkuningan.ac.id/$i2[dokumen]' target='_blank'><i class='fa fa-file'> Bukti</i></a>";
							}
							
							$luaran2 = mysqli_fetch_array(mysqli_query($con2,"SELECT * FROM kode WHERE kelompok='luaran' AND value='$i2[luaran]' "));

						echo"
							<tr class='text-xs'>
								<td>$no2</td>
								<td><p>$i2[nama]</p><p><b>Analisis Ketercapaian/Ketidaktercapaian:</b> <br>$i2[analisis]</p></td>
								<td>$i2[standar]</td>
								<td>$i2[capaian_before]</td>
								<td>$i2[target_after]</td>
								<td>$i2[capaian_after]</td>
								<td>$luaran2[desc]</td>
								<td>$dokumen2</td>
								<td>$valid2</td>
								<td>
									<a href='#' data-toggle='dropdown'><i class='fa fa-ellipsis-v'></i></a>
									<div class='dropdown-menu text-xs'>
						";
						if($ivalid2!='') {
							echo"
										<a class='dropdown-item bg-success' href='/update/acc_kinerja/2/$i2[id]/$unit[user]'>Approve</a>
										<a class='dropdown-item bg-danger' href='/update/acc_kinerja/3/$i2[id]/$unit[user]'>To be Revised</a>
							";
						}
						echo"
										<a class='dropdown-item' href='/pantaukinerja/edit/$i2[id]'>Edit</a>
									</div>
								</td>
							</tr>
						";
						$no2++;
						}
?>
				
				</table>
			</div>
					
			</div>
		</div>
		
<?php		
		break;

		
		case 'edit':
			$qi = mysqli_query($con2,"SELECT * FROM indikator WHERE id='$folder[3]' AND valid!='2' ");
			if(mysqli_num_rows($qi)<1) {
				header('Location: /pantaukinerja/');
	exit;
			}
			else {
				$i=mysqli_fetch_array($qi);
?>
		<div class='card'>
			<div class='card-header with-border'>
				<h3 class='card-title'>Edit Indikator Kinerja</h3>
			</div>
								<div class="card-body">
									<form role="form" enctype="multipart/form-data" method="post" action="/update/kinerja">
										<div class="form-group">
											<input type="hidden" name="id" value="<?php echo $i['id']; ?>">
											<input type="hidden" name="unit" value="<?php echo $i['unit']; ?>">
											<input type="hidden" name="tahun" value="<?php echo $i['tahun']; ?>">
											<p>
											<label>Standar SPMI<span class="text-danger"> *</span></label>
											<input name="topik" type="text" class="form-control" value="<?php echo $i['topik']; ?>" required <?=$readonly;?>>
											</p>
											<p>
											<label>Nama Indikator<span class="text-danger"> *</span></label>
											<input name="nama" type="text" class="form-control" value="<?php echo $i['nama']; ?>" required <?=$readonly;?>>
											</p>
											<p>
											<label>Kriteria</label>
											<input name="kriteria" type="text" class="form-control" value="<?php echo $i['kriteria']; ?>" <?=$readonly;?>>
											</p>
											<p>
											<div class="row">
											    <div class="cold-md-6 mx-2">
        											<p>
        											<label>Nilai Standar<span class="text-danger"> *</span></label>
        											<input name="standar" type="number" class="form-control" value="<?php echo $i['standar']; ?>" required <?=$readonly;?>>
        											</p>
											    </div>
											    <div class="cold-md-6 mx-2">
        											<p>
        											<label>Satuan Nilai</label>
        											<input name="skala" type="text" class="form-control" value="<?php echo $i['skala']; ?>" <?=$readonly;?>>
        											</p>
											    </div>
											</div>
											</p>
											<p>
											<label>Baseline<span class="text-danger"> *</span></label>
											<input name="capaian_before" type="number" min="0" class="form-control" value="<?php echo $i['capaian_before']; ?>" required>
											</p>
											<p>
											<label>Target<span class="text-danger"> *</span></label>
											<input name="target_after" type="number" min="0" class="form-control" value="<?php echo $i['target_after']; ?>" required>
											</p>
										</div>
									<input type="submit" class="btn btn-primary btn-sm" value="Simpan">
									</form>
								</div>
		</div>
<?php		
			}
		break;
		
		case 'laporan':
?>
		<div class='callout callout-success'>
			<p><h4>Informasi Laporan</h4></p>
			<p>Pengisian sampai dengan ...</p>
			<p>Review ...</p>
			<p>Revisi ...</p>
		</div>
		<div class='card'>
			<div class='card-header with-border'>
				<h3 class='card-title'>Laporan Kinerja</h3>
			                <div class="card-tools">
			                      <a class="btn btn-danger btn-sm" href="/cetak/pantaukinerja/laporan"><i class="fa fa-file-word"></i> Download (word)</a>
			                 </div>	
			</div>
			<div class="card-body">
			<div class='table-responsive'>
				<table class='table table-striped'>
<?php
						echo"
							<tr>
								<td colspan='8' class='table-primary'><b>Indikator Kinerja Utama (IKU)</b></td>
							</tr>
							<tr class='table-primary'>
								<th>No</th>
								<th>Indikator</th>
								<th>Standar</th>
								<th>Baseline</th>
								<th>Target</th>
								<th>Capaian</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						";
						$no = 1;
						$qi = mysqli_query($con2,"SELECT * FROM indikator WHERE jenis='1' AND unit='$_SESSION[ses_user]' ");
						while($i=mysqli_fetch_array($qi)) {
							$ivalid = $i['valid_laporan'];
							if($ivalid=='1') {
								$valid = "<span class='badge badge-warning'>In Review</span>";
							}
							elseif($ivalid=='2') {
								$valid = "<span class='badge badge-success'>Aproved</span>";
							}
							elseif($ivalid=='3') {
								$valid = "<span class='badge badge-danger'>To be Revised</span>";
							}
							else {
								$valid = "";
							}
						echo"
							<tr class='text-xs'>
								<td>$no</td>
								<td><p><b>$i[topik]</b><br>$i[nama]</p><p><b>Kriteria</b><br>$i[kriteria]</p></td>
								<td>$i[standar] $i[skala]</td>
								<td>$i[capaian_before]</td>
								<td>$i[target_after]</td>
								<td>$i[capaian_after]</td>
								<td>$valid</td>
								<td>
									<a href='#' data-toggle='dropdown'><i class='fa fa-ellipsis-v'></i></a>
									<div class='dropdown-menu text-xs'>
										<a class='dropdown-item' href='/pantaukinerja/edit_laporan/$i[id]'>Edit</a>
									</div>
								</td>
							</tr>
						";
						$no++;
						}
?>
<?php
						echo"
							<tr>
								<td colspan='8' class='table-info'><b>Indikator Kinerja Tambahan (IKT)</b></td>
							</tr>
							<tr class='table-info'>
								<th>No</th>
								<th>Indikator</th>
								<th>Standar</th>
								<th>Capaian</th>
								<th>Target</th>
								<th>Capaian</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						";
						$no2 = 1;
						$qi2 = mysqli_query($con2,"SELECT * FROM indikator WHERE jenis='2' AND unit='$_SESSION[ses_user]' ");
						while($i2=mysqli_fetch_array($qi2)) {
							$ivalid2 = $i2['valid_laporan'];
							if($ivalid2=='1') {
								$valid2 = "<span class='badge badge-warning'>In Review</span>";
							}
							elseif($ivalid2=='2') {
								$valid2 = "<span class='badge badge-success'>Aproved</span>";
							}
							elseif($ivalid2=='3') {
								$valid2 = "<span class='badge badge-danger'>To be Revised</span>";
							}
							else {
								$valid2 = "";
							}
						echo"
							<tr class='text-xs'>
								<td>$no2</td>
								<td><p><b>$i2[topik]</b><br>$i2[nama]</p><p><b>Kriteria</b><br>$i2[kriteria]</p></td>
								<td>$i2[standar]</td>
								<td>$i2[capaian_before]</td>
								<td>$i2[target_after]</td>
								<td>$i2[capaian_after]</td>
								<td>$valid2</td>
								<td>
									<a href='#' data-toggle='dropdown'><i class='fa fa-ellipsis-v'></i></a>
									<div class='dropdown-menu text-xs'>
										<a class='dropdown-item' href='/pantaukinerja/edit_laporan/$i2[id]'>Edit</a>
									</div>
								</td>
							</tr>
						";
						$no2++;
						}
?>
				
				</table>
			</div>
					
			</div>
		</div>
<?php
		break;
		
		case 'edit_laporan':
			$qi = mysqli_query($con2,"SELECT * FROM indikator WHERE id='$folder[3]' AND unit='$_SESSION[ses_user]' AND valid='2' AND valid_laporan!='2' ");
			if(mysqli_num_rows($qi)<1) {
				header('Location: /pantaukinerja/laporan');
	exit;
			}
			else {
				$i=mysqli_fetch_array($qi);
?>
		<div class='card'>
			<div class='card-header with-border'>
				<h3 class='card-title'>Edit Laporan Kinerja</h3>
			</div>
								<div class="card-body">
									<form role="form" enctype="multipart/form-data" method="post" action="/update/kinerja_laporan">
										<div class="form-group">
											<input type="hidden" name="id" value="<?php echo $i['id']; ?>">
											<p>
											<label>Nama Indikator<span class="text-danger"> *</span></label>
											<input name="nama" type="text" class="form-control" value="<?php echo $i['nama']; ?>" disabled>
											</p>
											<label>Standar<span class="text-danger"> *</span></label>
											<input name="standar" type="text" class="form-control" value="<?php echo $i['standar']; ?>" disabled>
											</p>
											</p>
											<label>Capaian Tahun 2024<span class="text-danger"> *</span></label>
											<input name="capaian_before" type="text" class="form-control" value="<?php echo $i['capaian_before']; ?>" disabled>
											</p>
											</p>
											<label>Target Tahun 2025<span class="text-danger"> *</span></label>
											<input name="target_after" type="text" class="form-control" value="<?php echo $i['target_after']; ?>" disabled>
											</p>
											</p>
											<label>Capaian Tahun 2025<span class="text-danger"> *</span></label>
											<input name="capaian_after" type="text" class="form-control" value="<?php echo $i['capaian_after']; ?>" required>
											</p>
										</div>
									<input type="submit" class="btn btn-primary btn-sm" value="Simpan">
									</form>
								</div>
		</div>
<?php		
			}
		break;
		
		
		case 'catatan':
  			$unit = mysqli_fetch_array(mysqli_query($con2,"SELECT * FROM level WHERE user='$folder[3]' "));
			$bulan = mysqli_fetch_array(mysqli_query($con2,"SELECT * FROM kode WHERE kelompok='bulan' AND value='$folder[4]' AND keterangan='$folder[5]' "));
			
			$iku = mysqli_num_rows(mysqli_query($con2,"SELECT id FROM indikator WHERE jenis='1' AND unit='$unit[user]' AND tahun='$folder[5]' "));
			$ikt = mysqli_num_rows(mysqli_query($con2,"SELECT id FROM indikator WHERE jenis='2' AND unit='$unit[user]' AND tahun='$folder[5]' "));
			$ik = $iku + $ikt;
			
			$jcatatan = mysqli_num_rows(mysqli_query($con2,"SELECT * FROM indikator,catatan WHERE indikator.id=catatan.id_indikator AND indikator.unit='$unit[user]' AND catatan.id_bulan='$bulan[value]' AND indikator.tahun='$folder[5]' GROUP BY indikator.id "));
			$persen_catatan = ROUND($jcatatan / $ik * 100,0);
			if($persen_catatan=='100') {
				$bg_catatan = 'success';
			}
			elseif($persen_catatan=='0') {
				$bg_catatan = 'danger';
			}
			else {
				$bg_catatan = 'warning';
			}
			
			$jcatatan2 = mysqli_fetch_array(mysqli_query($con2,"SELECT SUM(capaian) AS j FROM indikator,catatan WHERE indikator.id=catatan.id_indikator AND indikator.unit='$unit[user]' AND catatan.id_bulan='$bulan[value]' AND indikator.tahun='$folder[5]' "));
			$persen_catatan2 = ROUND($jcatatan2['j'] / $ik,0);
			if($persen_catatan2=='100') {
				$bg_catatan2 = 'success';
			}
			elseif($persen_catatan2=='0') {
				$bg_catatan2 = 'danger';
			}
			else {
				$bg_catatan2 = 'warning';
			}
			
?>
		<div class='card'>
			<div class="card-body">
				Pengisian Laporan<span class='badge badge-<?php echo $bg_catatan; ?>'><?php echo $persen_catatan; ?> %</span>
				Capaian Kemajuan<span class='badge badge-<?php echo $bg_catatan2; ?>'><?php echo $persen_catatan2; ?> %</span>
			</div>
		</div>

		<div class='card'>
			<div class='card-header with-border'>
				<h3 class='card-title'>Laporan Bulan <?php echo $bulan['desc']; ?> : <?php echo $unit['nama_unit']; ?></h3>
			                <div class="card-tools">
			                      <a class="btn btn-danger btn-sm" href="/cetak/catatan/<?php echo $unit['user']; ?>/<?php echo $bulan['value']; ?>/<?=$folder[5];?>"><i class="fa fa-file-word"></i> Save as Word</a>

			                 </div>	
			</div>
			<div class="card-body">
			<div class='table-responsive'>
				<table class='table'>
<?php
						$qind = mysqli_query($con2,"SELECT * FROM indikator WHERE unit='$unit[user]' AND indikator.tahun='$folder[5]' ORDER BY jenis,id ");
						while($ind=mysqli_fetch_array($qind)) {
							if($ind['jenis']=='1') {
								$ik = 'IKU';
								$bg_ik = 'success';
							}
							elseif($ind['jenis']=='2') {
								$ik = 'IKT';
								$bg_ik = 'warning';
							}
							else {
								$ik = '';
							}
						echo"
							<tr class='table-$bg_ik text-sm'>
								<td colspan='5'>
								[$ik] $ind[nama] <br> 
						";
						if($ind['valid']!='') {
						echo"
								Standar: $ind[standar] $ind[skala] &nbsp;&nbsp;&nbsp;
								Baseline: $ind[capaian_before] &nbsp;&nbsp;&nbsp;
								Target: $ind[target_after]
								</td>
						";
						}
						echo"
							</tr>
						";
						
						$no = 1;
						$qi = mysqli_query($con2,"SELECT catatan.* FROM catatan WHERE catatan.id_indikator='$ind[id]' AND catatan.id_bulan='$bulan[value]' ORDER BY id ");
						if(mysqli_num_rows($qi)<1) {
						echo"
							<tr class='text-xs'>
								<td colspan='5' class='text-danger'>Belum ada laporan</td>
							</tr>
						";
						}
						else {
						}
						while($i=mysqli_fetch_array($qi)) {

						echo"
							<tr class='text-xs'>
								<td><b>Upaya</b><br>$i[upaya]</td>
								<td><b>Kendala</b><br>$i[kendala]</td>
								<td><b>RTL</b><br>$i[rtl]</td>
								<td>
						";
							if($i['url_file']!='') { echo"
								<b>Lampiran</b><br><a href='$i[url_file]' target='_blank'><i class='fa fa-file-pdf'> Unduh</i></a>
							"; }
							else { echo " 
								<b>Lampiran</b><br><span class='text-danger'>Tidak ada</span>
							"; }
						echo"
								</td>
							</tr>
						";
						$no++;
						}
						echo"
							<tr class=''>
								<td colspan='5'></td>
							</tr>
						";
						}
?>
				</table>
			</div>
					
			</div>
		</div>
		
<?php
		break;

		}

}
?>