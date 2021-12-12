<?php

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
    $scores = [')' => 3, ']' => 57, '}' => 1197, '>' => 25137];
    $validOpeners = ['(', '[', '{', '<'];
    $validClosers = [')', ']', '}', '>'];

    if (in_array($line[$pos], $validOpeners)) {
        $expCloser = $validClosers[array_search($line[$pos], $validOpeners)];
        $pos++;
        while (isset($line[$pos]) && in_array($line[$pos], $validOpeners)) {
            chunk($line, $score, $pos);
            $pos++;
        }
        if (!isset($line[$pos])) {
//            echo 'incomplete' . PHP_EOL;
        } else {
            if ($line[$pos] != $expCloser) {
//                echo ' expected ' . $expCloser . ', but found ' . $line[$pos] . ' instead.';
                $score += $scores[$line[$pos]];
                $pos = 10000;
            }
        }
    }
}

$lines = [];
$score = 0;
foreach (explode("\n", $input) as $line) {
    if (!empty($line)) {
//        echo $line;
        $line = str_split($line);
        chunk($line, $score);
//        echo PHP_EOL;
    }
}
echo 'score: ' . $score . PHP_EOL;
