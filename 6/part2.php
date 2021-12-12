<?php

$input = file_get_contents(__DIR__ . '/input.txt');
//$input = '3,4,3,1,2';

$input = explode(',', $input);
$fishs = [0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0];

foreach ($input as $fish) {
    $fishs[$fish]++;
}

$daylimit = 256;

//print_r($fishs);
for ($i = 0; $i < $daylimit; $i++) {
    $newfishs = [0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0];
//    echo 'day ' . $i . PHP_EOL;
    foreach ($fishs as $key => $cnt) {
        if ($key == 0) {
            $newfishs[8] += $cnt;
            $newfishs[6] += $cnt;
        } else {
            $newfishs[$key - 1] += $cnt;
        }
    }
    $fishs = $newfishs;
}

$sum = 0;
foreach ($fishs as $cnt) {
    $sum += $cnt;
}
echo 'Count after ' . $i . ' days: ' . $sum . PHP_EOL;
// Count after 256 days: 1653250886439
