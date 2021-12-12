<?php

$input = file_get_contents(__DIR__ . '/input.txt');

$boards = [];
$lines = explode("\n", $input);
$draws = explode(',', $lines[0]);
unset($lines[0]);

$i = 0;
foreach ($lines as $line) {
    if ($line == '') {
        $i++;
        $boards[$i] = [];
    } else {
        $bline = [];
        foreach (explode(' ', $line) as $num) {
            if ($num != '') {
                $bline[] = [
                    'num' => $num,
                    'marked' => false
                ];
            }
        }
        $boards[$i][] = $bline;
    }
}

$wins = [];
foreach ($draws as $draw) {
    foreach ($boards as &$board) {
        foreach ($board as &$line) {
            foreach ($line as &$num) {
                if ($num['num'] == $draw) {
                    $num['marked'] = true;
                }
            }
        }
    }
    unset($board);
    unset($line);
    unset($num);
    foreach ($boards as $key => $board) {
        $found = false;
        foreach ($board as $line) {
            $cnt = 0;
            foreach ($line as $num) {
                if ($num['marked']) {
                    $cnt++;
                }
            }
            if ($cnt >= 5) {
                $found = true;
            }
        }
        for ($i = 0; $i < 5; $i++) {
            $cnt = 0;
            foreach ($board as $line) {
                if ($line[$i]['marked']) {
                    $cnt++;
                }
            }
            if ($cnt >= 5) {
                $found = true;
            }
        }
        if ($found) {
            $sum = 0;
            foreach ($board as $line) {
                foreach ($line as $num) {
                    if (!$num['marked']) {
                        $sum += $num['num'];
                    }
                }
            }
            $wins[$key] = true;
            if (sizeof($wins) >= sizeof($boards)) {
                $score = $sum * $draw;
                echo $sum . ' * ' . $draw . ' = ' . $score . PHP_EOL;
                return;
            }
        }
    }
}
