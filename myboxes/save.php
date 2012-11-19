<?php
	dbOpen();
		for ($x = 0; $x < count($_POST['id']); $x++){
			echo "playerPokedex set seen=1,caught=1,boxed=1 where playerID=".$_COOKIE['playerID']." and gameID=".$_COOKIE['version_id']." and pokemonID=" . $_POST['id'][$x];
			dbUpdate("
				playerPokedex
				set boxed=1
				where playerID=".$_COOKIE['playerID']."
					and gameID=".$_COOKIE['version_id']."
					and pokemonID=" . $_POST['id'][$x]
			);
		}
	dbClose();

	header('Location: /myboxes/');
?>
