<?php

$input = file_get_contents(__DIR__ . '/input.txt');
//$input = '5483143223
//2745854711
//5264556173
//6141336146
//6357385478
//4167524645
//2176841721
//6882881134
//4846848554
//5283751526
//';

$data = [];
foreach (explode("\n", $input) as $x => $line) {
    if (empty($line)) {
        continue;
    }
    foreach (str_split($line) as $y => $pos) {
        $data[$x][$y] = $pos;
    }
}

$steps = 500;
$flashes = 0;
for ($i = 0; $i < $steps; $i++) {
    $stepFlashes = 0;
    $flashesBefore = $flashes;
    $hasChange = true;
    $flashed = [];
    foreach ($data as $x => $arr) {
        foreach ($arr as $y => $pos) {
            $data[$x][$y] += 1;
        }
    }
    while ($hasChange) {
        foreach ($data as $x => $arr) {
            foreach ($arr as $y => $pos) {
                if ($pos > 9 && !in_array($x . '_' . $y, $flashed)) {
                    $flashes++;
                    $stepFlashes++;
                    if (isset($data[$x - 1][$y - 1])) $data[$x - 1][$y - 1] += 1;
                    if (isset($data[$x][$y - 1])) $data[$x][$y - 1] += 1;
                    if (isset($data[$x + 1][$y - 1])) $data[$x + 1][$y - 1] += 1;
                    if (isset($data[$x - 1][$y])) $data[$x - 1][$y] += 1;
                    if (isset($data[$x + 1][$y])) $data[$x + 1][$y] += 1;
                    if (isset($data[$x - 1][$y + 1])) $data[$x - 1][$y + 1] += 1;
                    if (isset($data[$x][$y + 1])) $data[$x][$y + 1] += 1;
                    if (isset($data[$x + 1][$y + 1])) $data[$x + 1][$y + 1] += 1;
                    $flashed[] = $x . '_' . $y;
                }
            }
        }
        $hasChange = $flashes > $flashesBefore;
        $flashesBefore = $flashes;
    }
    foreach ($data as $x => $arr) {
        foreach ($arr as $y => $pos) {
            if ($pos > 9) {
                $data[$x][$y] = 0;
            }
        }
    }
    if ($stepFlashes == 100) {
        echo 'all flashed in step ' . ($i+1) . PHP_EOL;
//        foreach ($data as $y => $arr) {
//            foreach ($arr as $x => $pos) {
//                echo $pos;
//            }
//            echo PHP_EOL;
//        }
        return;
    }
}

//foreach ($data as $y => $arr) {
//    foreach ($arr as $x => $pos) {
//        echo $pos;
//    }
//    echo PHP_EOL;
//}
echo 'flashes: ' . $flashes . PHP_EOL;
