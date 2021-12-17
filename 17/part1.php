<?php

$input = file_get_contents(__DIR__ . '/input.txt');
//$input = 'target area: x=20..30, y=-10..-5
//';

$target = [];
foreach (explode("\n", $input) as $line) {
    if (!empty($line)) {
        $data = explode(',', explode(':', $line)[1]);
        $x = trim($data[0]);
        $y = trim($data[1]);
        $target['x'] = explode('..', str_replace('x=', '', $x));
        $target['y'] = explode('..', str_replace('y=', '', $y));
    }
}

$bestVelocity = [];
$maxY = 0;
for ($x = 0; $x < 1000; $x++) {
    for ($y = 0; $y < 1000; $y++) {
        $highestY = 0;
        $pos = ['x' => 0, 'y' => 0];
        $velocity = ['x' => $x, 'y' => $y];
        for ($i = 0; $i < 1000; $i++) {
            $pos['x'] += $velocity['x'];
            $pos['y'] += $velocity['y'];
            if ($velocity['x'] != 0) {
                $velocity['x'] -= ($velocity['x'] / abs($velocity['x']));
            }
            $velocity['y'] -= 1;
            if ($pos['y'] > $highestY) {
                $highestY = $pos['y'];
            }

            if ($pos['x'] >= $target['x'][0] && $pos['x'] <= $target['x'][1] &&
                $pos['y'] >= $target['y'][0] && $pos['y'] <= $target['y'][1]) {
                if ($highestY > $maxY) {
                    $bestVelocity = ['x' => $x, 'y' => $y];
                    $maxY = $highestY;
                    echo $x . ', ' . $y . ': after step ' . $i . ' -> ' . $maxY . PHP_EOL;
                }
                $i = 1000;
            }
        }
    }
}
echo $bestVelocity['x'] . ', ' . $bestVelocity['y'] . ' => max y: ' . $maxY . PHP_EOL;
