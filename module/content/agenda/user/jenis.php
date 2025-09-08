<?php
declare(strict_types=1);

	$qp = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='agenda' AND value='$folder[3]' ");
	$p = mysqli_fetch_array($qp);
?>

	<div class='card'>
		<div class='card-body'>		
			<div class='row'>
				<div class='col-md-4'>
					<i class='fa fa-envelope'></i> Surat Undangan</a><br>
					<i class='fa fa-users'></i> Daftar Hadir<br>
					<i class='fa fa-pen-square'></i> Notulensi<br>
				</div>
				<div class='col-md-4'>
					<i class='fa fa-camera'></i> Foto Kegiatan<br>
					<i class='fa fa-video'></i> Vidio Kegiatan<br>
					<i class='fa fa-newspaper'></i> Rilis Berita<br>
				</div>
				<div class='col-md-4'>
					<i class='fa fa-book-reader'></i> Berita Acara<br>
					<i class='fa fa-file-powerpoint'></i> Bahan Kajian<br>
					<i class='fa fa-image'></i> Flyer<br>					
				</div>
			</div>
		</div>
	</div>


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
						<th>No</th>
						<th>Waktu</th>
						<th>Nama Agenda</th>
						<th>Tempat</th>
						<th>Narasumber dan Peserta</th>
						<th>Presensi</th>
						<th>File</th>
						<th>Aksi</th>
					</tr>
					</thead>
					<tbody class='text-sm'>

<?php
	$no = 1;
	$qs = mysqli_query($con,"SELECT * FROM kegiatan WHERE id_kegiatan='$folder[3]' ORDER BY tgl_mulai DESC ");
	while($s=mysqli_fetch_array($qs)) {

		$hadir = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(*) AS j FROM presensi WHERE id_kegiatan='$s[id]' AND presensi='1' "));
		$dispen = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(*) AS j FROM presensi WHERE id_kegiatan='$s[id]' AND presensi='2' "));
		$alfa = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(*) AS j FROM presensi WHERE id_kegiatan='$s[id]' AND presensi='3' "));
?>
					
					<tr>
						<td><?=$no;?></td>
						<td><?php echo $s['tgl_mulai']; ?><br>
						    <?php echo $s['jam_mulai']; ?></td>
						<td><?php echo $s['nama']; ?></td>
						<td><?php echo $s['lokasi']; ?></td>
						<td><?php echo $s['narasumber']; ?>-<?php echo $s['peserta']; ?></td>
						<td>
							<span class='btn btn-success btn-xs btn-block'><?php echo $hadir['j'];?> Hadir</span>
							<span class='btn btn-warning btn-xs btn-block'><?php echo $dispen['j'];?> Dispen</span>
							<span class='btn btn-danger btn-xs btn-block'><?php echo $alfa['j'];?> Alfa</span>
							<a href='/agenda/presensi/<?=$s['id'];?>'>[<i class='fa fa-plus'></i> Input]</a>
						</td>
						<td>
					<?php
						$qf = mysqli_query($con,"SELECT * FROM file_kegiatan WHERE id_kegiatan='$s[id]' ");
						while($f=mysqli_fetch_array($qf)) {
							switch($f['id_jenis_file']) {
								case '1': $icon = 'file-powerpoint'; $text='Bahan Kajian'; break;
								case '2': $icon = 'envelope'; $text='Surat Undangan'; break;
								case '3': $icon = 'image'; $text='Flyer'; break;
								case '4': $icon = 'users'; $text='Daftar Hadir'; break;
								case '5': $icon = 'camera'; $text='Foto Kegiatan'; break;
								case '6': $icon = 'video'; $text='Vidio Kegiatan'; break;
								case '7': $icon = 'book-reader'; $text='Berita Acara'; break;
								case '8': $icon = 'pen-square'; $text='Notulensi'; break;
								case '9': $icon = 'newspaper'; $text='Rilis Berita'; break;
								case '10': $icon = 'file'; $text='File Lainnya'; break;
							}
							echo"<a href='$f[url_file]' target='_blank'><i class='fa fa-$icon'></i> $text</a><br>";
						}
					?>
						<a href='/agenda/file/<?=$s['id'];?>'>[<i class='fa fa-plus'></i> Tambah]</a>
						
						</td>
						<td>
							<a href='#' data-toggle='dropdown'><i class='fa fa-ellipsis-v'></i></a>
							<div class='dropdown-menu text-xs'>
								<a class='dropdown-item' href='/agenda/edit/<?php echo $s['id']; ?>'>Edit</a>
								<a class='dropdown-item' href='/delete/agenda/<?php echo $s['id']; ?>/<?php echo $folder['3']; ?>'>Hapus</a>
							</div>
						</td>					
					</tr>
<?php
	$no++;
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
					<form role="form" enctype="multipart/form-data" method="post" action="/insert/agenda">
						<div class="form-group">
							<input type="hidden" name="id_kegiatan" value="<?php echo $folder['3']; ?>">
							<p>
								<label>Nama Agenda<span class="text-danger"> *</span></label>
								<input name="nama" type="text" class="form-control" placeholder="Nama Agenda" required>
							</p>
							<p>
								<label>Tanggal Mulai<span class="text-danger"> *</span></label>
								<input name="tgl_mulai" type="date" class="form-control" required>
							</p>
							<p>
								<label>Tanggal Selesai</label>
								<input name="tgl_selesai" type="date" class="form-control">
							</p>
							<p>
								<label>Jam Mulai<span class="text-danger"> *</span></label>
								<input name="jam_mulai" type="time" class="form-control" required>
							</p>
							<p>
								<label>Jam Selesai</label>
								<input name="jam_selesai" type="time" class="form-control">
							</p>
							<p>
								<label>Tempat/Lokasi<span class="text-danger"> *</span></label>
								<input name="lokasi" type="text" class="form-control" placeholder="Tempat/Lokasi" required>
							</p>
							<p>
								<label>Narasumber</label>
								<input name="narasumber" type="text" class="form-control" placeholder="Peserta">
							</p>
							<p>
								<label>Peserta<span class="text-danger"> *</span></label>
								<input name="peserta" type="text" class="form-control" placeholder="Peserta" required>
							</p>
							<p>
								<label>Deskripsi</label>
								<textarea name="deskripsi" class="form-control"></textarea>
							</p>
							
							<p class="text-center"><b>Share Agenda</b></p>
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
												if($s['value']==$folder[3]) { $selected = 'selected'; } else {$selected = '';}
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
	
