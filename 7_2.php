<?php

/*
--- Part Two ---
The crabs don't seem interested in your proposed solution. Perhaps you misunderstand crab engineering?

As it turns out, crab submarine engines don't burn fuel at a constant rate. Instead, each change of 1 step in horizontal position costs 1 more unit of fuel than the last: the first step costs 1, the second step costs 2, the third step costs 3, and so on.

As each crab moves, moving further becomes more expensive. This changes the best horizontal position to align them all on; in the example above, this becomes 5:

Move from 16 to 5: 66 fuel
Move from 1 to 5: 10 fuel
Move from 2 to 5: 6 fuel
Move from 0 to 5: 15 fuel
Move from 4 to 5: 1 fuel
Move from 2 to 5: 6 fuel
Move from 7 to 5: 3 fuel
Move from 1 to 5: 10 fuel
Move from 2 to 5: 6 fuel
Move from 14 to 5: 45 fuel
This costs a total of 168 fuel. This is the new cheapest possible outcome; the old alignment position (2) now costs 206 fuel instead.

Determine the horizontal position that the crabs can align to using the least fuel possible so they can make you an escape route! How much fuel must they spend to align to that position?
*/

$input = file_get_contents('7.txt');
//$input = '16,1,2,0,4,2,7,1,2,14';
$crabs = explode(',', $input);

$max = 0;
foreach ($crabs as $pos) {
    if ($pos > $max) {
        $max = $pos;
    }
}
echo 'max: ' . $max . PHP_EOL;

$minfuel = 1000000000;
$bestpos = 0;
for ($i = 0; $i <= $max; $i++) {
    $fuel = 0;
    foreach ($crabs as $pos) {
        $steps = abs($pos - $i);
        $fuel += ($steps+1) * $steps / 2;
    }
    echo 'move to pos ' . $i . ' needs ' . $fuel . ' fuel' . PHP_EOL;
    if ($fuel < $minfuel) {
        $minfuel = $fuel;
        $bestpos = $i;
    }
}
echo 'minimum fuel needed to get to pos ' . $bestpos . ': ' . $minfuel . PHP_EOL;
