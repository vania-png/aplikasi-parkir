<link rel="stylesheet" href="<?= base_url('assets/css/pages/area.css') ?>">

<div class="page-wrapper">
    <div class="page-header">
        <h2>Tambah User</h2>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Form Input User</h3>
        </div>

        <div class="card-body">
            <form action="<?= site_url('admin/user/simpan') ?>" method="post" class="form-edit-area">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" placeholder="Contoh: Budi Santoso" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" placeholder="Contoh: budisantoso" class="form-control" required autocomplete="off" autocapitalize="off" spellcheck="false">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Contoh: budi@email.com" class="form-control" required autocomplete="email">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Masukkan password minimal 6 karakter" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                            <option value="owner">Owner</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= site_url('admin/user') ?>" class="btn btn-secondary">← Kembali</a>
                    <button type="submit" class="btn btn-primary">👤 Simpan User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('admin/layout/footer'); ?>
