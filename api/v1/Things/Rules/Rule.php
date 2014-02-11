<?php
require_once 'Things/Rules/Condition.php';
require_once 'Things/Rules/Command.php';

class Rule
{
	var $conection;
	var $tableName;	

	var $cod;
	var $cod_thing;
	var $name;
	var $timely;
	var $atTime;
	var $atDate;	
	var $repeat;
	var $active;
	var $triggeredAt;
	
	public function __construct() 
	{
		$this->tableName = "rules";
		$this->conection = new Mysql();
	}
	
	function initWithData($data) 
	{
		$this->cod = $data["cod"];
		$this->cod_thing = $data["cod_thing"];
		$this->name = $data["name"];
		$this->timely = $data["timely"];
		$this->atTime = $data["atTime"];
		$this->atDate = $data["atDate"];
		$this->repeat = $data["repeat"];
		$this->active = $data["active"];
		$this->triggeredAt = $data["triggeredAt"];
	}
		
	function getActive()
	{
		return $this->active;
	}
	
	function setActie($active)
	{
		$this->active = $active;
	}
	
	function description()
	{
		$r = array();
		
		$r["cod"] = $this->cod;
		$r["name"] = $this->name;
		$r["timely"] = $this->timely;
		$r["atTime"] = $this->atTime;
		$r["atDate"] = $this->atDate;
		$r["repeat"] = $this->repeat;
		$r["active"] = $this->active;
		$r["condition"] = $this->getCondition()->description();
		$r["filters"] = array();
		$r["commands"] = array();
		
		$filters = $this->getFilters();
		
		foreach ($filters as &$filter) 
		{
    		$r["filters"][] = $filter->description();
		}
		
		$commands = $this->getCommands();
		
		foreach ($commands as &$command) 
		{
    		$r["commands"][] = $command->description();
		}
		
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
						name = '".$this->name."', 
						timely = '".$this->timely."', 
						atTime = '".$this->atTime."', 
						atDate = '".$this->atDate."', 
						`repeat` = '".$this->repeat."',
						active = '".$this->active."',
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
							'".$this->cod_thing."', 
							'".$this->name."', 
							'".$this->timely."', 
							'".$this->atTime."',
							'".$this->atDate."', 
							'".$this->repeat."', 
							'".$this->active."',
							'".$this->triggeredAt."' )";

		$cod = $this->conection->consultIns($consult);
		
		if ($cod) $this->cod = $cod;
	}
	
	function getCondition() 
	{
		$line = $this->conection->consultLine("SELECT * FROM rules_conditions WHERE cod_rule = '".$this->cod."' AND `trigger` = '1' LIMIT 1");
		
		$condition = new Condition();
		$condition->initWithData($line);

		return $condition;
	}
	
	function getFilters() 
	{
		$r = array();
		
		$result = $this->conection->consult("SELECT * FROM rules_conditions WHERE cod_rule = '".$this->cod."' AND `trigger` = '0' ORDER BY cod ASC");
		
		if ($result)
		{
			while ($line = mysql_fetch_array($result))
			{
				$condition = new Condition();
				$condition->initWithData($line);
				$r[] = $condition;
			}
		}
	
		return $r;
	}
	
	function getCommands() 
	{
		$r = array();
		
		$result = $this->conection->consult("SELECT * FROM rules_commands WHERE cod_rule = '".$this->cod."' ORDER BY `order` ASC");
		
		if ($result)
		{
			while ($line = mysql_fetch_array($result))
			{
				$command = new Command();
				$command->initWithData($line);
				$r[] = $command;
			}
		}
	
		return $r;
	}
	
	function check()
	{
		if (!$this->timely) 
		{
			$condition = $this->getCondition();
			
			$conditionResult = $condition->check();
					
			if ($conditionResult)
			{
				$filterResult = 1;
				
				$filters = $this->getFilters();
				
				foreach ($filters as &$filter) 
				{
			    	$result = $filter->check();
			    	
			    	if (!$result) $filterResult = 0;
				}
				
				if ($filterResult)
				{
					$this->triggered();
					
					$commands = $this->getCommands();
				
					foreach ($commands as &$command) 
					{
				    	$command->exec();
					}
				}
			}
		}
	}
	
	function triggerTime()
	{
		if ($this->timely) 
		{
			$this->triggered();
		
			$commands = $this->getCommands();
			
			foreach ($commands as &$command) 
			{
		    	$command->exec();
			}
		}
	}
	
	function triggered()
	{
		
		$this->triggeredAt = date("Y-m-d H:i:s");
		$this->save();

		if ($this->timely) 
		{
			$this->timelyProgramNext();
		}		
	}
	
	function timelyProgramNext()
	{
		if (strlen($this->repeat) == 0)
		{
			$this->active = 0;
		}
		else
		{
			$next = 1;
			
			$today = date("N");
			
			$days = split(";", $this->repeat);
			
			foreach ($days as &$day)
			{
				if ($day > $today)
				{
					if ($next < $today)
					{
						$next = $day;
					}
				}
			}
			
			switch ($next) {
			    case 1:
			        $next = "monday";
			        break;
			    case 1:
			        $next = "tuesday";
			        break;
			    case 3:
			        $next = "wednesday";
			        break;
			    case 4:
			        $next = "thursday";
			        break;
			    case 5:
			        $next = "friday";
			        break;
		        case 6:
			        $next = "saturday";
			        break;
		        case 7:
			        $next = "sunday";
			        break;
			}
			
			$nextDate = date("Y-m-d", strtotime("next ".$next));
		
			$this->atDate = $nextDate;
		}		
		
		$this->save();
	}
}
?>