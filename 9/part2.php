<?php

$input = file_get_contents(__DIR__ . '/input.txt');
//$input = '2199943210
//3987894921
//9856789892
//8767896789
//9899965678
//';

$data = [];
foreach (explode("\n", $input) as $y => $line) {
    if (empty($line)) {
        continue;
    }
    foreach (str_split($line) as $x => $pos) {
        $data[$x][$y] = $pos;
    }
}

$lows = [];
$basins = [];
$risk = 0;
foreach ($data as $x => $line) {
    foreach ($line as $y => $pos) {
        if (isset($data[$x][$y-1]) && $data[$x][$y-1] <= $pos) continue;
        if (isset($data[$x][$y+1]) && $data[$x][$y+1] <= $pos) continue;
        if (isset($data[$x-1][$y]) && $data[$x-1][$y] <= $pos) continue;
        if (isset($data[$x+1][$y]) && $data[$x+1][$y] <= $pos) continue;

        $lows[] = $pos;
        $basins[] = countNeighbours($data, $x, $y);
        $risk += $pos + 1;
    }
}

$sizemult = 1;
$cnt = 0;
rsort($basins);
foreach ($basins as $basin) {
    if ($cnt >= 3) {
        continue;
    }
    $sizemult *= $basin;
    $cnt++;
}
//echo 'risk: ' . $risk . PHP_EOL;
// risk: 530
echo 'mult: ' . $sizemult . PHP_EOL;
// mult: 1019494

function countNeighbours($data, $x, $y, &$done = []) {
    $pos = $data[$x][$y];
    if ($pos >= 9 || isset($done[$x . '_' . $y])) {
        return 0;
    }
    $done[$x . '_' . $y] = true;
    $cnt = 1;
    if (isset($data[$x][$y-1]) && $data[$x][$y-1] > $pos) $cnt += countNeighbours($data, $x, $y-1, $done);
    if (isset($data[$x][$y+1]) && $data[$x][$y+1] > $pos) $cnt += countNeighbours($data, $x, $y+1, $done);
    if (isset($data[$x-1][$y]) && $data[$x-1][$y] > $pos) $cnt += countNeighbours($data, $x-1, $y, $done);
    if (isset($data[$x+1][$y]) && $data[$x+1][$y] > $pos) $cnt += countNeighbours($data, $x+1, $y, $done);
    return $cnt;
}
