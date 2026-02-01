<link rel="stylesheet" href="<?= base_url('assets/css/owner.css') ?>">

<div class="page-wrapper">
    <div class="laporan-header">
        <span class="icon">📄</span>
        <span class="laporan-title">Rekap Pendapatan</span>
    </div>
    <div class="laporan-grid" style="display: flex; flex-direction: row; gap: 2rem; margin-bottom: 2rem; align-items: flex-start;">
        <div style="flex: 1 1 0; min-width: 0;">
            <div style="display: flex; flex-direction: row; gap: 1.5rem;">
                <div class="laporan-card green">
                    <small>HARI INI</small>
                    <span class="icon-card">💵</span>
                    <h3>Rp <?= number_format($hari_ini->total ?? 0,0,',','.') ?></h3>
                    <p><span class="icon">🚗</span><?= $hari_ini->transaksi ?? 0 ?> Transaksi</p>
                </div>
                <div class="laporan-card purple">
                    <small>7 HARI TERAKHIR</small>
                    <span class="icon-card">📅</span>
                    <h3>Rp <?= number_format($mingguan->total ?? 0,0,',','.') ?></h3>
                    <p><span class="icon">🚗</span><?= $mingguan->transaksi ?? 0 ?> Transaksi</p>
                </div>
            </div>
            <div class="laporan-card blue" style="margin-top: 1.5rem; width: 100%;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div>
                        <div style="font-size:1.1rem;font-weight:600;opacity:0.95;">TOTAL PENDAPATAN BULAN INI</div>
                        <h2 style="margin:0.2rem 0 0.3rem 0; font-size:2.1rem; font-weight:700;">Rp <?= number_format($bulanan->total ?? 0,0,',','.') ?></h2>
                        <p style="margin:0;opacity:0.95;">🔄 Akumulasi transaksi dari tanggal 1 bulan berjalan.</p>
                    </div>
                    <span class="icon-card" style="font-size:3rem;">📈</span>
                </div>
            </div>
        </div>
        <div class="laporan-filter" style="width: 340px; min-width: 260px; max-width: 400px;">
            <h4><span class="icon">🔎</span> Filter Rekap Kustom</h4>
            <form action="<?= base_url('index.php/owner/laporan/custom') ?>" method="get" style="display: flex; flex-direction: column; gap: 0.7rem;">
                <label for="dari">Dari Tanggal</label>
                <input type="date" name="dari" id="dari" required>
                <label for="sampai">Sampai Tanggal</label>
                <input type="date" name="sampai" id="sampai" required>
                <button type="submit"><span class="icon">🔍</span> LIHAT REKAP SEKARANG</button>
            </form>
        </div>
    </div>
    <div class="laporan-note">
        <span class="icon">⚠️</span>
        <span>Catatan: Data yang tampil hanya mencakup kendaraan yang statusnya sudah <b>Keluar</b> dan pembayaran telah lunas.</span>
    </div>
    <div style="margin-top: 2rem;">
        <h3 style="font-size: 1.2rem; margin-bottom: 1rem; color: #1976d2;">Detail Transaksi Hari Ini</h3>
        <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f5f5f5;">
                        <th style="padding: 1rem 1.2rem; font-size: 1rem; text-align: left; font-weight: 600; color: #555;">No</th>
                        <th style="padding: 1rem 1.2rem; font-size: 1rem; text-align: left; font-weight: 600; color: #555;">Plat Nomor</th>
                        <th style="padding: 1rem 1.2rem; font-size: 1rem; text-align: left; font-weight: 600; color: #555;">Jenis Kendaraan</th>
                        <th style="padding: 1rem 1.2rem; font-size: 1rem; text-align: left; font-weight: 600; color: #555;">Waktu Masuk</th>
                        <th style="padding: 1rem 1.2rem; font-size: 1rem; text-align: left; font-weight: 600; color: #555;">Waktu Keluar</th>
                        <th style="padding: 1rem 1.2rem; font-size: 1rem; text-align: left; font-weight: 600; color: #555;">Petugas</th>
                        <th style="padding: 1rem 1.2rem; font-size: 1rem; text-align: right; font-weight: 600; color: #555;">Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $ada_transaksi = false;
                    if (!empty($transaksi_hari_ini)) {
                        foreach ($transaksi_hari_ini as $t) {
                            $ada_transaksi = true;
                    ?>
                    <tr>
                        <td style="padding: 1rem 1.2rem; font-size: 1rem; text-align: center; border-bottom: 1px solid #e0e0e0;"><?= $no++ ?></td>
                        <td style="padding: 1rem 1.2rem; font-size: 1rem; text-align: center; border-bottom: 1px solid #e0e0e0;"><?= $t['no_polisi'] ?></td>
                        <td style="padding: 1rem 1.2rem; font-size: 1rem; text-align: center; border-bottom: 1px solid #e0e0e0;"><?= $t['jenis_kendaraan'] ?></td>
                        <td style="padding: 1rem 1.2rem; font-size: 1rem; text-align: center; border-bottom: 1px solid #e0e0e0;"><?= date('d/m/Y H:i', strtotime($t['waktu_masuk'])) ?></td>
                        <td style="padding: 1rem 1.2rem; font-size: 1rem; text-align: center; border-bottom: 1px solid #e0e0e0;"><?= date('d/m/Y H:i', strtotime($t['waktu_keluar'])) ?></td>
                        <td style="padding: 1rem 1.2rem; font-size: 1rem; text-align: center; border-bottom: 1px solid #e0e0e0;"><?= !empty($t['nama_petugas']) ? $t['nama_petugas'] : '-' ?></td>
                        <td style="padding: 1rem 1.2rem; font-size: 1rem; text-align: right; border-bottom: 1px solid #e0e0e0; font-weight: 600;">Rp <?= number_format($t['biaya_total'],0,',','.') ?></td>
                    </tr>
                    <?php
                        }
                    }
                    if (!$ada_transaksi) {
                    ?>
                    <tr>
                        <td colspan="6" style="padding: 2rem; text-align: center; color: #666;">Tidak ada transaksi hari ini.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>