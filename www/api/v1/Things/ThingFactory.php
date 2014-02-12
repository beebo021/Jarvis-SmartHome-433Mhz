<?php
require_once 'Things/Actuators/ActuatorFactory.php';
require_once 'Things/Sensors/SensorFactory.php';
require_once 'Things/Others/Area.php';


class ThingFactory
{
	function thingWithData($data)
	{
		$kind = $data["kind"];
		
		if ($kind=="Actuator") {
			$factory = new ActuatorFactory();
			$thing = $factory->thingWithData($data);
		} else if ($kind=="Sensor") {
			$factory = new SensorFactory();
			$thing = $factory->thingWithData($data);
		} else if ($kind=="Area") {
			$thing = new Area();
			$thing->initWithData($data);
		}

		return $thing;
	}
	
	function newThingWithKind($kind)
	{
		if ($kind=="actuator") {
			$factory = new ActuatorFactory();
			$thing = $factory->newThing();
		} else if ($kind=="sensor") {
			$factory = new SensorFactory();
			$thing = $factory->newThing();
		} else if ($kind=="area") {
			$thing = new Area();
			$thing->initWithPost();
			$thing->save();
		}

		return $thing;
	}
}
?>