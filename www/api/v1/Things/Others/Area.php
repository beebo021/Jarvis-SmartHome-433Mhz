<?php

class Area extends Thing
{	
	var $className;
	var $commands;
	
	public function __construct() 
	{
		parent::__construct();
		$this->className = "Area";
		$this->commands = array();
		$this->cmdList = array();
	}
	
	function initWithPost() 
	{
		$this->kind = "Area";
		/*$this->name = $_POST["name"];
		$this->status = 0;
		$this->icon = $_POST["icon"];
		$this->cod_area = $_POST["cod_area"];
		$this->ord = $_POST["ord"];*/
	}
	
	function updateWithPost()
	{
		$this->name = $_POST["name"];
		$this->icon = $_POST["icon"];
		$this->cod_area = $_POST["cod_area"];
		$this->ord = $_POST["ord"];
	}
	
	function configDetail()
	{
		$r = array();
		
		$r["config"] = "";
		
		return json_encode($r);
	}
}
?>