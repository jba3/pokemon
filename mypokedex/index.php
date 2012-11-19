<?php
	// show pokemon list based on game
	if (mysql_num_rows($qryMyPokedex) == 0){
		echo '<p align="center">CONGRATULATIONS! You have caught every pokemon in this game!</p>';
	}else{
		echo '<form method="post" action="/mypokedex/save">';
		echo '<p align="center">Pokemon are listed in numeric order. If the pokemon can be found in multiple locations, it will show with the highest encounter rate first.</p>';
		echo '<p align="center">Clicking \'caught\' is all you need to do, you do not need to click \'seen\' if you have caught the pokemon.</p>';
		echo '<p align="center">You have seen <strong>' . $qryCountSeen['total'] . '</strong> and caught <strong>' . $qryCountCaught['total'] . '</strong>; ';
		echo '<strong>' . ($arrGenStop[$_COOKIE['generation_id']] - $qryCountSeen['total']) . '</strong> more to see, <strong>' . ($arrGenStop[$_COOKIE['generation_id']] - $qryCountCaught['total']) . '</strong> to catch!</p>';
		echo '<p align="center"><input type="submit" value="Save progress"></p>';
		echo '<table class="datagrid" width="100%">';
		echo '<tr>';
		echo '	<th>Seen</th>';
		echo '	<th>Caught</th>';
		echo '	<th>#</th>';
		echo '	<th>Pokemon</th>';
		echo '	<th>Rate</th>';
		echo '	<th>Level</th>';
		echo '	<th>Location</th>';
		echo '	<th>Method</th>';
		echo '	<th>&nbsp;</th>';
		echo '</tr>';
		$oldPokemon = 0;
		$alternateRow = true;// alternating rows
		while ($rowMyPokedex = mysql_fetch_assoc($qryMyPokedex)){
			if ($oldPokemon != $rowMyPokedex["pokemonID"]){
				echo '<tr class=""' . (($alternateRow = !$alternateRow)?' class="odd"':'') . '>';
				echo '	<td width="1%" align="center">';
				if ($rowMyPokedex['seen'] == 1){
					echo '&nbsp;';
				}else{
					echo '		<input type="checkbox" name="pokemonSeen[]" value="' . $rowMyPokedex["pokemonID"] . '">';
				}
				echo '	</td>';
				echo '	<td width="1%" align="center"><input type="checkbox" name="pokemonCaught[]" value="' . $rowMyPokedex["pokemonID"] . '"></td>';
				echo '	<td width="3%" align="right">' . $rowMyPokedex["pokemonID"] . '</td>';
				echo '	<td width="10%">' . dspPokemonName($rowMyPokedex["pokemonName"]) . '</td>';
			}else{
				echo '<tr class="subline hidden pokemon'.$rowMyPokedex["pokemonID"].'">';
				echo '	<td colspan="4" class="transparent">&nbsp;</td>';
			}

			if ($rowMyPokedex["encounterRate"] == ""){
				echo '	<td colspan="5" width="85%"><em>Can not catch in this game; must be traded from another game<em></td>';
			}else{			
				echo '	<td width="15%" nowrap align="right">' . $rowMyPokedex["encounterRate"] . '%</td>';
				echo '	<td width="15%" nowrap align="right">' . $rowMyPokedex["min_level"] . ' to ' . $rowMyPokedex["max_level"] . '</td>';
				echo '	<td width="35%" nowrap>' . $rowMyPokedex["locationName"];
				if ($rowMyPokedex["locationDetails"] != ""){
					echo ' (' . $rowMyPokedex["locationDetails"] . ')';
				}
				echo '	</td>';
				echo '	<td width="15%" nowrap>' . $rowMyPokedex["encounterMethod"] . '</td>';
				if ($oldPokemon != $rowMyPokedex["pokemonID"]){
					echo '<td><a href="javascript:showRowByClass(\'.pokemon'.$rowMyPokedex["pokemonID"].'\');">VIEW MORE</a></td>';
				}else{
					echo '<td class="transparent">&nbsp;</td>';
				}
			}

			echo '</tr>';
			$oldPokemon = $rowMyPokedex["pokemonID"];
		}
		echo '</table>';
		echo '<p align="center"><input type="submit" value="Save progress"></p>';
		echo '</form>';
	}
?>
