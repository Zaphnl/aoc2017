<?php
$input = file_get_contents("./input/day25.txt");

$offset = 3;
$size = 10;

$steps = 0;
$state = null;
$blueprint = [];
$input = explode("\n", $input);
foreach ($input as $idx => $line) {
	$line = explode(' ', $line);
	$value = str_replace([ '.', ':' ], '', array_pop($line));
	if ($idx == 0)
		$state = $value;
	elseif ($idx == 1)
		$steps = array_pop($line);
	else {
		$sl = ($idx - $offset) % $size;
		if ($sl == 0)
			$s = $value;
		elseif ($sl < 9) {
			$l = ($sl - 1) % 4;
			switch ($l) {
				case 0: $b = $value; $blueprint[$s.$b] = []; break;
				case 1: $blueprint[$s.$b][] = (int)$value; break;
				case 2: $blueprint[$s.$b][] = $value == 'left' ? -1 : 1; break;
				case 3: $blueprint[$s.$b][] = $value; break;
				
			}
		}
	}
}

$tape = [];
$cursor = 0;
for ($step = 0; $step < $steps; $step++) {
	$bit = $tape[$cursor] ?? 0;
	$instruction = $blueprint[$state.$bit];
	$tape[$cursor] = $instruction[0];
	$cursor += $instruction[1];
	$state = $instruction[2];
}
echo "Part 1: diagnostic checksum after $steps steps is ".array_sum($tape)."\n";
