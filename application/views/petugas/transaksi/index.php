<link rel="stylesheet" href="<?= base_url('assets/css/pages/data_parkir.css') ?>">

<div class="content-wrapper">

    <div class="content-header">
        <h1>Transaksi Parkir</h1>
    </div>

    <div class="content-body">
  
        <!-- TABLE -->
        <div class="card table-card">
            <div class="card-header">
                <h3>Daftar Kendaraan Aktif</h3>
            </div>

            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Plat</th>
                            <th>Jenis</th>
                            <th>Waktu Masuk</th>
                            <th>Durasi</th>
                            <th>Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($transaksi as $t): ?>
                        <tr style="background-color: #fffde7;">
                            <td><strong><?= $t->plat_nomor ?? $t->no_polisi ?? '-' ?></strong></td>
                            <td><?= $t->jenis_kendaraan ?? '-' ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($t->waktu_masuk)) ?></td>
                            <td><strong><?= $t->durasi_jam ?? '-' ?> jam</strong></td>
                            <td><strong>Rp <?= number_format($t->biaya_total ?? 0) ?></strong></td>
                            <td>
                                <a href="<?= base_url('index.php/petugas/transaksi/keluar/'.$t->id_parkir) ?>" class="btn btn-danger btn-sm" title="Proses Keluar">
                                    📤 Keluar
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>

