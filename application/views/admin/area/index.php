<link rel="stylesheet" href="<?= base_url('assets/css/pages/area.css') ?>">

<div class="page-wrapper">
    <div class="page-header">
        <h2>Manajemen Area Parkir</h2>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        ✓ <?= $this->session->flashdata('success') ?>
    </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-error">
        ✗ <?= $this->session->flashdata('error') ?>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <a href="<?= base_url('index.php/admin/area/tambah') ?>" class="btn btn-primary" style="background-color: #1976d2 !important; color: white !important;">
                + Tambah Area
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Area</th>
                        <th>Kapasitas</th>
                        <th>Sisa Slot</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($area)): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada data area parkir</td>
                    </tr>
                    <?php else: ?>
                    <?php $no=1; foreach($area as $a): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $a->nama_area ?></td>
                        <td><?= $a->kapasitas ?></td>
                        <td><?= $a->sisa ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('index.php/admin/area/edit/'.$a->id_area) ?>" class="btn-icon btn-edit">✎</a>
                            <a href="<?= base_url('index.php/admin/area/hapus/'.$a->id_area) ?>"
                               onclick="return confirm('Yakin hapus area ini?')"
                               class="btn-icon btn-delete">🗑</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('admin/layout/footer'); ?>
