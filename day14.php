<?php
session_start();
$input = "wenycdww";

// Day 10 code
function doRun() {
	global $array, $current, $skipsize, $lengths;
	
	$newarray = [];
	for ($l = 0; $l < count($lengths); $l++) {
		for ($i = 0; $i < 256; $i++)
			$newarray[$i] = $array[$i];
		$index = $lengths[$l] % 256;
		for ($r = 0; $r < $lengths[$l]; $r++)
			$newarray[($current + $r) % 256] = $array[($current + $index - $r - 1) % 256];
		$current = ($current +  $lengths[$l] + $skipsize) % 256;
		$skipsize++;
		$array = $newarray;
	}
	return $array[0] * $array[1];
}
// Day 14...
$rows = 128;
$used = 0;
$grid = [];
$regions = 0;
for ($row = 0; $row < $rows; $row++) {
	$grid[$row] = [];
	$in = "$input-$row";
	$lengths = [];
	for ($c = 0; $c < strlen($in); $c++)
		$lengths[] = ord($in[$c]);
	$lengths = array_merge($lengths, [17, 31, 73, 47, 23]);
	$skipsize = 0;
	$current = 0;
	$array = [];
	for ($i = 0; $i < 256; $i++)
		$array[$i] = $i;
	for ($run = 0; $run < 64; $run++)
		$result = doRun();
	$binary = '';
	for ($step = 0; $step < 16; $step++) {
		$value = 0;
		for ($pos = 0; $pos < 16; $pos++)
			$value ^= $array[$step * 16 + $pos];
		$bin = str_pad(decbin($value), 8, '0', STR_PAD_LEFT );
		$u = 0;
		for ($c = 0; $c < 8; $c++)
			$u += $bin[$c] ? 1 : 0;
		$used += $u;
		$binary .= $bin;
	}
	for ($b = 0; $b < 128; $b++)
		$grid[$row][$b] = $binary[$b] ? '.' : '';
}
// Find groups
$stack = [];
for ($r = 0; $r < $rows; $r++) {
	for ($b = 0; $b < 128; $b++) {
		$g = 0;
		if ($grid[$r][$b] == '.') {
			$regions++;
			$stack[] = [ $r, $b, $regions ];
			while (count($stack)) {
				list($cr, $cb, $cg) = array_pop($stack);
				if ($cr >= 0 && $cr < $rows && $cb >= 0 && $cb < 128 && $grid[$cr][$cb] === '.') {
					$grid[$cr][$cb] = $regions;
					$stack[] = [ $cr - 1, $cb, $regions];
					$stack[] = [ $cr + 1, $cb, $regions];
					$stack[] = [ $cr    , $cb + 1, $regions];
					$stack[] = [ $cr    , $cb - 1, $regions];
				}
			}
		}
	}
}
echo "Part 1: Used squares: $used\n";
echo "Part 2: Number of regions: $regions\n";
