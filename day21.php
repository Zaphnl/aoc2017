<?php
$input = file_get_contents("./input/day21.txt");

$tmprules = explode("\n", $input);
$rules = [];
$grid = [
	'.#.',
	'..#',
	'###'
];
// First get all rotated and mirrored versions
foreach ($tmprules as $idx => $rule) {
	list($inrule, $out) = explode(" => ", $rule);
	$in = explode('/', $inrule);
	$out = explode('/', $out);
	$rules[$inrule] = $in;
	$size = count($in);
	$new = $in;
	for ($rotate = 0; $rotate < 4; $rotate++) {
		// Rotate grid
		for ($row = 0; $row < $size; $row++)
			for ($col = 0; $col < $size; $col++)
				$new[$col][$size - $row - 1] = $in[$row][$col];
		$rules[implode('/', $new)] = $out;
		$in = $new;
		// Mirror
		foreach ($new as $i => $rev)
			$new[$i] = strrev($rev);
		$rules[implode('/', $new)] = $out;
	}
}
// Go!
for ($iteration = 0; $iteration < 18; $iteration++) {
	$grids = [];
	$size = count($grid) % 2 === 0 ? 2 : 3;
	$gridsize = count($grid) / $size;
	for ($gridrow = 0; $gridrow < $gridsize; $gridrow++) {
		for ($gridcol = 0; $gridcol < $gridsize; $gridcol++) {
			$subgrid = [];
			for ($y = 0; $y < $size; $y++) {
				$row = $gridrow * $size + $y;
				$subgrid[] = substr($grid[$row],$gridcol * $size, $size);
			}
			$gridindex = $gridrow * $gridsize + $gridcol;
			$newgrid = $rules[implode('/', $subgrid)];
			$newsize = count($newgrid);
			for ($y = 0; $y < $newsize; $y++) {
				if (!isset($grids[$gridrow * $newsize + $y]))
					$grids[$gridrow * $newsize + $y] = '';
				$grids[$gridrow * $newsize + $y] .= $newgrid[$y];
			}
		}
	}
	$grid = $grids;
	if ($iteration == 4)
		echo "Part 1: pixels after 5 iteration = ".(strlen(str_replace('.', '', implode('', $grid))))."\n";
}
echo "Part 2: pixels after 18 iteration = ".(strlen(str_replace('.', '', implode('', $grid))))."\n";
