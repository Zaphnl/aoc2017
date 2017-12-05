<?php
set_time_limit(.01);

$input = explode("\n", file_get_contents("./input/day5.txt"));
$length = count($input);

$steps = $cursor = 0;
while ($cursor >= 0 && $cursor < $length && ++$steps)
	$cursor += $input[$cursor]++;
echo "Part 1: $steps steps\n";

// Do not forget to reload the input! ;-)
$input = explode("\n", file_get_contents("./input/day5.txt"));
$steps = $cursor = 0;
while ($cursor >= 0 && $cursor < $length && ++$steps) {
	$delta = $input[$cursor];
	$input[$cursor] += $delta > 2 ? -1 : 1;
	$cursor += $delta;
}
echo "Part 2: $steps steps\n";
