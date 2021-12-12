<?php

$input = file_get_contents(__DIR__ . '/input.txt');

$oxy = explode("\n", $input);
$pos = 0;
while (sizeof($oxy) > 1) {
    $cnt = [0 => 0, 1 => 0];
    foreach ($oxy as $key => $val) {
        $bits = str_split($val);
        $cnt[$bits[$pos]]++;
    }
    $bit = ($cnt[0] > $cnt[1] ? 0 : 1);
    foreach ($oxy as $key => $val) {
        $bits = str_split($val);
        if ($bits[$pos] != $bit) {
            unset($oxy[$key]);
        }
    }
    $pos++;
}

$co2 = explode("\n", $input);
$pos = 0;
while (sizeof($co2) > 1) {
    $cnt = [0 => 0, 1 => 0];
    foreach ($co2 as $key => $val) {
        $bits = str_split($val);
        $cnt[$bits[$pos]]++;
    }
    $bit = ($cnt[0] > $cnt[1] ? 1 : 0);
    foreach ($co2 as $key => $val) {
        $bits = str_split($val);
        if ($bits[$pos] != $bit) {
            unset($co2[$key]);
        }
    }
    $pos++;
}

$oxy = $oxy[array_keys($oxy)[0]];
$co2 = $co2[array_keys($co2)[0]];
echo 'oxy: ' . $oxy . PHP_EOL;
echo 'co2: ' . $co2 . PHP_EOL;
echo 'mult: ' . (bindec($oxy) * bindec($co2)) . PHP_EOL;
// oxy: 111000001101
// co2: 010101101101
// mult: 4996233
