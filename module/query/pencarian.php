<?php
declare(strict_types=1);


session_start();



if (empty($_SESSION['ses_user']) AND empty($_SESSION['ses_pass']) AND empty($_SESSION['ses_level']) ){

	header('Location: ../login--');
	exit;

}



else {

	echo"<p id='searchresults'>";

	

	define('valid','1');

	include '../../config/db.php';

	

	if(isset($_POST['queryString'])) {

		$queryString = mysqli_real_escape_string($con,$_POST['queryString']);

			

		if(strlen($queryString) > 0) {

			$query = mysqli_query($con,"SELECT u.username,u.name,l.keterangan FROM user AS u,level AS l WHERE u.level=l.level AND u.active='1' AND u.name LIKE '%" . $queryString . "%' ORDER BY u.name");

			

			if(mysqli_num_rows($query)>0) {

				echo "<ul class='products-list product-list-in-box'>";



				while($row = mysqli_fetch_array($query,MYSQLI_BOTH)) {



			

					$foto_com=mysqli_fetch_array(mysqli_query($con," SELECT file.file FROM file WHERE file.type='foto' AND file.active='Y' AND file.user='$row[username]' LIMIT 1 "),MYSQLI_BOTH);

					

					if($foto_com=='') { $tumb = 'file/foto/default.png'; } else { $tumb = 'file/foto/50_'.$foto_com['file']; }

					

					echo '

						<li class="item">

						<div class="product-img">						

						<img src="/'.$tumb.'" alt="" />

						</div>

					';



					$nama = $row['name'];

	         		

					if(strlen($nama) > 20) { 

	         			$nama = substr($nama, 0, 15) . "..";

	         		}

	         		

					echo '

						<div class="product-info">

							<a href="/user/'.$row['username'].'" class="product-title">'.$nama.'</a>

	                        <span class="product-description">

								'.$row['keterangan'].'

			                </span>

						</div>

						</li>

					';

				}

				echo "</ul>";

			} 

			else {

					echo 'Tidak ditemukan Civictas Akademika';

			}

		} 



	} 



	echo"</p>";

}



?>