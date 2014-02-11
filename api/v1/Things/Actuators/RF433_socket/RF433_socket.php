<?php
require_once 'class/php_serial.class.php';

class RF433_socket extends Thing
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
		$this->cmdList[] = "OFF";
		$this->cmdList[] = "SWITCH";
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
		$this->commands["OFF"] = $_POST["commands"]["OFF"];
	}
	
	function updateWithPost()
	{
		$this->name = $_POST["name"];
		$this->icon = $_POST["icon"];
		$this->cod_parent = $_POST["cod_parent"];
		$this->ord = $_POST["ord"];
		
		$this->commands["ON"] = $_POST["commands"]["ON"];
		$this->commands["OFF"] = $_POST["commands"]["OFF"];
	}
	
	function initWithData($data) 
	{
		parent::initWithData($data);
		
		$this->commands["ON"] = $this->config->commands->ON;
		$this->commands["OFF"] = $this->config->commands->OFF;		
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
			$this->sendSerial($this->commands[$cmd]);
			$this->setStatus(1);
		}
		else if ($cmd=="OFF")
		{
			$this->sendSerial($this->commands[$cmd]);
			$this->setStatus(0);
		}
		else if ($cmd=="SWITCH")
		{
			if ($this->status == 1) $this->sendCmd("OFF", $value);
			else $this->sendCmd("ON", $value);
		}
		else 
		{
			echo "Thing -> RF433_socket -> sendCmd($cmd, $value) -> ERROR";
		}
	}
	
	function sendSerial($text)
	{
		/*$serial = new phpSerial;
		$serial->deviceSet("/dev/ttyUSB0");
		$serial->confBaudRate(9600);
		$serial->deviceOpen();
		$serial->sendMessage($text);
		$serial->deviceClose();*/
	}
}
?>