
<link rel="stylesheet" href="<?= base_url('assets/css/pages/rekapan.css') ?>">
<div class="rekapan-app-wrapper" style="background: #f6f8fa; min-height: 100vh;">
    <div class="rekapan-header-bar" style="display: flex; align-items: center; gap: 1rem; padding: 1.2rem 2rem 0.5rem 2rem;">
        <div style="display: flex; align-items: center; gap: 0.7rem;">
            <div style="background: #1976d2; color: #fff; border-radius: 8px; padding: 0.7rem 1.1rem; font-size: 1.3rem; display: flex; align-items: center;">
                <span style="font-size: 1.5rem; margin-right: 0.7rem;">🗂️</span>
                <span style="font-weight: 700;">History Transaksi</span>
            </div>
        </div>
        <div style="margin-left: auto;">
            <a href="<?= base_url('index.php/petugas/dashboard') ?>" class="btn" style="background: #f5f5f5; color: #222; border: 1px solid #bbb; border-radius: 6px; padding: 0.5em 1.2em; font-size: 1em; text-decoration: none;">&larr; Kembali</a>
        </div>
    </div>
    <div style="padding: 0 2rem;">
        <div style="display: flex; gap: 1.5rem; margin-bottom: 1.2rem;">
            <div style="flex:1; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 1.2rem; text-align: center;">
                <div style="font-size: 1.1rem; color: #888;">Total Transaksi</div>
                <div style="font-size: 2.1rem; font-weight: 700; color: #1976d2; margin-top: 0.2rem;"><?= $total_transaksi ?></div>
            </div>
            <div style="flex:1; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 1.2rem; text-align: center;">
                <div style="font-size: 1.1rem; color: #888;">Transaksi Aktif</div>
                <div style="font-size: 2.1rem; font-weight: 700; color: #fbc02d; margin-top: 0.2rem;"><?= $transaksi_aktif ?></div>
            </div>
            <div style="flex:1; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 1.2rem; text-align: center;">
                <div style="font-size: 1.1rem; color: #888;">Pendapatan Hari Ini</div>
                <div style="font-size: 2.1rem; font-weight: 700; color: #1976d2; margin-top: 0.2rem;">Rp <?= number_format($pendapatan_hari_ini ?? 0,0,',','.') ?></div>
            </div>
        </div>
        <form style="display: flex; gap: 1.2rem; align-items: center; margin-bottom: 1.2rem;">
            <input type="text" name="cari_plat" placeholder="Contoh: BK 1234" value="<?= $cari_plat ?? '' ?>" style="flex:2; padding: 0.7rem 1rem; border-radius: 6px; border: 1px solid #cfd8dc; font-size: 1rem;">
            <select name="status" style="flex:1; padding: 0.7rem 1rem; border-radius: 6px; border: 1px solid #cfd8dc; font-size: 1rem;">
                <option value="" <?= empty($status) ? 'selected' : '' ?>>Semua Status</option>
                <option value="Aktif" <?= ($status ?? '')=='Aktif'?'selected':'' ?>>Aktif</option>
                <option value="Keluar" <?= ($status ?? '')=='Keluar'?'selected':'' ?>>Keluar</option>
            </select>
            <button type="submit" style="background: #1976d2; color: #fff; border: none; border-radius: 6px; padding: 0.7rem 1.5rem; font-size: 1.1rem; font-weight: 600; cursor: pointer;">Cari</button>
        </form>
        <div style="margin-bottom: 1.2rem; font-size: 1.1rem; color: #1976d2; font-weight: 600;"><?= $jumlah_ditemukan ?> transaksi ditemukan</div>
        <div style="background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); overflow: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f5f5f5;">
                        <th style="padding: 1rem 1.2rem; font-size: 1rem; text-align: left; font-weight: 600; color: #555;">Plat Nomor</th>
                        <th style="padding: 1rem 1.2rem; font-size: 1rem; text-align: left; font-weight: 600; color: #555;">Waktu Masuk</th>
                        <th style="padding: 1rem 1.2rem; font-size: 1rem; text-align: left; font-weight: 600; color: #555;">Waktu Keluar</th>
                        <th style="padding: 1rem 1.2rem; font-size: 1rem; text-align: left; font-weight: 600; color: #555;">Durasi</th>
                        <th style="padding: 1rem 1.2rem; font-size: 1rem; text-align: left; font-weight: 600; color: #555;">Biaya</th>
                        <th style="padding: 1rem 1.2rem; font-size: 1rem; text-align: left; font-weight: 600; color: #555;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transaksi_list as $t): ?>
                    <tr>
                        <td style="padding: 1rem 1.2rem; font-size: 1rem; text-align: left; border-bottom: 1px solid #e0e0e0;"><?= $t['no_polisi'] ?></td>
                        <td style="padding: 1rem 1.2rem; font-size: 1rem; text-align: left; border-bottom: 1px solid #e0e0e0;"><?= date('d F Y \p\u\k\u\l H:i', strtotime($t['waktu_masuk'])) ?></td>
                        <td style="padding: 1rem 1.2rem; font-size: 1rem; text-align: left; border-bottom: 1px solid #e0e0e0;">
                            <?= $t['waktu_keluar'] ? date('d F Y \p\u\k\u\l H:i', strtotime($t['waktu_keluar'])) : '-' ?>
                        </td>
                        <td style="padding: 1rem 1.2rem; font-size: 1rem; text-align: left; border-bottom: 1px solid #e0e0e0;">
                            <?= $t['durasi'] ?? '-' ?>
                        </td>
                        <td style="padding: 1rem 1.2rem; font-size: 1rem; text-align: left; border-bottom: 1px solid #e0e0e0; font-weight: 600;">Rp <?= number_format($t['biaya_total'] ?? 0,0,',','.') ?></td>
                        <td style="padding: 1rem 1.2rem; font-size: 1rem; text-align: left; border-bottom: 1px solid #e0e0e0;">
                            <?php if ($t['status'] == 'Keluar'): ?>
                                <span style="color: #388e3c; font-weight: 600; background: #e8f5e9; border-radius: 6px; padding: 0.2em 0.7em;">Keluar</span>
                            <?php else: ?>
                                <span style="color: #fbc02d; font-weight: 600; background: #fffde7; border-radius: 6px; padding: 0.2em 0.7em;">Aktif</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($transaksi_list)): ?>
                    <tr>
                        <td colspan="6" style="padding: 2rem; text-align: center; color: #666;">Tidak ada transaksi ditemukan.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
