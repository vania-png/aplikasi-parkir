<?php
/**
 * Final Verification Script
 * Ensures data consistency across the system
 */

$mysqli = new mysqli('localhost', 'root', '', 'parkir');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

echo "=== SYSTEM CONSISTENCY VERIFICATION ===\n";
echo "Date: " . date('Y-m-d H:i:s') . "\n\n";

// 1. Check orphan records (what should NOT exist)
echo "1. ORPHAN RECORDS CHECK (Should be 0):\n";
$result = $mysqli->query("SELECT COUNT(*) as count FROM tb_parkir WHERE waktu_keluar IS NULL AND biaya_total <= 0");
$row = $result->fetch_assoc();
echo "   Active transactions with Rp 0: " . $row['count'] . " (EXPECTED: 0)\n";

if ($row['count'] > 0) {
    echo "   ⚠️  WARNING: Found orphan records!\n";
    $result = $mysqli->query("SELECT id_parkir, no_polisi FROM tb_parkir WHERE waktu_keluar IS NULL AND biaya_total <= 0");
    while ($r = $result->fetch_assoc()) {
        echo "      - ID {$r['id_parkir']}: {$r['no_polisi']}\n";
    }
} else {
    echo "   ✓ CLEAN\n";
}

echo "\n2. VALID ACTIVE TRANSACTIONS:\n";
$result = $mysqli->query("SELECT COUNT(*) as count FROM tb_parkir WHERE waktu_keluar IS NULL AND biaya_total > 0");
$row = $result->fetch_assoc();
echo "   Count: " . $row['count'] . "\n";
if ($row['count'] > 0) {
    $result = $mysqli->query("SELECT id_parkir, no_polisi, biaya_total FROM tb_parkir WHERE waktu_keluar IS NULL AND biaya_total > 0");
    while ($r = $result->fetch_assoc()) {
        echo "   - ID {$r['id_parkir']}: {$r['no_polisi']} | Rp {$r['biaya_total']}\n";
    }
}

echo "\n3. COMPLETED TRANSACTIONS (KELUAR):\n";
$result = $mysqli->query("SELECT COUNT(*) as count FROM tb_parkir WHERE waktu_keluar IS NOT NULL AND biaya_total > 0");
$row = $result->fetch_assoc();
echo "   Count: " . $row['count'] . "\n";
if ($row['count'] > 0) {
    $result = $mysqli->query("SELECT id_parkir, no_polisi, biaya_total FROM tb_parkir WHERE waktu_keluar IS NOT NULL AND biaya_total > 0");
    while ($r = $result->fetch_assoc()) {
        echo "   - ID {$r['id_parkir']}: {$r['no_polisi']} | Rp {$r['biaya_total']}\n";
    }
}

echo "\n4. INVALID/INCOMPLETE TRANSACTIONS (Should be 0):\n";
$invalid1 = $mysqli->query("SELECT COUNT(*) as count FROM tb_parkir WHERE waktu_keluar IS NOT NULL AND biaya_total <= 0")->fetch_assoc();
$invalid2 = $mysqli->query("SELECT COUNT(*) as count FROM tb_parkir WHERE waktu_keluar IS NULL AND biaya_total <= 0")->fetch_assoc();
$total_invalid = $invalid1['count'] + $invalid2['count'];
echo "   Completed with Rp 0: " . $invalid1['count'] . "\n";
echo "   Active with Rp 0: " . $invalid2['count'] . "\n";
echo "   TOTAL INVALID: " . $total_invalid . " (EXPECTED: 0)\n";

if ($total_invalid > 0) {
    echo "   ⚠️  System has invalid records!\n";
} else {
    echo "   ✓ ALL CLEAN\n";
}

echo "\n5. TODAY'S STATISTICS:\n";
$today = date('Y-m-d');
$result = $mysqli->query("SELECT COUNT(*) as count, SUM(biaya_total) as total FROM tb_parkir WHERE DATE(waktu_masuk) = '$today' AND waktu_keluar IS NOT NULL AND biaya_total > 0");
$row = $result->fetch_assoc();
echo "   Completed transactions today: " . $row['count'] . "\n";
echo "   Total earnings today: Rp " . ($row['total'] ?? 0) . "\n";

echo "\n=== FINAL STATUS ===\n";
if ($total_invalid > 0) {
    echo "⚠️  SYSTEM NEEDS ATTENTION: Invalid records detected\n";
} else {
    echo "✅ SYSTEM HEALTHY: All data is consistent and valid\n";
}

echo "\nVerification completed at " . date('Y-m-d H:i:s') . "\n";

$mysqli->close();
?>
