<?php

date_default_timezone_set('America/Buenos_Aires');

class appconfig {

function conexion() {
		
		$hostname = "localhost";
		$database = "ssaif_local_diciembre_host";
		$username = "root";
		$password = "";
		
		
		
		/*
		$hostname = "185.28.21.241";
		$database = "u235498999_aifd";
		$username = "u235498999_aifd";
		$password = "rhcp7575";
		//u235498999_kike usuario
		*/
		
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