<?php
require_once 'Things/Thing.php';
require_once 'Things/ThingFactory.php';

class ThingController
{
	var $conection;
	var $tableName;	
	
	public function __construct() 
	{
		$this->tableName = "things";
		$this->conection = new Mysql();
	}
	
	function thingsUpdated ($updatedAt)
	{
		$factory = new ThingFactory();
	
		$r = array();
		
		$result = $this->conection->consult("SELECT * FROM things WHERE updatedAt > '".$updatedAt."' ORDER BY cod ASC");
		
		while ($line = mysql_fetch_array($result))
		{
			$r[] = $factory->thingWithData($line);
		}
	
		return $r;
	}
	
	function thingsWithParent ($cod_area)
	{
		$factory = new ThingFactory();
	
		$r = array();
		
		$result = $this->conection->consult("SELECT * FROM things WHERE cod_area = '".$cod_area."' ORDER BY ord ASC, name ASC");
		
		while ($line = mysql_fetch_array($result))
		{
			$r[] = $factory->thingWithData($line);
		}
	
		return $r;
	}
	
	function thingWithCod ($cod)
	{
		$factory = new ThingFactory();
	
		$r = array();
		
		$line = $this->conection->consultLine("SELECT * FROM things WHERE cod='".$cod."' LIMIT 1");
		
		if ($line)
		{
			$thing = $factory->thingWithData($line);
			return $thing;
		}
	}
	
	function newThingWithKind ($kind)
	{
		$factory = new ThingFactory();
		
		$thing = $factory->newThingWithKind($kind);
		
		return $thing;
	}
	
	function deleteThingWithCod($cod)
	{
		$this->conection->consultDel("DELETE FROM things WHERE cod='".$cod."' LIMIT 1");
		$this->conection->consultDel("DELETE FROM rf433_daemon WHERE cod_thing='".$cod."'");
	}
}
?>