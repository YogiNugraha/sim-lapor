        <div class="row">
	<?php
		$ql = mysqli_query($con,"SELECT COUNT(*) AS j,kode.desc FROM kerjasama,kode WHERE kerjasama.id_level=kode.value AND kode.kelompok='level' GROUP BY kerjasama.id_level");
		while($l = mysqli_fetch_array($ql)) {
	?>
	
          <div class="col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?=$l['desc'];?></span>
                <span class="info-box-number"><?=$l['j'];?></span>
              </div>
            </div>
          </div>
	<?php
		}
	?>
	</div>

        <div class="row">
<?php
	$qp = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='jenis_mitra' ");
	while($p = mysqli_fetch_array($qp)) {
		$jsk = mysqli_num_rows(mysqli_query($con,"SELECT id FROM kerjasama WHERE id_jenis='$p[value]' "));
?>

          <div class="col-md-3 col-6">
            <div class="small-box bg-info">
              <div class="inner bg-white">
                <h3><?php echo $jsk; ?></h3>
                <p><?php echo $p['desc']; ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-book"></i>
              </div>
              <a href="/kerjasama/jenis/<?php echo $p['value']; ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
<?php
	}
?>
    
          
        </div>

