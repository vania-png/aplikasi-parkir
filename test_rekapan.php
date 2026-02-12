<?php
/**
 * Test Script: Tambah Kendaraan Aktif untuk Testing
 */

$mysqli = new mysqli('localhost', 'root', '', 'parkir');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

echo "=== Testing Rekapan Display ===\n\n";

// 1. Insert test active vehicle
echo "1. Adding test active vehicle...\n";
$waktu_masuk = date('Y-m-d H:i:s', strtotime('-2 hours'));
$insert = $mysqli->query("
    INSERT INTO tb_parkir (no_polisi, jenis_kendaraan, id_area, id_tarif, waktu_masuk, waktu_keluar, durasi_jam, biaya_total, id_user)
    VALUES ('BK 5678 ABC', 'Mobil', 1, 1, '$waktu_masuk', NULL, 0, 0, 1)
");

if ($insert) {
    $id = $mysqli->insert_id;
    echo "   ✓ Added vehicle with ID: $id\n";
} else {
    echo "   ✗ Error: " . $mysqli->error . "\n";
}

echo "\n2. Current database state:\n";
$result = $mysqli->query("SELECT id_parkir, no_polisi, waktu_masuk, waktu_keluar, biaya_total FROM tb_parkir ORDER BY id_parkir DESC");
while ($row = $result->fetch_assoc()) {
    $status = isset($row['waktu_keluar']) && $row['waktu_keluar'] ? 'KELUAR' : 'AKTIF';
    echo "   ID: {$row['id_parkir']} | Plat: {$row['no_polisi']} | Status: $status\n";
}

echo "\n3. Expected in Rekapan:\n";
echo "   - All vehicles should appear in 'Semua Status' filter\n";
echo "   - Vehicles with waktu_keluar=NULL should be marked as 'Aktif'\n";
echo "   - Vehicles with waktu_keluar!=NULL should be marked as 'Keluar'\n";
echo "   - BK 5678 ABC should show as 'Aktif' (no waktu_keluar yet)\n";

echo "\n=== Test Complete ===\n";
echo "Visit: http://localhost/aplikasi_parkir/index.php/petugas/transaksi/rekapan\n";
echo "Check if BK 5678 ABC appears with AKTIF status\n";

$mysqli->close();
?>
