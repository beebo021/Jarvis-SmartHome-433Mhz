<?php
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
	
	function initWithPost() 
	{
	}
	
	function updateWithPost()
	{
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
		$this->status = $status;
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
	
	function configDescription() {}
	function configDetail() {}
	
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
	
	function sendCmd($cmd, $value) {}
}
?>