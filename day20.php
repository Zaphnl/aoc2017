<?php
$input = file_get_contents("./input/day20.txt");

$particles = [];
$lines = explode("\n", $input);
foreach ($lines as $idx => $line) {
	$line = explode(', ', $line);
	$particle = (object)[ 'id' => $idx, 'destroyed' => 0 ];
	foreach ($line as $set) {
		$type = $set[0];
		$set = explode(',', substr($set, 3, strlen($set) - 4));
		list($particle->{$type.'x'}, $particle->{$type.'y'}, $particle->{$type.'z'}) = $set;
	}
	$particle->startdistance = $particle->px + $particle->py  +$particle->pz;
	$particles[] = $particle;
}
$alive = count($particles);
for ($cycles = 0; $cycles < 1000; $cycles++) {
	$positions = [];
	foreach ($particles as $particle) {
		$particle->vx += $particle->ax;
		$particle->vy += $particle->ay;
		$particle->vz += $particle->az;
		$particle->px += $particle->vx;
		$particle->py += $particle->vy;
		$particle->pz += $particle->vz;
		$distance = abs($particle->px) + abs($particle->py) + abs($particle->pz);
		$particle->dx = $distance - $particle->startdistance;
		$particle->d = $distance;
		if (!$particle->destroyed) {
			$idx = "$particle->px,$particle->py,$particle->pz";
			if (isset($positions[$idx])) {
				$alive--;
				$particle->destroyed = 1;
				if (!$positions[$idx]->destroyed) {
					$alive--;
					$positions[$idx]->destroyed = 1;
				}
			} else
				$positions[$idx] = $particle;
		}
	}
}
function dxsort($a, $b) {
	$a = abs($a->dx);
	$b = abs($b->dx);
	if ($a == $b) return 0;
	return $a < $b ? -1 : 1;
}
usort($particles, 'dxsort');
echo "Part 1: closest staying particle = {$particles[0]->id}\n";
echo "Part 2: particles left = $alive\n";
