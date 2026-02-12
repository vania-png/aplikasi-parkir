<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Masuk Parkir</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/pages/struk_masuk.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
</head>
<body>
<div class="struk-masuk-container">
    <div class="struk-print">
        <!-- Header -->
        <div class="header">
            <div class="logo">📋 BUKTI PARKIR</div>
            <div class="subtitle">Sistem Manajemen Parkir</div>
        </div>
        
        <hr class="garis">
        
        <!-- Data Masuk -->
        <table class="data" width="100%">
            <tr>
                <td>PLAT NOMOR</td>
                <td>:</td>
                <td><?= $no_polisi ?></td>
            </tr>
            <tr>
                <td>JENIS KENDARAAN</td>
                <td>:</td>
                <td><?= $jenis_kendaraan ?></td>
            </tr>
            <tr>
                <td>AREA PARKIR</td>
                <td>:</td>
                <td><?= $nama_area ?></td>
            </tr>
            <tr>
                <td>WAKTU MASUK</td>
                <td>:</td>
                <td><?= date('d/m/Y H:i', strtotime($tanggal . ' ' . $jam_masuk)) ?></td>
            </tr>
            <tr>
                <td>TARIF/JAM</td>
                <td>:</td>
                <td>Rp <?= number_format($tarif_per_jam, 0, ',', '.') ?></td>
            </tr>
        </table>
        
        <hr class="garis">
        
        <!-- Barcode -->
        <div style="text-align: center; margin: 12px 0;">
            <svg id="barcode" style="max-width: 100%;"></svg>
        </div>
        
        <div class="footer">
            Terima Kasih Telah Menggunakan Layanan Kami<br>
            Mohon Jaga Bukti Parkir Ini
        </div>
    </div>
    
    <!-- Hidden Form untuk Submit ke Cetak Masuk -->
    <form id="form-submit" method="post" action="<?= base_url('index.php/petugas/transaksi/cetak_masuk') ?>" style="display: none;">
    </form>
    
    <!-- Button Group (Only Visible on Screen) -->
    <div class="button-group">
        <button class="btn btn-close" onclick="if(confirm('Kembali tanpa menyimpan?')) window.location='<?= base_url('index.php/petugas/transaksi/batal_cetak') ?>';">
            ✕ Tutup
        </button>
        <button class="btn btn-print" onclick="goToCetak();">
            🖨️ Cetak Struk
        </button>
    </div>
</div>

<script>
    // Generate barcode dengan ID parkir
    var barcodeValue = "<?= md5($no_polisi . $tanggal . $jam_masuk) ?>";
    JsBarcode("#barcode", barcodeValue.substring(0, 12), {
        format: "CODE128",
        width: 2,
        height: 35,
        displayValue: true,
        fontSize: 11,
        margin: 0
    });
    
    // Function untuk go to cetak_masuk page
    function goToCetak() {
        // Submit form via AJAX (tanpa POST redirect)
        var form = document.getElementById('form-submit');
        var formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Redirect ke halaman cetak_printed untuk menampilkan struk
                window.location = '<?= base_url('index.php/petugas/transaksi/cetak_printed') ?>';
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    }
</script>
</body>
</html>
