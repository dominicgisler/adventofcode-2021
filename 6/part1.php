<?php

$input = file_get_contents(__DIR__ . '/input.txt');
//$input = '3,4,3,1,2';

$fishs = explode(',', $input);
//echo join(',', $fishs);

$daylimit = 80;
const DEBUG = false;

for ($i = 0; $i < $daylimit; $i++) {
    foreach ($fishs as &$fish) {
        if ($fish <= 0) {
            $fish = 6;
            $fishs[] = 9;
        } else {
            $fish -= 1;
        }
    }
    if (DEBUG) {
        echo 'After ' . ($i + 1) . ' days: ' . join(',', $fishs) . PHP_EOL;
    }
}
//echo 'before ' .  $before . ', added ' . $tst . ' => ' . ($before + $tst) . PHP_EOL;
echo 'Count after ' . $i . ' days: ' . sizeof($fishs) . PHP_EOL;
// 365862
