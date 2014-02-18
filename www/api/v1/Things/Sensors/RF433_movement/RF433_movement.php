<?php

class RF433_movement extends Thing
{	
	var $className;
	var $commands;
	
	public function __construct() 
	{
		parent::__construct();
		$this->className = "RF433_socket";
		$this->commands = array();
		$this->cmdList = array();
		$this->cmdList[] = "ON";
	}
	
	function initWithPost() 
	{
		$this->kind = "Area";
		$this->name = $_POST["name"];
		$this->status = 0;
		$this->icon = $_POST["icon"];
		$this->cod_parent = $_POST["cod_parent"];
		$this->ord = $_POST["ord"];
		
		$this->commands["ON"] = $_POST["commands"]["ON"];
	}
	
	function updateWithPost()
	{
		$this->name = $_POST["name"];
		$this->icon = $_POST["icon"];
		$this->cod_parent = $_POST["cod_parent"];
		$this->ord = $_POST["ord"];
		
		$this->commands["ON"] = $_POST["commands"]["ON"];
	}
	
	function initWithData($data) 
	{
		parent::initWithData($data);
		
		$this->commands["ON"] = $this->config->commands->ON;
	}
	
	function configDescription()
	{
		$r = array();
		
		$r["className"] = $this->className;
		$r["cmdList"] = $this->cmdList;
		
		return $r;
	}
	
	function configDetail()
	{
		$r = array();
		
		$r["className"] = $this->className;
		$r["commands"] = $this->commands;
		
		return json_encode($r);
	}
	
	function sendCmd($cmd, $value)
	{
		if ($cmd=="ON")
		{
			$this->setStatus(1);
		}
		else 
		{
			echo "Thing -> RF433_socket -> sendCmd($cmd, $value) -> ERROR";
		}
	}
	
	function update() 
	{
		parent::update();
		
		$consult = "UPDATE rf433_daemon 
					SET rfString = '".$this->commands["ON"]."'
					WHERE cod_thing = '".$this->cod."' AND cmd = 'ON'";

		$r = $this->conection->consultUpd($consult);
	}
	
	function insert() 
	{
		parent::insert();
		$consult = "INSERT INTO rf433_daemon 
					VALUES ( NULL,
							'".$this->cod."', 
							'ON', 
							'0', 
							'".$this->commands["ON"]."')";

		$cod = $this->conection->consultIns($consult);
		
		if ($cod) $this->cod = $cod;
	}
}
?>