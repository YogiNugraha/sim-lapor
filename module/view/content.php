    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

          </div>
          <div class="col-sm-6">
          </div>
        </div>
      </div>
    </section>



        <section class="content">

	<?php

		if(!empty($_GET['m'])) {
			if($_GET['m']=='updated') {
			?>

				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					   <h4><i class="icon fa fa-check"></i> Pesan!</h4>
					   Perubahan berhasil disimpan.
				</div>
		<?php 
			}
			elseif($_GET['m']=='not_updated') {
		?>

				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-ban"></i> Pesan!</h4>
					Perubahan gagal disimpan
				</div>
		<?php 
			}
			if($_GET['m']=='inserted') {
			?>

				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					   <h4><i class="icon fa fa-check"></i> Pesan!</h4>
					   Data berhasil disimpan
				</div>
		<?php 
			}
			elseif($_GET['m']=='not_inserted') {
		?>

				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-ban"></i> Pesan!</h4>
					Data gagal disimpan
				</div>
		<?php 
			}
			elseif($_GET['m']=='not_inserted_edom') {
		?>

				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-ban"></i> Pesan!</h4>
					Harap isi komentar secara serius, tidak asal-asalan!
				</div>
		<?php 
			}
			if($_GET['m']=='deleted') {
			?>

				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					   <h4><i class="icon fa fa-check"></i> Pesan!</h4>
					   Data berhasil dihapus
				</div>
		<?php 
			}
			elseif($_GET['m']=='not_deleted') {
		?>

				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-ban"></i> Pesan!</h4>
					Data gagal dihapus
 				</div>
		<?php 
			}
			elseif($_GET['m']=='password') {
		?>

				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-ban"></i> Pesan!</h4>
					Mohon maaf, untuk keamanan penggunaan SIAmik, mohon ganti password dengan yang lebih rumit.
				</div>
		<?php 
			}
		}
		?>


			<?php

				switch($_SESSION['ses_level']) {
				

					
					default :

						if ($module=='dashboard'){
							include "module/content/kinerja/user.php";
						}
						if ($module=='pantaukinerja'){
							include "module/content/pantaukinerja/pimpinan.php";
						}
						elseif ($module=='account'){
							include "module/content/account/user.php";
						}
						elseif ($module=='kinerja'){
							include "module/content/kinerja/user.php";
						}
						elseif ($module=='proker'){
							include "module/content/proker/user.php";
						}
						elseif ($module=='catatan'){
							include "module/content/catatan/user.php";
						}
						elseif ($module=='lapor'){
							include "module/content/lapor/user.php";
						}
						elseif ($module=='kerjasama'){
							include "module/content/kerjasama/user/user.php";
						}
						elseif ($module=='sk'){
							include "module/content/sk/user/user.php";
						}
						elseif ($module=='tgs'){
							include "module/content/tgs/user/user.php";
						}
						elseif ($module=='ins'){
							include "module/content/ins/user/user.php";
						}
						elseif ($module=='edr'){
							include "module/content/edr/user/user.php";
						}
						elseif ($module=='mlm'){
							include "module/content/mlm/user/user.php";
						}
						elseif ($module=='ket'){
							include "module/content/ket/user/user.php";
						}
						elseif ($module=='per'){
							include "module/content/per/user/user.php";
						}
						elseif ($module=='rek'){
							include "module/content/rek/user/user.php";
						}
						elseif ($module=='sop'){
							include "module/content/sop/user/user.php";
						}
						elseif ($module=='suratmasuk'){
							include "module/content/suratmasuk/user/user.php";
						}
						elseif ($module=='suratkeluar'){
							include "module/content/suratkeluar/user/user.php";
						}
						elseif ($module=='disposisi'){
							include "module/content/disposisi/user/user.php";
						}
						elseif ($module=='agenda'){
							include "module/content/agenda/user/user.php";
						}
						elseif ($module=='insert'){
							include "module/content/insert/user.php";
						}
						elseif ($module=='update'){
							include "module/content/update/user.php";
						}
						elseif ($module=='delete'){
							include "module/content/delete/user.php";
						}
						else {
							include "module/content/error/404.php";
						}
					break;

				}
			?>


        </section>