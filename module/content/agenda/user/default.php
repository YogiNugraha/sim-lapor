        <div class="row">
<?php
	$qp = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='agenda' ");
	while($p = mysqli_fetch_array($qp)) {
		$jsk = mysqli_num_rows(mysqli_query($con,"SELECT id FROM kegiatan WHERE id_kegiatan='$p[value]' "));
?>

          <div class="col-md-3 col-6">
            <div class="small-box bg-info">
              <div class="inner bg-white">
                <h3><?php echo $jsk; ?></h3>
                <p>
                <?php echo "[$p[value]] $p[desc]"; ?>
                <?php if($p['keterangan']=='DP3') { echo "<span class='text-danger'>*</span>"; } ?>
                </p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-book"></i>
              </div>
              <a href="/agenda/jenis/<?php echo $p['value']; ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
<?php
	}
?>
          
        </div>