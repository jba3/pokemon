<?php
	dbOpen();
		$qryPokemon = dbSelect("
			a.identifier as abilityName
			from abilities a
			order by	a.identifier
		");
	dbClose();



	echo '<table class="datagrid" width="100%">';
	echo '<tr>';
	echo '	<th>Ability</th>';
	echo '</tr>';
	$alternateRow = true;// alternating rows
	while ($rowPokemon = mysql_fetch_assoc($qryPokemon)){
		echo '<tr' . (($alternateRow = !$alternateRow)?' class="odd"':'') . '>';
		echo '	<td>' . $rowPokemon["abilityName"] . '</td>';
		echo '</tr>';
	}
	echo '</table>';
?>
