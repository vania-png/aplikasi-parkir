<?php
$this->load->view('admin/layout/header', [
    'title'  => 'Data User',
    'active' => 'user'
]);
$this->load->view('admin/layout/sidebar');
?>
<link rel="stylesheet" href="<?= base_url('assets/css/pages/user.css') ?>">

<div class="page-wrapper">
    <div class="page-header">
        <h2>Manajemen User</h2>
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
            <a href="<?= site_url('admin/user/tambah') ?>" class="btn btn-primary">
                + Tambah User
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($user)): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada data user</td>
                    </tr>
                    <?php else: ?>
                    <?php $no=1; foreach($user as $u): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $u->nama_lengkap ?></td>
                        <td><?= $u->username ?></td>
                        <td><?= $u->email ?></td>
                        <td><?= ucfirst($u->role) ?></td>
                        <td class="text-center">
                            <a href="<?= site_url('admin/user/edit/'.$u->id_user) ?>" class="btn-icon btn-edit">✎</a>
                            <a href="<?= site_url('admin/user/hapus/'.$u->id_user) ?>"
                               onclick="return confirm('Yakin hapus user?')"
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