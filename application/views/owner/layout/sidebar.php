<aside class="sidebar" style="background-color: #1976d2 !important;">
    <!-- Logo dan Brand -->
    <div class="sidebar-brand" style="background-color: #1976d2 !important; color: white !important;">
        <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 10px;">
            <path d="M5 17v2h14v-2H5zM4.1 14.1L3 15.2l1.4 1.4 1.1-1.1L4.1 14.1zM7 12c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm-5-5h2V3h-2v4zm0 16h2v-4h-2v4z" fill="currentColor"/>
        </svg>
        <h1>APLIKASI<br>PARKIR</h1>
    </div>
    <hr style="border: 1px solid #ffffff; width: 80%; margin-left: 18px; margin-right: 0; margin-top: 0; margin-bottom: 0;">

    <!-- Navigation Menu -->
    <nav class="sidebar-menu" style="background-color: #1976d2  !important; color: #1976d2 !important;">
        <ul>
            <li>
                <a href="<?= base_url('index.php/owner/laporan') ?>" class="menu-item <?= ($active == 'dashboard') ? 'active' : '' ?>" style="color: #ffffff !important;">
                    <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 13h2v8H3zm4-8h2v16H7zm4-2h2v18h-2zm4 4h2v14h-2zm4-3h2v17h-2z" fill="currentColor"/></svg>
                    <span>Rekap Transaksi</span>
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
<?php $this->load->view('owner/layout/topbar'); ?>
<main class="main-content" style="margin-top: 64px;">