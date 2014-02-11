<?php
require_once 'Things/ThingController.php';
require_once 'Things/Thing.php';

class Condition
{
	var $conection;
	var $tableName;	

	var $cod;
	var $cod_rule;
	var $cod_thing;
	var $trigger;
	var $condition;
	var $value;
	var $triggeredAt;
	
	public function __construct() 
	{
		$this->tableName = "rules_conditions";
		$this->conection = new Mysql();
	}
	
	function initWithData($data) 
	{
		$this->cod = $data["cod"];
		$this->cod_rule = $data["cod_rule"];
		$this->cod_thing = $data["cod_thing"];
		$this->trigger = $data["trigger"];
		$this->condition = $data["condition"];
		$this->value = $data["value"];
		$this->triggeredAt = $data["triggeredAt"];
	}
	
	function description()
	{
		$r = array();
		
		$r["cod"] = $this->cod;
		$r["cod_thing"] = $this->cod_thing;
		$r["trigger"] = $this->trigger;
		$r["condition"] = $this->condition;
		$r["value"] = $this->value;
		
		return $r;
	}
		
	function save() 
	{
		if ($this->cod)
		{
			$this->update();
		}
		else 
		{
			$this->insert();
		}
	}
	
	function update() 
	{
		$consult = "UPDATE 
						".$this->tableName." 
					SET 
						cod_thing = '".$this->cod_thing."', 
						trigger = '".$this->trigger."', 
						condition = '".$this->condition."', 
						value = '".$this->value."', 
						triggeredAt = '".$this->triggeredAt."'
					WHERE 
						cod = '".$this->cod."'";

		$r = $this->conection->consultUpd($consult);
	}
	
	function insert() 
	{
		$consult = "INSERT INTO 
						".$this->tableName." 
					VALUES ( NULL,
							'".$this->cod_rule."', 
							'".$this->cod_thing."', 
							'".$this->trigger."', 
							'".$this->condition."',
							'".$this->value."', 
							'".$this->triggeredAt."' )";

		$cod = $this->conection->consultIns($consult);
		
		if ($cod) $this->cod = $cod;
	}
	
	function check()
	{
		$r = 0;

		$controller = new ThingController();
		$thing = $controller->thingWithCod($this->cod_thing);
		
		switch ($this->condition) {
		    case "=":
		        if ($thing->getStatus() == $this->value) $r = 1;
		        break;
		    case "!=":
		        if ($thing->getStatus() <> $this->value) $r = 1;
		        break;
		    case ">":
		        if ($thing->getStatus() > $this->value) $r = 1;
		        break;
		    case "<":
		        if ($thing->getStatus() < $this->value) $r = 1;
		        break;
		}
		
		return $r;		
	}
}
?>