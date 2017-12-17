<?php
$input = 301;
$buffer = [ 0 ];
$cursor = 0;
for ($step = 1; $step < 2018; $step++) {
	$cursor = ($cursor + $input) % $step + 1;
	array_splice($buffer, $cursor, 0, $step);
}
echo "Part 1: After last value = ".$buffer[$cursor+1]."\n";

$cursor = 0;
$pos1 = null;
for ($step = 1; $step < 50000000; $step++) {
	$cursor = ($cursor + $input) % $step + 1;
	if ($cursor == 1)
		$pos1 = $step;
}
echo "Part 2: Position 1 after 50M = $pos1\n";
