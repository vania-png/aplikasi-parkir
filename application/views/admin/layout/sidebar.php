<aside class="sidebar" style="background-color: #4f46e5 !important;">
    <!-- Logo dan Brand -->
    <div class="sidebar-brand" style="background-color: #4f46e5 !important; color: white !important;">
        <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 10px;">
            <path d="M5 17v2h14v-2H5zM4.1 14.1L3 15.2l1.4 1.4 1.1-1.1L4.1 14.1zM7 12c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm-5-5h2V3h-2v4zm0 16h2v-4h-2v4z" fill="currentColor"/>
        </svg>
        <h1>APLIKASI<br>PARKIR</h1>
    </div>
    <hr style="border: 1px solid #ffffff; width: 80%; margin-left: 18px; margin-right: 0; margin-top: 0; margin-bottom: 0;">

    <!-- Navigation Menu -->
    <nav class="sidebar-menu" style="background-color: #4f46e5  !important; color: #1976d2 !important;">
        <ul>
            <li>
                <a href="<?= base_url('index.php/admin/dashboard') ?>" class="menu-item <?= ($active == 'dashboard') ? 'active' : '' ?>" style="color: #ffffff !important;">
                    <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 13h2v8H3zm4-8h2v16H7zm4-2h2v18h-2zm4 4h2v14h-2zm4-3h2v17h-2z" fill="currentColor"/></svg>
                    <span>DASHBOARD</span>
                </a>
            </li>
            <hr style="border: 1px solid #ffffff; width: 80%; margin-left: 18px; margin-right: 0; margin-top: 10px; margin-bottom: 10px;">
            <li style="font-weight: bold; color: #ffffff; padding: 10px 15px;">ADMINISTRATOR</li>
            <li>
                <a href="<?= base_url('index.php/admin/user') ?>" class="menu-item <?= ($active == 'user') ? 'active' : '' ?>" style="color: #ffffff !important;">
                    <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="currentColor"/></svg>
                    <span>Manajemen User</span>
                </a>
            </li>
            <hr style="border: 1px solid #ffffff; width: 80%; margin-left: 18px; margin-right: 0; margin-top: 10px; margin-bottom: 10px;">
            <li style="font-weight: bold; color: #ffffff; padding: 10px 15px;">MASTER PARKIR</li>
            <li>
                <a href="<?= base_url('index.php/admin/tarif') ?>" class="menu-item <?= ($active == 'tarif') ? 'active' : '' ?>" style="color: #ffffff !important;">
                    <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z" fill="currentColor"/></svg>
                    <span>Tarif Parkir</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('index.php/admin/area') ?>" class="menu-item <?= ($active == 'area') ? 'active' : '' ?>" style="color: #ffffff !important;">
                    <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6z" fill="currentColor"/></svg>
                    <span>Area Parkir</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('index.php/admin/kendaraan') ?>" class="menu-item <?= ($active == 'kendaraan') ? 'active' : '' ?>" style="color: #ffffff !important;">
                    <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.1-.62l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.48.1.62l2.03 1.58c-.05.3-.07.62-.07.94 0 .33.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.1.62l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.48-.1-.62l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z" fill="currentColor"/></svg>
                    <span>Kendaraan</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('index.php/admin/log') ?>" class="menu-item <?= ($active == 'log') ? 'active' : '' ?>" style="color: #ffffff !important;">
                     <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-2.16-2.66c-.23-.28-.62-.38-.96-.23-.35.13-.58.48-.58.85h4V16c0 .55.45 1 1 1s1-.45 1-1v-4h4c0-.37-.23-.72-.58-.85-.34-.13-.73-.05-.96.23l-2.01 2.46z" fill="currentColor"/></svg>
                    <span>Log Aktivitas</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Logout Button -->
    <div class="sidebar-footer">
        <a href="<?= base_url('index.php/auth/logout') ?>" class="btn-logout" style="color: #ffffff !important;">
            <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z" fill="currentColor"/></svg>
            Log out
        </a>
    </div>
</aside>

<?php $this->load->view('admin/layout/topbar'); ?>
<main class="main-content" style="margin-top: 64px;">