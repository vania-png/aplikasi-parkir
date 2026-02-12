<?php
function check($s) {
    $norm = preg_replace('/\s+/', '', $s);
    $len = strlen($norm);
    $valid = ($len >= 7 && $len <= 8) ? 'VALID' : 'INVALID';
    return [$s, $norm, "len=$len", $valid];
}

$tests = [
    'B 1234 ABC',   // 8 chars
    'B1234ABC',     // 8 chars
    'L 1245 YZ',    // 7 chars
    'AB1234C',      // 7 chars
    'B 12345 ABC',  // 9 chars (too long)
    'A 123 BC',     // 6 chars (too short)
    'B12345ABC',    // 8 chars
    'ABCDEFG',      // 7 chars
    'ABCDEFGH',     // 8 chars
    'ABCDEF',       // 6 chars
];

echo "Validasi Plat: Minimal 7, Maksimal 8 Karakter\n";
echo "================================================\n";
foreach ($tests as $t) {
    list($orig, $norm, $len, $result) = check($t);
    $status = ($result === 'VALID') ? '✅' : '❌';
    echo sprintf("%s %s -> %s | %s\n", $status, $orig, $norm, $result);
}
?>