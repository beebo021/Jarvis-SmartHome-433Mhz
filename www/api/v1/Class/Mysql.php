<?php
class Mysql
{
	private static $instance = null;
	
	var $host = "localhost";
	var $user = "root";
	//var $pass = "raspberry";
	var $pass = "Fb8HxuyP4%AvWhJnwQaf";
	var $db = "jarvis";
	
	
	public function __construct() 
	{
		$error=0;
		
		$mysql=mysql_connect($this->host, $this->user, $this->pass);
		if (!$mysql)
		{
			$error=1;
		}
		else
		{
			$mysql=mysql_select_db($this->db);
			if (!$mysql)
			{
				$error = 2;
			}
			
			mysql_set_charset("utf8");
		}
		
		return($error);
	}

	public static function singleton() 
	{
		if( self::$instance == null ) 
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	function consultOne ($consulta)
	{
		$resultado = mysql_query($consulta);
		if ($resultado)
		{
			$linea=mysql_fetch_array($resultado);
			return ($linea[0]);
		}
		else
		{
			return(0);
		}
	}
	
	function consultLine ($consulta)
	{
		$resultado = mysql_query($consulta);
		if ($resultado)
		{
			$linea=mysql_fetch_array($resultado);
			return ($linea);
		}
		else
		{
			return(0);
		}
	}


	function consultUpd ($consulta)
	{
		$resultado = mysql_query($consulta);
		
		$filas = mysql_affected_rows();
		
		return($filas);
	}
	
	
	function consultDel ($consulta)
	{
		$resultado = mysql_query($consulta);
		return(mysql_affected_rows());
	}


	public function consultIns ($consulta)
	{
		$resultado = mysql_query($consulta);
		if (!$resultado)
		{
			echo 'ERROR: Function consultIns !!!';
			echo $consulta;
			exit;
		}
		else
		{
			return (mysql_insert_id());
		}
	}
	
	
	function consultList($consulta)
	{
		$resultado = mysql_query($consulta);
		
		while ($linea = mysql_fetch_array($resultado))
		{
			$r.=$linea[0].", ";
		}
		
		$r = substr($r, 0, -2);
		
		return ($r);
	}
	
	function consult ($consulta)
	{
	    $resultado = mysql_query($consulta);
	    return($resultado);
	}
}
?>