<?php

/*
--- Part Two ---
After reviewing the available paths, you realize you might have time to visit a single small cave twice. Specifically, big caves can be visited any number of times, a single small cave can be visited at most twice, and the remaining small caves can be visited at most once. However, the caves named start and end can only be visited exactly once each: once you leave the start cave, you may not return to it, and once you reach the end cave, the path must end immediately.

Now, the 36 possible paths through the first example above are:

start,A,b,A,b,A,c,A,end
start,A,b,A,b,A,end
start,A,b,A,b,end
start,A,b,A,c,A,b,A,end
start,A,b,A,c,A,b,end
start,A,b,A,c,A,c,A,end
start,A,b,A,c,A,end
start,A,b,A,end
start,A,b,d,b,A,c,A,end
start,A,b,d,b,A,end
start,A,b,d,b,end
start,A,b,end
start,A,c,A,b,A,b,A,end
start,A,c,A,b,A,b,end
start,A,c,A,b,A,c,A,end
start,A,c,A,b,A,end
start,A,c,A,b,d,b,A,end
start,A,c,A,b,d,b,end
start,A,c,A,b,end
start,A,c,A,c,A,b,A,end
start,A,c,A,c,A,b,end
start,A,c,A,c,A,end
start,A,c,A,end
start,A,end
start,b,A,b,A,c,A,end
start,b,A,b,A,end
start,b,A,b,end
start,b,A,c,A,b,A,end
start,b,A,c,A,b,end
start,b,A,c,A,c,A,end
start,b,A,c,A,end
start,b,A,end
start,b,d,b,A,c,A,end
start,b,d,b,A,end
start,b,d,b,end
start,b,end
The slightly larger example above now has 103 paths through it, and the even larger example now has 3509 paths through it.

Given these new rules, how many paths through this cave system are there?
*/

$input = file_get_contents('12.txt');
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
foreach ($paths as $path) {
    echo join(',', $path) . PHP_EOL;
}
echo 'count: ' . sizeof($paths) . PHP_EOL;
