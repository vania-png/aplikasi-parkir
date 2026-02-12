<?php
function check($s) {
    $norm = preg_replace('/\s+/', '', $s);
    $pattern = '/^[A-Za-z]{1,2}\s?\d{1,4}\s?[A-Za-z]{1,3}$/';
    $match = preg_match($pattern, $s) === 1 ? 'PATTERN_OK' : 'PATTERN_FAIL';
    $len_ok = strlen($norm) <= 8 ? 'LEN_OK' : 'LEN_TOO_LONG';
    return [$s, $norm, $match, $len_ok];
}

$tests = [
    'B 1234 ABC',
    'B1234ABC',
    'BK1234AB',
    'L 1245 YZ',
    'ABC123',
    '12345678',
    'AB 12345 C',
    'A 12345678',
    'B 12345 ABCD'
];

foreach ($tests as $t) {
    list($orig, $norm, $pat, $len) = check($t);
    echo sprintf("%s -> norm:%s | %s | %s\n", $orig, $norm, $pat, $len);
}
?>