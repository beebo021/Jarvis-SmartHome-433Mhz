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
}
?>