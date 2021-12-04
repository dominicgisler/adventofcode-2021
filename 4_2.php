<?php

/*
--- Part Two ---
On the other hand, it might be wise to try a different strategy: let the giant squid win.

You aren't sure how many bingo boards a giant squid could play at once, so rather than waste time counting its arms, the safe thing to do is to figure out which board will win last and choose that one. That way, no matter which boards it picks, it will win for sure.

In the above example, the second board is the last to win, which happens after 13 is eventually called and its middle column is completely marked. If you were to keep playing until this point, the second board would have a sum of unmarked numbers equal to 148 for a final score of 148 * 13 = 1924.

Figure out which board will win last. Once it wins, what would its final score be?
*/

$input = file_get_contents('4.txt');

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
