<link rel="stylesheet" href="<?= base_url('assets/css/pages/area.css') ?>">

<div class="page-wrapper">
    <div class="page-header">
        <h2>Tambah User</h2>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger" style="margin: 1rem 0; padding: 1rem; background: #fee; color: #c33; border: 1px solid #fcc; border-radius: 6px; display: flex; align-items: center; gap: 0.8rem;">
        <span style="font-size: 1.3rem;">⚠️</span>
        <span><?= $this->session->flashdata('error') ?></span>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3>Form Input User</h3>
        </div>

        <div class="card-body">
            <form action="<?= site_url('admin/user/simpan') ?>" method="post" class="form-edit-area" id="formUser">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" placeholder="Contoh: Budi Santoso" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" id="username" name="username" placeholder="Contoh: budisantoso" class="form-control" required autocomplete="off" autocapitalize="off" spellcheck="false">
                        <small id="usernameMessage" style="display: none; margin-top: 0.3rem; font-weight: 600;"></small>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="email" name="email" placeholder="Contoh: budi@email.com" class="form-control" required autocomplete="email">
                        <small id="emailMessage" style="display: none; margin-top: 0.3rem; font-weight: 600;"></small>
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
                    <button type="submit" class="btn btn-primary" id="submitBtn">👤 Simpan User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('username').addEventListener('blur', function() {
    let usernameValue = this.value.trim();
    
    if (usernameValue === '') {
        document.getElementById('usernameMessage').style.display = 'none';
        return;
    }
    
    fetch('<?= site_url('admin/user/cek_username') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'username=' + encodeURIComponent(usernameValue)
    })
    .then(response => response.json())
    .then(data => {
        let messageEl = document.getElementById('usernameMessage');
        let submitBtn = document.getElementById('submitBtn');
        
        if (data.status === 'ada') {
            messageEl.textContent = '❌ Username sudah terdaftar. Gunakan username lain.';
            messageEl.style.color = '#c33';
            messageEl.style.display = 'block';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.5';
            submitBtn.style.cursor = 'not-allowed';
        } else {
            messageEl.textContent = '✅ Username tersedia';
            messageEl.style.color = '#090';
            messageEl.style.display = 'block';
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

document.getElementById('email').addEventListener('blur', function() {
    let emailValue = this.value.trim();
    
    if (emailValue === '') {
        document.getElementById('emailMessage').style.display = 'none';
        return;
    }
    
    fetch('<?= site_url('admin/user/cek_email') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'email=' + encodeURIComponent(emailValue)
    })
    .then(response => response.json())
    .then(data => {
        let messageEl = document.getElementById('emailMessage');
        let submitBtn = document.getElementById('submitBtn');
        
        if (data.status === 'ada') {
            messageEl.textContent = '❌ Email sudah terdaftar. Gunakan email lain.';
            messageEl.style.color = '#c33';
            messageEl.style.display = 'block';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.5';
            submitBtn.style.cursor = 'not-allowed';
        } else {
            messageEl.textContent = '✅ Email tersedia';
            messageEl.style.color = '#090';
            messageEl.style.display = 'block';
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
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
