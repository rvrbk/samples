<?php

class Game {
	private $points;
	
	public function Points($value = null) {
		if(!isset($value)) {
			return $this->points;
		}
		
		$this->points = $value;
	}
}

?>