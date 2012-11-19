<?php
	dbOpen();
		for ($x = 0; $x < count($_POST['pokemonSeen']); $x++){
			dbUpdate("playerPokedex set seen=1 where playerID=".$_COOKIE['playerID']." and gameID=".$_COOKIE['version_id']." and pokemonID=" . $_POST['pokemonSeen'][$x]);
		}

		for ($y = 0; $y < count($_POST['pokemonCaught']); $y++){
			dbUpdate("playerPokedex set seen=1,caught=1 where playerID=".$_COOKIE['playerID']." and gameID=".$_COOKIE['version_id']." and pokemonID=" . $_POST['pokemonCaught'][$y]);
		}
	dbClose();

	header('Location: /mypokedex/');
?>
