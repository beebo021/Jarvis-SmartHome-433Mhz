<?php
require_once 'Things/Rules/Rule.php';

class Thing
{
	var $conection;
	var $tableName;	

	var $cmdList;
	
	var $cod;
	var $kind;
	var $name;
	var $icon;
	var $cod_parent;
	var $ord;	
	var $config;
	var $status;
	var $createdAt;
	var $updatedAt;
	
	public function __construct() 
	{
		$this->tableName = "things";
		$this->conection = new Mysql();
	}
	
	function initWithData($data) 
	{
		$this->cod = $data["cod"];
		$this->kind = $data["kind"];
		$this->name = $data["name"];
		$this->status = $data["status"];
		$this->icon = $data["icon"];
		$this->cod_parent = $data["cod_parent"];
		$this->ord = $data["ord"];
		$this->createdAt = $data["createdAt"];
		$this->updatedAt = $data["updatedAt"];

		$this->config = json_decode($data["config"]);
	}
		
	function getCmdList()
	{
		return $this->cmdList;
	}
	
	function getStatus()
	{
		return $this->status;
	}
	
	function setStatus($status)
	{
		$this->addStatusLog($status);
		$this->status = $status;
		$this->save();
		$this->checkRules();
	}
	
	function description()
	{
		$r = array();
		
		$r["cod"] = $this->cod;
		$r["kind"] = $this->kind;
		$r["name"] = $this->name;
		$r["icon"] = $this->icon;
		$r["cod_parent"] = $this->cod_parent;
		$r["ord"] = $this->ord;
		$r["status"] = $this->status;
		$r["updatedAt"] = $this->updatedAt;
		$r["createdAt"] = $this->createdAt;
		
		$r["config"] = $this->configDescription();
		
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
						kind = '".$this->kind."', 
						name = '".$this->name."', 
						icon = '".$this->icon."', 
						cod_parent = '".$this->cod_parent."', 
						ord = '".$this->ord."', 
						status = '".$this->status."',
						createdAt = '".$this->createdAt."',
						updatedAt = NOW(),
						config = '".$this->configDetail()."' 
					WHERE 
						cod = '".$this->cod."'";

		$r = $this->conection->consultUpd($consult);
	}
	
	function insert() 
	{
		$consult = "INSERT INTO 
						".$this->tableName." 
					VALUES ( NULL,
							'".$this->kind."', 
							'".$this->name."', 
							'".$this->configDetail()."', 
							'".$this->status."',
							'".$this->icon."', 
							'".$this->cod_parent."', 
							'".$this->ord."', 
							NOW(),
							NOW() )";

		$cod = $this->conection->consultIns($consult);
		
		if ($cod) $this->cod = $cod;
	}

	function getRules($timely) {
		
		$r = array();
		
		$result = $this->conection->consult("SELECT * FROM rules WHERE cod_thing = '".$this->cod."' AND timely = '".$timely."' ORDER BY name ASC");
		
		while ($line = mysql_fetch_array($result))
		{
			$rule = new Rule();
			$rule->initWithData($line);
			$r[] = $rule;
		}
	
		return $r;
	}
	
	function checkRules() {
		
		$rules = $this->getRules(0); //No timely
		
		foreach ($rules as &$rule) 
		{
	    	$rule->check();
		}
	}

	function addCmd($delay, $cmd, $value) {
		
		$triggerAt = date("Y-m-d H:i:s", strtotime("+".$delay." seconds"));
		
		$consult = "INSERT INTO cmds_queue
					VALUES ( NULL,
							'".$this->cod."', 
							'".$cmd."', 
							'".$value."', 
							'".$triggerAt."',
							'', 
							'0' )";
		
		$this->conection->consultIns($consult);
	}
	
	function addStatusLog($status)
	{
		$consult = "INSERT INTO things_log
					VALUES ( NULL,
							'".$this->cod."', 
							'".$status."', 
							NOW() )";
		
		$this->conection->consultIns($consult);
	}
	
	function initWithPost() {}
	function updateWithPost() {}
	function configDescription() {}
	function configDetail() {}
	function sendCmd($cmd, $value) {}
}
?>