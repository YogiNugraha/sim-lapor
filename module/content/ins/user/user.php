<?php
declare(strict_types=1);
 

ob_start();	

	if (empty($_SESSION['ses_user']) AND empty($_SESSION['ses_pass']) AND empty($_SESSION['ses_level']) ){
		header('Location: /login');
	exit;
	}
	else {
?>
	<link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
	<link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
	
	<div class='card card-success'>
		<div class='card-body'>
			<select onchange="window.document.location.href=this.options[this.selectedIndex].value;" class='form-control' name='ta'>
			<option value='#'>-- Pilih Jenis--</option>
		<?php

		$qp = mysqli_query($con,"SELECT * FROM kode WHERE kelompok='ins' ");
		while($p = mysqli_fetch_array($qp)) {
		if($p['value']==$folder['3']) { $selected = 'selected'; } else {$selected = '';}
			echo "
				<option value='/ins/jenis/$p[value]' $selected>$p[desc]</option>
			";
		}
		?>
	
			</select>
		</div>
	</div>
<?php
	switch($folder['2']) {

		default:
			include "default.php";
		break;
		
		case 'jenis':
			include "jenis.php";
		break;

		case 'edit':
			include "edit.php";
		break;
	}
}
?>

	<script src="/plugins/select2/js/select2.full.min.js"></script>
	
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
    
  })
</script>