<link rel="stylesheet" href="<?= base_url('assets/css/pages/area.css') ?>">

<div class="page-wrapper">
    <div class="page-header">
        <h2>Tambah Area Parkir</h2>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Form Input Area</h3>
        </div>

        <div class="card-body">
            <form action="<?= base_url('index.php/admin/area/simpan') ?>" method="post" class="form-edit-area">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nama_area">Nama Area</label>
                        <input type="text" id="nama_area" name="nama_area" class="form-control" placeholder="Contoh: Area Motor A" required>
                    </div>

                    <div class="form-group">
                        <label for="kapasitas">Kapasitas</label>
                        <input type="number" id="kapasitas" name="kapasitas" class="form-control" placeholder="Jumlah maksimal kendaraan" required>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="terisi">Terisi</label>
                        <input type="number" id="terisi" name="terisi" class="form-control" placeholder="Jumlah kendaraan saat ini" value="0" required>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('index.php/admin/area') ?>" class="btn btn-secondary">← Kembali</a>
                    <button type="submit" class="btn btn-primary">📍 Simpan Area</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('admin/layout/footer'); ?>
