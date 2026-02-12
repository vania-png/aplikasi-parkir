<link rel="stylesheet" href="<?= base_url('assets/css/pages/area.css') ?>">

<div class="page-wrapper">
    <div class="page-header">
        <h2>Edit Area Parkir</h2>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Form Edit Area</h3>
        </div>

        <div class="card-body">
            <form action="<?= base_url('index.php/admin/area/update/' . $area->id_area) ?>" method="post" class="form-edit-area">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nama_area">Nama Area</label>
                        <input type="text" id="nama_area" name="nama_area" class="form-control"
                               value="<?= $area->nama_area ?>" placeholder="Contoh: Area Motor A" required>
                    </div>

                    <div class="form-group">
                        <label for="kapasitas">Kapasitas</label>
                        <input type="number" id="kapasitas" name="kapasitas" class="form-control"
                               value="<?= $area->kapasitas ?>" placeholder="Jumlah maksimal kendaraan" required>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('index.php/admin/area') ?>" class="btn btn-secondary">← Kembali</a>
                    <button type="submit" class="btn btn-primary" style="background-color: #1976d2 !important; color: white !important;">✏️ Update Area</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('admin/layout/footer'); ?>
