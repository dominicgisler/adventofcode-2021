<?php

/*

*/

$input = file_get_contents(__DIR__ . '/input.txt');
//$input = '[({(<(())[]>[[{[]{<()<>>
//[(()[<>])]({[<{<<[]>>(
//{([(<{}[<>[]}>{[]{[(<()>
//(((({<>}<{<{<>}{[]{[]{}
//[[<[([]))<([[{}[[()]]]
//[{[{({}]{}}([{[{{{}}([]
//{<[[]]>}<{[{[{[]{()[[[]
//[<(<(<(<{}))><([]([]()
//<{([([[(<>()){}]>(<<{{
//<{([{{}}[<[[[<>{}]]]>[]]
//';

function chunk($line, &$score, &$pos = 0) {
    $scores = [')' => 1, ']' => 2, '}' => 3, '>' => 4];
    $validOpeners = ['(', '[', '{', '<'];
    $validClosers = [')', ']', '}', '>'];
//    echo $line[$pos];

    while (isset($line[$pos]) && in_array($line[$pos], $validOpeners)) {
        $expCloser = $validClosers[array_search($line[$pos], $validOpeners)];
//        echo $line[$pos];
        $pos++;
        while (isset($line[$pos]) && in_array($line[$pos], $validOpeners)) {
            chunk($line, $score, $pos);
//            echo isset($line[$pos]) ? $line[$pos] : '';
            $pos++;
        }
        if (!isset($line[$pos]) && $pos < 10000) {
            if ($score == 0) {
//                echo ' adding ';
            }
//            echo $expCloser;
            $score = $score * 5 + $scores[$expCloser];
//            echo 'new score: ' . $score . ' - ';
        } else {
            if (isset($line[$pos]) && $line[$pos] != $expCloser) {
//                echo ' expected ' . $expCloser . ', but found ' . $line[$pos] . ' instead.';
//                $score += $scores[$line[$pos]];
                $pos = 10000;
            } else {
//                $pos++;
//                chunk($line, $score, $pos);
            }
        }
    }
}

$lines = [];
$scores = [];
foreach (explode("\n", $input) as $line) {
    if (!empty($line)) {
        $score = 0;
        $pos = 0;
//        echo $line;
        $line = str_split($line);
//        echo PHP_EOL;
        while ($pos < sizeof($line)) {
            chunk($line, $score, $pos);
            $pos++;
        }
        if ($score > 0) {
            $scores[] = $score;
        }
//        echo PHP_EOL;
    }
}
sort($scores);
//print_r($scores);
echo 'middle score: ' . $scores[(sizeof($scores)-1)/2] . PHP_EOL;
