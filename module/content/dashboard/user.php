<?php
declare(strict_types=1);
 

ob_start();	

	if (empty($_SESSION['ses_user']) AND empty($_SESSION['ses_pass']) AND empty($_SESSION['ses_level']) ){
		header('Location: /login');
	exit;
	}
	else {

	?>
		
        <div class="row">

        </div>
        

        <div class="row">
          <div class="col-12 col-md-12">
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Rekap per Kriteria</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Rekap per Indikator</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                    <div class="row">
			<?php
			
				$bg = array("info","primary","secondary","info","primary","secondary","info","primary","secondary");
			
				$qc = mysqli_query($con,"SELECT * FROM kriteria ORDER BY id");
				while($c=mysqli_fetch_array($qc)) {
					$berkas = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(*) AS j FROM berkas,poin,subkriteria WHERE berkas.trash='0' AND berkas.id_poin=poin.id AND poin.id_subkriteria=subkriteria.id AND subkriteria.id_kriteria='$c[id]' "));
				shuffle($bg);
				$sbg = array_shift($bg);
			
			?>
			          <div class="col-md-4 col-6">
			            <div class="small-box bg-<?php echo $sbg; ?>">
			              <div class="inner">
			                <h3><?php echo $berkas['j'];?> Berkas</h3>
			                <p><h5><?php echo $c['kode'];?> <?php echo $c['kriteria']; ?></h5></p>
			              </div>
			              <div class="icon">
			                <i class="ion ion-ios-book"></i>
			              </div>
			<!--              <a href="/kontrak" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a> !-->
			            </div>
			          </div>
			<?php
				}
			?>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                  	<table class='table'>
				<?php
					$qk = mysqli_query($con,"SELECT * FROM kriteria ORDER BY id");
					while($k=mysqli_fetch_array($qk)) {
						echo"
						<tr>
							<td class='table-primary'><b>Jumlah Berkas</b></td>
							<td colspan='2' class='table-primary'><b>$k[kriteria]</b></td>
						</tr>
						";
				?>
						<?php
							$qsc = mysqli_query($con,"SELECT kriteria.kriteria,subkriteria.kode,subkriteria.subkriteria,poin.poin,poin.id AS id_poin FROM kriteria,subkriteria,poin WHERE kriteria.id=subkriteria.id_kriteria AND subkriteria.id=poin.id_subkriteria AND kriteria.id='$k[id]' ORDER BY kriteria.id,subkriteria.id,poin.id");
							while($sc=mysqli_fetch_array($qsc)) {
								$sberkas = mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(*) AS j FROM berkas WHERE berkas.trash='0' AND berkas.id_poin='$sc[id_poin]' "));
								shuffle($bg);
								$sbg = array_shift($bg);
						
						?>
								<tr>
									<td><?php echo $sberkas['j']; ?></td>
									<td><?php echo $sc['kode']; ?> <?php echo $sc['subkriteria']; ?></td>
									<td><?php echo $sc['poin']; ?></td>
								</tr>
						<?php
								$sc['kode'] = '';
							}
					}
						?>
			</table>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">

                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
        
	
	<?php
	}
?>