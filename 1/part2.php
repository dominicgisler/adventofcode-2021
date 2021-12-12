<?php

$input = file_get_contents(__DIR__ . '/input.txt');

$incr = 0;
$lastVal = 0;
$arr = explode("\n", $input);
for ($i = 0; $i < sizeof($arr); $i++) {
    if (isset($arr[$i]) && isset($arr[$i + 1]) && isset($arr[$i + 2])) {
        $curr = intval($arr[$i]) + intval($arr[$i + 1]) + intval($arr[$i + 2]);
        if ($lastVal > 0 && $curr > $lastVal) {
            $incr++;
        }
        $lastVal = $curr;
    }
}
echo $incr . ' increments' . PHP_EOL;
// 1395 increments
