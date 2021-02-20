<?php

class GameController {
	static public function hit($index) {
		$bee = unserialize($_SESSION["bees"][$index]);
		
		$bee->Hits($bee->Hits() +1);
		
		if($bee->isDead()) {
			unset($_SESSION["bees"][$index]);
			
			$_SESSION["bees"] = array_values($_SESSION["bees"]);
		}
		
		// TODO > If queen is dead reset session.
		// TODO > If all bees are dead reset session.
	}
}

?>