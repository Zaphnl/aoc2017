<?php
$input = file_get_contents("./input/day16.txt");

$program = 'abcdefghijklmnop';

$moves = explode(',', $input);
$results = [];
$runs = 1000000000;
for ($run = 0; $run < $runs; $run++) {
	foreach ($moves as $move) {
		$data = explode('/', substr($move, 1));
		if ($move[0] == 's') {
			$data = 16 - (int)$data[0];
			$program = substr($program, $data).substr($program, 0, $data);
		} else {
			if ($move[0] == 'p') {
				$pos1 = (int)strpos($program, $data[0]);
				$pos2 = (int)strpos($program, $data[1]);
			} else {
				$pos1 = (int)$data[0];
				$pos2 = (int)$data[1];
			}
			$tmp = $program[$pos1];
			$program[$pos1] = $program[$pos2];
			$program[$pos2] = $tmp;
		}
	}
	if (isset($results[$program])) {
		$program = array_search($runs % $run, $results);
		break;
	}
	$results[$program] = $run + 1;
	if ($run === 0)
		echo "Part 1: program order after 1 dance is '$program'\n";
}
echo "Part 2: program order after 1 billion dances is '$program'\n";
