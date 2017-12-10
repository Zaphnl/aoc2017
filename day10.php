<?php
$input = "129,154,49,198,200,133,97,254,41,6,2,1,255,0,191,108";

$lengths = explode(',', $input);
$skipsize = 0;
$current = 0;
$array = [];
for ($i = 0; $i < 256; $i++)
	$array[$i] = $i;
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
//		echo implode(',', $newarray)."\n";
		$array = $newarray;
	}
	return $array[0] * $array[1];
}
echo "Part 1: Check is ".doRun()."\n";

//Re-initialize
$skipsize = 0;
$current = 0;
for ($i = 0; $i < 256; $i++)
	$array[$i] = $i;
$lengths = [];
for ($c = 0; $c < strlen($input); $c++)
	$lengths[] = ord($input[$c]);
$lengths = array_merge($lengths, [17, 31, 73, 47, 23]);

for ($run = 0; $run < 64; $run++)
	doRun();
$hash = '';
for ($step = 0; $step < 16; $step++) {
	$value = 0;
	for ($pos = 0; $pos < 16; $pos++)
		$value ^= $array[$step * 16 + $pos];
	$hash .= str_pad(dechex($value), 2, '0');
}
echo "Part 2: Hash is $hash\n";
