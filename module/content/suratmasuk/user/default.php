        <div class="row">
<?php
	$qp = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='suratmasuk' ");
	while($p = mysqli_fetch_array($qp)) {
		if($p['value']=='3') {
			$jsk = mysqli_num_rows(mysqli_query($con,"SELECT * FROM suratkeluar WHERE tembusan_struktural LIKE '%$_SESSION[ses_user]%' "));
		}
		else {
			$jsk = mysqli_num_rows(mysqli_query($con,"SELECT id FROM suratmasuk WHERE id_jenis='$p[value]' AND tujuan='$_SESSION[ses_user]' "));
		}
?>

          <div class="col-md-3 col-6">
            <div class="small-box bg-info">
              <div class="inner bg-white">
                <h3><?php echo $jsk; ?></h3>
                <p>Dari: <?php echo $p['desc']; ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-book"></i>
              </div>
              <a href="/suratmasuk/jenis/<?php echo $p['value']; ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
<?php
	}
?>
          
        </div>

