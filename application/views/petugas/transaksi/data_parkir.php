<link rel="stylesheet" href="<?= base_url('assets/css/pages/transaksi.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/pages/data_parkir.css') ?>">

<div class="content-wrapper">

    <div class="content-header">
        <h1>Input Data Parkir</h1>
    </div>

    <div class="content-body">
        <!-- FORM TRANSAKSI -->
        <div class="card form-card">
            <div class="card-header">
                <h3>Form Input Kendaraan Masuk</h3>
            </div>

            <div class="card-body">
                <form action="<?= base_url('index.php/petugas/transaksi/simpan') ?>" method="post" id="form-transaksi">
                    <!-- Plat Nomor -->
                    <div class="form-group">
                        <label for="no_polisi">Plat Nomor Kendaraan</label>
                        <input type="text" name="no_polisi" class="form-control" placeholder="Masukkan Plat Nomor" required>
                    </div>

                    <!-- Jenis Kendaraan -->
                    <div class="form-group">
                        <label for="jenis_kendaraan">Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" class="form-control" required>
                            <option value="">Pilih Jenis Kendaraan</option>
                            <?php foreach ($tarif as $t): ?>
                                <option value="<?= $t->jenis_kendaraan ?>"><?= $t->jenis_kendaraan ?> - Rp <?= number_format($t->tarif_per_jam) ?>/jam</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Hidden Area (default to first area) -->
                    <input type="hidden" name="area_id" value="<?= $area[0]->id_area ?? 1 ?>">

                    <!-- Button Kendaraan Masuk -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            Kendaraan Masuk
                        </button>
                    </div>

                    <input type="hidden" name="tanggal" value="<?= date('Y-m-d') ?>">
                    <input type="hidden" name="jam_masuk" value="<?= date('H:i') ?>">
                </form>
            </div>
        </div>

    </div>
</div>

<script>
function updateTarif() {
    var select = document.getElementById('jenis_kendaraan');
    var selected = select.options[select.selectedIndex];
    var tarif = selected.getAttribute('data-tarif');
    var display = document.getElementById('tarif-display');
    if (tarif) {
        display.innerHTML = '<strong>Rp ' + tarif + '/jam</strong>';
        display.className = 'alert alert-success';
    } else {
        display.innerHTML = 'Pilih jenis kendaraan terlebih dahulu';
        display.className = 'alert alert-info';
    }
}
</script>

