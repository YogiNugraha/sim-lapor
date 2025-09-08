<div class="row">
  <div class="col-md-3">
  	<div class="card rounded-0">
  		<div class="card-header">
  			<h3 class="card-title">Dikeluarkan</h3>
  		</div>
  		<div class="card-body">
        <div class="row">
<?php
	$qp = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='tgs' ");
	while($p = mysqli_fetch_array($qp)) {
		$jsk = mysqli_num_rows(mysqli_query($con,"SELECT id FROM tgs WHERE id_jenis='$p[value]' AND asal='$_SESSION[ses_user]' "));
?>

          <div class="col-md-12">
            <div class="small-box bg-info">
              <div class="inner bg-white">
                <h3><?php echo $jsk; ?></h3>
                <p><?php echo $p['desc']; ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-book"></i>
              </div>
              <a href="/tgs/jenis/<?php echo $p['value']; ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

<?php
	}
?>
	</div>
		</div>
	</div>
  </div>
  <div class="col-md-9">
  	<div class="card rounded-0">
  		<div class="card-header">
  			<h3 class="card-title">Diterima</h3>
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
	$qsk = mysqli_query($con,"SELECT * FROM tgs WHERE tembusan_struktural LIKE '%$_SESSION[ses_user]%' ORDER BY date DESC ");
	while($sk=mysqli_fetch_array($qsk)) {
		$qp = mysqli_query($con,"SELECT `desc` FROM kode WHERE kelompok='tgs' AND value='$sk[id_jenis]' ");
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
  </div>
</div>