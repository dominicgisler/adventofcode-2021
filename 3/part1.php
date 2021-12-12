<?php

$input = file_get_contents(__DIR__ . '/input.txt');

$counts = [
    0 => [],
    1 => []
];
$gamma = '';
$eps = '';
foreach (explode("\n", $input) as $val) {
    $bits = str_split($val);
    foreach ($bits as $key => $bit) {
        if (!isset($counts[$bit][$key])) {
            $counts[$bit][$key] = 0;
        }
        $counts[$bit][$key]++;
    }
}
for ($i = 0; $i < sizeof($counts[0]); $i++) {
    $gamma .= ($counts[0][$i] > $counts[1][$i]) ? '0' : '1';
    $eps .= ($counts[0][$i] < $counts[1][$i]) ? '0' : '1';
}
echo 'gamma: ' . $gamma . ' => ' . bindec($gamma) . PHP_EOL;
echo 'eps: ' . $eps . ' => ' . bindec($eps) . PHP_EOL;
echo 'power consumption: ' . (bindec($gamma) * bindec($eps)) . PHP_EOL;
// gamma: 101000010000 => 2576
// eps: 010111101111 => 1519
// power consumption: 3912944
