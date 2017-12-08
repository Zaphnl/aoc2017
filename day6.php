<?php
$input = "0	5	10	0	11	14	13	4	11	8	8	7	1	4	12	11";

$banks = explode("\t", $input);
$length = count($banks);
$results = [];
$check = null;
do {
	if ($check)
		$results[] = $check;
	$highest = 0;
	$index = 0;
	foreach ($banks as $bank => $blocks)
		if ($blocks > $highest) {
			$highest = $blocks;
			$index = $bank;
		}
	$banks[$index++] = 0;
	for ($block = 0; $block < $highest; $block++)
		$banks[($index + $block) % $length]++;
	$check = implode(',', $banks);
} while (!in_array($check, $results));
echo "Part 1: Cycles needed = ".(count($results) + 1)."\n";
echo "Part 2: Loop size = ".(count($results) - array_search($check, $results))."\n";
