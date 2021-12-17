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

$cntVelos = 0;
$bestVelocity = [];
$maxY = 0;
for ($x = -$target['x'][0]-1; $x <= $target['x'][1]; $x++) {
    for ($y = $target['y'][0]-1; $y <= -$target['y'][0]; $y++) {
        $highestY = 0;
        $pos = ['x' => 0, 'y' => 0];
        $velocity = ['x' => $x, 'y' => $y];
        while ($velocity['y'] > 0 || $pos['y'] >= $target['y'][0]) {
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
                }
                $cntVelos++;
                break;
            }
        }
    }
}
echo $bestVelocity['x'] . ', ' . $bestVelocity['y'] . ' => max y: ' . $maxY . PHP_EOL;
echo 'count possible velocities: ' . $cntVelos . PHP_EOL;
