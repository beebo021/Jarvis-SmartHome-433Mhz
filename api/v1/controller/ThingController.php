<?php

require_once 'factory/ThingFactory.php';
require_once 'model/Thing.php';

class ThingController
{
	var $conection;
	var $tableName;	
	
	public function __construct() 
	{
		$this->tableName = "things";
		$this->conection = new Mysql();
	}
	
	function thingsForParent ($cod_parent)
	{
		$factory = new ThingFactory();
	
		$r = array();
		
		$result = $this->conection->consult("SELECT * FROM things WHERE cod_parent = '".$cod_parent."' ORDER BY ord ASC, name ASC");
		
		while ($line = mysql_fetch_array($result))
		{
			$r[] = $factory->thingForData($line);
		}
	
		return $r;
	}
	
	function thingForCod ($cod)
	{
		$factory = new ThingFactory();
	
		$r = array();
		
		$line = $this->conection->consultLine("SELECT * FROM things WHERE cod='".$cod."' LIMIT 1");
		
		if ($line)
		{
			$thing = $factory->thingForData($line);
			return $thing;
		}
	}
}
?>