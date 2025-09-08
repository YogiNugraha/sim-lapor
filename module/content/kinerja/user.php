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
	switch(@$folder['2']) {

		default:
		
		if(@$folder['3']=='') {
			$thn = '2025';
		}
		else {
			$thn = $folder['3'];
		}
?>
		<div class='callout callout-success'>
			<p><h4>Informasi</h4></p>
			<p>Pengisian sampai dengan 12 Februari 2025</br>
			Review 14 Februari 2025</br>
			Revisi 15 Februari 2025</p>
		</div>

		<div class='card'>
			<div class='card-body'>
				<select onchange="window.document.location.href=this.options[this.selectedIndex].value;" class='form-control' name='ta'>
				<option value='#'>-- Pilih Tahun --</option> 
					<?php
			
					$qp = mysqli_query($con,"SELECT * FROM periode ");
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
							<option value='/kinerja/default/$p[thn]' $selected>Kontrak Tahun $p[thn]</option>
						";
					}
					?>
				</select>
			</div>
		</div>


		<div class='card'>
			<div class='card-header with-border'>
				<h3 class='card-title'>Kontrak  Kinerja Tahunan</h3>
			                <div class="card-tools">
			                      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah IKT</button>
			                      <a class="btn btn-danger btn-sm" href="/cetak/kinerja/default/<?php echo $thn; ?>"><i class="fa fa-file-word"></i> Save as Word</a>
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
						$qi = mysqli_query($con,"SELECT * FROM indikator WHERE tahun='$thn' AND jenis='1' AND unit='$_SESSION[ses_user]' ");
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
							
							$luaran = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='luaran' AND value='$i[luaran]' "));

							
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
						if($ivalid!='2') {
							if($tgl_sekarang<='20250228') {
							echo"
										<a class='dropdown-item' href='/kinerja/edit/$i[id]'>Edit</a>
							";
							}
							else {
							echo"
										<a class='dropdown-item' href='#'>Masa Input Telah Berakhir</a>
							";
							}
						}
						echo"
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
						$qi2 = mysqli_query($con,"SELECT * FROM indikator WHERE tahun='$thn' AND jenis='2' AND unit='$_SESSION[ses_user]' ");
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
							
							$luaran2 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='luaran' AND value='$i2[luaran]' "));

						echo"
							<tr class='text-xs'>
								<td>$no2</td>
								<td><p>$i2[nama]</p><p><b>Kriteria</b><br>$i2[kriteria]</p></td>
								<td>$i2[standar] $i2[skala]</td>
								<td>$i2[capaian_before]</td>
								<td>$i2[target_after]</td>
								<td>$luaran2[desc]</td>
								<td>$valid2</td>
								<td>
									<a href='#' data-toggle='dropdown'><i class='fa fa-ellipsis-v'></i></a>
									<div class='dropdown-menu text-xs'>
						";
						if($ivalid2!='22') {
							if($tgl_sekarang<='20250905') {
							echo"
										<a class='dropdown-item' href='/kinerja/edit/$i2[id]'>Edit</a>
										<a class='dropdown-item' href='/delete/kinerja/$i2[id]'>Hapus</a>

							";
							}
							else {
							echo"
										<a class='dropdown-item' href='#'>Masa Input Telah Berakhir</a>
							";
							}
						echo"
									</div>
						";

						}
						echo"
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


				<div class="modal fade" id="tambah">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title">Tambah</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<form role="form" enctype="multipart/form-data" method="post" action="/insert/kinerja">
										<div class="form-group">
											<p>
											<label>Jenis<span class="text-danger"> *</span></label>
											<select class='form-control' name='jenis' required>
												<option value=''>-- Pilih --</option>
												<option value='2' selected>Indikator Kinerja Tambahan (IKT)</option>
											</select>
											</p>
											<p>
											<label>Standar SPMI<span class="text-danger"> *</span></label>
												<select name='topik' class='form-control select2 select2bs4' required>
													<option value=''>-Pilih-</option>
											<?php
												$qs = mysqli_query($con,"SELECT kriteria.kriteria,subkriteria.subkriteria FROM kriteria,subkriteria WHERE kriteria.id>='10' AND kriteria.id=subkriteria.id_kriteria ");
												while($s = mysqli_fetch_array($qs)) {
											?>
														<option value='<?=$s['subkriteria'];?>'><?=$s['kriteria'];?> - <?=$s['subkriteria'];?></option>
											<?php	} ?>
												</select>

											</p>

											<p>
											<label>Nama Indikator<span class="text-danger"> *</span></label>
											<input name="nama" type="text" class="form-control" placeholder="Penulisan arus dalam bentuk kalimat target" required>
											</p>
											<label>Kriteria</label>
											<input name="kriteria" type="text" class="form-control" placeholder="Kriteria penilaian">
											</p>
											<div class="row">
											    <div class="col-md-6 px-2">
        											<label>Nilai Standar<span class="text-danger"> *</span></label>
        											<input name="standar" type="number" class="form-control" step="0.01" required>
        											</p>
											    </div>
											    <div class="col-md-6 px-2">
        											<label>Satuan Nilai</label>
        											<input name="skala" type="text" class="form-control" placeholder="contoh: Juta, Orang, Judul, etc">
        											</p>
											    </div>
											</div>
											<p>
											<label>Baseline<span class="text-danger"> *</span></label>
											<input name="capaian_before" type="number" min="0" class="form-control" step="0.01" required>
											</p>
											<p>
											<label>Target<span class="text-danger"> *</span></label>
											<input name="target_after" type="number" min="0" class="form-control" step="0.01" required>
											</p>

											<label>Luaran<span class="text-danger"> *</span></label>
												<select name='luaran' class='form-control' required>
													<option value=''>-Pilih-</option>
											<?php
												$ql = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='luaran' ORDER BY value ");
												while($l = mysqli_fetch_array($ql)) {
											?>
														<option value='<?=$l['value'];?>'><?=$l['desc'];?></option>
											<?php	} ?>
												</select>
							


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
		
		case 'edit':
			$qi = mysqli_query($con,"SELECT * FROM indikator WHERE id='$folder[3]' AND unit='$_SESSION[ses_user]' AND valid!='2' ");
			if(mysqli_num_rows($qi)<1) {
				header('Location: /kinerja/');
	exit;
			}
			else {
				$i=mysqli_fetch_array($qi);
				if($i['jenis']=='1') { $readonly = 'readonly'; } else { $readonly = ''; }
?>
		<div class='card'>
			<div class='card-header with-border'>
				<h3 class='card-title'>Isi Indikator Kinerja</h3>
			</div>
								<div class="card-body">
									<form role="form" enctype="multipart/form-data" method="post" action="/update/kinerja">
										<div class="form-group">
											<input type="hidden" name="id" value="<?php echo $i['id']; ?>">
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
        											<input name="standar" type="number" class="form-control" value="<?php echo $i['standar']; ?>" step="0.01" required <?=$readonly;?>>
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
											<input name="capaian_before" type="number" min="0" class="form-control" value="<?php echo $i['capaian_before']; ?>" step="0.01" required>
											</p>
											<p>
											<label>Target<span class="text-danger"> *</span></label>
											<input name="target_after" type="number" min="0" class="form-control" value="<?php echo $i['target_after']; ?>" step="0.01" required>
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

			if(is_numeric($folder['3'])==FALSE) {
				$thn = '2025';
			}
			else {
				$thn = $folder['3'];
			}
?>
		<div class='callout callout-success'>
			<p><h4>Laporan Capaian Kontrak Kinerja</h4></p>
			<p>Pengisian sampai dengan Jum'at, 18 Juli 2025 pukul 23.59 WIB.</p>
		</div>


		<div class='card'>
			<div class='card-body'>
				<select onchange="window.document.location.href=this.options[this.selectedIndex].value;" class='form-control' name='ta'>
				<option value='#'>-- Pilih Tahun --</option> 
					<?php
			
					$qp = mysqli_query($con,"SELECT * FROM periode ");
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
							<option value='/kinerja/laporan/$p[thn]' $selected>$p[thn]</option>
						";
					}
					?>
				</select>
			</div>
		</div>




		<div class='card'>
			<div class='card-header with-border'>
				<h3 class='card-title'>Laporan Kinerja</h3>
			                <div class="card-tools">
			                      <a class="btn btn-danger btn-sm" href="/cetak/kinerja/laporan/<?php echo $thn; ?>" target="_blank"><i class="fa fa-file-word"></i> Download (word)</a>
			                 </div>	
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
						$qi = mysqli_query($con,"SELECT * FROM indikator WHERE tahun='$thn' AND jenis='1' AND unit='$_SESSION[ses_user]' ");
						while($i=mysqli_fetch_array($qi)) {
							$ivalid = $i['status_monev'];
							if($ivalid=='1') {
								$valid = "<span class='badge badge-warning'>In Review</span>";
							}
							elseif($ivalid=='2') {
								$valid = "<span class='badge badge-success'>Tercapai</span>";
							}
							elseif($ivalid=='3') {
								$valid = "<span class='badge badge-danger'>Belum Tercapai</span>";
							}
							else {
								$valid = "";
							}
							
							if($i['dokumen']=='') {
								$dokumen = '';
							}
							else {
								$dokumen = "<a href='$i[dokumen]' target='_blank'><i class='fa fa-file'> Bukti</i></a>";
							}
							
							$luaran = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='luaran' AND value='$i[luaran]' "));

							
						echo"
							<tr class='text-xs'>
								<td>$no</td>
								<td>	<p><b>$i[topik]</b><br>$i[nama]</p><p><b>Kriteria</b><br>$i[kriteria]</p><p><b>Analisis Ketercapaian/Ketidaktercapaian:</b> <br>$i[analisis]</p>
									<p><b>Rencana Tindak Lanjut:</b> <br>$i[rtl]</p>
									<p><b>Hasil Monev:</b> <br>$i[hasil_monev]</p>
									<p><b>Rekomendasi:</b> <br>$i[rekomendasi_monev]</p>
								</td>
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
										<a class='dropdown-item' href='/kinerja/edit_laporan/$i[id]'>Edit</a>
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
								$dokumen2 = "<a href='$i2[dokumen]' target='_blank'><i class='fa fa-file'> Bukti</i></a>";
							}
							
							$luaran2 = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='luaran' AND value='$i2[luaran]' "));

						echo"
							<tr class='text-xs'>
								<td>$no2</td>
								<td>	<p>$i2[nama]</p>
									<p><b>Analisis Ketercapaian/Ketidaktercapaian:</b> <br>$i2[analisis]</p>
									<p><b>Rencana Tindak Lanjut:</b> <br>$i2[rtl]</p>
								</td>
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
										<a class='dropdown-item' href='/kinerja/edit_laporan/$i2[id]'>Edit</a>
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
			$qi = mysqli_query($con,"SELECT * FROM indikator WHERE id='$folder[3]' AND unit='$_SESSION[ses_user]' ");
			if(mysqli_num_rows($qi)<1) {
				header('Location: /kinerja/laporan');
	exit;
			}
			else {
				$i=mysqli_fetch_array($qi);
				
				$dir = mysqli_fetch_array(mysqli_query($con,"SELECT folder FROM level WHERE user='$_SESSION[ses_user]' "));

				if($i['dokumen']=='') {
					$dokumen = '';
				}
				else {
					$dokumen = "<a href='$i[dokumen]' target='_blank'><i class='fa fa-file'> Bukti</i></a>";
				}
				
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
											<label>Baseline<span class="text-danger"> *</span></label>
											<input name="capaian_before" type="text" class="form-control" value="<?php echo $i['capaian_before']; ?>" disabled>
											</p>
											</p>
											<label>Target <span class="text-danger"> *</span></label>
											<input name="target_after" type="text" class="form-control" value="<?php echo $i['target_after']; ?>" disabled>
											</p>
											</p>
											<label>Capaian<span class="text-danger"> *</span></label>
											<input name="capaian_after" type="number" class="form-control" value="<?php echo $i['capaian_after']; ?>" step="0.01" required>
											</p>

											<p>
											<label>Dokumen Bukti/Luaran <span class="text-danger"> *</span> <?php echo $dokumen; ?> <a target="_blank" href="<?=$dir[folder];?>">Unggah dan Buat Folder Disini</a></label>
											<input name="dokumen" type="url" class="form-control" value="<?php echo $i['dokumen']; ?>" placeholder="Link ke folder spesifik di Google Drive" required>
											</p>
											
											<p>
											<label>Analisis Ketercapaian/Ketidaktercapaian<span class="text-danger"> *</span></label>
											<textarea name="analisis" class="form-control" minlength='3' placeholder='uraikan alasan/sebab secara spesifik dan konkrit, tidak normatif' required><?php echo $i['analisis']; ?></textarea>
											</p>

											<p>
											<label>Rencana Tindak Lanjut<span class="text-danger"> *</span></label>
											<textarea name="rtl" class="form-control" minlength='3' placeholder='uraikan rencana tindak lanjut di sisa tahun' required><?php echo $i['rtl']; ?></textarea>
											</p>


										</div>
									<input type="submit" class="btn btn-primary btn-sm" value="Simpan">
									</form>
								</div>
		</div>
<?php		
			}
		break;

		}

}
?>