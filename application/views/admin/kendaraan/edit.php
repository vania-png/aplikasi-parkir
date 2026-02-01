<link rel="stylesheet" href="<?= base_url('assets/css/pages/area.css') ?>">

<div class="page-wrapper">
    <div class="page-header">
        <h2>Edit Kendaraan</h2>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Form Edit Kendaraan</h3>
        </div>

        <div class="card-body">
            <form action="<?= base_url('index.php/admin/kendaraan/update/'.$kendaraan->id_kendaraan) ?>" method="post" class="form-edit-area">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Plat Nomor</label>
                        <input type="text" name="plat_nomor" value="<?= $kendaraan->plat_nomor ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" class="form-control" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Motor" <?= $kendaraan->jenis_kendaraan == 'Motor' ? 'selected' : '' ?>>Motor</option>
                            <option value="Mobil" <?= $kendaraan->jenis_kendaraan == 'Mobil' ? 'selected' : '' ?>>Mobil</option>
                            <option value="Truk" <?= $kendaraan->jenis_kendaraan == 'Truk' ? 'selected' : '' ?>>Truk</option>
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
                    <button type="submit" class="btn btn-primary">✏️ Update Kendaraan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('admin/layout/footer'); ?>
