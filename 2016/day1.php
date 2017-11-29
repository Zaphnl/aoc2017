<?php
$coordinates = ["L3", "R2", "L5", "R1", "L1", "L2", "L2", "R1", "R5", "R1", "L1", "L2", "R2", "R4", "L4", "L3", "L3",
"R5", "L1", "R3", "L5", "L2", "R4", "L5", "R4", "R2", "L2", "L1", "R1", "L3", "L3", "R2", "R1", "L4", "L1", "L1", "R4",
"R5", "R1", "L2", "L1", "R188", "R4", "L3", "R54", "L4", "R4", "R74", "R2", "L4", "R185", "R1", "R3", "R5", "L2", "L3",
"R1", "L1", "L3", "R3", "R2", "L3", "L4", "R1", "L3", "L5", "L2", "R2", "L1", "R2", "R1", "L4", "R5", "R4", "L5", "L5",
"L4", "R5", "R4", "L5", "L3", "R4", "R1", "L5", "L4", "L3", "R5", "L5", "L2", "L4", "R4", "R4", "R2", "L1", "L3", "L2",
"R5", "R4", "L5", "R1", "R2", "R5", "L2", "R4", "R5", "L2", "L3", "R3", "L4", "R3", "L2", "R1", "R4", "L5", "R1", "L5",
"L3", "R4", "L2", "L2", "L5", "L5", "R5", "R2", "L5", "R1", "L3", "L2", "L2", "R3", "L3", "L4", "R2", "R3", "L1", "R2",
"L5", "L3", "R4", "L4", "R4", "R3", "L3", "R1", "L3", "R5", "L5", "R1", "R5", "R3", "L1"];
$coordinates = explode(", ", "R5, L2, L1, R1, R3, R3, L3, R3, R4, L2, R4, L4, R4, R3, L2, L1, L1, R2, R4, R4, L4, R3, L2, R1, L4, R1, R3, L5, L4, L5, R3, L3, L1, L1, R4, R2, R2, L1, L4, R191, R5, L2, R46, R3, L1, R74, L2, R2, R187, R3, R4, R1, L4, L4, L2, R4, L5, R4, R3, L2, L1, R3, R3, R3, R1, R1, L4, R4, R1, R5, R2, R1, R3, L4, L2, L2, R1, L3, R1, R3, L5, L3, R5, R3, R4, L1, R3, R2, R1, R2, L4, L1, L1, R3, L3, R4, L2, L4, L5, L5, L4, R2, R5, L4, R4, L2, R3, L4, L3, L5, R5, L4, L2, R3, R5, R5, L1, L4, R3, L1, R2, L5, L1, R4, L1, R5, R1, L4, L4, L4, R4, R3, L5, R1, L3, R4, R3, L2, L1, R1, R2, R2, R2, L1, L1, L2, L5, L3, L1");
class ManhattanDistance {
	var $crossroads = [];
	var $directions = [
		[ -1,  0 ], // N
		[  0,  1 ], // E
		[  1,  0 ], // S
		[  0, -1 ]  // W
	];
	var $direction = 0;
	var $xpos = 0;
	var $ypos = 0;

	function registerVisit() {
		if (!isset($this->crossroads[$this->ypos]))
			$this->crossroads[$this->ypos] = [];
		if (!isset($this->crossroads[$this->ypos][$this->xpos]))
			$this->crossroads[$this->ypos][$this->xpos] = 0;
		$this->crossroads[$this->ypos][$this->xpos]++;
	}
	function run($coordinates) {
		foreach ($coordinates as $coordinate) {
			$deltadirection = $coordinate[0] == 'R' ? 1 : -1;
			$blocks = (int)substr($coordinate, 1);
			$this->direction = ($this->direction + $deltadirection + 4) % 4;
			if ($this->directions[$this->direction][1]) {
				for ($x = 0; $x < $blocks; $x++) {
					$this->xpos += $this->directions[$this->direction][1];
					$this->registerVisit();
				}
			} else {
				for ($y = 0; $y < $blocks; $y++) {
					$this->ypos += $this->directions[$this->direction][0];
					$this->registerVisit();
				}
			}
			//echo "Move $coordinate -> $this->xpos, $this->ypos\n";
		}
	}
	function report() {
		echo "Number of blocks away: ".abs($this->xpos + $this->ypos)."\n";
		foreach($this->crossroads as $y => $xroads) {
		//	$t = $y;
		//	while(strlen($t) < 3) $t = " $t";
		//	echo "$t: ";
			foreach ($xroads as $x => $visits) {
				if ($visits > 1) echo "\t Visited $x, $y - $visits times\n";
			}
		//	echo "\n";
		}
	}
}
$md = new ManhattanDistance();
$md->run($coordinates);
$md->report();
?>