<?php

$input = file_get_contents(__DIR__ . '/input.txt');
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
//    echo  $output . ': ' . $value . PHP_EOL;
    $sum += intval($value);
}
echo 'sum: ' . $sum . PHP_EOL;
