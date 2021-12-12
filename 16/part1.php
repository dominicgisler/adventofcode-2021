<?php

$input = file_get_contents(__DIR__ . '/input.txt');
$input = '
';

foreach (explode("\n", $input) as $line) {
    if (!empty($line)) {
        echo $line;
    }
}
