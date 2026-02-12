<link rel="stylesheet" href="<?= base_url('assets/css/pages/area.css') ?>">

<div class="page-wrapper">
    <div class="page-header">
        <h2>Edit User</h2>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger" style="margin: 1rem 0; padding: 1rem; background: #fee; color: #c33; border: 1px solid #fcc; border-radius: 6px; display: flex; align-items: center; gap: 0.8rem;">
        <span style="font-size: 1.3rem;">⚠️</span>
        <span><?= $this->session->flashdata('error') ?></span>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3>Form Edit User</h3>
        </div>

        <div class="card-body">
            <form action="<?= site_url('admin/user/update/' . $user->id_user) ?>" method="post" class="form-edit-area" id="formUser">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?= $user->nama_lengkap ?>" placeholder="Contoh: Budi Santoso" required>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?= $user->username ?>" placeholder="Contoh: budisantoso" required autocomplete="off" autocapitalize="off" spellcheck="false">
                        <small id="usernameMessage" style="display: none; margin-top: 0.3rem; font-weight: 600;"></small>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?= $user->email ?>" placeholder="Contoh: budi@email.com" required autocomplete="email">
                        <small id="emailMessage" style="display: none; margin-top: 0.3rem; font-weight: 600;"></small>
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
                    <button type="submit" class="btn btn-primary" id="submitBtn">✏️ Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let excludeId = <?= $user->id_user ?>;
let originalUsername = '<?= $user->username ?>';
let originalEmail = '<?= $user->email ?>';

document.getElementById('username').addEventListener('blur', function() {
    let usernameValue = this.value.trim();
    
    if (usernameValue === '') {
        document.getElementById('usernameMessage').style.display = 'none';
        return;
    }
    
    if (usernameValue === originalUsername) {
        document.getElementById('usernameMessage').style.display = 'none';
        document.getElementById('submitBtn').disabled = false;
        document.getElementById('submitBtn').style.opacity = '1';
        document.getElementById('submitBtn').style.cursor = 'pointer';
        return;
    }
    
    fetch('<?= site_url('admin/user/cek_username') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'username=' + encodeURIComponent(usernameValue) + '&exclude_id=' + excludeId
    })
    .then(response => response.json())
    .then(data => {
        let messageEl = document.getElementById('usernameMessage');
        let submitBtn = document.getElementById('submitBtn');
        
        if (data.status === 'ada') {
            messageEl.textContent = '❌ ' + data.message;
            messageEl.style.color = '#c33';
            messageEl.style.display = 'block';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.5';
            submitBtn.style.cursor = 'not-allowed';
        } else {
            messageEl.textContent = '✅ ' + data.message;
            messageEl.style.color = '#090';
            messageEl.style.display = 'block';
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
            validateForm();
        }
    })
    .catch(error => console.error('Error:', error));
});

document.getElementById('email').addEventListener('blur', function() {
    let emailValue = this.value.trim();
    
    if (emailValue === '') {
        document.getElementById('emailMessage').style.display = 'none';
        return;
    }
    
    if (emailValue === originalEmail) {
        document.getElementById('emailMessage').style.display = 'none';
        document.getElementById('submitBtn').disabled = false;
        document.getElementById('submitBtn').style.opacity = '1';
        document.getElementById('submitBtn').style.cursor = 'pointer';
        return;
    }
    
    fetch('<?= site_url('admin/user/cek_email') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'email=' + encodeURIComponent(emailValue) + '&exclude_id=' + excludeId
    })
    .then(response => response.json())
    .then(data => {
        let messageEl = document.getElementById('emailMessage');
        let submitBtn = document.getElementById('submitBtn');
        
        if (data.status === 'ada') {
            messageEl.textContent = '❌ ' + data.message;
            messageEl.style.color = '#c33';
            messageEl.style.display = 'block';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.5';
            submitBtn.style.cursor = 'not-allowed';
        } else {
            messageEl.textContent = '✅ ' + data.message;
            messageEl.style.color = '#090';
            messageEl.style.display = 'block';
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
            validateForm();
        }
    })
    .catch(error => console.error('Error:', error));
});

document.getElementById('formUser').addEventListener('submit', function(e) {
    let usernameMessage = document.getElementById('usernameMessage').textContent;
    let emailMessage = document.getElementById('emailMessage').textContent;
    let submitBtn = document.getElementById('submitBtn');
    
    if (submitBtn.disabled || usernameMessage.includes('❌') || emailMessage.includes('❌')) {
        e.preventDefault();
        alert('❌ Tidak bisa menyimpan! Username atau Email sudah terdaftar di sistem.');
    }
});
</script>

<?php $this->load->view('admin/layout/footer'); ?>
