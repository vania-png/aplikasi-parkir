<link rel="stylesheet" href="<?= base_url('assets/css/pages/area.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/pages/tarif.css') ?>">

<div class="page-wrapper">
    <div class="page-header">
        <h2>Manajemen Tarif Parkir</h2>
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
            <a href="<?= base_url('index.php/admin/tarif/tambah') ?>" class="btn btn-primary" style="background-color: #1976d2 !important; color: white !important;">
                + Tambah Tarif
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col-no">No</th>
                            <th>Jenis Kendaraan</th>
                            <th class="col-tarif">Tarif Per Jam</th>
                            <th class="col-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($tarif)): ?>
                        <tr>
                            <td colspan="4" class="empty-state">
                                📭 Belum ada data tarif
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php $no=1; foreach($tarif as $t): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <span class="jenis-kendaraan">
                                    <?= isset($t->jenis_kendaraan) ? $t->jenis_kendaraan : '-' ?>
                                </span>
                            </td>
                            <td class="col-tarif">
                                <span class="tarif-value">
                                    Rp <?= isset($t->tarif_per_jam) ? number_format($t->tarif_per_jam, 0, ',', '.') : '0' ?>
                                </span>
                            </td>
                            <td class="col-aksi">
                                <a href="<?= base_url('index.php/admin/tarif/edit/'.$t->id_tarif) ?>" 
                                   class="action-btn edit-btn" title="Edit">
                                    ✎ 
                                </a>
                                <a href="<?= base_url('index.php/admin/tarif/hapus/'.$t->id_tarif) ?>"
                                   onclick="return confirm('Yakin hapus tarif ini?')"
                                   class="action-btn delete-btn" title="Hapus">
                                    🗑 
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/layout/footer'); ?>