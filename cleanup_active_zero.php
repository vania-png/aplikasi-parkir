<?php
$mysqli = new mysqli('localhost', 'root', '', 'parkir');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

$today = date('Y-m-d'); // 2026-02-05

echo "Cleanup Active Transactions (Rp 0)\n";
echo "===================================\n";

// Show records with status AKTIF and biaya 0
echo "Records with status AKTIF and Rp 0:\n";
$result = $mysqli->query("SELECT id_parkir, no_polisi, waktu_masuk FROM tb_parkir WHERE DATE(waktu_masuk) = '$today' AND waktu_keluar IS NULL AND biaya_total = 0");
while ($row = $result->fetch_assoc()) {
    echo "ID: {$row['id_parkir']} | Plat: {$row['no_polisi']} | Waktu: {$row['waktu_masuk']}\n";
}

echo "\nDeleting active transactions with Rp 0...\n";
$delete = $mysqli->query("DELETE FROM tb_parkir WHERE DATE(waktu_masuk) = '$today' AND waktu_keluar IS NULL AND biaya_total = 0");

if ($delete) {
    $affected = $mysqli->affected_rows;
    echo "Successfully deleted $affected records!\n";
} else {
    echo 'Error: ' . $mysqli->error . "\n";
}

// Show remaining records
echo "\nRemaining records:\n";
$result = $mysqli->query("SELECT id_parkir, no_polisi, waktu_masuk, waktu_keluar, biaya_total FROM tb_parkir ORDER BY waktu_masuk");
while ($row = $result->fetch_assoc()) {
    $status = !empty($row['waktu_keluar']) ? 'KELUAR' : 'AKTIF';
    echo "ID: {$row['id_parkir']} | Plat: {$row['no_polisi']} | Status: $status | Biaya: Rp {$row['biaya_total']}\n";
}

$result = $mysqli->query("SELECT COUNT(*) as cnt FROM tb_parkir");
$row = $result->fetch_assoc();
echo "\nTotal remaining: {$row['cnt']} records\n";

$mysqli->close();
echo "\nCleanup completed!\n";
?>
