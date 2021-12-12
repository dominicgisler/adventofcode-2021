<?php

$input = file_get_contents(__DIR__ . '/input.txt');

$pos = 0;
$depth = 0;
$aim = 0;
foreach (explode("\n", $input) as $val) {
    $val = explode(' ', $val);
    switch ($val[0]) {
        case 'forward':
            $pos += intval($val[1]);
            if ($aim != 0) {
                $depth += intval($val[1]) * $aim;
            }
            break;
        case 'down':
            $aim += intval($val[1]);
            break;
        case 'up':
            $aim -= intval($val[1]);
            break;
    }
}
echo 'pos: ' . $pos . ', depth: ' . $depth . ', mult: ' . ($pos * $depth) . PHP_EOL;
// pos: 1931, depth: 894762, mult: 1727785422
