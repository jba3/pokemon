<p align="center">
	Pokemon caught but not in their box spot are highlighted in green.<br>
	Pokemon placed in their spot in the box are faded out.<br>
	When you place a pokemon in it's spot in the box, click the box. Click save when done.<br>
	<br>
	<em><strong>NOTE: Marking pokemon in it's box spot automatically marks it as seen and caught!</strong></em>
</p>

<form method="post" action="/myboxes/save">
	<p align="center"><input type="submit" value="Save"></p>

	<?php
		$countBox = 1;
		$countRow = 1;
		$countCol = 0;
		echo '<table align="center" class="datagrid">';
		$counter = 0;
		while ($rowBoxes = mysql_fetch_assoc($qryBoxes)){
			$counter += 1;

			if ($counter % 30 == 1){
				if ($counter > 1){
					echo '<tr><td class="transparent">&nbsp;</td></tr>';
				}
				echo '<tr><th colspan="6">BOX '.(1+(($counter-1) / 30)).'</th></tr>';			
			}

			if ($counter % 6 == 1){
				echo '<tr>';
			}

			echo '<td align="center">';
			echo '#'.$rowBoxes['id'] . '<br>';
			if ($rowBoxes['boxed'] == 1){
				echo dspPokemonIconCaught($rowBoxes['id']) . '<br>';
			}else if ($rowBoxes['caught'] == 1){
				echo dspPokemonIconToBox($rowBoxes['id']) . '<br>';
			}else{
				echo dspPokemonIcon($rowBoxes['id']) . '<br>';
			}
			echo dspPokemonName($rowBoxes['identifier']) . '<br>';
			if ($rowBoxes['boxed'] < 1){
				echo '<input type="checkbox" name="id[]" value="'.$rowBoxes['id'].'">';
			}
			echo '</td>';

			$countCol += 1;

			if ($countCol % 6 == 0){
				$countRow += 1;
			}
			if ($countRow == 5 && $countCol == 6){
				$countBox += 1;
			}

			if ($counter % 6 == 0){
				echo '</tr>';
			}
		}
		echo '</td></tr></table>';
	?>

	<p align="center"><input type="submit" value="Save"></p>
</form>
