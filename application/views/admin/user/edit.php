<link rel="stylesheet" href="<?= base_url('assets/css/pages/area.css') ?>">

<div class="page-wrapper">
    <div class="page-header">
        <h2>Edit User</h2>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Form Edit User</h3>
        </div>

        <div class="card-body">
            <form action="<?= site_url('admin/user/update/' . $user->id_user) ?>" method="post" class="form-edit-area">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?= $user->nama_lengkap ?>" placeholder="Contoh: Budi Santoso" required>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="<?= $user->username ?>" placeholder="Contoh: budisantoso" required autocomplete="off" autocapitalize="off" spellcheck="false">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?= $user->email ?>" placeholder="Contoh: budi@email.com" required autocomplete="email">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" <?= $user->role === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="petugas" <?= $user->role === 'petugas' ? 'selected' : '' ?>>Petugas</option>
                            <option value="owner" <?= $user->role === 'owner' ? 'selected' : '' ?>>Owner</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Password Baru <span style="color: #999; font-size: 12px;">(Kosongkan jika tidak ingin diubah)</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password baru (opsional)">
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= site_url('admin/user') ?>" class="btn btn-secondary">← Kembali</a>
                    <button type="submit" class="btn btn-primary">✏️ Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('admin/layout/footer'); ?>
