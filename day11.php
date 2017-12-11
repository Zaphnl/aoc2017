<?php
$input = explode(',', file_get_contents("./input/day11.txt"));

$moves = [
	'n' => [ 0, -1 ],
	'nw' => [ -1, -1 ],
	'ne' => [ 1, 0 ],
	'sw' => [ -1, 0 ],
	'se' => [ 1, 1 ],
	's' => [ 0, 1 ],
];

$distance = $x = $y = 0;
foreach ($input as $move) {
	list($dx, $dy) = $moves[$move];
	$x += $dx;
	$y += $dy;
	$distance = max(abs($x) + abs($y), $distance);
}
echo "Part 1: Child process distance: ".(abs($x) + abs($y))."\n";
echo "Part 2: Maximum distance: $distance\n";
