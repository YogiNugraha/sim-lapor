<?php
declare(strict_types=1);

//	header("Content-type: application/msword");
 	//header("Content-disposition: attachment; filename=AgendaKerja.doc");
?>
<style>
  table,tr,td,th {
	border: 1px solid black;
	border-collapse: collapse;
	padding: 5px;
  }
  th {
  	background-color: #ccc ;
  }
  h3 {
  	text-align: center;
  	font-size: 12pt;
  	margin:2px;
  }
  .tengah {
  	text-align: center;
  }
</style>
<p>
<h3>AGENDA KERJA</h3>
<h3>UNIT ..........................</h3>
<h3>UNIVERSITAS MUHAMMADIYAH KUNINGAN</h3>
<h3>TAHUN 2025</h3>
</p>


				<table class='table table-striped'>
<?php
						echo"
							<tr class='table-primary'>
								<th>No</th>
								<th>Indikator Kinerja</th>
								<th>Bentuk Kegiatan</th>
						";
						$jumlah = 1;
						while($jumlah<=25) {
						echo"
								<th>|</th>
						";
						$jumlah++;
						}
						echo"
							</tr>
						";
						$no = 1;
						$qi = mysqli_query($con,"SELECT indikator.nama,proker.* FROM proker,indikator WHERE proker.id_indikator=indikator.id AND indikator.unit='$_SESSION[ses_user]' ORDER BY indikator.jenis,indikator.id,proker.id ");
						while($i=mysqli_fetch_array($qi)) {
						echo"
							<tr class='text-xs'>
								<td>$no</td>
								<td>$i[nama]</td>
								<td>$i[bentuk]</td>
						";
						$jumlah = 1;
						while($jumlah<=25) {
						echo"
								<td>|</td>
						";
						$jumlah++;
						}
						echo"
							</tr>
						";
						$no++;
						}
?>
				</table>