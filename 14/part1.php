<?php

$input = file_get_contents(__DIR__ . '/input.txt');
//$input = 'NNCB
//
//CH -> B
//HH -> N
//CB -> H
//NH -> C
//HB -> C
//HC -> B
//HN -> C
//NN -> C
//BH -> H
//NC -> B
//NB -> B
//BN -> B
//BB -> N
//BC -> B
//CC -> N
//CN -> C
//';

$steps = 10;
$polymer = '';
$rules = [];
foreach (explode("\n", $input) as $line) {
    if (!empty($line)) {
        if (empty($polymer)) {
            $polymer = $line;
        } else {
            $rule = explode(" -> ", $line);
            $rules[$rule[0]] = $rule[1];
        }
    }
}

for ($i = 0; $i < $steps; $i++) {
    $parts = str_split($polymer);
    $newPolymer = '';
    for ($j = 0; $j < (sizeof($parts)-1); $j++) {
        $newPolymer .= $parts[$j] . $rules[$parts[$j] . $parts[$j+1]];
    }
    $newPolymer .= $parts[sizeof($parts)-1];
    $polymer = $newPolymer;
}

$counts = [];
foreach (str_split($polymer) as $letter) {
    if (!isset($counts[$letter])) {
        $counts[$letter] = 0;
    }
    $counts[$letter]++;
}
sort($counts);

echo $counts[sizeof($counts)-1] . ' - ' . $counts[0] . ' = ' . ($counts[sizeof($counts)-1] - $counts[0]) . PHP_EOL;
