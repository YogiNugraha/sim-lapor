<div class='row'>
  <div class='col-md-6'>
	<div class='card'>
		<div class='card-header with-border'>
			<h3 class='card-title'>Disposisi Eksternal</h3>
		</div>
		<div class="card-body">
			<div class='table-responsive'>
				<table class='table table-striped' id='custom'>
					<thead>
					<tr class='bg-info'>
						<th>Tanggal</th>
						<th>Asal</th>
						<th>Perihal</th>
						<th>File</th>
						<th>Disposisi</th>
					</tr>
					</thead>
					<tbody class='text-sm'>
<?php
	$qs = mysqli_query($con,"SELECT * FROM suratmasuk WHERE tembusan_struktural LIKE '%$_SESSION[ses_user]%' ORDER BY tgl DESC ");
	while($s=mysqli_fetch_array($qs)) {
		$asal = $s['asal'];
		
		$urgensi = mysqli_fetch_array(mysqli_query($con,"SELECT `value`,`desc` FROM kode WHERE value='$s[id_urgensi]' AND kelompok='urgensi' "));
		switch($urgensi['value']) {
			case '1': $status_urgensi = "<span class='bg-danger'>Penting</span>"; break;
			case '2': $status_urgensi = "<span class='bg-warning'>Segera</span>"; break;
			case '3': $status_urgensi = "<span class='bg-success'>Biasa</span>"; break;
		}
		$perintah = mysqli_fetch_array(mysqli_query($con,"SELECT `desc` FROM kode WHERE value='$s[id_perintah]' AND kelompok='perintahdisposisi' "));
?>
					<tr>
						<td>
							<p><?php echo $s['tgl']; ?></p>
							<p><?php echo $s['nomor']; ?></p>
						</td>
						<td><?php echo $asal; ?></td>
						<td>
							<p><?php echo $s['perihal']; ?></p>
							<p>Ket:<?php echo $s['keterangan']; ?></p>
						</td>
						<td><a href='<?php echo $surat; ?>/<?php echo $s['url_file']; ?>' target='_blank'><i class='fa fa-file-pdf'></i> File</a></td>
						<td>
						<p><?php echo $status_urgensi; ?></p>
						<p><?php echo $perintah['desc']; ?></p>
						<p><?php echo $s['catatan']; ?></p>
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

  </div>
  <div class='col-md-6'>
	<div class='card'>
		<div class='card-header with-border'>
			<h3 class='card-title'>Disposisi Internal</h3>
		</div>
		<div class="card-body">
			<div class='table-responsive'>
				<table class='table table-striped' id='custom'>
					<thead>
					<tr class='bg-info'>
						<th>Tanggal</th>
						<th>Asal</th>
						<th>Perihal</th>
						<th>File</th>
						<th>Disposisi</th>
					</tr>
					</thead>
					<tbody class='text-sm'>
<?php
	$qs2 = mysqli_query($con,"SELECT * FROM suratkeluar WHERE disposisi_struktural LIKE '%$_SESSION[ses_user]%' ORDER BY tgl DESC ");
	while($s2=mysqli_fetch_array($qs2)) {
		$qasal2 = mysqli_fetch_array(mysqli_query($con,"SELECT nama_unit_singkat FROM level WHERE user='$s2[asal]' "));
		$asal2 = $qasal2['nama_unit_singkat'];
		
		$urgensi2 = mysqli_fetch_array(mysqli_query($con,"SELECT `value`,`desc` FROM kode WHERE value='$s2[id_urgensi]' AND kelompok='urgensi' "));
		switch($urgensi2['value']) {
			case '1': $status_urgensi2 = "<span class='bg-danger'>Penting</span>"; break;
			case '2': $status_urgensi2 = "<span class='bg-warning'>Segera</span>"; break;
			case '3': $status_urgensi2 = "<span class='bg-success'>Biasa</span>"; break;
		}
		$perintah2 = mysqli_fetch_array(mysqli_query($con,"SELECT `desc` FROM kode WHERE value='$s2[id_perintah]' AND kelompok='perintahdisposisi' "));
?>
					<tr>
						<td>
							<p><?php echo $s2['tgl']; ?></p>
							<p><?php echo $s2['nomor']; ?></p>
						</td>
						<td><?php echo $asal2; ?></td>
						<td>
							<p><?php echo $s2['perihal']; ?></p>
							<p>Ket:<?php echo $s2['keterangan']; ?></p>
						</td>
						<td><a href='<?php echo $surat; ?>/<?php echo $s2['url_file']; ?>' target='_blank'><i class='fa fa-file-pdf'></i> File</a></td>
						<td>
						<p><?php echo $status_urgensi2; ?></p>
						<p><?php echo $perintah2['desc']; ?></p>
						<p><?php echo $s2['catatan']; ?></p>
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
	

  </div>
</div>
