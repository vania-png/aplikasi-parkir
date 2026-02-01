<link rel="stylesheet" href="<?= base_url('assets/css/laporan_custom.css') ?>">

<div class="laporan-custom-outer">
    <div class="laporan-custom-center">
        <div class="laporan-custom-header-bar" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <a href="<?= base_url('index.php/owner/laporan') ?>" class="laporan-custom-back-btn">&larr; Kembali</a>
            <a href="<?= base_url('index.php/owner/laporan/cetak?dari=' . $periode_mulai . '&sampai=' . $periode_selesai) ?>" class="laporan-custom-print-btn" target="_blank">Cetak Laporan</a>
        </div>
        <div class="laporan-custom-title">LAPORAN PENDAPATAN PARKIR</div>
        <div class="laporan-custom-period">Periode: <?= date('d M Y', strtotime($periode_mulai)) ?> - <?= date('d M Y', strtotime($periode_selesai)) ?></div>
        <div class="laporan-custom-card">
            <table class="laporan-custom-table">
                <tr>
                    <th>Jumlah Kendaraan Keluar</th>
                    <td><?= $jumlah_keluar ?> Unit</td>
                </tr>
                <tr>
                    <th>Total Pendapatan</th>
                    <td class="total">Rp <?= number_format($total_pendapatan,0,',','.') ?></td>
                </tr>
            </table>
        </div>
        <div class="laporan-custom-info-box">
            <span class="info-icon">&#9432;</span> Gunakan tombol <b>Cetak Laporan</b> untuk menyimpan dalam bentuk PDF.
        </div>
    </div>
</div>
