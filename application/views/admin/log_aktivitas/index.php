<link rel="stylesheet" href="<?= base_url('assets/css/pages/log_aktivitas.css') ?>">

<div class="page-wrapper">
    <div class="page-header">
        <h2>Log Aktivitas</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama User</th>
                        <th>Aktivitas</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($log)): ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada aktivitas</td>
                    </tr>
                    <?php else: ?>
                    <?php $no=1; foreach ($log as $l): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $l->nama_lengkap ?? '-' ?></td>
                        <td><?= $l->aktivitas ?></td>
                        <td><?= date('d/m/Y H:i:s', strtotime($l->waktu_aktivitas)) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('admin/layout/footer'); ?>
