<?php
function valid_plate($plat) {
    return preg_match('/^[A-Za-z]{1,2}\s?\d{1,4}\s?[A-Za-z]{1,3}$/', $plat) === 1;
}

$tests = [
    'B 1234 ABC',
    'B1234ABC',
    'BK1234AB',
    'L 1245 YZ',
    'ABC123',
    '12345678',
    'A 1 B',
    'AB 12 C'
];

foreach ($tests as $t) {
    echo sprintf("%s => %s\n", $t, valid_plate($t) ? 'VALID' : 'INVALID');
}
?>