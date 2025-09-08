<?php
declare(strict_types=1);

	$qp = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='suratmasuk' AND value='$folder[3]' ");
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
						<th>Tanggal</th>
						<th>Asal</th>
						<th>Perihal</th>
						<th>Nomor</th>
						<th>Keterangan</th>
						<th>File</th>
						<th>Aksi</th>
					</tr>
					</thead>
					<tbody class='text-sm'>
<?php
	if($folder['3']=='3') {
		$qs = mysqli_query($con,"SELECT * FROM suratkeluar WHERE tembusan_struktural LIKE '%$_SESSION[ses_user]%' ORDER BY tgl DESC ");
	}
	else {
		$qs = mysqli_query($con,"SELECT * FROM suratmasuk WHERE id_jenis='$folder[3]' AND tujuan='$_SESSION[ses_user]' ORDER BY tgl DESC ");
	}
	while($s=mysqli_fetch_array($qs)) {
		if($folder['3']=='3') {
			$qasal = mysqli_fetch_array(mysqli_query($con,"SELECT nama_unit_singkat FROM level WHERE user='$s[asal]' "));
			$asal = $qasal['nama_unit_singkat'];
		}
		else {
			$asal = $s['asal'];
		}
?>
					<tr>
						<td><?php echo $s['tgl']; ?></td>
						<td><?php echo $asal; ?></td>
						<td><?php echo $s['perihal']; ?></td>
						<td><?php echo $s['nomor']; ?></td>
						<td><?php echo $s['keterangan']; ?></td>
						<td><a href='<?php echo $surat; ?>/<?php echo $s['url_file']; ?>' target='_blank'><i class='fa fa-file-pdf'></i> File</a></td>
						<td>
<?php
		if($folder['3']!='3') {
?>
							<a href='#' data-toggle='dropdown'><i class='fa fa-ellipsis-v'></i></a>
							<div class='dropdown-menu text-xs'>
								<a class='dropdown-item' href='/suratmasuk/edit/<?php echo $s['id']; ?>'>Edit</a>
								<a class='dropdown-item' href='/delete/suratmasuk/<?php echo $s['id']; ?>/<?php echo $folder['3']; ?>'>Hapus</a>
							</div>
<?php
		}
?>						</td>					

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
					<form role="form" enctype="multipart/form-data" method="post" action="/insert/suratmasuk">
						<div class="form-group">
							<input type="hidden" name="id_jenis" value="<?php echo $folder['3']; ?>">
							<p>
								<label>Asal<span class="text-danger"> *</span></label>
								<input name="asal" type="text" class="form-control" placeholder="Asal" required>
							</p>
							<p>
								<label>Perihal<span class="text-danger"> *</span></label>
								<input name="perihal" type="text" class="form-control" placeholder="Perihal" required>
							</p>
							<p>
								<label>Nomor<span class="text-danger"> *</span></label>
								<input name="nomor" type="text" class="form-control" placeholder="Nomor" required>
							</p>
							<p>
								<label>Tanggal Surat<span class="text-danger"> *</span></label>
								<input name="tgl" type="date" class="form-control" required>
							</p>
							<p>
								<label>Tanggal Diterima<span class="text-danger"> *</span></label>
								<input name="tgl_diterima" type="date" class="form-control" value="<?php echo $now_date; ?>" required>
							</p>
							<p>
								<label>Keterangan</label>
								<input name="keterangan" type="text" class="form-control">
							</p>
							<p>
								<label>File<span class="text-danger"> *</span></label>
								<input name="fupload" type="file" class="form-control" accept="pdf" required>
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
	
