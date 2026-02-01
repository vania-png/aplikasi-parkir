<link rel="stylesheet" href="<?= base_url('assets/css/pages/data_parkir.css') ?>">

<div class="content-wrapper">

    <div class="content-header">
        <h1>Transaksi Parkir</h1>
    </div>

    <div class="content-body">
  
        <!-- TABLE -->
        <div class="card table-card">
            <div class="card-header">
                <h3>Data Transaksi Parkir Hari Ini</h3>
            </div>

            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Plat</th>
                            <th>Jenis</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Jam</th>
                            <th>Total</th>
                            <th>Cetak</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($transaksi as $t): ?>
                            <?php if (empty($t->waktu_keluar)): ?>
                        <tr>
                            <td><?= $t->plat_nomor ?? $t->no_polisi ?? '-' ?></td>
                            <td><?= $t->jenis_kendaraan ?? '-' ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($t->waktu_masuk)) ?></td>
                            <td>-</td>
                            <td><?= $t->durasi_jam ?? '-' ?> jam</td>
                            <td>Rp <?= number_format($t->biaya_total ?? 0) ?></td>
                            <td>
                                <a href="<?= base_url('index.php/petugas/transaksi/keluar/'.$t->id_parkir) ?>" class="btn btn-danger btn-sm" title="Keluar">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.09 15.59L11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5c-1.11 0-2 .9-2 2v4h2V5h14v14H5v-4H3v4c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" fill="currentColor"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                            <?php endif; ?>
                        <?php endforeach ?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>

<script>
function updateTarif() {
    var select = document.getElementById('jenis_kendaraan');
    var selected = select.options[select.selectedIndex];
    var tarif = selected.getAttribute('data-tarif');
    document.getElementById('tarif-display').innerText = 'Tarif: Rp ' + (tarif ? tarif : '-') + '/jam';
}

function scrollToForm(){
    document.getElementById('form-parkir').scrollIntoView({behavior:'smooth'});
}
</script>
