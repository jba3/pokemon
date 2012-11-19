<?php
	dbOpen();
		$qryPlayer = dbSelect("* from player where email='" . $_POST['email'] . "' and password='" . $_POST['password'] . "' and isActive=1");
	dbClose();



	if (mysql_num_rows($qryPlayer) == 1){
		$setPlayer = mysql_fetch_assoc($qryPlayer);
		setcookie("playerID", $setPlayer['playerID'], 0, "/");

		header('Location: /home/');
	}else{
		header('Location: /login/');
	}
?>
