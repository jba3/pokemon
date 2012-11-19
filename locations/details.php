<?php
	echo '<p align="center">Pokemon who have their image faded out have already been marked as caught in your pokedex.</p>';

	echo '<table align="center" class="datagrid">';
	echo '<tr><th colspan="6">'.$qryLocation['name'].'</th></tr>';
	$old_locationNameSub = "";
	$old_encounterMethodName = "";
	$has_headers = 0;
	while ($rowEncounters = mysql_fetch_assoc($qryEncounters)){
		if ($old_locationNameSub != $rowEncounters['locationNameSub'] || $has_headers == 0){
			echo '<tr><td colspan="6" class="transparent">&nbsp;</td></tr>';
			if ($rowEncounters['locationNameSub'] != ""){
				echo '<tr><th colspan="6">'.$rowEncounters['locationNameSub'].'</th></tr>';
			}
			echo '<tr>';
			echo '	<th>Method</th>';
			echo '	<th>Method Specifics</th>';
			echo '	<th>Condition</th>';
			echo '	<th>Pokemon</th>';
			echo '	<th>Level(s)</th>';
			echo '	<th>Rarity</th>';
			echo '</tr>';

			$has_headers = 1;
		}
		echo '<tr>';
		if ($old_encounterMethodName != $rowEncounters['encounterMethodName']){
			echo '	<td>'.$rowEncounters['encounterMethodName'].'</td>';
			echo '	<td>'.$rowEncounters['encounterMethodNameProse'].'</td>';
		}else{
			echo '<td colspan="2" class="transparent">&nbsp;</td>';
		}
		echo '	<td>'.$rowEncounters['encounterCondition'].'</td>';
		echo '	<td align="center">';
		if ($rowEncounters['pokemonCaught'] == 1){
			echo dspPokemonIconCaught($rowEncounters['pokemonID']);
		}else{
			echo dspPokemonIcon($rowEncounters['pokemonID']);
		}
		echo '<br>'.dspPokemonName($rowEncounters['pokemonName']).'</td>';
		echo '	<td align="right">'.$rowEncounters['min_level'];
		if ($rowEncounters['min_level'] != $rowEncounters['max_level']){
			echo ' to '.$rowEncounters['max_level'];
		}
		echo '	</td>';
		echo '	<td align="right">'.$rowEncounters['rarity'].'%</td>';
		echo '</tr>';

		$old_locationNameSub = $rowEncounters['locationNameSub'];
		$old_encounterMethodName = $rowEncounters['encounterMethodName'];
	}
	echo '</table>';
?>
