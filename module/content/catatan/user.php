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
	
		case 'rekap':				
?>
		<div class='callout callout-success'>
			<p><h4>Informasi</h4></p>
			<p>Pengisian sampai dengan akhir bulan</p>
		</div>
		<div class='card'>
			<div class='card-header with-border'>
				<h3 class='card-title'>Laporan Bulanan</h3>
			                <div class="card-tools">
						<select onchange="window.document.location.href=this.options[this.selectedIndex].value;" class='form-control' name='ta'>
						<option value='#'>-- Cetak Berita Acara --</option>
					<?php
			
					$qp = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='bulan' ");
					while($p = mysqli_fetch_array($qp)) {
					if($p['value']==$folder['3']) { $selected = 'selected'; } else {$selected = '';}
						echo "
							<option value='/cetak/catatan/$p[value]/$p[keterangan]' $selected>$p[desc] $p[keterangan]</option>
						";
					}
					?>
				
						</select>
			                 </div>	
			</div>
			<div class="card-body">
			<div class='table-responsive'>
				<table class='table table-striped'>
<?php
						echo"
							<tr>
								<td colspan='18' class='table-primary'><b>Indikator Kinerja Utama (IKU)</b></td>
							</tr>
							<tr class='table-primary text-xs'>
								<th>No</th>
								<th>Indikator</th>
								<th>Luaran</th>
								<th>Standar</th>
								<th>Baseline</th>
								<th>Target</th>
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
						$qi = mysqli_query($con,"SELECT * FROM indikator WHERE tahun='$folder[4]' AND jenis='1' AND unit='$_SESSION[ses_user]' ");
						while($i=mysqli_fetch_array($qi)) {
							$luaran = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='luaran' AND value='$i[luaran]' "));
						echo"
							<tr class='text-xs'>
								<td>$no</td>
								<td><b>$i[topik]</b><br>$i[nama]</td>
								<td>$luaran[desc]</td>
								<td>$i[standar] $i[skala]</td>
								<td>$i[capaian_before]</td>
								<td>$i[target_after]</td>
							";
							
							$qbulan = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='bulan' GROUP BY value ORDER BY CAST(value AS SIGNED) ");
							while($bulan=mysqli_fetch_array($qbulan)) {
									$capaian = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM catatan WHERE catatan.id_indikator='$i[id]' AND catatan.id_bulan='$bulan[value]' "));
									$persen_capaian = ROUND(($capaian[capaian]/$i[target_after])*100,0);

									if($persen_capaian>='0' AND $persen_capaian<'25') {
										$bg_catatan = 'dark';
									}
									elseif($persen_capaian>='25' AND $persen_capaian<'50') {
										$bg_catatan = 'danger';
									}
									elseif($persen_capaian>='50' AND $persen_capaian<'75') {
										$bg_catatan = 'warning';
									}
									elseif($persen_capaian>='75' AND $persen_capaian<'100') {
										$bg_catatan = 'success';
									}
									elseif($persen_capaian>='100') {
										$bg_catatan = 'primary';
									}

									
									if($capaian[capaian]!='') {
										echo"
										<td class='text-center text-sm'>
										<a href='/catatan/edit/$capaian[id]'><span class='badge badge-$bg_catatan'>$capaian[capaian]</span></a>
										<br>
										<a href='$capaian[url_file]' target='_blank'><span class='badge badge-$bg_catatan'><i class='fa fa-file-pdf'></i> </span></a>
										</td>
										";
									} else {
										echo"
										<td class='text-center'><a href='/catatan/isi/$bulan[value]/$i[id]' target='_blank'>isi</a></td>
										";									
									}
							}
						echo"
							</tr>
						";
						$no++;
						}
