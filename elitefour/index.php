<?php
	echo '<p align="center">Elite four quick-reference cheat sheet.</p>';
	echo '<table class="datagrid" width="100%">';
	$oldSequence = "";
	$oldOpponent = "";
	$alternateRow = true;// alternating rows
	while ($rowEliteFour = mysql_fetch_assoc($qryEliteFour)){
		if ($rowEliteFour['type2'] != ""){
			$thisTypeCount = 2;
			$damageBug = $rowEliteFour['damageBug1'] * $rowEliteFour['damageBug2'];
			$damageDark = $rowEliteFour['damageDark1'] * $rowEliteFour['damageDark2'];
			$damageDragon = $rowEliteFour['damageDragon1'] * $rowEliteFour['damageDragon2'];
			$damageElectric = $rowEliteFour['damageElectric1'] * $rowEliteFour['damageElectric2'];
			$damageFighting = $rowEliteFour['damageFighting1'] * $rowEliteFour['damageFighting2'];
			$damageFire = $rowEliteFour['damageFire1'] * $rowEliteFour['damageFire2'];
			$damageFlying = $rowEliteFour['damageFlying1'] * $rowEliteFour['damageFlying2'];
			$damageGhost = $rowEliteFour['damageGhost1'] * $rowEliteFour['damageGhost2'];
			$damageGrass = $rowEliteFour['damageGrass1'] * $rowEliteFour['damageGrass2'];
			$damageGround = $rowEliteFour['damageGround1'] * $rowEliteFour['damageGround2'];
			$damageIce = $rowEliteFour['damageIce1'] * $rowEliteFour['damageIce2'];
			$damageNormal = $rowEliteFour['damageNormal1'] * $rowEliteFour['damageNormal2'];
			$damagePoison = $rowEliteFour['damagePoison1'] * $rowEliteFour['damagePoison2'];
			$damagePsychic = $rowEliteFour['damagePsychic1'] * $rowEliteFour['damagePsychic2'];
			$damageRock = $rowEliteFour['damageRock1'] * $rowEliteFour['damageRock2'];
			$damageSteel = $rowEliteFour['damageSteel1'] * $rowEliteFour['damageSteel2'];
			$damageWater = $rowEliteFour['damageWater1'] * $rowEliteFour['damageWater2'];
		}else{
			$thisTypeCount = 1;
			$damageBug = $rowEliteFour['damageBug1'];
			$damageDark = $rowEliteFour['damageDark1'];
			$damageDragon = $rowEliteFour['damageDragon1'];
			$damageElectric = $rowEliteFour['damageElectric1'];
			$damageFighting = $rowEliteFour['damageFighting1'];
			$damageFire = $rowEliteFour['damageFire1'];
			$damageFlying = $rowEliteFour['damageFlying1'];
			$damageGhost = $rowEliteFour['damageGhost1'];
			$damageGrass = $rowEliteFour['damageGrass1'];
			$damageGround = $rowEliteFour['damageGround1'];
			$damageIce = $rowEliteFour['damageIce1'];
			$damageNormal = $rowEliteFour['damageNormal1'];
			$damagePoison = $rowEliteFour['damagePoison1'];
			$damagePsychic = $rowEliteFour['damagePsychic1'];
			$damageRock = $rowEliteFour['damageRock1'];
			$damageSteel = $rowEliteFour['damageSteel1'];
			$damageWater = $rowEliteFour['damageWater1'];
		}

		if ($rowEliteFour['sequence'] != $oldSequence){
			if ($oldSequence != 0){
				echo '<tr><td colspan="27" class="transparent">&nbsp;</td></tr>';
			}
			echo '<tr><th colspan="27">Sequence ' . $rowEliteFour['sequence'] . '</th>';
		}

		if ($rowEliteFour['eliteFourName'] != $oldOpponent){
			echo '<tr>';
			echo '	<th>'.$rowEliteFour['eliteFourName'].'</th>';
			echo '	<th>Pokemon</th>';
			echo '	<th>Type</th>';
			echo '	<th>Level</th>';
			// types
			echo '	<th>'.dspType('bug').'</th>';
			echo '	<th>'.dspType('dark').'</th>';
			echo '	<th>'.dspType('dragon').'</th>';
			echo '	<th>'.dspType('electric').'</th>';
			echo '	<th>'.dspType('fighting').'</th>';
			echo '	<th>'.dspType('fire').'</th>';
			echo '	<th>'.dspType('flying').'</th>';
			echo '	<th>'.dspType('ghost').'</th>';
			echo '	<th>'.dspType('grass').'</th>';
			echo '	<th>'.dspType('ground').'</th>';
			echo '	<th>'.dspType('ice').'</th>';
			echo '	<th>'.dspType('normal').'</th>';
			echo '	<th>'.dspType('poison').'</th>';
			echo '	<th>'.dspType('psychic').'</th>';
			echo '	<th>'.dspType('rock').'</th>';
			echo '	<th>'.dspType('steel').'</th>';
			echo '	<th>'.dspType('water').'</th>';
			// moving here so effectiveness is closer to pokemon name
			echo '	<th>Ability</th>';
			echo '	<th>Item</th>';
			echo '	<th>Move1</th>';
			echo '	<th>Move2</th>';
			echo '	<th>Move3</th>';
			echo '	<th>Move4</th>';
			echo '</tr>';
		}
		echo '<tr>';
		echo '	<td class="transparent">&nbsp;</td>';
		echo '	<td>' . dspPokemonName($rowEliteFour['pokemonName']) . '</td>';
		echo '	<td align="center">';
		echo dspType($rowEliteFour['type1']);
		if ($thisTypeCount == 2){
			echo dspType($rowEliteFour['type2']);
		}
		echo '	</td>';
		echo '	<td align="right">' . $rowEliteFour['level'] . '</td>';
		// damage values
		echo dspDamage($damageBug);
		echo dspDamage($damageDark);
		echo dspDamage($damageDragon);
		echo dspDamage($damageElectric);
		echo dspDamage($damageFighting);
		echo dspDamage($damageFire);
		echo dspDamage($damageFlying);
		echo dspDamage($damageGhost);
		echo dspDamage($damageGrass);
		echo dspDamage($damageGround);
		echo dspDamage($damageIce);
		echo dspDamage($damageNormal);
		echo dspDamage($damagePoison);
		echo dspDamage($damagePsychic);
		echo dspDamage($damageRock);
		echo dspDamage($damageSteel);
		echo dspDamage($damageWater);
		// moving here so effectiveness is closer to pokemon name
		echo '	<td>' . dspAbility($rowEliteFour['abilityName']) . '</td>';
		echo '	<td>' . $rowEliteFour['itemName'] . '</td>';
		echo '	<td>' . $rowEliteFour['moveName1'] . '</td>';
		echo '	<td>' . $rowEliteFour['moveName2'] . '</td>';
		echo '	<td>' . $rowEliteFour['moveName3'] . '</td>';
		echo '	<td>' . $rowEliteFour['moveName4'] . '</td>';
		echo '</tr>';

		$oldOpponent = $rowEliteFour['eliteFourName'];
		$oldSequence = $rowEliteFour['sequence'];
	}
	echo '</table>';
?>
