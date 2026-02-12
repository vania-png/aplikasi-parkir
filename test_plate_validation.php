<?php
function valid_plate($plat) {
    $plat_normal = preg_replace('/\s+/', '', $plat);
    return strlen($plat_normal) === 8;
}

$tests = [
    'B 1234 ABC',
    'B1234ABC',
    'BK1234AB',
    'L 1245 YZ',
    'ABC123',
    '12345678'
];

foreach ($tests as $t) {
    echo sprintf("%s => %s\n", $t, valid_plate($t) ? 'VALID' : 'INVALID');
}
?>