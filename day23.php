<?php
	$input = "set b 84
set c b
jnz a 2
jnz 1 5
mul b 100
sub b -100000
set c b
sub c -17000
set f 1
set d 2
set e 2
set g d
mul g e
sub g b
jnz g 2
set f 0
sub e -1
set g e
sub g b
jnz g -8
sub d -1
set g d
sub g b
jnz g -13
jnz f 2
sub h -1
set g b
sub g c
jnz g 2
jnz 1 3
sub b -17
jnz 1 -23";

	$muls = 0;
	$regs = [];
	foreach (range('a', 'h') as $r)
		$regs[$r] = 0;
	$lines = explode("\n", $input);
	$cursor = 0;
	while ($cursor >= 0 && $cursor <count($lines)) {
		list($cmd, $p1, $p2) = explode(' ', $lines[$cursor]);
		if (!is_numeric($p2))
			$p2 = $regs[$p2];
		switch($cmd) {
			case 'set': $regs[$p1] = $p2; break;
			case 'sub': $regs[$p1] -= $p2; break;
			case 'mul': $regs[$p1] *= $p2; $muls++; break;
			case 'jnz': if (!is_numeric($p1)) $p1 = $regs[$p1]; if ($p1) $cursor += $p2 - 1; break;
		}
		$cursor++;
	}
	
	echo "Part 1: mul invoked $muls times\n";

	$h = 0;
	for ($b = 108400; $b <= 125400; $b += 17) {
		for ($e = 2; $e < $b; $e++)
			if ($b % $e == 0) {
				$h++;
				break;
			}
	}
	echo "Part 2: value left in register h is $h\n";
