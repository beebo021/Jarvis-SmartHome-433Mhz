<?php
	require_once 'Class/Mysql.php';
	require_once 'Things/ThingController.php';
	require_once 'Things/Thing.php';
	
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
				echo ".";
				//sleep(1); // 1 Second
				//usleep(1000000); // 1 Second
				usleep(250000); // 0,25 Second
			}
		}
	}
	
	function check()
	{
		$conection = new Mysql();
		
		$result = $conection->consult("SELECT * FROM cmds_queue WHERE triggerAt <= NOW() AND executed=0 ORDER BY triggerAt ASC LIMIT 10");
		
		$num = mysql_num_rows($result);
		
		if ($num)
		{
			$controller = new ThingController();
				
			while ($line = mysql_fetch_array($result))
			{
				echo "*";
				
				$thing = $controller->thingWithCod($line["cod_thing"]);
				$thing->sendCmd($line["cmd"], $line["value"]);
				
				$consult = "UPDATE cmds_queue
							SET executed = '1', executedAt = NOW() 
							WHERE cod = '".$line["cod"]."'";

				$conection->consultUpd($consult);
			}
		}
		
		return $num;
	}