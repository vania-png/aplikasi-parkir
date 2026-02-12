<?php
$mysqli = new mysqli('localhost', 'root', '', 'parkir');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

$today = date('Y-m-d'); // 2026-02-05

echo "Database Cleanup Started\n";
echo "========================\n";
echo "Today's date: $today\n\n";

// Show records that will be deleted
echo "Records to be deleted (not today):\n";
$result = $mysqli->query("SELECT COUNT(*) as cnt FROM tb_parkir WHERE DATE(waktu_masuk) != '$today'");
$row = $result->fetch_assoc();
echo "Total records to delete: {$row['cnt']}\n\n";

// Show records that will be kept
echo "Records to be kept (today - $today):\n";
$result = $mysqli->query("SELECT id_parkir, no_polisi, waktu_masuk, waktu_keluar, biaya_total FROM tb_parkir WHERE DATE(waktu_masuk) = '$today' ORDER BY waktu_masuk");
while ($row = $result->fetch_assoc()) {
    $status = !empty($row['waktu_keluar']) ? 'KELUAR' : 'AKTIF';
    echo "ID: {$row['id_parkir']} | Plat: {$row['no_polisi']} | Waktu Masuk: {$row['waktu_masuk']} | Status: $status | Biaya: Rp {$row['biaya_total']}\n";
}

echo "\nDeleting old records...\n";
$delete = $mysqli->query("DELETE FROM tb_parkir WHERE DATE(waktu_masuk) != '$today'");

if ($delete) {
    $affected = $mysqli->affected_rows;
    echo "Successfully deleted $affected old records!\n";
} else {
    echo 'Error: ' . $mysqli->error . "\n";
}

// Show final count
$result = $mysqli->query("SELECT COUNT(*) as cnt FROM tb_parkir");
$row = $result->fetch_assoc();
echo "\nFinal record count: {$row['cnt']}\n";

$mysqli->close();
echo "\nCleanup completed!\n";
?>
