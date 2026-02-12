<link rel="stylesheet" href="<?= base_url('assets/css/pages/transaksi.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/pages/data_parkir.css') ?>">

<div class="content-wrapper">

    <div class="content-header">
        <h1>Input Data Parkir</h1>
    </div>

    <div class="content-body">
        <!-- NOTIFIKASI KENDARAAN AKTIF -->
        <?php if (!empty($transaksi_aktif)): ?>
        <div style="background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 6px; padding: 12px 16px; margin-bottom: 20px; color: #856404;">
            <strong>⚠️ Perhatian:</strong> Ada <?= count($transaksi_aktif) ?> kendaraan yang masih aktif (belum keluar). 
            Jika Anda memilih plat nomor yang sama, sistem akan menolak dan memberitahu bahwa kendaraan tersebut masih parkir.
        </div>
        <?php endif; ?>

        <!-- FORM TRANSAKSI -->
        <div class="card form-card">
            <div class="card-header">
                <h3>Form Input Kendaraan Masuk</h3>
            </div>

            <div class="card-body">
                <!-- ALERT DUPLIKAT -->
                <div id="alert-duplikat" style="display:none; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 6px; padding: 12px 16px; margin-bottom: 15px; color: #721c24;">
                    <strong>❌ Kendaraan Masih Aktif!</strong>
                    <div id="alert-duplikat-text"></div>
                </div>

                <form id="form-transaksi">
                    <!-- Plat Nomor -->
                    <div class="form-group">
                        <label for="no_polisi">Plat Nomor Kendaraan</label>
                        <select name="no_polisi" id="no_polisi" class="form-control" required>
                            <option value="">Pilih Plat Nomor Kendaraan</option>
                            <?php foreach ($kendaraan as $k): ?>
                                <option value="<?= $k->plat_nomor ?>"><?= $k->plat_nomor ?> (<?= $k->jenis_kendaraan ?>) - <?= $k->warna ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Jenis Kendaraan -->
                    <div class="form-group">
                        <label for="jenis_kendaraan">Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-control" required>
                            <option value="">Pilih Jenis Kendaraan</option>
                            <?php foreach ($tarif as $t): ?>
                                <option value="<?= $t->jenis_kendaraan ?>"><?= $t->jenis_kendaraan ?> - Rp <?= number_format($t->tarif_per_jam) ?>/jam</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Area Parkir -->
                    <div class="form-group">
                        <label for="area_id">Area Parkir</label>
                        <select name="area_id" id="area_id" class="form-control" required>
                            <option value="">Pilih Area Parkir</option>
                            <?php foreach ($area as $a): ?>
                                <option value="<?= $a->id_area ?>"><?= $a->nama_area ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Button Kendaraan Masuk -->
                    <div class="text-center">
                        <button type="button" class="btn btn-primary btn-lg" id="btn-submit" style="background-color:#1976d2;border-color:#1976d2;box-shadow:0 2px 8px rgba(25, 118, 210, 0.25);" onclick="submitForm();">
                            Kendaraan Masuk
                        </button>
                    </div>

                    <input type="hidden" name="tanggal" value="<?= date('Y-m-d') ?>">
                    <input type="hidden" name="jam_masuk" value="<?= date('H:i') ?>">
                </form>
            </div>
        </div>

        <!-- DAFTAR KENDARAAN AKTIF -->
        <?php if (!empty($transaksi_aktif)): ?>
        <div class="card" style="margin-top: 2rem;">
            <div class="card-header">
                <h3>📋 Kendaraan Masih Parkir (<?= count($transaksi_aktif) ?>)</h3>
            </div>
            <div class="card-body" style="padding: 0; overflow: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background-color: #f5f5f5;">
                        <tr>
                            <th style="padding: 12px 16px; text-align: left; font-weight: 600; color: #555; border-bottom: 2px solid #ddd;">Plat Nomor</th>
                            <th style="padding: 12px 16px; text-align: left; font-weight: 600; color: #555; border-bottom: 2px solid #ddd;">Jenis</th>
                            <th style="padding: 12px 16px; text-align: left; font-weight: 600; color: #555; border-bottom: 2px solid #ddd;">Waktu Masuk</th>
                            <th style="padding: 12px 16px; text-align: left; font-weight: 600; color: #555; border-bottom: 2px solid #ddd;">Durasi</th>
                            <th style="padding: 12px 16px; text-align: left; font-weight: 600; color: #555; border-bottom: 2px solid #ddd;">Biaya Estimasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transaksi_aktif as $t): ?>
                        <tr style="border-bottom: 1px solid #e0e0e0;">
                            <td style="padding: 12px 16px; font-weight: 600; color: #1976d2;"><?= $t->no_polisi ?></td>
                            <td style="padding: 12px 16px;"><?= $t->jenis_kendaraan ?></td>
                            <td style="padding: 12px 16px;"><?= date('d/m/Y H:i', strtotime($t->waktu_masuk)) ?></td>
                            <td style="padding: 12px 16px;"><strong><?= $t->durasi_jam ?> jam</strong></td>
                            <td style="padding: 12px 16px; font-weight: 600; color: #d32f2f;">Rp <?= number_format($t->biaya_estimasi, 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<script>
// Data plat nomor yang sedang aktif (dari PHP)
const platAktif = <?= json_encode($plat_aktif ?? []) ?>;

// Validasi saat memilih plat nomor
document.getElementById('no_polisi').addEventListener('change', function() {
    const selectedPlat = this.value;
    const alertDiv = document.getElementById('alert-duplikat');
    const alertText = document.getElementById('alert-duplikat-text');
    const btnSubmit = document.getElementById('btn-submit');
    
    if (selectedPlat && platAktif.includes(selectedPlat)) {
        // Plat ada di transaksi aktif
        alertDiv.style.display = 'block';
        alertText.innerHTML = `Plat nomor <strong>${selectedPlat}</strong> masih dalam transaksi aktif. Silakan selesaikan transaksi sebelumnya terlebih dahulu.`;
        btnSubmit.disabled = true;
        btnSubmit.style.opacity = '0.5';
        btnSubmit.style.cursor = 'not-allowed';
    } else {
        // Plat aman
        alertDiv.style.display = 'none';
        btnSubmit.disabled = false;
        btnSubmit.style.opacity = '1';
        btnSubmit.style.cursor = 'pointer';
    }
});

// Function untuk submit form
function submitForm() {
    var form = document.getElementById('form-transaksi');
    var formData = new FormData(form);
    
    // POST ke struk_masuk (controller akan redirect ke struk_masuk_preview via GET)
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '<?= base_url('index.php/petugas/transaksi/struk_masuk') ?>', true);
    xhr.onload = function() {
        if (xhr.status === 200 || xhr.status === 302) {
            // Redirect sudah dihandle oleh browser, arahkan ke preview
            setTimeout(function() {
                window.location.href = '<?= base_url('index.php/petugas/transaksi/struk_masuk_preview') ?>';
            }, 100);
        }
    };
    xhr.onerror = function() {
        alert('Terjadi kesalahan. Silakan coba lagi.');
    };
    xhr.send(formData);
}
</script>

