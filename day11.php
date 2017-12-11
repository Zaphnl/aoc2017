<?php
$input = explode(',', file_get_contents("./input/day11.txt"));
//$input = [ 'ne', 'ne', 'ne', 'ne' ];
$moves = [
	'n' => [ 0, -1 ],
	'nw' => [ -1, -1 ],
	'ne' => [ 1, 0 ],
	'sw' => [ -1, 0 ],
	'se' => [ 1, 1 ],
	's' => [ 0, 1 ],
];
function distance($x, $y) {
	$distance = 0;
	if ($x < 0 && $y < 0) {
		$d = max($x, $y);
		$distance -= $d;
		$x -= $d;
		$y -= $y;
		$distance -= max($x, $y);
	} elseif ($x > 0 && $y > 0) {
		$d = min($x, $y);
		$distance += $d;
		$x -= $d;
		$y -= $y;
		$distance += max($x, $y);
	} else {
		$distance = abs($x) + abs($y);
	}
	return $distance;
}
$distance = $x = $y = 0;
foreach ($input as $move) {
	list($dx, $dy) = $moves[$move];
//	if ($x % 2 == 1 && $dx > 0) $dy = 0;
//	if ($x % 2 == 0 && $dx < 0) $dy = 0;
	$x += $dx;
	$y += $dy;
	$d = distance($x, $y);
	$distance = max($d, $distance);
//	echo "$move:\t$dx,\t$dy\t->\t$x,\t$y\n";
}
echo "Part 1: Child process distance: ".(abs($x) + abs($y))."\n";
echo "Part 2: Maximum distance: $distance\n";
