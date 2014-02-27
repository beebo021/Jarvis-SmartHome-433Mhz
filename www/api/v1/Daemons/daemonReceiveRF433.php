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
		echo ".";
		usleep(100000); // 0,1 Second
		
		$received = $serial->readUntil("#");
		
		if (strlen($received))
		{
			echo "\n\n".date("D/m/Y H:i:s")."\n".$received."\n"."\n";
			
			$received = substr($received, 0, -1);

			$values = split(";", $received);

			$consult = "INSERT INTO rf433_log VALUES (NULL, '".$values[0]."', '".$values[1]."', '".$values[2]."', '".$values[3]."', NOW())";
			$conection->consultIns($consult);				
		}
		
		$received = "";
	}
	
	$serial->deviceClose(); 
}

readSerial();

?>