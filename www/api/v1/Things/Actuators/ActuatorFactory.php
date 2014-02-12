<?php
require_once 'Things/Thing.php';
require_once 'Things/Actuators/RF433_socket/RF433_socket.php';


class ActuatorFactory
{
	function thingWithData($data)
	{
		$config = json_decode($data["config"]);
		
		if ($config->className=="RF433_socket") {
			
			$thing = new RF433_socket();
		}
		
		$thing->initWithData($data);

		return $thing;
	}
	
	function newThing() 
	{
		/*$config = json_decode($_POST["config"]);
		
		if ($config->className=="RF433_socket") 
		{
			$thing = new RF433_socket();
		}*/
		
		$thing = new RF433_socket();
		
		$thing->initWithPost();
		$thing->save();

		return $thing;
	}
}
?>