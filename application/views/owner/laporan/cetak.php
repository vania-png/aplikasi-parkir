<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendapatan Parkir</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/laporan_cetak.css') ?>">
    <style>
        body, .cetak-container, .cetak-title, .cetak-period, .cetak-table th, .cetak-table td {
            font-family: 'Courier New', Courier, monospace !important;
            font-size: 12px !important;
        }
        .cetak-title {
            font-size: 1.2rem !important;
        }
        .cetak-period {
            font-size: 0.95rem !important;
        }
        .cetak-table .total {
            font-size: 1rem !important;
        }
        .cetak-info-box { display: none !important; }
        .garis {
            border: none;
            border-top: 2px dotted #888;
            margin: 0.5em 0;
        }
        .judul {
            font-size: 1.1em;
            font-weight: bold;
            text-align: center;
            margin-bottom: 0.2em;
            letter-spacing: 1px;
        }
        @media print {
            a { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="cetak-container">
        <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 0.5em;">
            <a href="<?= base_url('index.php/owner/laporan') ?>" style="background: #fff; color: #1976d2; border: 1px solid #1976d2; border-radius: 6px; padding: 0.4em 1.2em; font-size: 1em; text-decoration: none; margin-left: auto;">&larr; Kembali</a>
        </div>
        <div class="judul">E-PARKING SYSTEM</div>
        <hr class="garis">
        <div class="cetak-title">LAPORAN PENDAPATAN PARKIR</div>
        <div class="cetak-period">Periode: <?= date('d M Y', strtotime($periode_mulai)) ?> - <?= date('d M Y', strtotime($periode_selesai)) ?></div>
        <table class="cetak-table">
            <tr>
                <th>Jumlah Kendaraan Keluar</th>
                <td><?= $jumlah_keluar ?> Unit</td>
            </tr>
            <tr>
                <th>Total Pendapatan</th>
                <td class="total">Rp <?= number_format($total_pendapatan,0,',','.') ?></td>
            </tr>
        </table>
        <hr class="garis">
    </div>
</body>
</html>
