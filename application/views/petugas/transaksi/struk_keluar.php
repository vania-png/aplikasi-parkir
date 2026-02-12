<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-PARKING SYSTEM - Struk Parkir</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/pages/struk_print.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
</head>
<body onload="window.print()">
<div class="struk-print">
    <div class="judul">E-PARKING SYSTEM</div>
    <div class="alamat">Jl. Raya Lokasi Parkir No. 1</div>
    <hr class="garis">
    <table class="data" width="100%">
        <tr>
            <td>No. Karcis</td><td>:</td><td><?= $transaksi->nomor_karcis ?? $transaksi->id_parkir ?? '-' ?></td>
        </tr>
        <tr>
            <td>Jenis Kendaraan</td><td>:</td><td><?= $transaksi->jenis_kendaraan ?? '-' ?></td>
        </tr>
        <tr>
            <td>Area Parkir</td><td>:</td><td><?= $transaksi->nama_area ?? '-' ?></td>
        </tr>
        <tr>
            <td>Plat</td><td>:</td><td><?= $transaksi->no_polisi ?></td>
        </tr>
        <tr>
            <td>Masuk</td><td>:</td><td><?= date('d/m/Y H:i', strtotime($transaksi->waktu_masuk)) ?></td>
        </tr>
        <tr>
            <td>Keluar</td><td>:</td><td><?= date('d/m/Y H:i', strtotime($transaksi->waktu_keluar ?: date('Y-m-d H:i:s'))) ?></td>
        </tr>
    </table>
    <hr class="garis">
    <table class="data" width="100%">
        <?php
        // Hitung durasi dan total jika data belum valid
        $durasi_jam = $transaksi->durasi_jam;
        $biaya_total = $transaksi->biaya_total;
        if (empty($durasi_jam) || $durasi_jam == 0 || empty($biaya_total) || $biaya_total == 0) {
            $waktu_masuk = strtotime($transaksi->waktu_masuk);
            $waktu_keluar = strtotime($transaksi->waktu_keluar ?: date('Y-m-d H:i:s'));
            $durasi_jam = ceil(($waktu_keluar - $waktu_masuk) / 3600);
            if ($durasi_jam < 1) $durasi_jam = 1;
            // Ambil tarif per jam dari database
            $CI =& get_instance();
            $tarif = $CI->Transaksi_model->get_tarif_by_jenis($transaksi->jenis_kendaraan);
            $biaya_total = $tarif ? $durasi_jam * $tarif->tarif_per_jam : 0;
        }
        // Pastikan uang diterima dan kembalian otomatis terisi
        if (!isset($uang_diberikan) || $uang_diberikan === null || $uang_diberikan == 0) {
            $uang_diberikan = isset($transaksi->uang_diberikan) ? $transaksi->uang_diberikan : $biaya_total;
        }
        if (!isset($kembalian) || $kembalian === null || $kembalian == 0) {
            $kembalian = isset($transaksi->kembalian) ? $transaksi->kembalian : ($uang_diberikan - $biaya_total);
        }
        ?>
        <tr>
            <td>Durasi</td><td>:</td><td><?= $durasi_jam ?> Jam</td>
        </tr>
        <tr>
            <td><b>TOTAL</b></td><td>:</td><td><b>Rp <?= number_format($biaya_total,0,',','.') ?></b></td>
        </tr>
        <tr>
            <td>Uang Diterima</td><td>:</td><td>Rp <?= number_format($uang_diberikan,0,',','.') ?></td>
        </tr>
        <tr>
            <td>Kembalian</td><td>:</td><td>Rp <?= number_format($kembalian,0,',','.') ?></td>
        </tr>
    </table>
    <div class="barcode-container" style="text-align: center; margin: 10px 0;">
        <svg id="barcode"></svg>
    </div>
    <div class="footer">
        Terima Kasih Atas Kunjungan Anda<br>
        -- Simpan Struk Ini --
    </div>
</div>
<script>
    var barcodeValue = "<?= $transaksi->nomor_karcis ?? $transaksi->id_parkir ?? '000000' ?>";
    JsBarcode("#barcode", barcodeValue, {
        format: "CODE128",
        width: 2,
        height: 40,
        displayValue: true,
        fontSize: 12,
        margin: 0
    });
</script>
</body>
</html>
