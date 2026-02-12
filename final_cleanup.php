<?php
$mysqli = new mysqli('localhost', 'root', '', 'parkir');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

echo "Final Database Cleanup\n";
echo "=====================\n\n";

echo "1. Records to be deleted (AKTIF with Rp 0):\n";
$result = $mysqli->query("SELECT id_parkir, no_polisi FROM tb_parkir WHERE waktu_keluar IS NULL AND biaya_total = 0");
while ($row = $result->fetch_assoc()) {
    echo "ID: {$row['id_parkir']} | Plat: {$row['no_polisi']}\n";
}

echo "\nDeleting...\n";
$delete = $mysqli->query("DELETE FROM tb_parkir WHERE waktu_keluar IS NULL AND biaya_total = 0");

if ($delete) {
    $affected = $mysqli->affected_rows;
    echo "Deleted $affected invalid records.\n";
} else {
    echo 'Error: ' . $mysqli->error . "\n";
}

echo "\n2. Final database state:\n";
$result = $mysqli->query("SELECT id_parkir, no_polisi, waktu_masuk, waktu_keluar, biaya_total FROM tb_parkir ORDER BY id_parkir");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status = !empty($row['waktu_keluar']) ? 'KELUAR' : 'AKTIF';
        echo "ID: {$row['id_parkir']} | Plat: {$row['no_polisi']} | Status: $status | Biaya: Rp {$row['biaya_total']}\n";
    }
} else {
    echo "Database is empty\n";
}

echo "\nDone!\n";

$mysqli->close();
?>
