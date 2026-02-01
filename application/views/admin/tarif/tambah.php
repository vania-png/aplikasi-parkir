<link rel="stylesheet" href="<?= base_url('assets/css/pages/area.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/pages/tarif.css') ?>">

<div class="page-wrapper">
    <div class="page-header">
        <h2>Tambah Tarif Parkir</h2>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Form Input Tarif</h3>
        </div>

        <div class="card-body">
            <form action="<?= site_url('admin/tarif/simpan') ?>" method="post" class="form-edit-area">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Jenis Kendaraan</label>
                        <input type="text" name="jenis_kendaraan" placeholder="Contoh: Motor, Mobil, Truk" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Tarif Per Jam (Rp)</label>
                        <input type="number" name="tarif_per_jam" placeholder="Masukkan tarif per jam" class="form-control" required>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= site_url('admin/tarif') ?>" class="btn btn-secondary">← Kembali</a>
                    <button type="submit" class="btn btn-primary">💾 Simpan Tarif</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('admin/layout/footer'); ?>
