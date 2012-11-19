<?php
	echo '<p align="center">Pokemon who have their image faded out have already been marked as caught in your pokedex.</p>';

	$oldLocation = "";

	echo '<table align="center" class="datagrid">';
	echo '<tr><th>LOCATION</th><th>POKEMON</th>';
	$alternateRow = true;// alternating rows
	while ($rowLocations = mysql_fetch_assoc($qryLocations)){
		if ($oldLocation != $rowLocations['locationName']){
			if ($oldLocation != ""){
				echo '</td>';
			}
			echo '</tr>';
			echo '<tr' . (($alternateRow = !$alternateRow)?' class="odd"':'') . '>';
			echo '	<td>'.dspLocation($rowLocations['locationName']).'</td>';
			echo '	<td>';
		}
		if ($rowLocations['hasCaughtPokemon'] == 1){
			echo dspPokemonIconCaught($rowLocations['pokemonID']);
		}else{
			echo dspPokemonIcon($rowLocations['pokemonID']);
		}
//		echo '	<td>'.$rowLocations['pokemonName'].'</td>';

		$oldLocation = $rowLocations['locationName'];
	}
	echo '</tr>';
	echo '</table>';
?>
