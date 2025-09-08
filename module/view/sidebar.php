	          <a href="#" class="brand-link bg-navy">
	          	<img src="/dist/img/logo_univ_med.png" alt="Logo" class="brand-image opacity-75 shadow" />
	          	<span class="brand-text fw-bold text-light"><b>SIM</b></span>
	          </a>

	          <div class="sidebar">


	          	<div class="user-panel mt-3 pb-3 mb-3 d-flex">
	          		<div class="pull-left info">
	          			<a href="#" class="d-block">
	          				<?php echo $_SESSION['ses_name']; ?>
	          			</a>
	          		</div>
	          	</div>


	          	<nav class="mt-2">
	          		<ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-flat text-sm" data-widget="treeview" role="menu" data-accordion="false">

	          			<li class='nav-item'>
	          				<a href='/dashboard' class='nav-link'><i class='nav-icon fas fa-home'></i>
	          					<p>Dashboard</p><small class='label pull-right bg-red'></small>
	          				</a>
	          			</li>
	          			<li class='nav-item'>
	          				<a href='/logout' class='nav-link'><i class='nav-icon fas fa-sign-out-alt'></i>
	          					<p>Logout</p><small class='label pull-right bg-red'></small>
	          				</a>
	          			</li>


	          			<li class="nav-header">LAYANAN</li>


	          			<li class='nav-item has-treeview active menu-open'>
	          				<a class='nav-link' href='#'><i class='nav-icon fa fa-chart-line'></i>
	          					<p>Kinerja Tahunan</p>
	          					<i class='fas fa-angle-left right'></i>
	          				</a>
	          				<ul class='nav nav-treeview active'>
	          					<li class='nav-item'>
	          						<a href='/kinerja' class='nav-link'><i class='nav-icon fa fa-arrow-right'></i>
	          							<p>Kontrak Kinerja</p><small class='label pull-right bg-red'></small>
	          						</a>
	          					</li>
	          					<li class='nav-item'>
	          						<a href='/proker' class='nav-link'><i class='nav-icon fa fa-arrow-right'></i>
	          							<p>Program Kerja</p><small class='label pull-right bg-red'></small>
	          						</a>
	          					</li>
	          					<?php if ($_SESSION['ses_level'] == 'pimpinan') { ?>
	          						<li class='nav-item'>
	          							<a href='/pantaukinerja' class='nav-link'><i class='nav-icon fa fa-arrow-right'></i>
	          								<p>Monitoring Kinerja</p><small class='label pull-right bg-red'></small>
	          							</a>
	          						</li>
	          					<?php } ?>

	          					<!--
				<li class='nav-item'>
					<a href='/catatan' class='nav-link'><i class='nav-icon fa fa-arrow-right'></i> <p>Laporan Bulanan</p><small class='label pull-right bg-red'></small></a>
				</li>
