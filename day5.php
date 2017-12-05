<?php
$input = explode("\n", file_get_contents("./input/day5.txt"));
$length = count($input);

$steps = $cursor = 0;
while ($cursor >= 0 && $cursor < $length && ++$steps)
	$cursor += $input[$cursor]++;
echo "Part 1: $steps steps\n";

// Do not forget to reload the input! ;-)
$input = explode("\n", file_get_contents("./input/day5.txt"));
$steps = $cursor = 0;
while ($cursor >= 0 && $cursor < $length && ++$steps)
	$cursor += $input[$cursor] > 2 ? $input[$cursor]-- :$input[$cursor]++;
echo "Part 2: $steps steps\n";
