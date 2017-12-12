<?php
$input = file_get_contents("./input/day12.txt");

$pipes = explode("\n", $input);
foreach ($pipes as $idx => $pipe)
	$pipes[$idx] = (explode(' <-> ', $pipe))[1];
$check = [ 0 ];
$group = 0;
$checklist = [];
$result = [];
$total = 0;
while ($total < count($pipes)) {
	$result[$group] = [];
	while(count($check) > 0) {
		$id = array_pop($check);
		if ($pipes[$id] !== null) {
			foreach (explode(', ', $pipes[$id]) as $pipe) {
				$check[] = $pipe;
				$result[$group][$pipe] = $pipe;
				$checklist[$pipe] = $pipe;
			}
			$pipes[$id] = null;
		}
	}
	for ($p = 0; $p < count($pipes); $p++)
		if (!in_array($p, $checklist)) {
			$check = [ $p ];
			break;
		}
	$total += count($result[$group]);
	$group++;
}
echo "Part 1: Programs in group with #0: ".count($result[0])."\n";
echo "Part 2: Total number of groups: ".count($result)."\n";
