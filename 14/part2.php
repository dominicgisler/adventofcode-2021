<?php

$input = file_get_contents(__DIR__ . '/input.txt');
$input = 'NNCB

CH -> B
HH -> N
CB -> H
NH -> C
HB -> C
HC -> B
HN -> C
NN -> C
BH -> H
NC -> B
NB -> B
BN -> B
BB -> N
BC -> B
CC -> N
CN -> C
';

$steps = 40;
$polymer = '';
$rules = [];
$counts = [];
foreach (explode("\n", $input) as $line) {
    if (!empty($line)) {
        if (empty($polymer)) {
            $polymer = $line;
            foreach (str_split($polymer) as $letter) {
                if (!isset($counts[$letter])) {
                    $counts[$letter] = 0;
                }
                $counts[$letter]++;
            }
        } else {
            $rule = explode(" -> ", $line);
            $rules[$rule[0]] = $rule[1];
        }
    }
}

for ($i = 0; $i < $steps; $i++) {
    $parts = str_split($polymer);
    for ($j = 0; $j < (sizeof($parts)-1); $j++) {
        if (!isset($counts[$rules[$parts[$j] . $parts[$j+1]]])) {
            $counts[$rules[$parts[$j] . $parts[$j+1]]] = 0;
        }
        $counts[$rules[$parts[$j] . $parts[$j+1]]]++;
    }
}
print_r($counts);
exit;

sort($counts);

echo $counts[sizeof($counts)-1] . ' - ' . $counts[0] . ' = ' . ($counts[sizeof($counts)-1] - $counts[0]) . PHP_EOL;
