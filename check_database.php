<?php
$mysqli = new mysqli('localhost', 'root', '', 'parkir');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

$today = date('Y-m-d');

echo "Database Status Check\n";
echo "====================\n\n";

echo "1. ALL RECORDS IN DATABASE:\n";
$result = $mysqli->query("SELECT id_parkir, no_polisi, waktu_masuk, waktu_keluar, biaya_total FROM tb_parkir ORDER BY waktu_masuk DESC");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status = !empty($row['waktu_keluar']) ? 'KELUAR' : 'AKTIF';
        echo "ID: {$row['id_parkir']} | Plat: {$row['no_polisi']} | Status: $status | Biaya: Rp {$row['biaya_total']}\n";
    }
} else {
    echo "No records found\n";
}

echo "\n2. RECORDS FOR TODAY ($today):\n";
$result = $mysqli->query("SELECT COUNT(*) as cnt FROM tb_parkir WHERE DATE(waktu_masuk) = '$today'");
$row = $result->fetch_assoc();
echo "Total today: {$row['cnt']}\n";

echo "\n3. ACTIVE TRANSACTIONS (waktu_keluar IS NULL):\n";
$result = $mysqli->query("SELECT COUNT(*) as cnt FROM tb_parkir WHERE waktu_keluar IS NULL");
$row = $result->fetch_assoc();
echo "Total active: {$row['cnt']}\n";

echo "\n4. COMPLETED TRANSACTIONS (waktu_keluar IS NOT NULL):\n";
$result = $mysqli->query("SELECT COUNT(*) as cnt FROM tb_parkir WHERE waktu_keluar IS NOT NULL");
$row = $result->fetch_assoc();
echo "Total completed: {$row['cnt']}\n";

echo "\n5. COMPLETED WITH VALID FEES (waktu_keluar IS NOT NULL AND biaya_total > 0):\n";
$result = $mysqli->query("SELECT id_parkir, no_polisi, biaya_total FROM tb_parkir WHERE waktu_keluar IS NOT NULL AND biaya_total > 0");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['id_parkir']} | Plat: {$row['no_polisi']} | Biaya: Rp {$row['biaya_total']}\n";
    }
} else {
    echo "No valid completed transactions\n";
}

$mysqli->close();
?>
