<?php
$input = file_get_contents("./input/day9.txt");

$cursor = 0;
$length = strlen($input);
$level = 0;
$stack = [ null ];
$scores = [ 0 ];
$closer = null;
$garbage = 0;
while($cursor < $length) {
	switch ($input[$cursor++]) {
		case '{':
			if ($closer !== '>') {
				$stack[++$level] = $closer = '}';
				$scores[$level] = $level;
			} else
				$garbage++;
			break;
		case '<':
			if ($closer !== '>')
				$stack[++$level] = $closer = '>';
			else
				$garbage++;
				break;
		case '!':
			$cursor++;
			break;
		case $closer:
			$level--;
			if ($closer === '}')
				$scores[$level] += $scores[$level+1];
			$closer = $stack[$level];
			break;
		default:
			if ($closer == '>')
				$garbage++;
	}
}
echo "Part 1: Total score = {$scores[0]}\n";
echo "Part 2: Garbage characters = $garbage\n";
