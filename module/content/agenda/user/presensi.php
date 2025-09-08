<?php
declare(strict_types=1);

	$qp = mysqli_query($con,"SELECT * FROM kegiatan WHERE id='$folder[3]' ");
	$p = mysqli_fetch_array($qp);
?>

	<div class='card card-primary'>
		<div class='card-header with-border'>
			<h3 class='card-title'><a href='/agenda/jenis/<?=$p['id_kegiatan'];?>'><i class='fa fa-arrow-left'></i> </a><?php echo $p['tgl_mulai']; ?>: <?php echo $p['nama']; ?></h3>
		</div>
		<div class="card-body">
			<form method="POST" enctype="multipart/form-data" action="/insert/presensikegiatan">
				<input type="hidden" name="id" value="<?=$p['id'];?>">
				<input type="hidden" name="id_kegiatan" value="<?=$p['id_kegiatan'];?>">

				<table class='table table-bordered'>
				<tr>
					<th>No</th>
					<th>NIK</th>
					<th>Nama</th>
					<th>Hadir</th>
					<th>Dispensasi</th>
					<th>Alfa</th>
				</tr>
<?php
	$no=1;
	$q = mysqli_query($con2,"SELECT nik,name_glr FROM dosen WHERE status='A' AND ikatan='A' ");
	while ($r=mysqli_fetch_array($q)) {

		$cek = mysqli_fetch_array(mysqli_query($con,"SELECT presensi FROM presensi WHERE id_kegiatan='$p[id]' AND nik='$r[nik]' "));

		if($cek['presensi']=='1') {
			$selected_1 = 'checked';
			$selected_2 = '';
			$selected_3 = '';
			$bg_1 = 'bg-success';
			$bg_2 = '';
			$bg_3 = '';
		}
		elseif($cek['presensi']=='2') {
			$selected_1 = '';
			$selected_2 = 'checked';
			$selected_3 = '';
			$bg_1 = '';
			$bg_2 = 'bg-warning';
			$bg_3 = '';
		}
		elseif($cek['presensi']=='3') {
			$selected_1 = '';
			$selected_2 = '';
			$selected_3 = 'checked';
			$bg_1 = '';
			$bg_2 = '';
			$bg_3 = 'bg-danger';
		}
		else {
			$selected_1 = '';
			$selected_2 = '';
			$selected_3 = '';
			$bg_1 = '';
			$bg_2 = '';
			$bg_3 = '';
		}
			
		
?>				
				<tr>
					<td><?=$no;?></td>
					<td><?=$r['nik'];?></td>
					<td><?=$r['name_glr'];?></td>
					<td class='<?=$bg_1;?>'>
						<input type='radio' value='1' name='<?=$r['nik'];?>' <?=$selected_1;?>> Hadir
					</td>
					<td class='<?=$bg_2;?>'>
						<input type='radio' value='2' name='<?=$r['nik'];?>' <?=$selected_2;?>> Dispensasi
					</td>
					<td class='<?=$bg_3;?>'>
						<input type='radio' value='3' name='<?=$r['nik'];?>' <?=$selected_3;?>> Alfa
					</td>
				</tr>
<?php
	$no++;
	}
?>			
				</table>				

				<p>
				<input type="submit" value="Simpan" class="btn btn-sm btn-success">
				</p>
				
			</form>
				
		</div>
	</div>