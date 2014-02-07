<?php
require_once 'model/Thing.php';
require_once 'model/RF433_socket.php';


class ActuatorFactory
{
	function thingForData($data)
	{
		$config = json_decode($data["config"]);
		
		if ($config->className=="RF433_socket") {
			
			$thing = new RF433_socket();
		}
		
		$thing->initWithData($data);

		return $thing;
	}
}
?>