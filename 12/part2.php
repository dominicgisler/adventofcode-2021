<?php

$input = file_get_contents(__DIR__ . '/input.txt');
//$input = 'start-A
//start-b
//A-c
//A-b
//b-d
//A-end
//b-end
//';

$conn = [];
foreach (explode("\n", $input) as $line) {
    if (!empty($line)) {
        $path = explode('-', $line);
        $from = $path[0];
        $to = $path[1];

        if (!array_key_exists($from, $conn)) {
            $conn[$from] = [];
        }
        if (!array_key_exists($to, $conn)) {
            $conn[$to] = [];
        }
        $conn[$from][] = $to;
        $conn[$to][] = $from;
    }
}

$paths = [];

function findPath($conn, $start, $last = [], $twice = 0, &$paths = []) {
    if (!isset($conn[$start])) {
        return null;
    }
    if (sizeof($last) == 0) {
        $last[] = $start;
    }
    foreach ($conn[$start] as $way) {
        $curr = $last;
        if ($way == strtoupper($way) || !in_array($way, $curr)) {
            $curr[] = $way;
            if ($way != 'end') {
                findPath($conn, $way, $curr, $twice, $paths);
            }
        } else if ($way == strtolower($way) && in_array($way, $curr) && !in_array($way, ['start', 'end']) && $twice == 0) {
            findPath($conn, $way, $curr, 1, $paths);
        }
        if ($curr[sizeof($curr)-1] == 'end') {
            $paths[] = $curr;
        }
    }
    return $paths;
}

$paths = findPath($conn, 'start');
//foreach ($paths as $path) {
//    echo join(',', $path) . PHP_EOL;
//}
echo 'count: ' . sizeof($paths) . PHP_EOL;
