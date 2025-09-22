<?php

declare(strict_types=1);


ob_start();

if (empty($_SESSION['ses_user']) and empty($_SESSION['ses_pass']) and empty($_SESSION['ses_level'])) {
  header('Location: /login');
  exit;
} else {

  switch ($folder['2']) {

    default:
?>
      <div class="content-header">
        <div class="container-fluid">
          <h1 class="m-0">Laporan masuk</h1>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <p><button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Kirim Laporan</button></p>


          <?php
          $qlapor = mysqli_query($con, "SELECT * FROM lapor WHERE user='$_SESSION[ses_user]' ");
          while ($lapor = mysqli_fetch_array($qlapor)) {

            if ($lapor['tipe'] == '1') {
              $tipe = 'Pengaduan';
            } elseif ($lapor['tipe'] == '2') {
              $tipe = 'Aspirasi';
            }

            $jenis = mysqli_fetch_array(mysqli_query($con, "SELECT terlapor.unit,jenis_laporan.jenis FROM terlapor,jenis_laporan WHERE terlapor.id=jenis_laporan.id_terlapor AND jenis_laporan.id='$lapor[jenis]'"));

            if ($lapor['visibilitas'] == '1') {
              $rpelapor = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM user WHERE username='$lapor[user]' "));
              $pelapor = 'Pribadi';
            } elseif ($lapor['visibilitas'] == '2') {
              $pelapor = 'Kelompok';
            } elseif ($lapor['visibilitas'] == '3') {
              $pelapor = 'Kelas';
            }

            switch ($lapor['status']) {
              case '1':
                $bg = 'warning';
                $ket = 'Proses Verifikasi';
                break;
              case '2':
                $bg = 'primary';
                $ket = 'Proses Tindaklanjut';
                break;
              case '3':
                $bg = 'danger';
                $ket = 'Ditolak';
                break;
              case '4':
                $bg = 'success';
                $ket = 'Selesai';
                break;
            }

            echo "
			<div class='card card-outline card-$bg'>
				<div class='card-header with-border'>
					<h3 class='card-title'>$tipe: $lapor[judul]</h3>
			                <div class='card-tools'>
			                      <span class='badge badge-$bg'>$ket</span>
		";
            if ($lapor['status'] == '1') {
              echo " <a href='/delete/lapor/$lapor[id]'><span class='badge badge-danger'><i class='fa fa-times'></i> Hapus Laporan</span></a>";
            }
            echo "
			                 </div>	
					
				</div>
				<div class='card-body text-sm'>
					$lapor[isi]
				</div>
				<div class='card-footer text-xs'>
					Atas nama $pelapor : $jenis[unit] > $jenis[jenis]<br>
					Dikirim pada $lapor[date] Jam $lapor[time] WIB. Lampiran: 
		";
            if ($lapor['url_lampiran'] != '') {
              echo "
					<a href='$lapor[url_lampiran]' target='_blank'>Unduh</a>
			";
            } else {
              echo "Tidak ada";
            }
            echo "
				</div>
			</div>
		";
          }
          ?>
        </div>
      </div>


      <div class="modal fade" id="tambah">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Buat Laporan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form role="form" enctype="multipart/form-data" method="post" action="/insert/lapor">
                <div class="form-group">

                  <p>
                    <label>Tipe<span class="text-danger"> *</span></label>
                    <select class='form-control' name='tipe' required>
                      <option value=''>-- Pilih --</option>
                      <option value='1'>Pengaduan (Pelanggaran, Pungutan Liar, Penyalahgunaan Wewenang, Kekerasan Seksual, Korupsi, Pidana)</option>
                      <option value='2'>Aspirasi (Kritik, Keluhan, Saran dan Masukan)</option>
                    </select>
                  </p>


                  <p>
                    <label>Judul<span class="text-danger"> *</span></label>
                    <input name="judul" type="text" class="form-control" placeholder="Silakan diisi" required>
                  </p>
                  <label>Isi<span class="text-danger"> *</span></label>
                  <textarea name='isi' class='form-control' required>tulis secara rinci, jika ada disertai krnologi, waktu dan tempat</textarea>
                  </p>

                  <p>
                    <label>Topik<span class="text-danger"> *</span></label>
                    <select class='form-control' name='jenis' required>
                      <option value=''>-- Pilih --</option>
                      <?php
                      $qterlapor = mysqli_query($con, "SELECT * FROM terlapor ORDER BY id");
                      while ($terlapor = mysqli_fetch_array($qterlapor)) {
                        echo "
												<optgroup label='$terlapor[unit]'>
												";
                        $qjenis = mysqli_query($con, "SELECT * FROM jenis_laporan WHERE id_terlapor='$terlapor[id]' ORDER BY id");
                        while ($jenis = mysqli_fetch_array($qjenis)) {
                          echo "
														<option value='$jenis[id]'>$jenis[jenis]</option>
													";
                        }
                      }
                      ?>

                    </select>
                  </p>

                  <p>
                    <label>Atas Nama<span class="text-danger"> *</span></label>
                    <input type='radio' name='visibilitas' value='1'> Pribadi
                    <input type='radio' name='visibilitas' value='2'> Kelompok
                    <input type='radio' name='visibilitas' value='3'> Kelas
                  </p>


                  <p>
                    <label>Berkas Pendukung Laporan (PDF) Digabungkan (Jika Ada)</label>
                    <input name="fupload" type="file" class="form-control">
                  </p>

                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <p class="text-sm">Identitas Anda dirahasiakan</p>
              <input type="submit" class="btn btn-primary" value="Kirim">
            </div>
            </form>
          </div>
        </div>
      </div>
      </div>

<?php
      break;

    case 'disposisi':

      $qlapor = mysqli_query($con, "SELECT * FROM lapor WHERE disposisi='$_SESSION[ses_user]' ORDER BY 'status',stamp ");
      while ($lapor = mysqli_fetch_array($qlapor)) {

        if ($lapor['tipe'] == '1') {
          $tipe = 'Pengaduan';
        } elseif ($lapor['tipe'] == '2') {
          $tipe = 'Aspirasi';
        }

        $jenis = mysqli_fetch_array(mysqli_query($con, "SELECT terlapor.unit,jenis_laporan.jenis FROM terlapor,jenis_laporan WHERE terlapor.id=jenis_laporan.id_terlapor AND jenis_laporan.id='$lapor[jenis]'"));

        if ($lapor['visibilitas'] == '1') {
          $rpelapor = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM user WHERE username='$lapor[user]' "));
          $pelapor = 'Pribadi';
        } elseif ($lapor['visibilitas'] == '2') {
          $pelapor = 'Kelompok';
        } elseif ($lapor['visibilitas'] == '3') {
          $pelapor = 'Kelas';
        }

        switch ($lapor['status']) {
          case '1':
            $bg = 'warning';
            $ket = 'Proses Verifikasi';
            break;
          case '2':
            $bg = 'primary';
            $ket = 'Proses Tindaklanjut';
            break;
          case '3':
            $bg = 'danger';
            $ket = 'Ditolak';
            break;
          case '4':
            $bg = 'success';
            $ket = 'Selesai';
            break;
        }

        echo "
			<div class='card card-outline card-$bg'>
				<div class='card-header with-border'>
					<h3 class='card-title'>$tipe: $lapor[judul]</h3>
		";

        if ($lapor['status'] == '2') {
          echo "
			                <div class='card-tools'>
			                      <a href='/update/lapor/$lapor[id]'><span class='badge badge-warning'>Nyatakan Selesai</span></a>
			                 </div>	
			";
        } elseif ($lapor['status'] == '3') {
          echo "
			                <div class='card-tools'>
			                      <span class='badge badge-success'>Selesai</span>
			                 </div>	
			";
        }




        echo "
				</div>
				<div class='card-body text-sm'>
					$lapor[isi]
				</div>
				<div class='card-footer text-xs'>
					Atas nama $pelapor : $jenis[unit] > $jenis[jenis]<br>
					Dikirim pada $lapor[date] Jam $lapor[time] WIB. Lampiran: 
		";
        if ($lapor['url_lampiran'] != '') {
          echo "
					<a href='$lapor[url_lampiran]' target='_blank'>Unduh</a>
			";
        } else {
          echo "Tidak ada";
        }
        echo "
				</div>
			</div>
		";
      }

      break;
  }
}
?>