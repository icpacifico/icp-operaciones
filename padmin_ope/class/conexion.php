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
		    self::$conexionDB = new PDO("mysql:host=$this->servidor;dbname=$this->base_datos", $this->usuario, $this->pass);		   
		    self::$conexionDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		    
		}catch (PDOException $e){ $this->status(3, $e->getMessage());}					  				
	}
	
	public function cerrar(){
		try {
			self::$conexionDB = null;
		}catch (PDOException $e){ $this->status(3, $e->getMessage());}		
	}

	public function consulta_form($consulta,$valor){
		try {
			self::$ejecutar = self::$conexionDB->prepare($consulta);		    
		    self::$ejecutar->execute($valor);		   
		}catch (PDOException $e){ $this->status(3, $e->getMessage());}
	}

	public static function select($consulta){
		try {
			// $con = self::$conexionDB->query($consulta);
			$con = self::$conexionDB->prepare($consulta);
			$con->execute();
			return $con->fetchAll(PDO::FETCH_ASSOC);			
			// return $query;			
		}catch (PDOException $e){ $this->status(3, $e->getMessage());}
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
		}catch (PDOException $e){ $this->status(3, $e->getMessage());}
	}

	public static function consulta_total($query){
		try {
			$rows = self::$conexionDB->query($query);
			return $rows->rowCount();		
	    }catch (PDOException $e){ $this->status(3, $e->getMessage());}
	}

	//-------EJECUTA UNA CONSULTA A LA BASE DE DATOS SIN PARAMETRO DE PRUEBA
	public function consulta_prueba($consulta){
		try {
			self::$ejecutar = self::$conexionDB->query($consulta);			
		}catch (PDOException $e){ $this->status(3, $e->getMessage());}
	}
	//-------EXTRAE LOS REGISTROS DE UNA TABLA
	public function extraer_registro(){
	    try{
			$file='';
			return ($file = self::$ejecutar->fetchAll(PDO::FETCH_ASSOC)) ? $file : false;
		}catch (PDOException $e){ $this->status(3, $e->getMessage());}
	}
	//-------EXTRAE LOS REGISTROS DE UNA TABLA
	public function extraer_registro_unico(){
		try {
			$file='';
			return ($file = self::$ejecutar->fetch()) ? $file : false;
		}catch (PDOException $e){ $this->status(3, $e->getMessage());}		
	}
	//-------CANTIDAD DE REGISTROS DE UNA CONSULTA
	public function total(){
		try {
			return self::$ejecutar->rowCount();
		}catch (PDOException $e){ $this->status(3, $e->getMessage());}		
	}
	//-------DEVUELVE EL ULTIMO ID DESPUES DE UNA INSERCION
	public function ultimo_id(){
		try {
			return self::$conexionDB->lastInsertId();		
	    }catch (PDOException $e){ $this->status(3, $e->getMessage());}		
	}

	private function status($tipo,$msj){
		$jsondata['envio'] = $tipo;
		$jsondata['error_consulta'] = $msj;
		echo json_encode($jsondata);
		exit();
	}
}
?>