<?php
$input = 312051;
$prevsquare = 0;
$square = 0;
for ($ring = 1; $square < $input; $ring += 2) {
	$prevsquare = $square;
	$square = pow($ring, 2);
}
$ring -= 2;

$diff = ($square - $prevsquare);
$sidelength = $diff / 4;
$offset = floor($sidelength / 2) - 1;

$newinput = $input - $prevsquare;
$sideoffset = ($input - $prevsquare - 1) % $sidelength;
$sidedistance = abs($sideoffset - $offset);
$distance = $sidedistance + ($ring - 1) / 2;
echo "Part 1: Distance = $distance\n";

$value = 0;
$prevsquare = 1;
global $items;
$items = [ 0 => [ 0 => 1 ] ];
function additem($atx, $aty) {
	global $items;
	$sum = 0;
	for ($x = -1; $x < 2; $x++)
		for ($y = -1; $y < 2; $y++)
			$sum += isset($items[$atx+$x][-$aty+$y]) ? $items[$atx+$x][-$aty+$y] : 0;
	$items[$atx][-$aty] = $sum;
	return $sum;
}
for ($ring = 3; $value < $input; $ring += 2) {
	$square = pow($ring, 2);
	$diff = ($square - $prevsquare);
	$sidelength = $diff / 4;
	$halflength = $sidelength / 2;
	$dx = 1;
	$dy = 0;
	$x = $halflength;
	$y = -$halflength ;
	$sign = -1;
	for ($item = 0; $item < $diff && $value < $input; $item++) {
		if (2 * $item  % ($sidelength * 2) === 0)
			$sign *= -1;
		if (($item) % $sidelength === 0) {
			if ($dx) {
				$dy = $sign * $dx;
				$dx = 0;
			} else {
				$dx = $sign * $dy;
				$dy = 0;
			}
		}
		$x += $dx;
		$y += $dy;
		if (!isset($items[$x]))
			$items[$x] = [];
		$value = additem($x, $y);
	}
	$prevsquare = $square;
}
echo "Part 2: First larger value = $value";
