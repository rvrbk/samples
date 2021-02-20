<?php

class Bee {
	private $type;
	private $worth;
	private $hits;
	private $hitpoints;
	
	public function Type($value = null) {
		if(!isset($value)) {
			return $this->type;
		}
		
		$this->type = $value;
	}
	
	public function Worth($value = null) {
		if(!isset($value)) {
			return $this->worth;
		}
		
		$this->worth = $value;
	}
	
	public function Hits($value = null) {
		if(!isset($value)) {
			return $this->hits;
		}
		
		$this->hits = $value;
	}
	
	
	public function Hitpoints($value = null) {
		if(!isset($value)) {
			return $this->hitpoints;
		}
		
		$this->hitpoints = $value;
	}
	
	public function isDead() {
		if($this->worth -($this->hits *$this->hitpoints) < 1) {
			return true;
		}
		
		return false;
	}
}

?>