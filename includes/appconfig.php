<?php

date_default_timezone_set('America/Buenos_Aires');

class appconfig {

function conexion() {
		
		$hostname = "localhost";
		$database = "ss_aif_2018_junio";
		$username = "root";
		$password = "";
		
		
		
		/*
		$hostname = "localhost";
		$database = "u235498999_copa";
		$username = "u235498999_copa";
		$password = "rhcp7575";
		*/
		//u235498999_kike usuario
		
		
		/*
		$hostname = "localhost";
		$database = "u235498999_aifd";
		$username = "u235498999_aifd";
		$password = "rhcp7575";
		//u235498999_kike usuario
		*/
		
		$conexion = array("hostname" => $hostname,
						  "database" => $database,
						  "username" => $username,
						  "password" => $password);
						  
		return $conexion;
}

}




?>