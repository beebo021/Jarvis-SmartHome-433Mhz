<?php
	require_once 'Class/Mysql.php';
	require_once 'Things/ThingController.php';
	require_once 'Things/Thing.php';
	require_once 'Things/Rules/Rule.php';
	
	header('Content-Type: text/plain; charset=utf-8');
	mb_internal_encoding('UTF-8');
	mb_http_output('UTF-8');
	mb_http_input('UTF-8');
	
	main();
	
	function main()
	{
		while (1)
		{
			$num = check();
			
			if (!$num)
			{
				echo "...............";
				sleep(5);
			}
		}
	}
	
	function check()
	{
		$conection = new Mysql();
		
		$date = date("Y-m-d");
		$time = date("H:i:00");
		
		$result = $conection->consult("SELECT * FROM rules WHERE atDate = '".$date."' AND atTime <= '".$time."' AND active = '1' LIMIT 10");
		
		$num = mysql_num_rows($result);
		
		if ($num)
		{
			while ($line = mysql_fetch_array($result))
			{
				echo "*";
				
				$rule = new Rule();
				$rule->initWithData($line);				
				$rule->triggerTime();
			}
		}
		
		return $num;
	}