<?php
global $programs; // Using wrapper function, we're not at 'global' level here...
$input = explode("\n", file_get_contents("./input./day7.txt"));
$programs = [];
foreach ($input as $line) {
	if (strpos($line, ' -> ') === false) {
		$program = $line;
		$kids = '';
	} else
		list($program, $kids) = explode( ' -> ', $line);
	list($program, $weight) = explode(',', preg_replace('~(.*) \((.*)\)~U', '\1,\2', $program));
	$programs[$program] = (object)[ 'name' => $program, 'weight' => $weight, 'kids' => $kids ? explode(", ", $kids) : [], 'parent' => null ];
}
foreach ($programs as $idx => $program)
	foreach ($program->kids as $kid)
			$programs[$kid]->parent = $program->name;
$base = 'Not found';
foreach ($programs as $idx => $program)
	if ($program->parent === null) {
		$base = $program->name;
		break;
	}
echo "Part 1: Base program: $base\n";

function walkWeights($program) {
	global $programs;

	if (count($programs[$program]->kids) == 0)
		return $programs[$program]->weight;
	$check = null;
	$weights = [];
	$kids = [];
	$programs[$program]->totalweight = $programs[$program]->weight;
	// Get child weights and save stats
	foreach ($programs[$program]->kids as $kid) {
		$weight = walkWeights($kid);
		// Found it, so leave recursion
		if ($weight == null)
			return null;
		$kids[$weight] = [ 'kid' => $kid, 'weight' => $weight ];
		if (!isset($weights[$weight])) $weights[$weight] = 0;
		$weights[$weight]++;
		$programs[$program]->totalweight += $weight;
	}
	// Check number of weights found, more than 1 means unbalance
	if (count($weights) > 1) {
		asort($weights);
		// Get lowest counting = wrong one
		foreach ($weights as $weight => $count) {
			$wrong = $kids[$weight];
			unset($weights[$weight]);
			break;
		}
		// Remaining one is correct
		foreach ($weights as $weight => $count)
			break;
		$diff = $wrong['weight'] - $weight;
		$wrong = $programs[$wrong['kid']];
		$shouldbe = $wrong->weight - $diff;
		echo "Part 2: Weight for '$kid' should be $shouldbe\n";
		return null;
	}
	return $programs[$program]->totalweight;
}
walkWeights($base);
