<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Sistem Informasi Manajemen| Universitas Muhammadiyah Kuningan</title>
	<meta name="description" content="Sistem untuk inventarisasi bukti fisik dan digital akreditasi" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="/dist/css/adminlte.min.css">
	<link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<link rel="icon" href="/dist/img/logo_univ.png" type="image/png">
	<link href="/plugins/datatables-bs4/css/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
	<link href='/plugins/icheck-bootstrap/icheck-bootstrap.css' rel='stylesheet' type='text/css' />

	<link rel="manifest" href="/manifest.json">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="application-name" content="SIMASTER">
	<meta name="apple-mobile-web-app-title" content="SIMASTER">
	<meta name="msapplication-starturl" content="/">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="image/png" sizes="48x48" href="/dist/img/logo_univ.png">
	<link rel="apple-touch-icon" type="image/png" sizes="48x48" href="/file/img/simaster48.png">
	<link rel="icon" type="image/png" sizes="192x192" href="/file/img/simaster192.png">
	<link rel="apple-touch-icon" type="image/png" sizes="192x192" href="/dist/img/logo_univ.png">
	<link rel="icon" type="image/png" sizes="512x512" href="/file/img/simaster512.png">
	<link rel="apple-touch-icon" type="image/png" sizes="512x512" href="/dist/img/logo_univ.png">


</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">

	<script src="/plugins/jquery/jquery.min.js"></script>
	<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="/dist/js/adminlte.min.js"></script>
	<script src="/dist/js/demo.js"></script>

	<div class="wrapper">

		<nav class="main-header navbar navbar-expand navbar-navy navbar-dark">
			<?php
			include "module/view/top.php";
			?>
		</nav>


		<aside class="main-sidebar sidebar-light-primary elevation-4">
			<?php
			include "module/view/sidebar.php";
			?>
		</aside>

		<script src="/dist/js/app.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="/dist/js/suggest.js"></script>

		<script src="/plugins/datatables/jquery.dataTables.js"></script>
		<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

		<script src="/plugins/icheck-bootstrap/icheck-bootstrap.min.js" type="text/javascript"></script>

		<script type="text/javascript">
			$(function() {
				$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
					checkboxClass: 'icheckbox_minimal-blue',
					radioClass: 'iradio_minimal-blue'
				});
				//Red color scheme for iCheck
				$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
					checkboxClass: 'icheckbox_minimal-red',
					radioClass: 'iradio_minimal-red'
				});
				//Flat red color scheme for iCheck
				$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
					checkboxClass: 'icheckbox_flat-green',
					radioClass: 'iradio_flat-green'
				});
			});
		</script>
		<script type="text/javascript">
			$(function() {
				$("#example1").dataTable();
				$('#example2').dataTable({
					"bPaginate": true,
					"bLengthChange": false,
					"bFilter": false,
					"bSort": true,
					"bInfo": true,
					"bAutoWidth": false
				});
				$('#custom').dataTable({
					"bPaginate": true,
					"bLengthChange": true,
					"bFilter": true,
					"bSort": true,
					"bInfo": false,
					"pageLength": 50,
					"bAutoWidth": false
				});
			});
		</script>

		<div class="content-wrapper">
			<?php
			include "module/view/content.php";
			?>
		</div>


		<footer class="main-footer">
			<?php
			include "module/view/foot.php";
			?>
		</footer>

	</div>


</body>

</html>