<link rel="stylesheet" href="<?= base_url('assets/css/pages/area.css') ?>">

<div class="page-wrapper">
    <div class="page-header">
        <h2>Tambah Kendaraan</h2>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Form Input Kendaraan</h3>
        </div>

        <div class="card-body">
            <form action="<?= base_url('index.php/admin/kendaraan/simpan') ?>" method="post" class="form-edit-area">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Plat Nomor</label>
                        <input type="text" name="plat_nomor" placeholder="Contoh: B 1234 ABC" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" class="form-control" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Motor">Motor</option>
                            <option value="Mobil">Mobil</option>
                            <option value="Truk">Truk</option>
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
                    <button type="submit" class="btn btn-primary">🚗 Simpan Kendaraan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('admin/layout/footer'); ?>
