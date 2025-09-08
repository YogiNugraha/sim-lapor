<?php
declare(strict_types=1);

	$qp = mysqli_query($con,"SELECT * FROM kegiatan WHERE id='$folder[3]' ");
	$p = mysqli_fetch_array($qp);
?>

	<div class='card card-primary'>
		<div class='card-header with-border'>
			<h3 class='card-title'><?php echo $p['tgl_mulai']; ?>: <?php echo $p['nama']; ?></h3>
		</div>
		<div class="card-body">
			<form method="POST" enctype="multipart/form-data" action="/insert/filekegiatan">
				<input type="hidden" name="id" value="<?=$p['id'];?>">
				<input type="hidden" name="id_kegiatan" value="<?=$p['id_kegiatan'];?>">
				<p>
				<label>Jenis</label>
				<select class="form-control" name="id_jenis_file" required>
					<option value="">--Pilih--</option>
				<?php
					$qf = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='file' ");
					while($f=mysqli_fetch_array($qf)) {
					
					echo"<option value='$f[value]'>$f[desc]</option>";
					
					}
				?>
				</select>
				</p>

				<p>
				<label>Upload File</label>				
				<input type="file" class="form-control" name="fupload" required>
				</p>

				<p>
				<label>Khusus Link Berita/Vidio</label>
				<input type="url" class="form-control" name="berita">
				</p>

				<p>
				<input type="submit" value="Tambah" class="btn btn-sm btn-success">
				</p>
				
			</form>
				
		</div>
	</div>