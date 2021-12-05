<?php

/*
Unfortunately, considering only horizontal and vertical lines doesn't give you the full picture; you need to also consider diagonal lines.

Because of the limits of the hydrothermal vent mapping system, the lines in your list will only ever be horizontal, vertical, or a diagonal line at exactly 45 degrees. In other words:

An entry like 1,1 -> 3,3 covers points 1,1, 2,2, and 3,3.
An entry like 9,7 -> 7,9 covers points 9,7, 8,8, and 7,9.
Considering all lines from the above example would now produce the following diagram:

1.1....11.
.111...2..
..2.1.111.
...1.2.2..
.112313211
...1.2....
..1...1...
.1.....1..
1.......1.
222111....
You still need to determine the number of points where at least two lines overlap. In the above example, this is still anywhere in the diagram with a 2 or larger - now a total of 12 points.

Consider all of the lines. At how many points do at least two lines overlap?
*/

$input = file_get_contents('5.txt');
//$input = '0,9 -> 5,9
//8,0 -> 0,8
//9,4 -> 3,4
//2,2 -> 2,1
//7,0 -> 7,4
//6,4 -> 2,0
//0,9 -> 2,9
//3,4 -> 1,4
//0,0 -> 8,8
//5,5 -> 8,2';

$data = [];
for ($i = 0; $i <= 1000; $i++) {
    $data[$i] = [];
    for ($j = 0; $j <= 1000; $j++) {
        $data[$i][] = 0;
    }
}

foreach (explode("\n", $input) as $line) {
    if (empty($line)) {
        continue;
    }
    $pos = explode(' -> ', $line);
    $pos1 = explode(',', $pos[0]);
    $pos2 = explode(',', $pos[1]);
    if ($pos1[0] == $pos2[0]) {
        if ($pos1[1] < $pos2[1]) {
//            echo join(',', $pos1) . ' => ' . join(',', $pos2) . PHP_EOL;
            for ($i = $pos1[1]; $i <= $pos2[1]; $i++) {
                $data[$i][$pos1[0]]++;
            }
        } else {
//            echo join(',', $pos1) . ' => ' . join(',', $pos2) . PHP_EOL;
            for ($i = $pos2[1]; $i <= $pos1[1]; $i++) {
                $data[$i][$pos1[0]]++;
            }
        }
    } else if ($pos1[1] == $pos2[1]) {
        if ($pos1[0] < $pos2[0]) {
//            echo join(',', $pos1) . ' => ' . join(',', $pos2) . PHP_EOL;
            for ($i = $pos1[0]; $i <= $pos2[0]; $i++) {
                $data[$pos1[1]][$i]++;
            }
        } else {
//            echo join(',', $pos1) . ' => ' . join(',', $pos2) . PHP_EOL;
            for ($i = $pos2[0]; $i <= $pos1[0]; $i++) {
                $data[$pos1[1]][$i]++;
            }
        }
    } else {
        if ($pos1[0] > $pos2[0] && $pos1[1] > $pos2[1]) {
//            echo join(',', $pos1) . ' => ' . join(',', $pos2) . PHP_EOL;
            $j = $pos2[1];
            for ($i = $pos2[0]; $i <= $pos1[0]; $i++) {
                $data[$j][$i]++;
                $j++;
            }
        } else if ($pos1[0] > $pos2[0] && $pos1[1] < $pos2[1]) {
//            echo join(',', $pos1) . ' => ' . join(',', $pos2) . PHP_EOL;
            $j = $pos2[1];
            for ($i = $pos2[0]; $i <= $pos1[0]; $i++) {
                $data[$j][$i]++;
                $j--;
            }
        } else if ($pos1[0] < $pos2[0] && $pos1[1] < $pos2[1]) {
//            echo join(',', $pos1) . ' => ' . join(',', $pos2) . PHP_EOL;
            $j = $pos1[1];
            for ($i = $pos1[0]; $i <= $pos2[0]; $i++) {
                $data[$i][$j]++;
                $j++;
            }
        } else if ($pos1[0] < $pos2[0] && $pos1[1] > $pos2[1]) {
//            echo join(',', $pos1) . ' => ' . join(',', $pos2) . PHP_EOL;
            $j = $pos1[1];
            for ($i = $pos1[0]; $i <= $pos2[0]; $i++) {
                $data[$j][$i]++;
                $j--;
            }
        }
    }
}

$cnt = 0;
foreach ($data as $line) {
    foreach ($line as $point) {
        if ($point >= 2) {
            $cnt++;
        }
//        echo $point ?: '.';
    }
//    echo PHP_EOL;
}
echo 'multiple overlaps: ' . $cnt . ' times' . PHP_EOL;
// multiple overlaps: 17623 times
