<?php
	if (strpos($_SERVER['SERVER_NAME'], '.local') == false){
		// PRODUCTION SETTINGS
		$application_dbserver = "pokedexpal.db.8602431.hostedresource.com";
		$application_dbname = "pokedexpal";
		$application_dbuser = "pokedexpal";
		$application_dbpass = "Sql2011!";
	}else{
		// LOCAL DEVELOPMENT SETTINGS
		$application_dbserver = "localhost:3387";
		$application_dbname = "pokemon";
		$application_dbuser = "root";
		$application_dbpass = "root";
	}
?>
