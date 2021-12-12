<?php

$input = file_get_contents(__DIR__ . '/input.txt');

$incr = 0;
$lastVal = 0;
foreach (explode("\n", $input) as $val) {
    $curr = intval($val);
    if ($lastVal > 0 && $curr > $lastVal) {
        $incr++;
    }
    $lastVal = $curr;
}
echo $incr . ' increments' . PHP_EOL;
// 1451 increments
