<?php
declare(strict_types=1);

	$qp = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='ket' AND value='$folder[3]' ");
	$p = mysqli_fetch_array($qp);
?>

	<div class='card card-primary'>
		<div class='card-header with-border'>
			<h3 class='card-title'><?php echo $p['desc']; ?></h3>
		                <div class="card-tools">
		                      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah</button>
		                 </div>	
		</div>
		<div class="card-body">
			<div class='table-responsive'>
				<table class='table table-striped' id='custom'>
					<thead>
					<tr class='bg-info'>
						<th>Tentang</th>
						<th>Nomor</th>
						<th>Tanggal</th>
						<th>File</th>
						<th>Tembusan</th>
						<th>Aksi</th>
					</tr>
					</thead>
					<tbody class='text-sm'>
<?php
	$qsk = mysqli_query($con,"SELECT * FROM ket WHERE id_jenis='$folder[3]' AND asal='$_SESSION[ses_user]' ORDER BY date DESC ");
	while($sk=mysqli_fetch_array($qsk)) {
?>
					<tr>
						<td><?php echo $sk['judul']; ?></td>
						<td><?php echo $sk['nomor']; ?></td>
						<td><?php echo $sk['tgl_sk']; ?></td>
						<td><a href='<?php echo $surat; ?>/<?php echo $sk['url_file']; ?>' target='_blank'><i class='fa fa-file-pdf'></i> File</a></td>
						<td><a href='/ket/edit/<?php echo $sk['id']; ?>'><i class='fa fa-users'></i> Lihat</a></td>
						<td>
							<a href='#' data-toggle='dropdown'><i class='fa fa-ellipsis-v'></i></a>
							<div class='dropdown-menu text-xs'>
								<a class='dropdown-item' href='/ket/edit/<?php echo $sk['id']; ?>'>Edit</a>
								<a class='dropdown-item' href='/delete/ket/<?php echo $sk['id']; ?>/<?php echo $folder['3']; ?>'>Hapus</a>
							</div>
						</td>					
					</tr>
<?php
	}
?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="tambah">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Tambah</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<form role="form" enctype="multipart/form-data" method="post" action="/insert/ket">
						<div class="form-group">
							<input type="hidden" name="id_jenis" value="<?php echo $folder['3']; ?>">
							<p>
								<label>Judul<span class="text-danger"> *</span></label>
								<input name="judul" type="text" class="form-control" placeholder="Judul" required>
							</p>
							<p>
								<label>Nomor<span class="text-danger"> *</span></label>
								<input name="nomor" type="text" class="form-control" placeholder="Nomor" required>
							</p>
							<p>
								<label>Tanggal<span class="text-danger"> *</span></label>
								<input name="tgl_sk" type="date" class="form-control" required>
							</p>
							<p>
								<label>File<span class="text-danger"> *</span></label>
								<input name="fupload" type="file" class="form-control" accept="pdf" required>
							</p>
							<p class="text-center"><b>Tembusan</b></p>
							<hr>
							<div class="row">
								<div class="col-md-6">
									<p>
										<label>Struktural</label>
										<select class='select2bs4 select2-primary' multiple='multiple' name='tembusan_struktural[]'>
											<option value=''>-- Pilih Struktural--</option>
												<?php
												$qs = mysqli_query($con,"SELECT * FROM level ");
												while($s = mysqli_fetch_array($qs)) {
												if($s['value']==$folder['3']) { $selected = 'selected'; } else {$selected = '';}
													echo "
														<option value='$s[user]' $selected>$s[nama_unit_singkat]</option>
													";
												}
												?>
										</select>
									</p>
									<p>
										<label>Dosen</label>
										<select class='select2bs4 select2-primary' multiple='multiple' name='tembusan_dosen[]'>
											<option value=''>-- Pilih Dosen--</option>
												<?php
												$qd = mysqli_query($con2,"SELECT * FROM dosen WHERE status='A' ORDER BY ikatan,name ");
												while($d = mysqli_fetch_array($qd)) {
												if($d['nik']==$folder['3']) { $selected = 'selected'; } else {$selected = '';}
													echo "
														<option value='$d[nik]' $selected>$d[name]</option>
													";
												}
												?>
										</select>
									</p>
									<p>
										<label>Karyawan</label>
										<select class='select2bs4 select2-primary' multiple='multiple' name='tembusan_karyawan[]'>
											<option value=''>-- Pilih Karyawan--</option>
												<?php
												$qk = mysqli_query($con3,"SELECT * FROM karyawan WHERE status='A' ORDER BY ikatan,name ");
												while($k = mysqli_fetch_array($qk)) {
												if($k['nik']==$folder['3']) { $selected = 'selected'; } else {$selected = '';}
													echo "
														<option value='$k[nik]' $selected>$k[name]</option>
													";
												}
												?>
										</select>
									</p>
								</div>
								<div class="col-md-6">
									<p>
										<label>Struktural</label><br>
										<input type="checkbox" value="Y" name="struktural_all"> Semua Struktural<br/>
										<input type="checkbox" value="Y" name="struktural_lembaga"> Ketua Lembaga<br/>
										<input type="checkbox" value="Y" name="struktural_bagian"> Kepala Bagian<br/>
										<input type="checkbox" value="Y" name="struktural_upt"> Kepala UPT<br/>
										<input type="checkbox" value="Y" name="struktural_prodi"> Ketua Prodi<br/>
									</p>
									<p>
										<label>Dosen</label><br>
										<input type="checkbox" value="Y" name="dt"> Dosen Tetap<br/>
										<input type="checkbox" value="Y" name="dtt"> Dosen Tidak Tetap<br/>
									</p>
									<p>
										<label>Karyawan</label><br>
										<input type="checkbox" value="Y" name="kt"> Karyawan Tetap<br/>
										<input type="checkbox" value="Y" name="ktt"> Karyawan Tidak Tetap<br/>
									</p>
								</div>
							</div>

						</div>
				</div>
				<div class="modal-footer justify-content-between">
					<input type="submit" class="btn btn-primary" value="Tambah">
				</div>
				</form>
			</div>
		</div>
	</div>
	
