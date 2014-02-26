<?php
require_once 'Things/Actuators/RF433_socket/Class/php_serial.class.php';
require_once 'Class/Mysql.php';

function readSerial()
{
	$conection = new Mysql();

	$serial = new phpSerial;
	$serial->deviceSet("/dev/ttyUSB0");
	
	$serial->confBaudRate(9600);
	$serial->confParity("none");  //Parity (this is the "N" in "8-N-1")
    $serial->confCharacterLength(8); //Character length     (this is the "8" in "8-N-1")
    $serial->confStopBits(1);  //Stop bits (this is the "1" in "8-N-1")
    $serial->confFlowControl("none");

	$serial->deviceOpen(); 
	
	$lastReceive = "";
	
	while (1)
	{
		echo "Waiting...";
		//usleep(250000); // 0,25 Second
		
		$nowReceive = $serial->readUntil("#");
		
		while (strlen($nowReceive)>3)
		{
			$nowTime = time(); 
			
			//echo "now: ".$nowTime."\n";
			//echo "last: ".$lastTime."\n";
			//echo "dif: ".($nowTime-$lastTime)."\n\n";
		
			if ($lastReceive == $nowReceive)
			{
				if (($nowTime-$lastTime)>2) 
				{
					$insert = 1;
				}
				else
				{
					$insert = 0;
				}
			}
			else
			{
				$insert = 1;
			}
			
			if ($insert)
			{
				$lastReceive = $nowReceive;
				$lastTime = $nowTime;
			
				echo "\n";
				echo "\n";
				echo date("D/m/Y H:i:s", $nowTime);
				echo "\n";
				echo $nowReceive;
				echo "\n";
				echo "\n";
				
				$received = substr($nowReceive, 0, -1);
				
				$values = split(";", $received);
				
				$consult = "INSERT INTO rf433_log VALUES (NULL, '".$values[0]."', '".$values[1]."', '".$values[2]."', '".$values[3]."', NOW())";

				$conection->consultIns($consult);				
			}
		
			$nowReceive = "";
			$nowReceive = $serial->readLine();
		}
	}
	
	$serial->deviceClose(); 
	
	
}


readSerial();

?>