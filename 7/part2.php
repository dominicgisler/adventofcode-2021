<?php

$input = file_get_contents(__DIR__ . '/input.txt');
//$input = '16,1,2,0,4,2,7,1,2,14';
$crabs = explode(',', $input);

$max = 0;
foreach ($crabs as $pos) {
    if ($pos > $max) {
        $max = $pos;
    }
}
//echo 'max: ' . $max . PHP_EOL;

$minfuel = 1000000000;
$bestpos = 0;
for ($i = 0; $i <= $max; $i++) {
    $fuel = 0;
    foreach ($crabs as $pos) {
        $steps = abs($pos - $i);
        $fuel += ($steps+1) * $steps / 2;
    }
//    echo 'move to pos ' . $i . ' needs ' . $fuel . ' fuel' . PHP_EOL;
    if ($fuel < $minfuel) {
        $minfuel = $fuel;
        $bestpos = $i;
    }
}
echo 'minimum fuel needed to get to pos ' . $bestpos . ': ' . $minfuel . PHP_EOL;
