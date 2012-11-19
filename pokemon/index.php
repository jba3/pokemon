<?php
	// figure out if ATTACKER or SPECIAL ATTACKER
	// attack more than 10% higher than spAtt
	if ($qryPokemon['baseAtt'] > ($qryPokemon['baseSpAtt']*1.1)){
		$attStatPreference = 'Att';
	// spAtt more than 10% higher than attack
	}else if ($qryPokemon['baseSpAtt'] > ($qryPokemon['baseAtt']*1.1)){
		$attStatPreference = 'SpAtt';
	}else{
		$attStatPreference = '';
	}



	echo '<table width="100%">';
	echo '<tr>';
	echo '<td valign="top" width="25%" align="left">'.'#'.($qryPokemon['id']-1).'<br>'.dspPokemonIcon($qryPokemon['id']-1).'<br>PREV</td>';
	echo '<td valign="top" width="50%" align="center">'.'#'.$qryPokemon['id'].'<br>'.dspPokemonSprite($qryPokemon['id']).'</td>';
	echo '<td valign="top" width="25%" align="right">'.'#'.($qryPokemon['id']+1).'<br>'.dspPokemonIcon($qryPokemon['id']+1).'<br>NEXT</td>';
	echo '</tr>';
	echo '</table>';

	echo '<table class="datagrid">';
	echo '<tr><th colspan="2">BASIC INFO</th></tr>';
	echo '<tr>';
	echo '	<td valign="top">Name</td>';
	echo '	<td>' . $qryPokemon['identifier'] . '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '	<td valign="top">Type</td>';
	echo '	<td>'.dspType($qryPokemon['type1']);
	if ($qryPokemon['type2'] != ''){
		echo '<br>'.dspType($qryPokemon['type2']);
	}
	echo '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '	<td valign="top">Abilities</td>';
	echo '	<td>';
	echo dspAbility($qryPokemon['ability1']).'<br>';
	echo $qryPokemon['ability1effectshort'].'<br>';
	echo $qryPokemon['ability1effect'];
	echo '	</td>';
	echo '</tr>';
	if ($qryPokemon['ability2'] != ''){
		echo '<tr>';
		echo '	<td class="transparent">&nbsp;</td>';
		echo '	<td>';
		echo dspAbility($qryPokemon['ability2']).'<br>';
		echo $qryPokemon['ability2effectshort'].'<br>';
		echo $qryPokemon['ability2effect'];
		echo '	</td>';
		echo '</tr>';
	}
	echo '<tr>';
	echo '	<td valign="top">Dream World Ability</td>';
	echo '	<td>';
	echo dspAbility($qryPokemon['abilityDream']) . '<br>';
	echo $qryPokemon['abilityDreameffectshort'] . '<br>';
	echo $qryPokemon['abilityDreameffect'];
	echo '	</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td valign="top">Egg Groups</td>';
	echo '<td>' . dspEggGroup($qryPokemon['eggGroup1']);
	if ($qryPokemon['eggGroup2'] != $qryPokemon['eggGroup1']){
		echo '<br>'.dspEggGroup($qryPokemon['eggGroup2']);
	}
	echo '</td>';
	echo '</tr>';
	echo '</table>';

	echo '<br>';

	echo '<strong>BASE STATS</strong><br>';
	echo '<table class="datagrid">';
	echo '<tr>';
	echo '	<th>HP</th>';
	echo '	<th>Att</th>';
	echo '	<th>Def</th>';
	echo '	<th>SpAtt</th>';
	echo '	<th>SpDef</th>';
	echo '	<th>Speed</th>';
	echo '	<th>Total</th>';
	echo '</tr>';
	echo '<tr>';
	echo '	<td align="right">' . $qryPokemon['baseHP'] . '</td>';
	echo '	<td align="right">' . $qryPokemon['baseAtt'] . '</td>';
	echo '	<td align="right">' . $qryPokemon['baseDef'] . '</td>';
	echo '	<td align="right">' . $qryPokemon['baseSpAtt'] . '</td>';
	echo '	<td align="right">' . $qryPokemon['baseSpDef'] . '</td>';
	echo '	<td align="right">' . $qryPokemon['baseSpeed'] . '</td>';
	echo '	<td align="right">' . $qryPokemon['baseTotal'] . '</td>';
	echo '</tr>';
	echo '</table>';

	echo '<br>';

	// evolution info
	dbOpen();
		$qryEvolutionBaby   = getEvolutionBaby($qryPokemon['evolution_chain_id']);
		$qryEvolutionBase   = getEvolutionBase($qryPokemon['evolution_chain_id']);
			$arrEvolutionBaby   = mysql_fetch_assoc($qryEvolutionBaby);
			$arrEvolutionBase   = mysql_fetch_assoc($qryEvolutionBase);

		$qryEvolutionStage1 = getEvolutionStages($arrEvolutionBase['id']);
			$arrEvolutionStage1 = mysql_fetch_assoc($qryEvolutionStage1);
	dbClose();

	echo '<table class="datagrid" align="center">';
	echo '<tr><th colspan="4">EVOLUTIONS</th></tr>';
	echo '<tr><th>BABY</th><th>BASE</th><th>Stage 1</th><th>Stage 2</th></tr>';
	echo '<tr>';
	/***************************************************************************************
	****************************************************************************************
	BABY
	****************************************************************************************
	***************************************************************************************/
	echo '<td valign="top" width="25%">';
	if (mysql_num_rows($qryEvolutionBaby) == 0){
		echo '&nbsp;';
	}else{
		dspEvolution(
			$arrEvolutionBaby['id'],
			$arrEvolutionBaby['evolution_trigger_id'],
			$arrEvolutionBaby['pokemonName'],
			$arrEvolutionBaby['evolveMethod'],
			$arrEvolutionBaby['itemNameUse'],
			$arrEvolutionBaby['minimum_level'],
			$arrEvolutionBaby['minimum_happiness'],
			$arrEvolutionBaby['minimum_beauty'],
			$arrEvolutionBaby['known_move_id'],
			$arrEvolutionBaby['time_of_day'],
			$arrEvolutionBaby['itemNameHeld'],
			$arrEvolutionBaby['location_id'],
			$arrEvolutionBaby['genderName']
		);
	}
	echo '</td>';
	/***************************************************************************************
	****************************************************************************************
	BASE
	****************************************************************************************
	***************************************************************************************/
	echo '<td valign="top" width="25%">';
		dspEvolution(
			$arrEvolutionBase['id'],
			$arrEvolutionBase['evolution_trigger_id'],
			$arrEvolutionBase['pokemonName'],
			$arrEvolutionBase['evolveMethod'],
			$arrEvolutionBase['itemNameUse'],
			$arrEvolutionBase['minimum_level'],
			$arrEvolutionBase['minimum_happiness'],
			$arrEvolutionBase['minimum_beauty'],
			$arrEvolutionBase['known_move_id'],
			$arrEvolutionBase['time_of_day'],
			$arrEvolutionBase['itemNameHeld'],
			$arrEvolutionBase['location_id'],
			$arrEvolutionBase['genderName']
		);
	echo '</td>';
	/***************************************************************************************
	****************************************************************************************
	STAGE 1
	****************************************************************************************
	***************************************************************************************/
	echo '<td valign="top" width="25%">';
	if (mysql_num_rows($qryEvolutionStage1) == 0){
		echo '&nbsp;';
	}else{
		mysql_data_seek($qryEvolutionStage1, 0);
		// some have multiple possibilities for single stage, like eevee-lutions
		while ($rowEvolutionStage1 = mysql_fetch_assoc($qryEvolutionStage1)){
			dspEvolution(
				$rowEvolutionStage1['id'],
				$rowEvolutionStage1['evolution_trigger_id'],
				$rowEvolutionStage1['pokemonName'],
				$rowEvolutionStage1['evolveMethod'],
				$rowEvolutionStage1['itemNameUse'],
				$rowEvolutionStage1['minimum_level'],
				$rowEvolutionStage1['minimum_happiness'],
				$rowEvolutionStage1['minimum_beauty'],
				$rowEvolutionStage1['known_move_id'],
				$rowEvolutionStage1['time_of_day'],
				$rowEvolutionStage1['itemNameHeld'],
				$rowEvolutionStage1['location_id'],
				$rowEvolutionStage1['genderName']
			);
			echo '<hr>';
		}
	}
	echo '</td>';
	/***************************************************************************************
	****************************************************************************************
	STAGE 2
	****************************************************************************************
	***************************************************************************************/
	echo '<td valign="top" width="25%">';
	if (mysql_num_rows($qryEvolutionStage1) == 0){
		echo '&nbsp;';
	}else{
		mysql_data_seek($qryEvolutionStage1, 0);
		while ($rowEvolutionStage1 = mysql_fetch_assoc($qryEvolutionStage1)){
			dbOpen();
				$qryEvolutionStage2 = getEvolutionStages($arrEvolutionStage1['id']);
			dbClose();

			while ($rowEvolutionStage2 = mysql_fetch_assoc($qryEvolutionStage2)){
				dspEvolution(
					$rowEvolutionStage2['id'],
					$rowEvolutionStage2['evolution_trigger_id'],
					$rowEvolutionStage2['pokemonName'],
					$rowEvolutionStage2['evolveMethod'],
					$rowEvolutionStage2['itemNameUse'],
					$rowEvolutionStage2['minimum_level'],
					$rowEvolutionStage2['minimum_happiness'],
					$rowEvolutionStage2['minimum_beauty'],
					$rowEvolutionStage2['known_move_id'],
					$rowEvolutionStage2['time_of_day'],
					$rowEvolutionStage2['itemNameHeld'],
					$rowEvolutionStage2['location_id'],
					$rowEvolutionStage2['genderName']
				);
				echo '<hr>';
			}
		}
	}
	echo '</td>';
	echo '</tr>';
	echo '</table>';

	echo '<p><strong>MOVES AVAILABLE</strong></p>';

	echo '<p>';
	echo 'Moves matching this pokemons type receive STAB (Same Type Attack Bonus); they have the row highlighted in green.<br>';
	echo 'Moves matching this pokemons attack class (PHYSICAL or SPECIAL) have the text on the row in <strong>BOLD</strong> letters.<br>';
	echo 'Moves both highlighted and bold will be the most effective moves for this pokemon, assuming equal power rating compared to other moves.';
	echo '</p>';

	echo '<table class="datagrid">';
	// pokemon always has level-up moves
	dspMoveHeader('LEVEL UP as ' . $qryPokemon['identifier']);
	while ($rowMoves = mysql_fetch_assoc($qryMovesLevelUp)){
		dspMoveRow(
			$attStatPreference,
			$qryPokemon['type1'],
			$qryPokemon['type2'],
			$rowMoves['level'],
			$rowMoves['moveName'],
			$rowMoves['moveType'],
			$rowMoves['moveDamageClass'],
			$rowMoves['power'],
			$rowMoves['accuracy'],
			$rowMoves['pp'],
			$rowMoves['priority'],
			$rowMoves['short_effect']
		);
	}

	// other level-up moves for the evolution chain that are NOT in this pokemon's moveset
	if (mysql_num_rows($qryMovesLevelUpOtherEvolutions) > 0){
		$oldOtherEvolutions = "";
		while ($rowMovesLevelUpOtherEvolutions = mysql_fetch_assoc($qryMovesLevelUpOtherEvolutions)){
			if ($oldOtherEvolutions != $rowMovesLevelUpOtherEvolutions['pokemonName']){
				dspMoveHeader('LEVEL UP as '.$rowMovesLevelUpOtherEvolutions['pokemonName'].' (but not learnable with level up as '.$qryPokemon['identifier'].')');
			}
			dspMoveRow(
				$attStatPreference,
				$qryPokemon['type1'],
				$qryPokemon['type2'],
				$rowMovesLevelUpOtherEvolutions['level'],
				$rowMovesLevelUpOtherEvolutions['moveName'],
				$rowMovesLevelUpOtherEvolutions['moveType'],
				$rowMovesLevelUpOtherEvolutions['moveDamageClass'],
				$rowMovesLevelUpOtherEvolutions['power'], 
				$rowMovesLevelUpOtherEvolutions['accuracy'],
				$rowMovesLevelUpOtherEvolutions['pp'],
				$rowMovesLevelUpOtherEvolutions['priority'],
				$rowMovesLevelUpOtherEvolutions['short_effect']
			);
			$oldOtherEvolutions = $rowMovesLevelUpOtherEvolutions['pokemonName'];
		}
	}

	if (mysql_num_rows($qryMovesMachine) > 0){
		echo '<tr><td colspan="9" class="transparent">&nbsp;</td></tr>';
		dspMoveHeader('MACHINE (HM/TM)');
		while ($rowMovesMachine = mysql_fetch_assoc($qryMovesMachine)){
			dspMoveRow(
				$attStatPreference,
				$qryPokemon['type1'],
				$qryPokemon['type2'],
				$rowMovesMachine['machine_number'],
				$rowMovesMachine['moveName'],
				$rowMovesMachine['moveType'],
				$rowMovesMachine['moveDamageClass'],
				$rowMovesMachine['power'],
				$rowMovesMachine['accuracy'],
				$rowMovesMachine['pp'],
				$rowMovesMachine['priority'],
				$rowMovesMachine['short_effect']
			);
		}
	}

	if (mysql_num_rows($qryMovesEgg) > 0){
		echo '<tr><td colspan="9" class="transparent">&nbsp;</td></tr>';
		dspMoveHeader('EGG MOVES - Inherited by baby pokemon if the FATHER knows the move');
		while ($rowEgg = mysql_fetch_assoc($qryMovesEgg)){
			dspMoveRow(
				$attStatPreference,
				$qryPokemon['type1'],
				$qryPokemon['type2'],
				'',
				$rowEgg['moveName'],
				$rowEgg['moveType'],
				$rowEgg['moveDamageClass'],
				$rowEgg['power'],
				$rowEgg['accuracy'],
				$rowEgg['pp'],
				$rowEgg['priority'],
				$rowEgg['short_effect']
			);
		}
	}

	if (mysql_num_rows($qryMovesMoveTutor) > 0){
		echo '<tr><td colspan="9" class="transparent">&nbsp;</td></tr>';
		dspMoveHeader('MOVE TUTORS');
		while ($rowMovesMoveTutor = mysql_fetch_assoc($qryMovesMoveTutor)){
			dspMoveRow(
				$attStatPreference,
				$qryPokemon['type1'],
				$qryPokemon['type2'],
				'',
				$rowMovesMoveTutor['moveName'],
				$rowMovesMoveTutor['moveType'],
				$rowMovesMoveTutor['moveDamageClass'],
				$rowMovesMoveTutor['power'],
				$rowMovesMoveTutor['accuracy'],
				$rowMovesMoveTutor['pp'],
				$rowMovesMoveTutor['priority'],
				$rowMovesMoveTutor['short_effect']
			);
		}
	}
	echo '</table>';

	echo '<br>';

	echo '<table class="datagrid">';
	echo '<tr><th colspan="6">CAPTURE LOCATIONS</th></tr>';
	if (mysql_num_rows($qryLocations) == 0){
		echo '<tr><td colspan="6">This pokemon cannot be caught in the wild in this game</td></tr>';
	}else{
		echo '<tr>';
		echo '	<th>Location</th>';
		echo '	<th>Level(s)</th>';
		echo '	<th>Method</th>';
		echo '	<th>Method Specifics</th>';
		echo '	<th>Condition</th>';
		echo '	<th>Rarity</th>';
		echo '</tr>';
		while ($rowLocations = mysql_fetch_assoc($qryLocations)){
			echo '<tr>';
			echo '	<td>'.dspLocation($rowLocations['locationName']).'</td>';
			echo '	<td>'.$rowLocations['min_level'].' to '.$rowLocations['max_level'].'</td>';
			echo '	<td>'.$rowLocations['encounterMethodName'].'</td>';
			echo '	<td>'.$rowLocations['encounterMethodNameProse'].'</td>';
			echo '	<td>'.$rowLocations['encounterCondition'].'</td>';
			echo '	<td align="right">'.$rowLocations['rarity'].'%</td>';
			echo '</tr>';
		}
	}
	echo '</table>';
?>
