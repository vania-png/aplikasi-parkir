<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Struk Masuk Parkir</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/pages/struk_print.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
</head>
<body onload="window.print()">
<div class="struk-print">
    <div class="judul">E-PARKING SYSTEM</div>
    <div class="alamat">Jl. Raya Lokasi Parkir No. 1</div>
    <hr class="garis">
    
    <!-- Data Masuk -->
    <table class="data" width="100%">
        <tr>
            <td>Plat</td><td>:</td><td><?= htmlspecialchars($no_polisi) ?></td>
        </tr>
        <tr>
            <td>Jenis Kendaraan</td><td>:</td><td><?= htmlspecialchars($jenis_kendaraan) ?></td>
        </tr>
        <tr>
            <td>Area Parkir</td><td>:</td><td><?= htmlspecialchars($nama_area) ?></td>
        </tr>
        <tr>
            <td>Waktu Masuk</td><td>:</td><td><?= date('d/m/Y H:i', strtotime($waktu_masuk)) ?></td>
        </tr>
        <tr>
            <td>Tarif/Jam</td><td>:</td><td>Rp <?= number_format($tarif_per_jam, 0, ',', '.') ?></td>
        </tr>
    </table>
    
    <hr class="garis">
    
    <!-- Info Tambahan -->
    <table class="data" width="100%">
        <tr>
            <td>Status</td><td>:</td><td><b>MASUK</b></td>
        </tr>
    </table>
    
    <!-- Barcode -->
    <div class="barcode-container" style="text-align: center; margin: 10px 0;">
        <svg id="barcode"></svg>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        Terima Kasih Telah Menggunakan Layanan Kami<br>
        -- Simpan Bukti Ini Hingga Keluar Parkir --
    </div>
</div>

<script>
    // Generate barcode
    var barcodeValue = "<?= md5($no_polisi . $waktu_masuk) ?>";
    JsBarcode("#barcode", barcodeValue.substring(0, 12), {
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