!-->
	          					<li class='nav-item'>
	          						<a href='/kinerja/laporan/' class='nav-link'><i class='nav-icon fa fa-arrow-right'></i>
	          							<p>Laporan Kinerja</p><small class='label pull-right bg-red'></small>
	          						</a>
	          					</li>
	          				</ul>
	          			</li>

	          			<li class='nav-item has-treeview'>
	          				<a class='nav-link' href='#'><i class='nav-icon fa fa-file'></i>
	          					<p>Dokumen Formal</p>
	          					<i class='fas fa-angle-left right'></i>
	          				</a>
	          				<ul class='nav nav-treeview'>
	          					<li class='nav-item'>
	          						<a href='/kebijakan' class='nav-link'><i class='nav-icon fa fa-sticky-note'></i>
	          							<p>Kebijakan</p><small class='label pull-right bg-red'></small>
	          						</a>
	          					</li>
	          					<li class='nav-item'>
	          						<a href='/panduan' class='nav-link'><i class='nav-icon fa fa-sticky-note'></i>
	          							<p>Panduan</p><small class='label pull-right bg-red'></small>
	          						</a>
	          					</li>
	          					<li class='nav-item'>
	          						<a href='/sop' class='nav-link'><i class='nav-icon fa fa-sticky-note'></i>
	          							<p>SOP</p><small class='label pull-right bg-red'></small>
	          						</a>
	          					</li>
	          				</ul>
	          			</li>



	          			<li class='nav-item has-treeview'>
	          				<a class='nav-link' href='#'><i class='nav-icon fa fa-envelope'></i>
	          					<p>Administrasi</p>
	          					<i class='fas fa-angle-left right'></i>
	          				</a>
	          				<ul class='nav nav-treeview'>
	          					<li class='nav-item'>
	          						<a href='/disposisi' class='nav-link'><i class='nav-icon fa fa-reply-all'></i>
	          							<p>Disposisi</p>
	          						</a>
	          					</li>
	          					<li class='nav-item'>
	          						<a href='/suratmasuk' class='nav-link'><i class='nav-icon fa fa-envelope'></i>
	          							<p>Surat Masuk</p>
	          						</a>
	          					</li>
	          					<li class='nav-item'>
	          						<a href='/suratkeluar' class='nav-link'><i class='nav-icon fa fa-paper-plane'></i>
	          							<p>Surat Keluar</p>
	          						</a>
	          					</li>
	          				</ul>
	          			</li>

	          			<li class='nav-item has-treeview'>
	          				<a class='nav-link' href='#'><i class='nav-icon fa fa-file-word'></i>
	          					<p>Surat Khusus</p>
	          					<i class='fas fa-angle-left right'></i>
	          				</a>
	          				<ul class='nav nav-treeview'>

	          					<li class='nav-item'>
	          						<a href='/sk' class='nav-link'><i class='nav-icon fa fa-file-word'></i>
	          							<p>Surat Keputusan</p>
	          						</a>
	          					</li>
	          					<li class='nav-item'>
	          						<a href='/tgs' class='nav-link'><i class='nav-icon fa fa-file-word'></i>
	          							<p>Surat Tugas</p>
	          						</a>
	          					</li>
	          					<li class='nav-item'>
	          						<a href='/ket' class='nav-link'><i class='nav-icon fa fa-file-word'></i>
	          							<p>Surat Keterangan</p>
	          						</a>
	          					</li>
	          					<li class='nav-item'>
	          						<a href='/per' class='nav-link'><i class='nav-icon fa fa-file-word'></i>
	          							<p>Surat Pernyataan</p>
	          						</a>
	          					</li>
	          					<li class='nav-item'>
	          						<a href='/edr' class='nav-link'><i class='nav-icon fa fa-file-word'></i>
	          							<p>Surat Edaran</p>
	          						</a>
	          					</li>
	          					<li class='nav-item'>
	          						<a href='/rek' class='nav-link'><i class='nav-icon fa fa-file-word'></i>
	          							<p>Surat Rekomendasi</p>
	          						</a>
	          					</li>
	          					<li class='nav-item'>
	          						<a href='/ins' class='nav-link'><i class='nav-icon fa fa-file-word'></i>
	          							<p>Surat Instruksi</p>
	          						</a>
	          					</li>
	          					<li class='nav-item'>
	          						<a href='/mlm' class='nav-link'><i class='nav-icon fa fa-file-word'></i>
	          							<p>Surat Maklumat</p>
	          						</a>
	          					</li>
	          				</ul>
	          			</li>

	          			<li class='nav-item'>
	          				<a href='/agenda' class='nav-link'><i class='nav-icon fa fa-calendar-alt'></i>
	          					<p>Agenda</p>
	          				</a>
	          			</li>

	          			<li class='nav-item'>
	          				<a href='/kerjasama' class='nav-link'><i class='nav-icon fa fa-hands-helping'></i>
	          					<p>Mitra dan Kerjasama</p>
	          				</a>
	          			</li>


	          			<li class='nav-item has-treeview'>
	          				<a class='nav-link' href='#'><i class='nav-icon fa fa-comment-alt'></i>
	          					<p>Lapor!</p>
	          					<i class='fas fa-angle-left right'></i>
	          				</a>
	          				<ul class='nav nav-treeview'>
	          					<li class='nav-item'>
	          						<a href='#' class='nav-link'><i class='nav-icon fa fa-circle'></i>
	          							<p>Laporan Masuk</p><small class='label pull-right bg-red'> Soon</small>
	          						</a>
	          					</li>
	          					<li class='nav-item'>
	          						<a href='/lapor/submit' class='nav-link'><i class='nav-icon fa fa-circle'></i>
	          							<p>Submit Lapor!</p><small class='label pull-right bg-red'> Soon</small>
	          						</a>
	          					</li>
	          				</ul>
	          			</li>

	          		</ul>
	          	</nav>



	          </div>