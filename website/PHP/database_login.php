<?php
	function connexion(){
		$host = "localhost";
		$dbname="projet_conception_db";
		$user_name="root";
		$password="";
		try {
			$db= new PDO ("mysql:host=".$host."; dbname=".$dbname,$user_name,$password);
			$db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

			return $db;
		} catch(Exception $e) {
			echo("ERREUR : ". $e->getMessage());
		}
	}	

?>