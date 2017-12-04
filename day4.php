<?php
$lines = file("./input/day4.txt");
$count = 0;
foreach ($lines as $idx => $line) {
	$lines[$idx] = $line = explode(' ', trim($line));
	if (count($line) === count(array_unique($line)))
		$count++;

}
echo "Part 1 - Correct passphrases: $count out of ".count($lines)."\n";

$count = 0;
foreach ($lines as $lineno => $line) {
	$test = [];
	foreach ($line as $word) {
		$word = preg_split('//', $word);
		asort($word);
		$test[] = implode('', $word);
	}
	if (count($line) === count(array_unique($test)))
		$count++;
}
echo "Part 2 - Correct passphrases: $count out of ".count($lines)."\n";
