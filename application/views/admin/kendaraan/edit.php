<link rel="stylesheet" href="<?= base_url('assets/css/pages/area.css') ?>">

<div class="page-wrapper">
    <div class="page-header">
        <h2>Edit Kendaraan</h2>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger" style="margin: 1rem 0; padding: 1rem; background: #fee; color: #c33; border: 1px solid #fcc; border-radius: 6px; display: flex; align-items: center; gap: 0.8rem;">
        <span style="font-size: 1.3rem;">⚠️</span>
        <span><?= $this->session->flashdata('error') ?></span>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3>Form Edit Kendaraan</h3>
        </div>

        <div class="card-body">
            <form action="<?= base_url('index.php/admin/kendaraan/update/'.$kendaraan->id_kendaraan) ?>" method="post" class="form-edit-area" id="formKendaraan">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Plat Nomor</label>
                        <input type="text" name="plat_nomor" id="platNomor" value="<?= $kendaraan->plat_nomor ?>" class="form-control" required>
                        <small id="platMessage" style="display: none; margin-top: 0.3rem; font-weight: 600;"></small>
                    </div>

                    <div class="form-group">
                        <label>Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" class="form-control" required>
                            <option value="">-- Pilih Jenis --</option>
                            <?php if (!empty($jenis_kendaraan)): ?>
                                <?php foreach ($jenis_kendaraan as $jenis): ?>
                                    <option value="<?= htmlspecialchars($jenis->jenis_kendaraan) ?>" 
                                        <?= $kendaraan->jenis_kendaraan == $jenis->jenis_kendaraan ? 'selected' : '' ?>>
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
                        <input type="text" name="warna" value="<?= $kendaraan->warna ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Pemilik</label>
                        <input type="text" name="pemilik" value="<?= $kendaraan->pemilik ?>" class="form-control" required>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('index.php/admin/kendaraan') ?>" class="btn btn-secondary">← Kembali</a>
                    <button type="submit" class="btn btn-primary" id="submitBtn">✏️ Update Kendaraan</button>
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

let excludeId = <?= $kendaraan->id_kendaraan ?>;
let originalPlat = '<?= $kendaraan->plat_nomor ?>';
var isDuplicate = false;

// Blur listener untuk validasi panjang dan duplicate check
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
            setMessage('❌ Plat minimal 7 karakter (tanpa spasi).', '#c33');
        } else {
            setMessage('❌ Plat maksimal 8 karakter (tanpa spasi).', '#c33');
        }
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.5';
        submitBtn.style.cursor = 'not-allowed';
        return;
    }
    
    // Jika plat sama dengan yang asli, tidak perlu cek
    if (platValue === originalPlat) {
        messageEl.style.display = 'none';
        isDuplicate = false;
        submitBtn.disabled = false;
        submitBtn.style.opacity = '1';
        submitBtn.style.cursor = 'pointer';
        return;
    }
    
    // AJAX untuk cek plat nomor
    fetch('<?= base_url('index.php/admin/kendaraan/cek_plat') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'plat_nomor=' + encodeURIComponent(platValue) + '&exclude_id=' + excludeId
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'ada') {
            isDuplicate = true;
            setMessage('❌ ' + data.message, '#c33');
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.5';
            submitBtn.style.cursor = 'not-allowed';
        } else {
            isDuplicate = false;
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
    let platValue = document.getElementById('platNomor').value.trim();
    let normalized = normalizePlat(platValue);
    let submitBtn = document.getElementById('submitBtn');
    
    if (normalized.length < 7 || normalized.length > 8) {
        e.preventDefault();
        if (normalized.length < 7) {
            alert('❌ Plat minimal 7 karakter (tanpa spasi).');
        } else {
            alert('❌ Plat maksimal 8 karakter (tanpa spasi).');
        }
        return;
    }
    
    if (submitBtn.disabled) {
        e.preventDefault();
        alert('❌ Tidak bisa menyimpan! Nomor plat tidak valid atau sudah terdaftar di sistem.');
    }
});
</script>

<?php $this->load->view('admin/layout/footer'); ?>
