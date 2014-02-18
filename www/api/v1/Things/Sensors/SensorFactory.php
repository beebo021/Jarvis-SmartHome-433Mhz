<?php
require_once 'Things/Thing.php';
require_once 'Things/Sensors/RF433_movement/RF433_movement.php';


class SensorFactory
{
	function thingWithData($data)
	{
		$config = json_decode($data["config"]);
		
		if ($config->className=="RF433_movement") {
			
			$thing = new RF433_movement();
		}
		
		$thing->initWithData($data);

		return $thing;
	}
	
	function newThing() 
	{
		$thing = new RF433_movement();
		
		$thing->initWithPost();
		$thing->save();

		return $thing;
	}
}
?>