<?php
function check($s) {
    $norm = preg_replace('/\s+/', '', $s);
    $pattern = '/^[A-Za-z]{1,2}\s?\d{1,4}\s?[A-Za-z]{1,3}$/';
    $match = preg_match($pattern, $s) === 1 ? 'PATTERN_OK' : 'PATTERN_FAIL';
    $len = strlen($norm);
    $result = (preg_match($pattern, $s) === 1 && $len === 8) ? 'VALID' : 'INVALID';
    return [$s, $norm, $match, "len=$len", $result];
}

$tests = [
    'B 1234 ABC',   // 8 chars
    'B1234ABC',     // 8 chars
    'BK1234AB',     // 8 chars
    'L 1245 YZ',    // 7 chars
    'B 12345 ABC',  // 9 chars
    'A 1234 BCD',   // 8 chars
    'ABC 123',      // 6 chars
];

foreach ($tests as $t) {
    list($orig, $norm, $pat, $len, $result) = check($t);
    echo sprintf("%s -> %s | %s | %s | %s\n", $orig, $norm, $pat, $len, $result);
}
?>