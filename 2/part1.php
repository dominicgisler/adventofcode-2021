<?php

$input = file_get_contents(__DIR__ . '/input.txt');

$pos = 0;
$depth = 0;
foreach (explode("\n", $input) as $val) {
    $val = explode(' ', $val);
    switch ($val[0]) {
        case 'forward':
            $pos += intval($val[1]);
            break;
        case 'down':
            $depth += intval($val[1]);
            break;
        case 'up':
            $depth -= intval($val[1]);
            break;
    }
}
echo 'pos: ' . $pos . ', depth: ' . $depth . ', mult: ' . ($pos * $depth) . PHP_EOL;
// pos: 1931, depth: 953, mult: 1840243
