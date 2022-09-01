<?php

class conexion
{
	private static $conexionDB;
	private static $ejecutar;
	private $servidor;
	private $usuario;
	private $pass;
	private $base_datos;
	private $descriptor;
	private $close;
	private $sql;
	private $error;
	
	//-------PARAMETROS DE CONEXION
	function __construct(){
		$this->servidor = _SERVER;
		$this->usuario = _USER;
		$this->pass = _PASS;
		$this->base_datos = _DB;
		$this->conectar_base_datos();
	}
	//-------CONEXION A UNA BASE DE DATOS
	private function conectar_base_datos(){
		try {		 
			$options = array(
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION
			 );   
		    self::$conexionDB = new PDO("mysql:host=$this->servidor;dbname=$this->base_datos", $this->usuario, $this->pass,$options);		   
		    // self::$conexionDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		    
		}catch (PDOException $e){ 			
			
			$this->status("Error Grave!",$this->codeError($e),"error","#");    		
		}					  				
	}
	
	public function cerrar(){
		try {
			self::$conexionDB = null;
		}catch (PDOException $e){ 
			$this->status("Error Grave!",$this->codeError($e),"error","#");
		}		
	}

	public function consulta_form($consulta,$valor){
		try {
			self::$ejecutar = self::$conexionDB->prepare($consulta);		    
		    self::$ejecutar->execute($valor);		   
		}catch (PDOException $e){ 
			$this->status("Error Grave!",$this->codeError($e),"error","#");
		}
	}

	public static function select($consulta){
		try {
			// $con = self::$conexionDB->query($consulta);
			$con = self::$conexionDB->prepare($consulta);
			$con->execute();
			return $con->fetchAll(PDO::FETCH_ASSOC);			
		}catch (PDOException $e){ 
			$this->status("Error Grave!",$this->codeError($e),"error","#");
		}
	}
	
	public function consulta_form_prueba($consulta,$valor){
		try {
			self::$ejecutar = self::$conexionDB->prepare($consulta);		    
		    self::$ejecutar->execute($valor);		   
		}catch (PDOException $e){ $this->status(3, $e->getMessage());}
	}
	//-------EJECUTA UNA CONSULTA A LA BASE DE DATOS SIN PARAMETRO
	public function consulta($consulta){
		try {
			self::$ejecutar = self::$conexionDB->query($consulta);
		}catch (PDOException $e){ 
			$this->status("Error Grave!",$this->codeError($e),"error","#");
		}
	}

	public static function consulta_total($query){
		try {
			$rows = self::$conexionDB->query($query);
			return $rows->rowCount();		
	    }catch (PDOException $e){ 
			$this->status("Error Grave!",$this->codeError($e),"error","#");
		}
	}

	//-------EJECUTA UNA CONSULTA A LA BASE DE DATOS SIN PARAMETRO DE PRUEBA
	public function consulta_prueba($consulta){
		try {
			self::$ejecutar = self::$conexionDB->query($consulta);			
		}catch (PDOException $e){ 
			$this->status("Error Grave!",$this->codeError($e),"error","#");
		}
	}
	//-------EXTRAE LOS REGISTROS DE UNA TABLA
	public function extraer_registro(){
	    try{
			$file='';
			return ($file = self::$ejecutar->fetchAll(PDO::FETCH_ASSOC)) ? $file : false;
		}catch (PDOException $e){ 
			$this->status("Error Grave!",$this->codeError($e),"error","#");
		}
	}
	//-------EXTRAE LOS REGISTROS DE UNA TABLA
	public function extraer_registro_unico(){
		try {
			$file='';
			return ($file = self::$ejecutar->fetch()) ? $file : false;
		}catch (PDOException $e){ 
			$this->status("Error Grave!",$this->codeError($e),"error","#");
		}		
	}
	//-------CANTIDAD DE REGISTROS DE UNA CONSULTA
	public function total(){
		try {
			return self::$ejecutar->rowCount();
		}catch (PDOException $e){ 
			$this->status("Error Grave!",$this->codeError($e),"error","#");
		}		
	}
	//-------DEVUELVE EL ULTIMO ID DESPUES DE UNA INSERCION
	public function ultimo_id(){
		try {
			return self::$conexionDB->lastInsertId();		
	    }catch (PDOException $e){ 
			$this->status("Error Grave!",$this->codeError($e),"error","#");
		}		
	}

	public function status($title,$message,$icon,$action){
		$jsondata['title'] = $title;
		$jsondata['message'] = $message;
		$jsondata['icon'] = $icon;
		$jsondata['action'] = $action;		
		print json_encode($jsondata);
		die();
	}
	public function codeError($error){
		    $message = explode(' ', $error->getMessage());
			$dbCode = rtrim($message[1], ']');
			$dbCode = trim($dbCode, '[');
			// codes specific to MySQL
			switch ($dbCode) {
				case 1049:
					$userMessage = 'Base de datos desconocida - probablemente error de configuración:';					
					break;
				case 2002:
					$userMessage = 'LA BASE DE DATOS ESTÁ CAÍDA:';
					break;
				case 1045:
					$userMessage = 'Credenciales de base de datos incorrectas:';
					break;
				default:
					$userMessage = 'Error no detectado: '.$error->getMessage();
					break;
			}
			return $userMessage;
	}
}
?>