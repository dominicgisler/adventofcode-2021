<?php

$input = file_get_contents(__DIR__ . '/input.txt');
//$input = '6,10
//0,14
//9,10
//0,3
//10,4
//4,11
//6,0
//6,12
//4,1
//0,13
//10,12
//3,4
//3,0
//8,4
//1,10
//2,14
//8,10
//9,0
//
//fold along y=7
//fold along x=5
//';

$maxX = 0;
$maxY = 0;
$dataTmp = [];
$folds = [];
foreach (explode("\n", $input) as $line) {
    if (!empty($line)) {
        if (strpos($line, 'fold along') !== false) {
            $line = str_replace('fold along ', '', $line);
            $fold = explode("=", $line);
            if (!isset($folds[$fold[0]])) {
                $folds[$fold[0]] = [];
            }
            $folds[$fold[0]][] = $fold[1];
        } else {
            $coords = explode(",", $line);
            $dataTmp[$coords[1]][$coords[0]] = 1;
            if ($coords[0] > $maxX) $maxX = $coords[0];
            if ($coords[1] > $maxY) $maxY = $coords[1];
        }
    }
}
$data = [];
for ($x = 0; $x <= $maxX; $x++) {
    for ($y = 0; $y <= $maxY; $y++) {
        if (isset($dataTmp[$y][$x])) {
            $data[$y][$x] = $dataTmp[$y][$x];
        } else {
            $data[$y][$x] = 0;
        }
    }
}

$done = false;
foreach ($folds as $c => $fold) {
    foreach ($fold as $pos) {
        if ($done) {
            continue;
        }
//        echo 'fold ' . $c . ':' . $pos . PHP_EOL;
        if ($c == 'x') {
            for ($x = $pos + 1; $x <= $maxX; $x++) {
                foreach ($data as $y => $line) {
                    if ($line[$x] == 1) {
                        $move = $x - $pos;
                        $data[$y][$x - 2*$move] = 1;
                        $data[$y][$x] = 0;
                    }
                }
            }
//            $done = true;
        } else {
            for ($y = $pos + 1; $y <= $maxY; $y++) {
                foreach ($data[$y] as $x => $pos2) {
                    if ($pos2 == 1) {
                        $move = $y - $pos;
                        $data[$y - 2*$move][$x] = 1;
                        $data[$y][$x] = 0;
                    }
                }
            }
//            $done = true;
        }
    }
}

$visible = 0;
foreach ($data as $y => $line) {
    foreach ($line as $x => $pos) {
        if ($pos == 1) {
            echo '#';
            $visible++;
        } else if ($x <= 40 && $y <= 5) {
            echo '.';
        }
    }
    if ($y <= 5) {
        echo PHP_EOL;
    }
}
// JZGUAPRB
