<?php
declare(strict_types=1);

	$qp = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='jenis_mitra' AND value='$folder[3]' ");
	$p = mysqli_fetch_array($qp);
?>

	<div class='card card-primary'>
		<div class='card-header with-border'>
			<h3 class='card-title'><?php echo $p['desc']; ?></h3>

		</div>
		<div class="card-body">
			<div class='table-responsive'>
				<table class='table table-striped' id='custom'>
					<thead>
					<tr class='bg-info'>
						<th>Level</th>
						<th>Mitra</th>
						<th>Bidang</th>
						<th>Ruang Lingkup</th>
						<th>Waktu</th>
						<th>Nomor</th>
						<th>File</th>

					</tr>
					</thead>
					<tbody class='text-sm'>
<?php
	$qks = mysqli_query($con,"SELECT * FROM kerjasama WHERE id_jenis='$folder[3]' ORDER BY date DESC ");
	while($ks=mysqli_fetch_array($qks)) {
		$level = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='level' AND value='$ks[id_level]' "));
		$dharma = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM kode WHERE kelompok='dharma' AND value='$ks[id_dharma]' "));
?>
					<tr>
						<td><?php echo $level['desc']; ?></td>
						<td><?php echo $ks['nama_mitra']; ?></td>
						<td><?php echo $dharma['desc']; ?></td>
						<td><?php echo $ks['skup']; ?></td>
						<td><?php echo $ks['tanggal_mulai']; ?> s.d <?php echo $ks['tanggal_selesai']; ?></td>
						<td><?php echo $ks['nomor']; ?></td>
						<td><a href='<?php echo $surat; ?>/<?php echo $ks['url_file']; ?>' target='_blank'><i class='fa fa-file-pdf'></i> File</a></td>
				
					</tr>
<?php
	}
?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	