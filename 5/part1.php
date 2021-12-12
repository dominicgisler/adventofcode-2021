<?php

$input = file_get_contents(__DIR__ . '/input.txt');
//$input = '0,9 -> 5,9
//8,0 -> 0,8
//9,4 -> 3,4
//2,2 -> 2,1
//7,0 -> 7,4
//6,4 -> 2,0
//0,9 -> 2,9
//3,4 -> 1,4
//0,0 -> 8,8
//5,5 -> 8,2';

$data = [];
for ($i = 0; $i <= 1000; $i++) {
    $data[$i] = [];
    for ($j = 0; $j <= 1000; $j++) {
        $data[$i][] = 0;
    }
}

foreach (explode("\n", $input) as $line) {
    $pos = explode(' -> ', $line);
    $pos1 = explode(',', $pos[0]);
    $pos2 = explode(',', $pos[1]);
    if ($pos1[0] == $pos2[0]) {
        if ($pos1[1] < $pos2[1]) {
            for ($i = $pos1[1]; $i <= $pos2[1]; $i++) {
                $data[$i][$pos1[0]]++;
            }
        } else {
            for ($i = $pos2[1]; $i <= $pos1[1]; $i++) {
                $data[$i][$pos1[0]]++;
            }
        }
    } else if ($pos1[1] == $pos2[1]) {
        if ($pos1[0] < $pos2[0]) {
            for ($i = $pos1[0]; $i <= $pos2[0]; $i++) {
                $data[$pos1[1]][$i]++;
            }
        } else {
            for ($i = $pos2[0]; $i <= $pos1[0]; $i++) {
                $data[$pos1[1]][$i]++;
            }
        }
    }
}

$cnt = 0;
foreach ($data as $line) {
    foreach ($line as $point) {
        if ($point >= 2) {
            $cnt++;
        }
//        echo $point ?: '.';
    }
//    echo PHP_EOL;
}
echo 'multiple overlaps: ' . $cnt . ' times' . PHP_EOL;
// multiple overlaps: 4421 times
