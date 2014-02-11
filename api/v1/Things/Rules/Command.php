<?php
require_once 'Things/ThingController.php';
require_once 'Things/Thing.php';

class Command
{
	var $conection;
	var $tableName;	

	var $cod;
	var $cod_rule;
	var $cod_thing;
	var $delay;
	var $cmd;
	var $value;
	var $order;
	var $triggeredAt;
	
	public function __construct() 
	{
		$this->tableName = "rules_commands";
		$this->conection = new Mysql();
	}
	
	function initWithData($data) 
	{
		$this->cod = $data["cod"];
		$this->cod_rule = $data["cod_rule"];
		$this->cod_thing = $data["cod_thing"];
		$this->delay = $data["delay"];
		$this->cmd = $data["cmd"];
		$this->value = $data["value"];
		$this->order = $data["order"];
		$this->triggeredAt = $data["triggeredAt"];
	}
	
	function description()
	{
		$r = array();
		
		$r["cod"] = $this->cod;
		$r["cod_thing"] = $this->cod_thing;
		$r["delay"] = $this->delay;
		$r["cmd"] = $this->cmd;
		$r["value"] = $this->value;
		$r["order"] = $this->order;
		
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
						delay = '".$this->delay."', 
						cmd = '".$this->cmd."', 
						value = '".$this->value."', 
						order = '".$this->order."',
						triggeredAt = '".$this->triggeredAt."',
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
							'".$this->delay."', 
							'".$this->cmd."',
							'".$this->value."', 
							'".$this->order."', 
							'".$this->triggeredAt."' )";

		$cod = $this->conection->consultIns($consult);
		
		if ($cod) $this->cod = $cod;
	}
	
	function exec()
	{
		$controller = new ThingController();
		$thing = $controller->thingWithCod($this->cod_thing);
		
		$thing->addCmd($this->delay, $this->cmd, $this->value);
	}
}
?>