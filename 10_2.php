<?php

/*
--- Part Two ---
Now, discard the corrupted lines. The remaining lines are incomplete.

Incomplete lines don't have any incorrect characters - instead, they're missing some closing characters at the end of the line. To repair the navigation subsystem, you just need to figure out the sequence of closing characters that complete all open chunks in the line.

You can only use closing characters (), ], }, or >), and you must add them in the correct order so that only legal pairs are formed and all chunks end up closed.

In the example above, there are five incomplete lines:

[({(<(())[]>[[{[]{<()<>> - Complete by adding }}]])})].
[(()[<>])]({[<{<<[]>>( - Complete by adding )}>]}).
(((({<>}<{<{<>}{[]{[]{} - Complete by adding }}>}>)))).
{<[[]]>}<{[{[{[]{()[[[] - Complete by adding ]]}}]}]}>.
<{([{{}}[<[[[<>{}]]]>[]] - Complete by adding ])}>.
Did you know that autocomplete tools also have contests? It's true! The score is determined by considering the completion string character-by-character. Start with a total score of 0. Then, for each character, multiply the total score by 5 and then increase the total score by the point value given for the character in the following table:

): 1 point.
]: 2 points.
}: 3 points.
>: 4 points.
So, the last completion string above - ])}> - would be scored as follows:

Start with a total score of 0.
Multiply the total score by 5 to get 0, then add the value of ] (2) to get a new total score of 2.
Multiply the total score by 5 to get 10, then add the value of ) (1) to get a new total score of 11.
Multiply the total score by 5 to get 55, then add the value of } (3) to get a new total score of 58.
Multiply the total score by 5 to get 290, then add the value of > (4) to get a new total score of 294.
The five lines' completion strings have total scores as follows:

}}]])})] - 288957 total points.
)}>]}) - 5566 total points.
}}>}>)))) - 1480781 total points.
]]}}]}]}> - 995444 total points.
])}> - 294 total points.
Autocomplete tools are an odd bunch: the winner is found by sorting all of the scores and then taking the middle score. (There will always be an odd number of scores to consider.) In this example, the middle score is 288957 because there are the same number of scores smaller and larger than it.

Find the completion string for each incomplete line, score the completion strings, and sort the scores. What is the middle score?
*/

$input = file_get_contents('10.txt');
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
    echo $line[$pos];

    while (isset($line[$pos]) && in_array($line[$pos], $validOpeners)) {
        $expCloser = $validClosers[array_search($line[$pos], $validOpeners)];
//        echo $line[$pos];
        $pos++;
        while (isset($line[$pos]) && in_array($line[$pos], $validOpeners)) {
            chunk($line, $score, $pos);
            echo isset($line[$pos]) ? $line[$pos] : '';
            $pos++;
        }
        if (!isset($line[$pos]) && $pos < 10000) {
            if ($score == 0) {
                echo ' adding ';
            }
            echo $expCloser;
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
        echo $line;
        $line = str_split($line);
        echo PHP_EOL;
        while ($pos < sizeof($line)) {
            chunk($line, $score, $pos);
            $pos++;
        }
        if ($score > 0) {
            $scores[] = $score;
        }
        echo PHP_EOL;
    }
}
sort($scores);
print_r($scores);
echo 'middle score: ' . $scores[(sizeof($scores)-1)/2] . PHP_EOL;
