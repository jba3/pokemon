<?php
	if (!(isset($_COOKIE['playerID'])) || $_COOKIE['playerID'] == ""){
		if ($requestModule != "login"){
				header('Location: /login/');
		}
	}
?>
