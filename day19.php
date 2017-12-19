<?php
$input = file_get_contents("./input/day19.txt");

$maze = explode("\n", $input);
$w = 0;
foreach ($maze as $m)
	$w = max($w, strlen($m));
foreach ($maze as $i => $m)
	if ($w > strlen($m))
		$maze[$i] .= str_repeat(' ', $w - strlen($m));
$h = count($maze);
$y = 0;
$x = strpos($maze[0], '|');
$dx = 0;
$dy = 1;
$looks = [
	[ -1, 0 ],
	[ 1, 0 ],
	[ 0, -1 ],
	[ 0, 1 ]
];
$output = '';
$steps = 0;
$busy = true;
while ($busy) {
	$x += $dx;
	$y += $dy;
	switch ($maze[$y][$x]) {
		case '-':
		case '|':
			// Nothing...
			break;
		case ' ':
			// Done...
			$busy = false;
			break;
		case '+':
			foreach ($looks as $look) {
				list($nx, $ny) = $look;
				if (
					!($nx == -$dx && $ny == -$dy) &&
					$x + $nx >= 0 &&
					$x + $nx < $w &&
					$y + $ny >= 0 &&
					$y + $ny < $h
				) {
					if ($maze[$y + $ny][$x + $nx] != ' ') {
						$dx = $nx;
						$dy = $ny;
						break;
					}
				}
			}
			break;
		default:
			// Letter...
			$output .= $maze[$y][$x];
	}
	$steps++;
}
echo "Part 1: Letters seen = $output\n";
echo "Part 2: Steps taken = $steps\n";
