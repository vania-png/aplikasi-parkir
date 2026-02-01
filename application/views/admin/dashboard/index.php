<div class="page-wrapper " style="padding: 20px;">

    <div class="page-header mt-4">
        <h2>Dashboard</h2>
        <p>Ringkasan aktivitas parkir hari ini</p>
    </div>

    <!-- STAT CARD -->
    <div class="dashboard-cards">
        <div class="card stat-card blue">
            <div class="stat-icon">🚗</div>
            <div class="stat-info">
                <h3><?= $total_kendaraan_aktif ?></h3>
                <span>Kendaraan Aktif</span>
            </div>
        </div>

        <div class="card stat-card green">
            <div class="stat-icon">🅿️</div>
            <div class="stat-info">
                <h3><?= $total_slot_tersedia ?></h3>
                <span>Slot Tersedia</span>
            </div>
        </div>

        <div class="card stat-card orange">
            <div class="stat-icon">📊</div>
            <div class="stat-info">
                <h3><?= $total_data_kendaraan ?></h3>
                <span>Data Kendaraan</span>
            </div>
        </div>

        <div class="card stat-card purple">
            <div class="stat-icon">💰</div>
            <div class="stat-info">
                <h3>Rp <?= number_format($total_pendapatan,0,',','.') ?></h3>
                <span>Pendapatan Hari Ini</span>
            </div>
        </div>
    </div>

</div>
