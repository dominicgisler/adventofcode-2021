<?php

$input = file_get_contents(__DIR__ . '/input.txt');
//$input = '2199943210
//3987894921
//9856789892
//8767896789
//9899965678
//';

$data = [];
foreach (explode("\n", $input) as $y => $line) {
    if (empty($line)) {
        continue;
    }
    foreach (str_split($line) as $x => $pos) {
        $data[$x][$y] = $pos;
    }
}

$lows = [];
$risk = 0;
foreach ($data as $x => $line) {
    foreach ($line as $y => $pos) {
        if (isset($data[$x][$y-1]) && $data[$x][$y-1] <= $pos) continue;
        if (isset($data[$x][$y+1]) && $data[$x][$y+1] <= $pos) continue;
        if (isset($data[$x-1][$y]) && $data[$x-1][$y] <= $pos) continue;
        if (isset($data[$x+1][$y]) && $data[$x+1][$y] <= $pos) continue;
        $lows[] = $pos;
        $risk += $pos + 1;
    }
}
//print_r($lows);
echo 'risk: ' . $risk . PHP_EOL;
// risk: 530
