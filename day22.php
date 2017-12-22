<?php
set_time_limit(60); // Meh

$input = "##.###.....##..#.####....
##...#.#.#..##.#....#.#..
...#..#.###.#.###.##.####
..##..###....#.##.#..##.#
###....#####..###.#..#..#
.....#.#...#..##..#.##...
.##.#.###.#.#...##.#.##.#
......######.###......###
#.....##.#....#...#......
....#..###.#.#.####.##.#.
.#.#.##...###.######.####
####......#...#...#..#.#.
###.##.##..##....#..##.#.
..#.###.##..#...#######..
...####.#...###..#..###.#
..#.#.......#.####.#.....
..##..####.######..##.###
..#..#..##...#.####....#.
.#..#.####.#..##..#..##..
......#####...#.##.#....#
###..#...#.#...#.#..#.#.#
.#.###.#....##..######.##
##.######.....##.#.#.#..#
..#..##.##..#.#..###.##..
#.##.##..##.#.###.......#";


function run($bursts, $part2 = false) {
	global $input;

	foreach (explode("\n", $input) as $line)
		$grid[] = str_split(trim($line));
	$x = $y = (int)floor(count($grid)/2);
	$dx = 0;
	$dy = -1;
	$infected = 0;
	for ($burst = 0; $burst < $bursts; $burst++) {
		if (!isset($grid[$y][$x]))
			$grid[$y][$x] = '.';
		if ($grid[$y][$x] == '#')
			$sign = $dy ? -1 : 1;
		elseif ($grid[$y][$x] == '.')
			$sign = $dx ? -1 : 1;
		switch ($grid[$y][$x]) {
			case '#': $grid[$y][$x] = $part2 ? 'F' : '.'; list($dx, $dy) = [ $dy * $sign, $dx * $sign ]; break;
			case '.': $grid[$y][$x] = $part2 ? 'W' : '#'; list($dx, $dy) = [ $dy * $sign, $dx * $sign ]; break;
			case 'W': $grid[$y][$x] = '#'; break;
			case 'F': $grid[$y][$x] = '.'; list($dx, $dy) = [ -$dx, -$dy ]; break;
		}
		if ($grid[$y][$x] == '#')
			$infected++;
		$x += $dx;
		$y += $dy;
	}
	return $infected;
}
$bursts = 10000;
$infected = run($bursts);
echo "Part 1: After $bursts bursts $infected were infected\n";
$bursts = 10000000;
$infected = run($bursts, true);
echo "Part 2: After $bursts bursts $infected were infected\n";
