<?php
$input = explode("\n", file_get_contents("./input/day8.txt"));

$cmds = [];
$registers = [];
$max = 0;
foreach ($input as $idx => $line) {
	list($reg, $act, $num, $if, $cmp, $op, $val) = explode(' ', $line);
	if (!isset($registers[$reg]))
		$registers[$reg] = 0;
	if (!isset($registers[$cmp]))
		$registers[$cmp] = 0;
	$cmp = $registers[$cmp];
	$result = null;
	switch ($op) {
		case "<": $result = $cmp < $val; break;
		case ">": $result = $cmp > $val; break;
		case "<=": $result = $cmp <= $val; break;
		case ">=": $result = $cmp >= $val; break;
		case "==": $result = $cmp == $val; break;
		case "!=": $result = $cmp != $val; break;
		default: echo "Error - unknown op: $op\n";
	}
	if ($result) {
		$registers[$reg] += $act == 'inc' ? $num : -$num;
		if ($registers[$reg] > $max)
			$max = $registers[$reg];
	}
}
asort($registers);
echo "Part 1: Highest register value at end = ".array_pop($registers)."\n";
echo "Part 2: Highest register during process = $max\n";
/**
 * Created by PhpStorm.
 * User: Peter
 * Date: 8-12-2017
 * Time: 10:34
 */