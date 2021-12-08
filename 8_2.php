<?php

/*
--- Part Two ---
Through a little deduction, you should now be able to determine the remaining digits. Consider again the first example above:

acedgfb cdfbe gcdfa fbcad dab cefabd cdfgeb eafb cagedb ab |
cdfeb fcadb cdfeb cdbaf
After some careful analysis, the mapping between signal wires and segments only make sense in the following configuration:

 dddd
e    a
e    a
 ffff
g    b
g    b
 cccc
So, the unique signal patterns would correspond to the following digits:

acedgfb: 8
cdfbe: 5
gcdfa: 2
fbcad: 3
dab: 7
cefabd: 9
cdfgeb: 6
eafb: 4
cagedb: 0
ab: 1
Then, the four digits of the output value can be decoded:

cdfeb: 5
fcadb: 3
cdfeb: 5
cdbaf: 3
Therefore, the output value for this entry is 5353.

Following this same process for each entry in the second, larger example above, the output value of each entry can be determined:

fdgacbe cefdb cefbgd gcbe: 8394
fcgedb cgb dgebacf gc: 9781
cg cg fdcagb cbg: 1197
efabcd cedba gadfec cb: 9361
gecf egdcabf bgf bfgea: 4873
gebdcfa ecba ca fadegcb: 8418
cefg dcbef fcge gbcadfe: 4548
ed bcgafe cdgba cbgef: 1625
gbdfcae bgc cg cgb: 8717
fgae cfgab fg bagce: 4315
Adding all of the output values in this larger example produces 61229.

For each entry, determine all of the wire/segment connections and decode the four-digit output values. What do you get if you add up all of the output values?
*/

$input = file_get_contents('8.txt');
//$input = 'acedgfb cdfbe gcdfa fbcad dab cefabd cdfgeb eafb cagedb ab | cdfeb fcadb cdfeb cdbaf';
//$input = 'be cfbegad cbdgef fgaecd cgeb fdcge agebfd fecdb fabcd edb | fdgacbe cefdb cefbgd gcbe
//edbfga begcd cbg gc gcadebf fbgde acbgfd abcde gfcbed gfec | fcgedb cgb dgebacf gc
//fgaebd cg bdaec gdafb agbcfd gdcbef bgcad gfac gcb cdgabef | cg cg fdcagb cbg
//fbegcd cbd adcefb dageb afcb bc aefdc ecdab fgdeca fcdbega | efabcd cedba gadfec cb
//aecbfdg fbg gf bafeg dbefa fcge gcbea fcaegb dgceab fcbdga | gecf egdcabf bgf bfgea
//fgeab ca afcebg bdacfeg cfaedg gcfdb baec bfadeg bafgc acf | gebdcfa ecba ca fadegcb
//dbcfg fgd bdegcaf fgec aegbdf ecdfab fbedc dacgb gdcebf gf | cefg dcbef fcge gbcadfe
//bdfegc cbegaf gecbf dfcage bdacg ed bedf ced adcbefg gebcd | ed bcgafe cdgba cbgef
//egadfb cdbfeg cegd fecab cgb gbdefca cg fgcdab egfdb bfceg | gbdfcae bgc cg cgb
//gcafb gcf dcaebfg ecagb gf abcdeg gaef cafbge fdbac fegbdc | fgae cfgab fg bagce';

$sum = 0;
foreach (explode("\n", $input) as $line) {
    if (empty($line)) {
        continue;
    }

    $nums = [
        0 => '',
        1 => '',
        2 => '',
        3 => '',
        4 => '',
        5 => '',
        6 => '',
        7 => '',
        8 => '',
        9 => ''
    ];

    $numinput = [];
    $input = explode(" | ", $line)[0];
    foreach (explode(" ", $input) as $num) {
        $prts = str_split($num);
        sort($prts);
        $numinput[] = implode($prts);
    }

    foreach ($numinput as $num) {
        switch (strlen($num)) {
            case 2:
                $nums[1] = $num;
                break;
            case 4:
                $nums[4] = $num;
                break;
            case 3:
                $nums[7] = $num;
                break;
            case 7:
                $nums[8] = $num;
                break;
        }
    }
    foreach ($numinput as $num) {
        if (!in_array($num, $nums)) {
            $contains = true;
            foreach (str_split($nums[1]) as $onepart) {
                if (strpos($num, $onepart) === false) {
                    $contains = false;
                }
            }
            if ($contains) {
                if (strlen($num) == 5) {
                    $nums[3] = $num;
                }
                $fourmatches = 0;
                foreach (str_split($num) as $numpart) {
                    foreach (str_split($nums[4]) as $fourpart) {
                        if ($numpart == $fourpart) {
                            $fourmatches++;
                        }
                    }
                }
                if (strlen($num) == 6) {
                    if ($fourmatches == 3) {
                        $nums[0] = $num;
                    } else if ($fourmatches == 4) {
                        $nums[9] = $num;
                    }
                }
            }
        }
    }
    foreach ($numinput as $num) {
        if (!in_array($num, $nums)) {
            $eightmatches = 0;
            foreach (str_split($num) as $numpart) {
                foreach (str_split($nums[8]) as $eightpart) {
                    if ($numpart == $eightpart) {
                        $eightmatches++;
                    }
                }
            }
            if ($eightmatches == 6) {
                $nums[6] = $num;
            }
        }
    }
    foreach ($numinput as $num) {
        if (!in_array($num, $nums)) {
            $sixmatches = 0;
            foreach (str_split($num) as $numpart) {
                foreach (str_split($nums[6]) as $sixpart) {
                    if ($numpart == $sixpart) {
                        $sixmatches++;
                    }
                }
            }
            if ($sixmatches == 5) {
                $nums[5] = $num;
            } else if ($sixmatches == 4) {
                $nums[2] = $num;
            }
        }
    }
    foreach ($numinput as $num) {
        if (!in_array($num, $nums)) {
            $onematches = 0;
            foreach (str_split($num) as $numpart) {
                foreach (str_split($nums[1]) as $onepart) {
                    if ($numpart == $onepart) {
                        $onematches++;
                    }
                }
            }
            if ($onematches == 2) {
                $nums[0] = $num;
            }
        }
    }

    $value = '';
    $output = explode(" | ", $line)[1];
    foreach (explode(" ", $output) as $num) {
        $prts = str_split($num);
        sort($prts);
        $num = implode($prts);
        foreach ($nums as $key => $el) {
            if ($num == $el) {
                $value .= $key;
            }
        }
    }
    echo  $output . ': ' . $value . PHP_EOL;
    $sum += intval($value);
}
echo 'sum: ' . $sum . PHP_EOL;
