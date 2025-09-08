<?php
declare(strict_types=1);

	$qsk = mysqli_query($con,"SELECT * FROM sk WHERE id='$folder[3]'");
	$sk=mysqli_fetch_array($qsk);
?>
	<div class='card card-primary'>
		<div class='card-header with-border'>
			<h3 class='card-title'>Edit: SK Panitia Perubahan Status Universitas</h3>
		</div>

				<div class="card-body">
					<form role="form" enctype="multipart/form-data" method="post" action="/update/sk">
						<div class="form-group">
							<input type="hidden" name="id" value="<?php echo $sk['id']; ?>">
							<p>
								<label>Jenis<span class="text-danger"> *</span></label>
								<select class='form-control' name='id_jenis' required>
									<option value=''>-- Pilih Jenis--</option>
										<?php
										$qp = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='sk' ");
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
								<label>Judul<span class="text-danger"> *</span></label>
								<input name="judul" type="text" class="form-control" value="<?php echo $sk['judul']; ?>" required>
							</p>
							<p>
								<label>Nomor<span class="text-danger"> *</span></label>
								<input name="nomor" type="text" class="form-control" value="<?php echo $sk['nomor']; ?>" required>
							</p>
							<p>
								<label>Tanggal SK<span class="text-danger"> *</span></label>
								<input name="tgl_sk" type="date" class="form-control" value="<?php echo $sk['tgl_sk']; ?>" required>
							</p>
							<p>
								<label>
								File<span class="text-xs"> kosongkan jika tidak diganti</span>
								<a href='/<?php echo $sk['url_file']; ?>' target='_blank'><i class='fa fa-file-pdf'></i> File</a>
								</label>
								<input name="fupload" type="file" class="form-control" accept="pdf">
							</p>
							<p class="text-center"><b>Tembusan</b></p>
							<hr>
							<div class="row">
								<div class="col-md-12">
									<p>
										<label>Struktural</label>
										<select class='select2bs4 select2-primary' multiple='multiple' name='tembusan_struktural[]'>
											<option value=''>-- Pilih Struktural--</option>
												<?php
												$qs = mysqli_query($con,"SELECT * FROM level ");
												while($s = mysqli_fetch_array($qs)) {
													$cek_sk_struktural=mysqli_num_rows(mysqli_query($con,"SELECT * FROM sk WHERE id='$sk[id]' AND tembusan_struktural LIKE '%$s[user]%' "));
													if($cek_sk_struktural>0) { $selected = 'selected'; } else {$selected = '';}
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
												$qd = mysqli_query($con2,"SELECT * FROM dosen WHERE status='A' AND nik!='' ORDER BY ikatan,name ");
												while($d = mysqli_fetch_array($qd)) {
													$cek_sk_dosen=mysqli_num_rows(mysqli_query($con,"SELECT * FROM sk WHERE id='$sk[id]' AND tembusan_dosen LIKE '%$d[nik]%' "));
													if($cek_sk_dosen>0) { $selected = 'selected'; } else {$selected = '';}
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
													$cek_sk_kry=mysqli_num_rows(mysqli_query($con,"SELECT * FROM sk WHERE id='$sk[id]' AND tembusan_karyawan LIKE '%$k[nik]%' "));
													if($cek_sk_kry>0) { $selected = 'selected'; } else {$selected = '';}
													echo "
														<option value='$k[nik]' $selected>$k[name]</option>
													";
												}
												?>
										</select>
									</p>
								</div>
							</div>
							
						</div>
				</div>
				<div class="card-footer justify-content-between">
					<input type="submit" class="btn btn-primary" value="Ubah">
				</div>
				</form>

	</div>