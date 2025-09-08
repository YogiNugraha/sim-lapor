<?php
declare(strict_types=1);

	$qsk = mysqli_query($con,"SELECT * FROM suratmasuk WHERE id='$folder[3]'");
	$sk=mysqli_fetch_array($qsk);
?>
	<div class='card card-primary'>
		<div class='card-header with-border'>
			<h3 class='card-title'>Edit: <?php echo $sk['perihal']; ?></h3>
		</div>

				<div class="card-body">
					<form role="form" enctype="multipart/form-data" method="post" action="/update/suratmasuk">
						<div class="form-group">
							<input type="hidden" name="id" value="<?php echo $sk['id']; ?>">
							<p>
								<label>Jenis<span class="text-danger"> *</span></label>
								<select class='form-control' name='id_jenis' required>
									<option value=''>-- Pilih Jenis--</option>
										<?php
										$qp = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='suratmasuk' ");
										while($p = mysqli_fetch_array($qp)) {
										if($p['value']==$sk['id_jenis']) { $selected = 'selected'; } else {$selected = '';}
											echo "
												<option value='$p[value]' $selected>$p[desc]</option>
											";
										}
										?>
								</select>
							</p>
							<p>
								<label>Asal<span class="text-danger"> *</span></label>
								<input name="asal" type="text" class="form-control" placeholder="Asal" value="<?php echo $sk['asal']; ?>" required>
							</p>

							<p>
								<label>Perihal<span class="text-danger"> *</span></label>
								<input name="perihal" type="text" class="form-control" value="<?php echo $sk['perihal']; ?>" required>
							</p>
							<p>
								<label>Nomor<span class="text-danger"> *</span></label>
								<input name="nomor" type="text" class="form-control" value="<?php echo $sk['nomor']; ?>" required>
							</p>
							<p>
								<label>Tanggal Surat<span class="text-danger"> *</span></label>
								<input name="tgl" type="date" class="form-control" value="<?php echo $sk['tgl']; ?>" required>
							</p>
							<p>
								<label>Tanggal Diterima<span class="text-danger"> *</span></label>
								<input name="tgl_diterima" type="date" class="form-control" value="<?php echo $sk['tgl_diterima']; ?>" required>
							</p>
							<p>
								<label>Keterangan</label>
								<input name="keterangan" type="text" class="form-control" value="<?php echo $sk['keterangan']; ?>">
							</p>

							<p>
								<label>
								File<span class="text-xs"> kosongkan jika tidak diganti</span>
								<a href='<?php echo $surat; ?>/<?php echo $sk['url_file']; ?>' target='_blank'><i class='fa fa-file-pdf'></i> File</a>
								</label>
								<input name="fupload" type="file" class="form-control" accept="pdf">
							</p>

						</div>
				</div>
				<div class="card-footer justify-content-between">
					<input type="submit" class="btn btn-primary" value="Ubah">
				</div>
				</form>

	</div>