?>
<?php
						echo"
							<tr>
								<td colspan='18' class='table-info'><b>Indikator Kinerja Tambahan (IKT)</b></td>
							</tr>
							<tr class='table-info text-xs'>
								<th>No</th>
								<th>Indikator</th>
								<th>Luaran</th>
								<th>Standar</th>
								<th>Baseline</th>
								<th>Target</th>
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
						$no2 = 1;
						$qi2 = mysqli_query($con,"SELECT * FROM indikator WHERE tahun='$folder[4]' AND jenis='2' AND unit='$_SESSION[ses_user]' ");
						while($i2=mysqli_fetch_array($qi2)) {
							$luaran2 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='luaran' AND value='$i2[luaran]' "));

						echo"
							<tr class='text-xs'>
								<td>$no2</td>
								<td><b>$i2[topik]</b><br>$i2[nama]</td>
								<td>$luaran2[desc]</td>
								<td>$i2[standar]</td>
								<td>$i2[capaian_before]</td>
								<td>$i2[target_after]</td>
							";
							
							$qbulan2 = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='bulan' GROUP BY value ORDER BY CAST(value AS SIGNED) ");
							while($bulan2=mysqli_fetch_array($qbulan2)) {
								if($bulan2['value']<='12' AND $bulan2['value']>'0') {
									$capaian2 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM catatan WHERE catatan.id_indikator='$i2[id]' AND catatan.id_bulan='$bulan2[value]' "));
									$persen_capaian2 = ROUND(($capaian2[capaian]/$i2[target_after])*100,0);
								

									if($persen_capaian2>='0' AND $persen_capaian2<'25') {
										$bg_catatan2 = 'dark';
									}
									elseif($persen_capaian2>='25' AND $persen_capaian2<'50') {
										$bg_catatan2 = 'danger';
									}
									elseif($persen_capaian2>='50' AND $persen_capaian2<'75') {
										$bg_catatan2 = 'warning';
									}
									elseif($persen_capaian2>='75' AND $persen_capaian2<'100') {
										$bg_catatan2 = 'success';
									}
									elseif($persen_capaian2>='100') {
										$bg_catatan2 = 'primary';
									}

									
									if($capaian2[capaian]!='') {
										echo"
										<td class='text-center text-sm'>
										<a href='/catatan/edit/$capaian2[id]'><span class='badge badge-$bg_catatan2'>$capaian2[capaian]</span></a>
										<br>
										<a href='$capaian2[url_file]' target='_blank'><span class='badge badge-$bg_catatan2'><i class='fa fa-file-pdf'></i> </span></a>
										</td>
										";
									} else {
										echo"
										<td class='text-center'><a href='/catatan/isi/$bulan2[value]/$i2[id]' target='_blank'>isi</a></td>
										";									
									}
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
						$no2++;
						}
?>
				
				</table>
			</div>
					
			</div>
		</div>
		
<?php		
		break;
		
		
		default:
								
?>
		<div class='callout callout-success'>
			<p><h4>Informasi</h4></p>
			<p>Pengisian sampai dengan 28 Februari 2025</br>
			Rapat Bulanan pada 01 Maret 2025</p>
		</div>

		
		<div class='col-md-12'>
			<div class='card card-success'>
				<div class='card-body'>
					<select onchange="window.document.location.href=this.options[this.selectedIndex].value;" class='form-control' name='ta'>
					<option value='/catatan/periode/'>-- Pilih Periode --</option>
					<optgroup label='Tahun 2025'>
					<option value='/catatan/rekap//2025'>Rekapitulasi Capaian</option>
				<?php
		
				$qp = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='bulan' AND keterangan='2025' ");
				while($p = mysqli_fetch_array($qp)) {
				if($p['value']==$folder['3'] AND $p['keterangan']==$folder['4']) { $selected = 'selected'; } else {$selected = '';}
					echo "
						<option value='/catatan/periode/$p[value]/$p[keterangan]' $selected>$p[desc] - $p[keterangan]</option>
					";
				}
				?>
					</optgroup>					<optgroup label='Tahun 2023'>
					<option value='/catatan/rekap//2023'>Rekapitulasi Capaian</option>
				<?php
		
				$qp = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='bulan' AND keterangan='2023' ");
				while($p = mysqli_fetch_array($qp)) {
				if($p['value']==$folder['3'] AND $p['keterangan']==$folder['4']) { $selected = 'selected'; } else {$selected = '';}
					echo "
						<option value='/catatan/periode/$p[value]/$p[keterangan]' $selected>$p[desc] - $p[keterangan]</option>
					";
				}
				?>
					</optgroup>
					<optgroup label='Tahun 2022'>
					<option value='/catatan/rekap//2022'>Rekapitulasi Capaian</option>
				<?php
		
				$qp2 = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='bulan' AND keterangan='2022' ");
				while($p2 = mysqli_fetch_array($qp2)) {
				if($p2['value']==$folder['3'] AND $p2['keterangan']==$folder['4']) { $selected2 = 'selected'; } else {$selected2 = '';}
					echo "
						<option value='/catatan/periode/$p2[value]/$p2[keterangan]' $selected2>$p2[desc] - $p2[keterangan]</option>
					";
				}
				?>
					</optgroup>
			
					</select>
				</div>
			</div>
		</div>
		
		<?php
		if($folder['3']!='') {
			$bulan = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='bulan' AND value='$folder[3]' "));
			$bulandate = str_replace("-","",$bulan['date']);
			$next_bulan = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='bulan' AND value=$folder[3]+1 "));
			
			$iku = mysqli_num_rows(mysqli_query($con,"SELECT id FROM indikator WHERE tahun='$folder[4]' AND jenis='1' AND unit='$_SESSION[ses_user]' "));
			$ikt = mysqli_num_rows(mysqli_query($con,"SELECT id FROM indikator WHERE tahun='$folder[4]' AND jenis='2' AND unit='$_SESSION[ses_user]' "));
			$ik = $iku + $ikt;
			
			$jcatatan = mysqli_num_rows(mysqli_query($con,"SELECT * FROM indikator,catatan WHERE indikator.tahun='$folder[4]' AND indikator.id=catatan.id_indikator AND indikator.unit='$_SESSION[ses_user]' AND catatan.id_bulan='$bulan[value]' GROUP BY indikator.id "));
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
			
			$jcatatan2 = mysqli_fetch_array(mysqli_query($con,"SELECT SUM(capaian) AS j FROM indikator,catatan WHERE indikator.tahun='$folder[4]' AND indikator.id=catatan.id_indikator AND indikator.unit='$_SESSION[ses_user]' AND catatan.id_bulan='$bulan[value]' "));
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
				<h3 class='card-title'>Laporan Bulan <?php echo $bulan['desc']; ?></h3>
			                <div class="card-tools">

<!--			                      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Isi Laporan</button> !-->
			                      <a class="btn btn-danger btn-sm" href="/cetak/catatan/<?php echo $folder['3']; ?>/<?php echo $folder['4']; ?>"><i class="fa fa-file-word"></i> Save as Word</a>

			                 </div>	
			</div>
			<div class="card-body">
			<div class='table-responsive'>
				<table class='table'>
<?php
						$qind = mysqli_query($con,"SELECT * FROM indikator WHERE tahun='$folder[4]' AND unit='$_SESSION[ses_user]' ORDER BY jenis,id ");
						while($ind=mysqli_fetch_array($qind)) {
							$luaran = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='luaran' AND value='$ind[luaran]' "));
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
								<td colspan='6'>
								[$ik] $ind[nama] <br> 
						";
						if($ind['valid']!='') {
						echo"
								Standar: $ind[standar] $ind[skala] &nbsp;&nbsp;&nbsp;
								Baseline: $ind[capaian_before] &nbsp;&nbsp;&nbsp;
								Target: $ind[target_after]
								
						";
						}
						echo"
								<br>
								Luaran: $luaran[desc]
								</td>
							</tr>
						";
						
						$no = 1;
						$qi = mysqli_query($con,"SELECT catatan.* FROM catatan WHERE catatan.id_indikator='$ind[id]' AND catatan.id_bulan='$folder[3]' ORDER BY id ");
						if(mysqli_num_rows($qi)<1) {
						echo"
							<tr class='text-xs'>
								<td colspan='6' class='text-danger'>Belum ada laporan <a class='btn btn-warning btn-xs' href='/catatan/isi/$folder[3]/$ind[id]'><i class='fas fa-plus'></i> Isi Laporan</a></td>
							</tr>
						";
						}
						else {
						}
						while($i=mysqli_fetch_array($qi)) {

						echo"
							<tr class='text-xs'>
								<td>
						";
							if($i['url_file']!='') { echo"
								<b>Luaran</b><br><a href='$i[url_file]' target='_blank'><i class='fa fa-file-pdf'> Unduh</i></a>
							"; }
							else { echo " 
								<b>Luaran</b><br><span class='text-danger'>Tidak ada</span>
							"; }
						echo"
								</td>
								<td><b>Capaian</b><br>$i[capaian] $ind[skala]</td>
								<td class='border-left'><b>Upaya</b><br>$i[upaya]</td>
								<td><b>Kendala</b><br>$i[kendala]</td>
								<td><b>RTL</b><br>$i[rtl]</td>

								<td>
									<a href='#' data-toggle='dropdown'><i class='fa fa-ellipsis-v'></i></a>
									<div class='dropdown-menu text-xs'>
						";
								echo"
										<a class='dropdown-item' href='/catatan/edit/$i[id]'>Edit</a>
										<a class='dropdown-item' href='/delete/catatan/$i[id]'>Hapus</a>
								";

						echo"
									</div>
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

		}
		?>


				<div class="modal fade" id="tambah">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title">Isi Catatan Bulan <?php echo $bulan['desc']; ?></h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<form role="form" enctype="multipart/form-data" method="post" action="/insert/catatan">
										<input type="hidden" name="id_bulan" value="<?php echo $bulan['value']; ?>">
										<div class="form-group">
											<p>
											<label>Indikator Kinerja / Tujuan<span class="text-danger"> *</span></label>
											<select class='form-control' name='id_indikator' required>
											  <option value=''>--Hanya bisa pilih dari indikator yang belum dilaporkan--</option>
											  <?php
											    $qind = mysqli_query($con,"SELECT * FROM indikator WHERE unit='$_SESSION[ses_user]' ORDER BY jenis,id ");
											    while($ind=mysqli_fetch_array($qind)) {
											    $c = mysqli_num_rows(mysqli_query($con,"SELECT catatan.id FROM catatan WHERE catatan.id_indikator='$ind[id]' AND id_bulan='$folder[3]' ORDER BY id "));
											    
											      if($c<1) {
											    	echo"
												<option value='$ind[id]'>$ind[nama]</option>
												";
											      }
											      else {
											    	echo"
												<option value='$ind[id]' disabled>(sudah dilaporkan) $ind[nama]</option>
												";
											      }
											    }
											  ?>
											</select>
											</p>
											<p>
											<label>Upaya yang telah dilakukan pada bulan <?php echo $bulan['desc']; ?><span class="text-danger"> *</span></label>
											<textarea name="upaya" class="form-control" minlength='3' placeholder='uraikan secara spesifik dan konkrit, tidak normatif' required></textarea>
											</p>
											<p>
											<label>Kendala yang dihadapi<span class="text-danger"> *</span></label>
											<textarea name="kendala" class="form-control" required></textarea>
											</p>
											<p>
											<label>Rencana Tindak Lanjut (RTL) pada bulan <?php echo $next_bulan['desc']; ?><span class="text-danger"> *</span></label>
											<textarea name="rtl" class="form-control" required></textarea>
											</p>
											
											<p>
											<label>Persentase (%) Progress Capaian Indikator Ini sampai dengan Bulan <?php echo $bulan['desc']; ?><span class="text-danger"> *</span></label>
											<input name="capaian" type="number" max="100" class="form-control" required>
											</p>
											
											<p>
											<label>File Pendukung Laporan (PDF) Digabungkan</label>
											<input name="fupload" type="file" class="form-control">
											</p>

										</div>
								</div>
								<div class="modal-footer justify-content-between">
									<input type="submit" class="btn btn-primary" value="Tambah">
								</div>
								</form>
							</div>
						</div>
			  	        </div>
<?php		
		break;
		
		case 'isi':
			$bulan = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='bulan' AND value='$folder[3]' "));
			$ind=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM indikator WHERE unit='$_SESSION[ses_user]' AND id='$folder[4]' ORDER BY jenis,id "));
			$luaran = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='luaran' AND value='$ind[luaran]' "));
			$bulandate = str_replace("-","",$bulan['date']);
			$next_bulan = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='bulan' AND value=$folder[3]+1 "));
?>		

			<div class='card'>
								<div class="card-header bg-info rounded-0">
									<h4 class="card-title"><b><?php echo $ind['topik']; ?></b> : Laporan Bulan <?php echo $bulan['desc']; ?></h4>
								</div>
								<div class="card-body">
									<form role="form" enctype="multipart/form-data" method="post" action="/insert/catatan">
										<input type="hidden" name="id_bulan" value="<?php echo $bulan['value']; ?>">
										<input type="hidden" name="id_indikator" value="<?php echo $ind['id']; ?>">
										<div class="form-group">
											<p>
												<label>Indikator Kinerja / Tujuan</label>
												<br/>
												<?php echo $ind['nama']; ?>
											</p>

											<p>
												<label>Standar</label>
												<br/>
												<?php echo $ind['standar']; ?> <?php echo $ind['skala']; ?>
											</p>
											
											<p>
												<label>Target</label>
												<br/>
												<?php echo $ind['target_after']; ?> <?php echo $ind['skala']; ?>
											</p>
										</div>
								</div>
								<div class="card-header bg-info rounded-0">
									<h4 class="card-title text-center">Luaran yang ditargetkan: <?php echo $luaran['desc']; ?></h4>
								</div>
								<div class="card-body">
<?php
								switch($ind['luaran']) {
									case '1':
?>							
										<div class="form-group">
											<p>
												<label>Dokumen Luaran <span class="text-danger"> *</span></label>
												<input name="fupload" type="file" class="form-control" required>
											</p>

											<p>
												<label>Capaian Luaran <span class="text-danger"> *</span></label>
												<select name="capaian" class="form-control" required>
													<option value=''>--pilih capaian luaran--</option>
											<?php
												$qformal = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='dokumenformal' ");
												while($formal=mysqli_fetch_array($qformal)) {
													echo"
													<option value='$formal[value]'>($formal[value]%) $formal[desc]</option>
													";
												}
											?>
												</select>												
											</p>
										</div>
<?php
									break;
									case '2':
?>
										<div class="form-group">
											<p>
												<label>Dokumen Luaran <span class="text-danger"> *</span></label>
												<input name="fupload" type="file" class="form-control" required>
											</p>

											<p>
												<label>Kelengkapan Bukti Sahih <span class="text-danger"> *</span></label>
												<select name="capaian" class="form-control" required>
													<option value=''>--pilih kelengkapan bukti--</option>
											<?php
												$qbukti = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='buktisahih' ");
												while($bukti=mysqli_fetch_array($qbukti)) {
													echo"
													<option value='$bukti[value]'>($bukti[value]%) $bukti[desc]</option>
													";
												}
											?>
												</select>												
											</p>
										</div>
<?php
									break;
									
									case '3':
?>
										<div class="form-group">
											<p>
												<!-- <a href='/<?php echo $ind['url_template']; ?>' target='_blank'>[download template data]</a><br> !-->
												<label>Dokumen Data <span class="text-danger"> *</span></label>
												<input name="fupload" type="file" class="form-control" required>
											</p>

											<p>
												<label>Capaian: ....... <?php echo $ind['skala']; ?> <span class="text-danger"> *</span></label>
												<div class="row" p-0 m-0>
												<div class="col-md-2">
													<input type="number" name="capaian" class="form-control" step=".1">
												</div>
												<div class="col-md-2">
													<b><?php echo $ind['skala']; ?></b>
												</div>
												</div>
											</p>
										</div>
<?php									
									break;
									
									case '4':
//										include "hitung.php";
	
//										$capaian = hitung($ind['id_data'],$_SESSION['ses_user']);
?>
										<div class="form-group">
											<p>
												<!-- <a href='/<?php echo $ind['url_template']; ?>' target='_blank'>[Alamat Pengisian]</a><br> !-->
												<label>Lampiran <span class="text-danger"> *</span></label>
												<input name="fupload" type="file" class="form-control" required>
											</p>

											<p>
												<label>Capaian: ....... <?php echo $ind['skala']; ?> <span class="text-danger"> *</span></label>
												<div class="row" p-0 m-0>
												<div class="col-md-2">
													<input type="number" name="capaian" class="form-control" step=".1" value="<?php echo $capaian; ?>" required>
												</div>
												<div class="col-md-2">
													<b><?php echo $ind['skala']; ?></b>
												</div>
												</div>
											</p>
										</div>
<?php									
									break;
								}
?>
								</div>
								<div class="card-header bg-info rounded-0">
									<h4 class="card-title text-center">Analisis Keberhasilan/Ketidakberhasilan</h4>
								</div>
								<div class="card-body">
										<div class="form-group">
											<p>
											<label>Upaya yang telah dilakukan pada bulan <?php echo $bulan['desc']; ?><span class="text-danger"> *</span></label>
											<textarea name="upaya" class="form-control" minlength='3' placeholder='uraikan secara spesifik dan konkrit, tidak normatif' required></textarea>
											</p>
											<p>
											<label>Kendala yang dihadapi<span class="text-danger"> *</span></label>
											<textarea name="kendala" class="form-control" required></textarea>
											</p>
											<p>
											<label>Rencana Tindak Lanjut (RTL) pada bulan <?php echo $next_bulan['desc']; ?><span class="text-danger"> *</span></label>
											<textarea name="rtl" class="form-control" required></textarea>
											</p>
										</div>
								</div>
								<div class="modal-footer justify-content-between">
									<input type="submit" class="btn btn-primary" value="Simpan">
								</div>
								</form>

			
			</div>

<?php
		break;
		
		case 'edit':
			$qc = mysqli_query($con,"SELECT * FROM catatan WHERE id='$folder[3]' ");
			if(mysqli_num_rows($qc)<1) {
				header('Location: /catatan/');
	exit;
			}
			else {
				$c=mysqli_fetch_array($qc);

		
			$ind=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM indikator WHERE unit='$_SESSION[ses_user]' AND id='$c[id_indikator]' "));
			$luaran = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='luaran' AND value='$ind[luaran]' "));
			$bulan = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='bulan' AND value='$c[id_bulan]' "));
			$next_bulan = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='bulan' AND value=$c[id_bulan]+1 "));
?>		

			<div class='card'>
								<div class="card-header bg-info rounded-0">
									<h4 class="card-title"><b><?php echo $ind['topik']; ?></b> : Edit Laporan Bulan <?php echo $bulan['desc']; ?></h4>
								</div>
								<div class="card-body">
									<form role="form" enctype="multipart/form-data" method="post" action="/update/catatan">
										<input type="hidden" name="id" value="<?php echo $c['id']; ?>">
										<div class="form-group">
											<p>
												<label>Indikator Kinerja / Tujuan</label>
												<br/>
												<?php echo $ind['nama']; ?>
											</p>

											<p>
												<label>Standar</label>
												<br/>
												<?php echo $ind['standar']; ?> <?php echo $ind['skala']; ?>
											</p>
											
											<p>
												<label>Target</label>
												<br/>
												<?php echo $ind['target_after']; ?> <?php echo $ind['skala']; ?>
											</p>
										</div>
								</div>
								<div class="card-header bg-info rounded-0">
									<h4 class="card-title text-center">Luaran yang ditargetkan: <?php echo $luaran['desc']; ?></h4>
								</div>
								<div class="card-body">
<?php
								switch($ind['luaran']) {
									case '1':
?>							
										<div class="form-group">
											<p>
												<label>Dokumen Luaran</label>
												<input name="fupload" type="file" class="form-control">
											</p>

											<p>
												<label>Capaian Luaran <span class="text-danger"> *</span></label>
												<select name="capaian" class="form-control" required>
													<option value="">--Silakan Pilih Capaian Dokumen--</option>
											<?php
												$qformal = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='dokumenformal' ");
												while($formal=mysqli_fetch_array($qformal)) {
													if($formal['value']==$c['capaian']) {
														echo"
														<option value='$formal[value]' selected>($formal[value]%) $formal[desc]</option>
														";
													}
													else{
														echo"
														<option value='$formal[value]'>($formal[value]%) $formal[desc]</option>
														";
													}
												}
											?>
												</select>												
											</p>
										</div>
<?php
									break;
									case '2':
?>
										<div class="form-group">
											<p>
												<label>Dokumen Luaran</label>
												<input name="fupload" type="file" class="form-control">
											</p>
											<p>
												<label>Kelengkapan Bukti Sahih <span class="text-danger"> *</span></label>
												<select name="capaian" class="form-control" required>
												<option value=''>--Silakan Pilih Capaian Bukti Sahih--</option>
											<?php
												$qbukti = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='buktisahih' ");
												while($bukti=mysqli_fetch_array($qbukti)) {
													if($bukti['value']==$c['capaian']) {
														echo"
														<option value='$bukti[value]' selected>($bukti[value]%) $bukti[desc]</option>
														";
													}
													else {
														echo"
														<option value='$bukti[value]'>($bukti[value]%) $bukti[desc]</option>
														";
													}
												}
											?>
												</select>												
											</p>
										</div>
<?php
									break;
									
									case '3':
?>
										<div class="form-group">
											<p>
												<a href='/<?php echo $ind['url_template']; ?>' target='_blank'>[download template data]</a><br>
												<label>Dokumen Data</label>
												<input name="fupload" type="file" class="form-control">
											</p>

											<p>
												<label>Capaian: ....... <?php echo $ind['skala']; ?> <span class="text-danger"> *</span></label>
												<div class="row" p-0 m-0>
												<div class="col-md-2">
													<input type="number" name="capaian" class="form-control" step=".1">
												</div>
												<div class="col-md-2">
													<b><?php echo $ind['skala']; ?></b>
												</div>
												</div>
											</p>
										</div>
<?php									
									break;
									
									case '4':
										function KecukupanDosen() {

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
											
											$dosen = mysqli_fetch_array(mysqli_query($con2,"SELECT COUNT(*) AS j FROM dosen WHERE ikatan='A' AND status='A' "));
											$prodi = mysqli_fetch_array(mysqli_query($con2,"SELECT COUNT(*) AS j FROM prodi "));
											$capaian = ROUND($dosen['j']/$prodi['j'],0);		
											
											return $capaian;							
										}
										if($ind[topik]=="Kecukupan Dosen") {
											$capaian = KecukupanDosen();
										}
?>
										<div class="form-group">
											<p>
												<a href='/<?php echo $ind['url_template']; ?>' target='_blank'>[Alamat Pengisian]</a><br>
											</p>

											<p>
												<label>Capaian: ....... <?php echo $ind['skala']; ?> <span class="text-danger"> *</span></label>
												<div class="row" p-0 m-0>
												<div class="col-md-2">
													<input type="number" name="capaian" class="form-control" step=".1" value="<?php echo $capaian; ?>" readonly>
												</div>
												<div class="col-md-2">
													<b><?php echo $ind['skala']; ?></b>
												</div>
												</div>
											</p>
										</div>
<?php									
									break;
								}
?>
								</div>
								<div class="card-header bg-info rounded-0">
									<h4 class="card-title text-center">Analisis Keberhasilan/Ketidakberhasilan</h4>
								</div>
								<div class="card-body">
										<div class="form-group">
											<p>
											<label>Upaya yang telah dilakukan pada bulan <?php echo $bulan['desc']; ?><span class="text-danger"> *</span></label>
											<textarea name="upaya" class="form-control" minlength='3' placeholder='uraikan secara spesifik dan konkrit, tidak normatif' required><?php echo $c['upaya']; ?></textarea>
											</p>
											<p>
											<label>Kendala yang dihadapi<span class="text-danger"> *</span></label>
											<textarea name="kendala" class="form-control" required><?php echo $c['kendala']; ?></textarea>
											</p>
											<p>
											<label>Rencana Tindak Lanjut (RTL) pada bulan <?php echo $next_bulan['desc']; ?><span class="text-danger"> *</span></label>
											<textarea name="rtl" class="form-control" required><?php echo $c['rtl']; ?></textarea>
											</p>
										</div>
								</div>
								<div class="modal-footer justify-content-between">
									<input type="submit" class="btn btn-primary" value="Simpan">
								</div>
								</form>

			
			</div>
		
		
<?php		
			}
		break;
		
		case 'agenda':
?>
		<div class='card'>
			<div class='card-header with-border'>
				<h3 class='card-title'>Agenda Kerja</h3>
			                <div class="card-tools">
			                      <a class="btn btn-danger btn-sm" href="/cetak/agenda_kerja/"><i class="fa fa-file-word"></i> Download (word)</a>
			                 </div>	
			</div>
			<div class="card-body">
			<div class='table-responsive'>
				<table class='table table-striped'>
<?php
						echo"
							<tr class='table-primary'>
								<th>No</th>
								<th>Indikator Kinerja</th>
								<th>Bentuk Kegiatan</th>
								<th>Waktu Pelaksanaan</th>
							</tr>
						";
						$no = 1;
						$qi = mysqli_query($con,"SELECT indikator.nama,proker.* FROM proker,indikator WHERE proker.id_indikator=indikator.id AND indikator.unit='$_SESSION[ses_user]' ORDER BY indikator.jenis,indikator.id,proker.id ");
						while($i=mysqli_fetch_array($qi)) {
						echo"
							<tr class='text-xs'>
								<td>$no</td>
								<td>$i[nama]</td>
								<td>$i[bentuk]</td>
								<td>$i[waktu_mulai] s.d $i[waktu_selesai]</td>
							</tr>
						";
						$no++;
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