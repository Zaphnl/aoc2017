<?php
$input = [ 699, 124 ];

$factor1 = 16807;
$factor2 = 48271;

$end = 40000000;
$count = 0;
$gen1 = $input[0];
$gen2 = $input[1];
for ($pair = 0; $pair < $end; $pair++) {
	$gen1 = ($gen1 * $factor1) % 2147483647;
	$gen2 = ($gen2 * $factor2) % 2147483647;
	if (($gen1 & 0xffff) == ($gen2 & 0xffff))
		$count++;
}
echo "Part 1: final count is $count\n";

ini_set('memory_limit', '1024M');
$gen1 = $input[0];
$gen2 = $input[1];
$comp1 = $comp2 = [];
$cnt = 0;
$end = 5000000;
while ($cnt < $end) {
	$gen1 = ($gen1 * $factor1) % 2147483647;
	$gen2 = ($gen2 * $factor2) % 2147483647;
	if ($gen1 % 4 === 0)
		$comp1[] = $gen1 & 0xffff;
	if ($gen2 % 8 === 0) {
		$comp2[] = $gen2 & 0xffff;
		$cnt++;
	}
}
$count = 0;
for ($cnt = 0; $cnt < $end; $cnt++)
	if ($comp1[$cnt] == $comp2[$cnt])
		$count++;
echo "Part 2: final count is $count\n";

