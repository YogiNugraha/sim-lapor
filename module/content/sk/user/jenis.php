<?php
declare(strict_types=1);


?>

	<div class='card'>
		<div class='card-header with-border'>
			<h3 class='card-title'>Surat Keputusan</h3>
		</div>
		<div class="card-body">
			<div class='table-responsive'>
				<table class='table table-striped' id='custom'>
					<thead>
					<tr class='bg-info'>
						<th>Jenis</th>
						<th>Tentang</th>
						<th>Nomor</th>
						<th>Tanggal SK</th>
						<th>File</th>
					</tr>
					</thead>
					<tbody class='text-sm'>
<?php
	$qsk = mysqli_query($con,"SELECT * FROM sk WHERE tembusan_struktural LIKE '%$_SESSION[ses_user]%' ORDER BY date DESC ");
	while($sk=mysqli_fetch_array($qsk)) {
		$qp = mysqli_query($con,"SELECT `desc` FROM kode WHERE kelompok='sk' AND value='$sk[id_jenis]' ");
		$p = mysqli_fetch_array($qp);
?>
					<tr>
						<td><?php echo $p['desc']; ?></td>
						<td><?php echo $sk['judul']; ?></td>
						<td><?php echo $sk['nomor']; ?></td>
						<td><?php echo $sk['tgl_sk']; ?></td>
						<td><a href='<?php echo $surat; ?>/<?php echo $sk['url_file']; ?>' target='_blank'><i class='fa fa-file-pdf'></i> File</a></td>

					</tr>
<?php
	}
?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	
