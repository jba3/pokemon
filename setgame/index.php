<?php
		$newGame = $_POST['version_id'];

		dbOpen();
			$qryGame = dbSelectAssoc("v.version_group_id, v.identifier AS version, vg.generation_id FROM versions v JOIN version_groups vg ON v.version_group_id = vg.id where v.id=" . $newGame);
		dbClose();

		setcookie("version", $qryGame['version'], 0, "/");
		setcookie("version_id", $newGame, 0, "/");
		setcookie("version_group_id", $qryGame['version_group_id'], 0, "/");
		setcookie("generation_id", $qryGame['generation_id'], 0, "/");

		header('Location: /home/');
?>
