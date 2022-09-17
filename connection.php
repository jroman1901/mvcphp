<?php 

/**
* CREAMOS AUNA CLASE ESPECIAL PARA PODER REALIZAR LA CONEXION A LA BASE DE DATOS
*/
class Db  
{
	//CREAMOS UNA VARIALBE DE INSTANCIA COMO NULL
	private static $instance=NULL;
	
	//EL CONSTRUCTOR DE LA CLASE EN PHP
	function __construct(){}

		//DEFINIMOS UNA FUNCION ESTATICA PARA PODER REALIZAR LA OPERACIÓN DE LA CONEXION CON LA BASE DE DATOS
	public static function  getConnect()
	{

		if (!isset(self::$instance)) // ESTA FUNCION VALIDA SI LA INSTANCIA EXISTE
		{
			//UTILIZAMOS PDO
			$pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;	
			// PARAMETROS NECESARIOS PARA PASAR A LA BASE DE DATOS		
			self::$instance= new PDO('mysql:host=localhost;dbname=umg','root','1234',$pdo_options);
		} 
		return self::$instance;
	}
}

 ?>