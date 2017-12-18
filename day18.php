<?php
$input = file_get_contents("./input/day18.txt");

$commands = explode("\n", $input);
class Program {
	var $registers = [];
	var $frequency = null;
	var $received = null;
	var $cursor = 0;
	var $link = null;
	var $done = false;
	var $queue = [];
	var $runs =0;
	var $id = 0;
	var $waiting = false;
	var $count = 0;
	
	function init($id, $link = null) {
		$this->id = $id;
		for ($r = 97; $r < 123; $r++)
			$this->registers[chr($r)] = 0;
		$this->registers['p'] = $id;
		$this->runs = 0;
		$this->link = $link;
		$this->done = false;
		$this->waiting = false;
		$this->cursor = 0;
	}
	
	function run() {
		global $commands;
		
		list($command, $value1, $value2) = explode(' ', $commands[$this->cursor].' ');
		if (($command === 'jgz' || $command === 'snd') && !is_numeric($value1))
			$value1 = $this->registers[$value1];
		if (is_numeric($value2))
			$value2 = (float)$value2;
		elseif ($value2 != '')
			$value2 = $this->registers[$value2];

		switch ($command) {
			case 'snd':
				if ($this->link) {
					$this->link->queue[] = $value1;
					$this->count++;
				} else
					$this->frequency = $value1;
				break;
			case 'set': $this->registers[$value1] = (float)$value2; break;
			case 'add': $this->registers[$value1] += (float)$value2; break;
			case 'mul': $this->registers[$value1] *= (float)$value2; break;
			case 'mod': $this->registers[$value1] = fmod($this->registers[$value1], $value2); break;
			case 'rcv':
				if ($this->link) {
					if (count($this->queue) == 0) {
					// Queue empty, set waiting, skip cycle
						$this->waiting = true;
						return;
					}
					$this->waiting = false;
					$this->registers[$value1] = array_shift($this->queue);
				} elseif ($this->registers[$value1] != 0) {
					$this->received = $this->frequency;
					$this->done = true;
				}
				break;
			case 'jgz': if ($value1 > 0) $this->cursor += $value2 - 1; continue;
		}
		$this->cursor++;
		if ($this->cursor < 0 || $this->cursor >= count($commands))
			$this->done = true;
	}
}
$program1 = new Program();
$program1->init(0);
while (!$program1->done)
	$program1->run();
echo "Part 1: first recovered frequency is $program1->frequency\n";

$program2 = new Program();
$program1->init(0, $program2);
$program2->init(1, $program1);
while (true) {
	if (!$program1->done)
		$program1->run();
	if (!$program2->done)
		$program2->run();
	if ($program1->done && $program2->done)
		break;
	if ($program1->waiting && $program2->waiting)
		break;
}
echo "Part 2: number of sends from program 1 is $program2->count\n";
