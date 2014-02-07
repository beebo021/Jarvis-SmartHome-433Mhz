<?php
require_once 'model/Thing.php';
require_once 'factory/ActuatorFactory.php';

require_once 'model/Area.php';


class ThingFactory
{
	function thingForData($data)
	{
		$kind = $data["kind"];
		
		if ($kind=="Actuator") {
			$factory = new ActuatorFactory();
			$thing = $factory->thingForData($data);
		} else if ($kind=="Area") {
			$thing = new Area();
			$thing->initWithData($data);
		}

		return $thing;
	}
}
?>