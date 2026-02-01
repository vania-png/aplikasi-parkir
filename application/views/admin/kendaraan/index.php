<link rel="stylesheet" href="<?= base_url('assets/css/pages/kendaraan.css') ?>">

<div class="page-wrapper">
    <div class="page-header">
        <h2>Manajemen Kendaraan</h2>
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
            <a href="<?= base_url('index.php/admin/kendaraan/tambah') ?>" class="btn btn-primary">
                + Tambah Kendaraan
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Plat Nomor</th>
                        <th>Jenis</th>
                        <th>Warna</th>
                        <th>Pemilik</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($kendaraan)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada data kendaraan</td>
                    </tr>
                    <?php else: ?>
                    <?php $no=1; foreach($kendaraan as $k): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $k->plat_nomor ?></td>
                        <td><?= $k->jenis_kendaraan ?></td>
                        <td><?= $k->warna ?></td>
                        <td><?= $k->pemilik ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('index.php/admin/kendaraan/edit/'.$k->id_kendaraan) ?>" class="btn-icon btn-edit">✎</a>
                            <a href="<?= base_url('index.php/admin/kendaraan/hapus/'.$k->id_kendaraan) ?>"
                               onclick="return confirm('Yakin hapus kendaraan ini?')"
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
