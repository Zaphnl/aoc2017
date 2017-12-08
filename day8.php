<?php
$input = explode("\n", file_get_contents("./input/day8.txt"));

$registers = [];
$max = $result = 0;
foreach ($input as $idx => $line) {
	list($reg, $act, $num, $if, $cmp, $op, $val) = explode(' ', $line);
	if (!isset($registers[$reg]))
		$registers[$reg] = 0;
	if (!isset($registers[$cmp]))
		$registers[$cmp] = 0;
	switch ($op) {
		case "<": if (!($registers[$cmp] < $val)) continue 2; break;
		case ">": if (!($registers[$cmp] > $val)) continue 2; break;
		case "<=": if (!($registers[$cmp] <= $val)) continue 2; break;
		case ">=": if (!($registers[$cmp] >= $val)) continue 2; break;
		case "==": if (!($registers[$cmp] == $val)) continue 2; break;
		case "!=": if (!($registers[$cmp] != $val)) continue 2; break;
	}
	$registers[$reg] += $act == 'inc' ? $num : -$num;
	if ($registers[$reg] > $max)
		$max = $registers[$reg];
}
asort($registers);
echo "Part 1: Highest register value at end = ".array_pop($registers)."\n";
echo "Part 2: Highest register during process = $max\n";