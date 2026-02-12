<link rel="stylesheet" href="<?= base_url('assets/css/pages/area.css') ?>">

<div class="page-wrapper">
    <div class="page-header">
        <h2>Tambah Kendaraan</h2>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger" style="margin: 1rem 0; padding: 1rem; background: #fee; color: #c33; border: 1px solid #fcc; border-radius: 6px; display: flex; align-items: center; gap: 0.8rem;">
        <span style="font-size: 1.3rem;">⚠️</span>
        <span><?= $this->session->flashdata('error') ?></span>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3>Form Input Kendaraan</h3>
        </div>

        <div class="card-body">
            <form action="<?= base_url('index.php/admin/kendaraan/simpan') ?>" method="post" class="form-edit-area" id="formKendaraan">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Plat Nomor</label>
                        <input type="text" name="plat_nomor" id="platNomor" placeholder="Contoh: B 1234 ABC" class="form-control" required>
                        <small id="platMessage" style="display: none; margin-top: 0.3rem; font-weight: 600;"></small>
                    </div>

                    <div class="form-group">
                        <label>Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" class="form-control" required>
                            <option value="">-- Pilih Jenis --</option>
                            <?php if (!empty($jenis_kendaraan)): ?>
                                <?php foreach ($jenis_kendaraan as $jenis): ?>
                                    <option value="<?= htmlspecialchars($jenis->jenis_kendaraan) ?>">
                                        <?= htmlspecialchars($jenis->jenis_kendaraan) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Warna</label>
                        <input type="text" name="warna" placeholder="Contoh: Hitam" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Pemilik</label>
                        <input type="text" name="pemilik" placeholder="Nama pemilik kendaraan" class="form-control" required>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('index.php/admin/kendaraan') ?>" class="btn btn-secondary">← Kembali</a>
                    <button type="submit" class="btn btn-primary" id="submitBtn">🚗 Simpan Kendaraan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function normalizePlat(s) {
    return s.replace(/\s+/g, ''); // hapus spasi
}

function setMessage(text, color) {
    let messageEl = document.getElementById('platMessage');
    messageEl.textContent = text;
    messageEl.style.color = color;
    messageEl.style.display = 'block';
}

document.getElementById('platNomor').addEventListener('blur', function() {
    let platValue = this.value.trim();
    let normalized = normalizePlat(platValue);
    let submitBtn = document.getElementById('submitBtn');
    let messageEl = document.getElementById('platMessage');

    if (platValue === '') {
        messageEl.style.display = 'none';
        submitBtn.disabled = false;
        submitBtn.style.opacity = '1';
        submitBtn.style.cursor = 'pointer';
        return;
    }
    // Validasi panjang harus 7-8 karakter
    if (normalized.length < 7 || normalized.length > 8) {
        if (normalized.length < 7) {
            setMessage('❌ Plat minimal 7 karakter.', '#c33');
        } else {
            setMessage('❌ Plat maksimal 8 karakter.', '#c33');
        }
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.5';
        submitBtn.style.cursor = 'not-allowed';
        return;
    }

   // Jika pola benar, lanjut cek apakah sudah terdaftar via AJAX
    fetch('<?= base_url('index.php/admin/kendaraan/cek_plat') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'plat_nomor=' + encodeURIComponent(platValue)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'ada') {
            setMessage('❌ ' + data.message, '#c33');
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.5';
            submitBtn.style.cursor = 'not-allowed';
        } else {
            setMessage('✅ Nomor plat tersedia', '#090');
            // Enable only if 7-8 characters
            if (normalized.length >= 7 && normalized.length <= 8) {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

document.getElementById('formKendaraan').addEventListener('submit', function(e) {
    let submitBtn = document.getElementById('submitBtn');

    if (submitBtn.disabled) {
        e.preventDefault();
        alert('❌ Tidak bisa menyimpan! Nomor plat tidak valid atau sudah terdaftar.');
    }
});
</script>

<?php $this->load->view('admin/layout/footer'); ?>
