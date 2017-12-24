<?php
$input = file_get_contents("./input/day24.txt");

set_time_limit(60); // Bleh...

$parts = explode("\n", $input);
foreach ($parts as $idx => $part)
	$parts[$idx] = explode('/', $part);

function find($match, $used) {
	global $parts;
	
	$bestweight = 0;
	$bestlengthweight = 0;
	$bestlength = 0;
	foreach ($parts as $idx => $part) {
		if (!in_array($idx, $used)) {
			if ($part[0] == $match || $part[1] == $match) {
				$next = $part[($part[0] == $match ? 1 : 0)];
				$res = find($next, array_merge($used, [ $idx ]));
				$weight = $part[0] + $part[1] + $res['weight'];
				if ($weight > $bestweight)
					$bestweight = $weight;
				$weight = $part[0] + $part[1] + $res['lengthweight'];
				$length = $res['length'] + 1;
				if ($length > $bestlength || ($length == $bestlength && $weight > $bestlengthweight)) {
					$bestlengthweight = $weight;
					$bestlength = $length;
				}
			}
		}
	}
	return [
		'weight' => $bestweight,
		'lengthweight' => $bestlengthweight,
		'length' => $bestlength
	];
}
$result = find( 0, []);
echo "Part 1: The strongest bridge weighs {$result['weight']}\n";
echo "Part 2: The longest bridge weighs {$result['lengthweight']}\n";
