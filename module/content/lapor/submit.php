<div class="content">
  <div class="container-fluid">

    <div class="row text-xs">
      <div class="col-md-12">
        <div class="card rounded-0">
          <div class="card-header">
            <h3 class="card-title">Pengajuan Surat</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <!-- <div class="col-md-12 pb-4 text-end">
            <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#tambah">
              <i class="fas fa-plus"></i> Tambah Jenis
            </button>
          </div> -->

              <?php
              $ses_user = $_SESSION['ses_user'];
              $sql_jenis = "SELECT 
                                    k.value, 
                                    k.desc, 
                                    COUNT(j.id) AS jumlah_sk 
                                  FROM kode k 
                                  LEFT JOIN ajuan j ON k.value = j.id_jenis AND j.asal = ?
                                  WHERE k.kelompok = 'ajuan' 
                                  GROUP BY k.value, k.desc";

              $stmt_jenis = mysqli_prepare($con, $sql_jenis);
              mysqli_stmt_bind_param($stmt_jenis, 's', $ses_user);
              mysqli_stmt_execute($stmt_jenis);
              $result_jenis = mysqli_stmt_get_result($stmt_jenis);

              while ($p = mysqli_fetch_assoc($result_jenis)) {
              ?>
                <div class="col-md-3">
                  <div class="small-box bg-info">
                    <div class="inner bg-white">
                      <h3><?php echo htmlspecialchars($p['jumlah_sk']); ?></h3>
                      <p><?php echo htmlspecialchars($p['desc']); ?></p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-ios-book"></i>
                    </div>
                    <a href="/ajuan/jenis/<?php echo htmlspecialchars($p['value']); ?>" class="small-box-footer">
                      Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                    </a>
                  </div>
                </div>
              <?php
              }
              mysqli_stmt_close($stmt_jenis);
              ?>

            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card rounded-0">
          <div class="card-header">
            <h3 class="card-title">Ajuan Masuk Terbaru</h3>
          </div>
          <div class="card-body">
            <div class='table-responsive'>
              <table class="table table-striped table-bordered table-hover text-sm" id="ajuan">
                <thead>
                  <tr class="bg-info text-white text-center">
                    <th>Judul Surat</th>
                    <th>Tanggal Surat</th>
                    <th>Dari Lembaga</th>
                    <th>Status</th>
                    <th>Detail</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql_sk = "SELECT * FROM ajuan WHERE id_jenis = 1 ORDER BY DATE DESC";
                  $stmt_sk = mysqli_prepare($con, $sql_sk);
                  mysqli_stmt_execute($stmt_sk);
                  $result_sk = mysqli_stmt_get_result($stmt_sk);

                  while ($sk = mysqli_fetch_assoc($result_sk)) {
                  ?>
                    <tr>
                      <td class="col-4"><?= htmlspecialchars($sk['judul']); ?></td>
                      <td><?= htmlspecialchars($sk['tgl_sk']); ?></td>
                      <td class="text-center">
                        <?= htmlspecialchars($sk['asal_sim'] ?? '-'); ?>
                      </td>
                      <td class="text-center">
                        <?php
                        $status = $sk['status'] ?? 'Tidak ada status';
                        $badgeClass = 'badge-danger';
                        if ($status == 'Sedang Diajukan') {
                          $badgeClass = 'badge-primary';
                        } elseif ($status == 'Sedang Diproses') {
                          $badgeClass = 'badge-warning';
                        } elseif ($status == 'Selesai') {
                          $badgeClass = 'badge-success';
                        }
                        ?>
                        <span class="badge <?= $badgeClass; ?>"><?= htmlspecialchars($status); ?></span>
                      </td>
                      <td class="text-center">
                        <a href="/ajuan/edit/<?= htmlspecialchars($sk['id']); ?>" class="btn btn-sm btn-info">
                          <i class="fa fa-eye"></i> Lihat Detail
                        </a>
                      </td>
                    </tr>
                  <?php
                  }
                  mysqli_stmt_close($stmt_sk);
                  ?>
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card rounded-0">
          <div class="card-header">
            <h3 class="card-title">Semua Ajuan</h3>
          </div>
          <div class="card-body">
            <div class='table-responsive'>
              <table class="table table-striped table-bordered table-hover text-sm" id="ajuan">
                <thead>
                  <tr class="bg-info text-white text-center">
                    <th>Judul Surat</th>
                    <th>Tanggal Surat</th>
                    <th>Dari Lembaga</th>
                    <th>Status</th>
                    <th>Detail</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql_sk = "SELECT * FROM ajuan ORDER BY DATE DESC";
                  $stmt_sk = mysqli_prepare($con, $sql_sk);
                  mysqli_stmt_execute($stmt_sk);
                  $result_sk = mysqli_stmt_get_result($stmt_sk);

                  while ($sk = mysqli_fetch_assoc($result_sk)) {
                  ?>
                    <tr>
                      <td class="col-4"><?= htmlspecialchars($sk['judul']); ?></td>
                      <td><?= htmlspecialchars($sk['tgl_sk']); ?></td>
                      <td class="text-center">
                        <?= htmlspecialchars($sk['asal_sim'] ?? '-'); ?>
                      </td>
                      <td class="text-center">
                        <?php
                        $status = $sk['status'] ?? 'Tidak ada status';
                        $badgeClass = 'badge-danger';
                        if ($status == 'Sedang Diajukan') {
                          $badgeClass = 'badge-primary';
                        } elseif ($status == 'Sedang Diproses') {
                          $badgeClass = 'badge-warning';
                        } elseif ($status == 'Selesai') {
                          $badgeClass = 'badge-success';
                        }
                        ?>
                        <span class="badge <?= $badgeClass; ?>"><?= htmlspecialchars($status); ?></span>
                      </td>
                      <td class="text-center">
                        <a href="/ajuan/edit/<?= htmlspecialchars($sk['id']); ?>" class="btn btn-sm btn-info">
                          <i class="fa fa-eye"></i> Lihat Detail
                        </a>
                      </td>
                    </tr>
                  <?php
                  }
                  mysqli_stmt_close($stmt_sk);
                  ?>
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>








<?php
$id = 1;
$sql_max_id = "SELECT max(CAST(value AS SIGNED)) AS val FROM kode WHERE kelompok = 'ajuan'";
$result_max_id = mysqli_query($con, $sql_max_id);
if ($row_max_id = mysqli_fetch_assoc($result_max_id)) {
  $id = $row_max_id['val'] + 1;
}
?>
<div class="modal fade" id="tambah">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Jenis</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" enctype="multipart/form-data" method="post" action="/insert/jenis">
          <div class="form-group">
            <input type="hidden" name="kelompok" value="ajuan">
            <p>
              <label>ID<span class="text-danger"> *</span></label>
              <input name="value" type="text" class="form-control" value="<?php echo htmlspecialchars($id); ?>"
                readonly>
            </p>
            <p>
              <label>Nama Jenis<span class="text-danger"> *</span></label>
              <input name="desc" type="text" class="form-control" placeholder="Nama Jenis" required>
            </p>
          </div>
          <div class="modal-footer justify-content-between">
            <input type="submit" class="btn btn-primary" value="Tambah">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(function() {
    $('#ajuan').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": false,
      "bInfo": false,
      "pageLength": 50,
      "bAutoWidth": false
    });
  });
</script>