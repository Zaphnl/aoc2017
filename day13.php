<?php
$input = file_get_contents("./input/day13.txt");

$input = explode("\n", $input);
$layers = [];
$layercount = 0;
foreach ($input as $layer) {
	$layer = explode(': ', $layer);
	$layers[$layer[0]] = (int)$layer[1] * 2 - 2;
	$layercount = (int)$layer[0];
}
$attempt = 0;
while (true) {
	$position = 0;
	$severity = 0;
	$test = [];
	while ($position <= $layercount) {
		if (isset($layers[$position])) {
			if (($position + $attempt) % $layers[$position] === 0) {// * 2 - 2) === 0) {
				if ($attempt > 0)
					break;
				$severity += $position * ($layers[$position] + 2) / 2;
			}
		}
		$position++;
	}
	if ($attempt === 0)
		echo "Part 1: Severity is $severity\n";
	if ($severity === 0 && $position === $layercount + 1)
		break;
	$attempt += 2; // input[1] == 2, so skip that
}
echo "Part 2: Required delay is $attempt ps\n";
