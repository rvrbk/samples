<?php

session_start();

include("class/bee.class.php");
include("class/game.class.php");
include("class/game.controller.php");
include("class/game.helper.php");

if(isset($_GET["index"])) {
	GameController::hit($_GET["index"]);
}

if(!isset($_SESSION["bees"])) {
	$queen = new Bee();
	
	$worker1 = new Bee();
	$worker2 = new Bee();
	$worker3 = new Bee();
	$worker4 = new Bee();
	$worker5 = new Bee();
	
	$drone1 = new Bee();
	$drone2 = new Bee();
	$drone3 = new Bee();
	$drone4 = new Bee();
	$drone5 = new Bee();
	$drone6 = new Bee();
	$drone7 = new Bee();
	$drone8 = new Bee();
	
	// Queen
	$queen->Type("Queen");
	$queen->Worth(100);
	$queen->Hitpoints(8);
	
	// Workers
	$worker1->Type("Worker");
	$worker1->Worth(75);
	$worker1->Hitpoints(10);
	
	$worker2->Type("Worker");
	$worker2->Worth(75);
	$worker2->Hitpoints(10);
	
	$worker3->Type("Worker");
	$worker3->Worth(75);
	$worker3->Hitpoints(10);
	
	$worker4->Type("Worker");
	$worker4->Worth(75);
	$worker4->Hitpoints(10);
	
	$worker5->Type("Worker");
	$worker5->Worth(75);
	$worker5->Hitpoints(10);
	
	// Drones
	$drone1->Type("Drone");
	$drone1->Worth(50);
	$drone1->Hitpoints(12);
	
	$drone2->Type("Drone");
	$drone2->Worth(50);
	$drone2->Hitpoints(12);
	
	$drone3->Type("Drone");
	$drone3->Worth(50);
	$drone3->Hitpoints(12);
	
	$drone4->Type("Drone");
	$drone4->Worth(50);
	$drone4->Hitpoints(12);
	
	$drone5->Type("Drone");
	$drone5->Worth(50);
	$drone5->Hitpoints(12);
	
	$drone6->Type("Drone");
	$drone6->Worth(50);
	$drone6->Hitpoints(12);
	
	$drone7->Type("Drone");
	$drone7->Worth(50);
	$drone7->Hitpoints(12);
	
	$drone8->Type("Drone");
	$drone8->Worth(50);
	$drone8->Hitpoints(12);
	
	$_SESSION["bees"] = array(serialize($queen), serialize($worker1), serialize($worker2), serialize($worker3), serialize($worker4), serialize($worker5), serialize($drone1), serialize($drone2), serialize($drone3), serialize($drone4), serialize($drone5), serialize($drone6), serialize($drone7), serialize($drone8));
}

$randomindex = rand(0, (count($_SESSION["bees"]) -1));

$beetokill = unserialize($_SESSION["bees"][$randomindex]);

?>

<!DOCTYPE HTML>
<html lang="nl">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />			
		<title>Shoot the Bee!</title>
		<link rel="stylesheet" type="text/css" href="css/screen.css" />
	</head>
	<body>
		<div class="viewport">
		<?php
		
		echo "<h1>" . $beetokill->Type() . "</h1>";
		echo "Worth: " . $beetokill->Worth() . "<br />";
		echo "Hits: " . $beetokill->Hits() . "<br />";
		echo "Hitpoints: " . $beetokill->Hitpoints();
		
		?>
		</div>
		<div class="controls">
			<a class="shoot" href="?index=<?php echo $randomindex; ?>">SHOOT!</a>&nbsp;<span class="points">3 points</span>
		</div>
	</body>