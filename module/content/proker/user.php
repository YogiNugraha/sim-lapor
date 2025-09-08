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
		<div class='callout callout-success'>
			<p><h4>Informasi</h4></p>
			<p>Pengisian sampai dengan 12 Februari 2025<br>
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
							<option value='/proker/default/$p[thn]' $selected>Program Kerja Tahun $p[thn]</option>
						";
					}
					?>
				</select>
			</div>
		</div>



		<div class='card'>
			<div class='card-header with-border'>
				<h3 class='card-title'>Program Kerja Tahunan</h3>
			                <div class="card-tools">
			                      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah</button>
			                      <a class="btn btn-danger btn-sm" href="/cetak/proker/<?php echo $thn; ?>"><i class="fa fa-file-word"></i> Save as Word</a>
			                 </div>	
			</div>
			<div class="card-body">
			<div class='table-responsive'>
				<table class='table'>
<?php
						$qind = mysqli_query($con,"SELECT * FROM indikator WHERE tahun='$thn' AND unit='$_SESSION[ses_user]' ORDER BY jenis,id ");
						while($ind=mysqli_fetch_array($qind)) {
							if($ind['jenis']=='1') {
								$ik = 'IKU';
								$table_bg = 'table-primary';
							}
							elseif($ind['jenis']=='2') {
								$ik = 'IKT';
								$table_bg = 'table-info';
							}
							else {
								$ik = '';
							}
						echo"
							<tr class='$table_bg text-sm'>
								<td colspan='9'>
								[$ik] $ind[nama] <br> 
						";
						if($ind['valid']!='') {
						echo"<b>
								Standar: $ind[standar]  $ind[skala] &nbsp;&nbsp;&nbsp;
								Baseline: $ind[capaian_before] &nbsp;&nbsp;&nbsp;
								Target: $ind[target_after]
							</b></td>
						";
						}
						echo"
							</tr>
						";
						
						$no = 1;
						$qi = mysqli_query($con,"SELECT proker.* FROM proker WHERE proker.id_indikator='$ind[id]' ORDER BY id ");
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
								<th>Nama Program/Kegiatan</th>
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
						";
						if($ivalid!='2') {
							if($tgl_sekarang<='20250231') {
						echo"
										<a class='dropdown-item' href='/proker/edit/$i[id]'>Edit</a>
										<a class='dropdown-item' href='/delete/proker/$i[id]'>Hapus</a>
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
									<form role="form" enctype="multipart/form-data" method="post" action="/insert/proker">
										<div class="form-group">
											<p>
											<label>Indikator Kinerja / Tujuan<span class="text-danger"> *</span></label>
											<br>Jika indikator kinerja tidak tersedia, silakan tambah IKT ada kontrak kerja.
											<select class='form-control' name='id_indikator' required>
											  <option value=''>--Hanya bisa pilih dari indikator yang sudah diisi targetnya--</option>
											  <?php
											    $qind = mysqli_query($con,"SELECT * FROM indikator WHERE tahun='$thn' AND unit='$_SESSION[ses_user]' ORDER BY jenis,id ");
											    while($ind=mysqli_fetch_array($qind)) {
											      if($ind['valid']!='') {
											    	echo"
												<option value='$ind[id]'>$ind[nama]</option>
												";
											      }
											      else {
											    	echo"
												<option value='$ind[id]' disabled>(indikator belum diisi target) $ind[nama]</option>
												";
											      }
											    }
											  ?>
											</select>
											</p>
											<p>
											<label>Kebijakan</label>
											<input name="kebijakan" type="text" class="form-control" placeholder="isi dengan landasan kebijakan yang telah atau akan dibuat">
											</p>
											<p>
											<label>Nama Program/Kegiatan<span class="text-danger"> *</span></label>
											<input name="bentuk" type="text" class="form-control" placeholder="Silakan diisi" required>
											</p>
											<p>
											<label>Deskripsi Kegiatan<span class="text-danger"> *</span></label>
											<textarea name="deskripsi" class="form-control" required></textarea>
											</p>
											<p>
											<label>Waktu Mulai<span class="text-danger"> *</span></label>
											<input name="waktu_mulai" type="date" class="form-control" required>
											</p>
											<p>
											<label>Waktu Selesai<span class="text-danger"> *</span></label>
											<input name="waktu_selesai" type="date" class="form-control" required>
											</p>
											<p>
											<label>Sasaran<span class="text-danger"> *</span></label>
											<input name="sasaran" type="text" class="form-control" placeholder="Contoh: Mahasiswa, Dosen, Masyarakat" required>
											</p>
											<p>
											<label>Tolak Ukur/Luaran yang Akan Dihasilkan<span class="text-danger"> *</span></label>
											<input name="luaran" type="text" class="form-control" placeholder="Silakan diisi" required>
											</p>
											<p>
											<label>Alokasi Anggaran<span class="text-danger"> *</span></label>
											<input name="anggaran" type="number" class="form-control" required>
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
			$qi = mysqli_query($con,"SELECT * FROM proker WHERE id='$folder[3]' AND valid!='2222' ");
			if(mysqli_num_rows($qi)<1) {
				header('Location: /proker/');
	exit;
			}
			else {
				$i=mysqli_fetch_array($qi);
?>
		<div class='card'>
			<div class='card-header with-border'>
				<h3 class='card-title'>Edit Program Kerja</h3>
			</div>
								<div class="card-body">
									<form role="form" enctype="multipart/form-data" method="post" action="/update/proker">
										<div class="form-group">
											<input type="hidden" name="id" value="<?php echo $i['id']; ?>">
											<p>
											<label>Indikator Kinerja / Tujuan<span class="text-danger"> *</span></label>
											<select class='form-control' name='id_indikator' required>
											  <?php
											    $qind = mysqli_query($con,"SELECT * FROM indikator WHERE unit='$_SESSION[ses_user]' AND tahun='$i[tahun]' ORDER BY jenis,id ");
											    while($ind=mysqli_fetch_array($qind)) {
											    	if($ind['id']==$i['id_indikator']) {
											    	echo"
												<option value='$ind[id]' selected>$ind[nama]</option>
												";
												}
											    	else {
											    	echo"
												<option value='$ind[id]'>$ind[nama]</option>
												";
												}
											    }
											  ?>
											</select>
											</p>
											<p>
											<label>Kebijakan</label>
											<input name="kebijakan" type="text" class="form-control" value="<?php echo $i['kebijakan']; ?>">
											</p>
											<p>
											<label>Nama Program/Kegiatan<span class="text-danger"> *</span></label>
											<input name="bentuk" type="text" class="form-control" value="<?php echo $i['bentuk']; ?>" required>
											</p>
											<p>
											<label>Deskripsi Kegiatan<span class="text-danger"> *</span></label>
											<textarea name="deskripsi" class="form-control" required><?php echo $i['deskripsi']; ?></textarea>
											</p>
											<p>
											<label>Waktu Mulai<span class="text-danger"> *</span></label>
											<input name="waktu_mulai" type="date" class="form-control" value="<?php echo $i['waktu_mulai']; ?>" required>
											</p>
											<p>
											<label>Waktu Selesai<span class="text-danger"> *</span></label>
											<input name="waktu_selesai" type="date" class="form-control" value="<?php echo $i['waktu_selesai']; ?>" required>
											</p>
											<p>
											<label>Sasaran<span class="text-danger"> *</span></label>
											<input name="sasaran" type="text" class="form-control" value="<?php echo $i['sasaran']; ?>" required>
											</p>
											<p>
											<label>Tolak Ukur/Luaran yang Akan Dihasilkan<span class="text-danger"> *</span></label>
											<input name="luaran" type="text" class="form-control" value="<?php echo $i['luaran']; ?>" required>
											</p>
											<p>
											<label>Alokasi Anggaran<span class="text-danger"> *</span></label>
											<input name="anggaran" type="number" class="form-control" value="<?php echo $i['anggaran']; ?>" required>
											</p>
										</div>
									<input type="submit" class="btn btn-primary btn-sm" value="Simpan">
									</form>
								</div>
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