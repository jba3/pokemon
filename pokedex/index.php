<?php
	// have to do complicated parsing because of URL rewrites
	$strUrlPath = $_SERVER['REQUEST_URI'];
	$arrPathFile = explode("?", $strUrlPath);
	$urlGen = end($arrPathFile);

	if (count(explode("?", $strUrlPath)) == 1){
		$urlGen = 1;
	}

	switch ($urlGen){
		case 1:
			$genStartID = 1;
			$genStopID = 151;
			break;
		case 2:
			$genStartID = 152;
			$genStopID = 251;
			break;
		case 3:
			$genStartID = 252;
			$genStopID = 386;
			break;
		case 4:
			$genStartID = 387;
			$genStopID = 494;
			break;
		case 5:
			$genStartID = 495;
			$genStopID = 649;
			break;
	}

//	echo $_GET['gen'];

	dbOpen();
		$qryPokemon = dbSelect("
			*
				,(select identifier from pokemon_types sub_pt join types sub_t on sub_pt.type_id=sub_t.id where sub_pt.pokemon_id=p.species_id and slot=1) as type1
				,(select identifier from pokemon_types sub_pt join types sub_t on sub_pt.type_id=sub_t.id where sub_pt.pokemon_id=p.species_id and slot=2) as type2
				,(select identifier from abilities sub_a join pokemon_abilities sub_pa on sub_a.id=sub_pa.ability_id where sub_pa.pokemon_id=p.species_id and slot=1) as ability1
				,(select identifier from abilities sub_a join pokemon_abilities sub_pa on sub_a.id=sub_pa.ability_id where sub_pa.pokemon_id=p.species_id and slot=2) as ability2
				,(select identifier from abilities sub_a join pokemon_abilities sub_pa on sub_a.id=sub_pa.ability_id where sub_pa.pokemon_id=p.species_id and slot=3) as abilityDream
				,(select identifier from egg_groups sub_eg join pokemon_egg_groups sub_peg on sub_eg.id=sub_peg.egg_group_id where sub_peg.species_id=p.species_id order by egg_group_id asc limit 1) as eggGroup1
				,(select identifier from egg_groups sub_eg join pokemon_egg_groups sub_peg on sub_eg.id=sub_peg.egg_group_id where sub_peg.species_id=p.species_id order by egg_group_id desc limit 1) as eggGroup2
				,(select base_stat from pokemon_stats sub_ps where sub_ps.pokemon_id=p.species_id and stat_id=1) as baseHP
				,(select base_stat from pokemon_stats sub_ps where sub_ps.pokemon_id=p.species_id and stat_id=2) as baseAtt
				,(select base_stat from pokemon_stats sub_ps where sub_ps.pokemon_id=p.species_id and stat_id=3) as baseDef
				,(select base_stat from pokemon_stats sub_ps where sub_ps.pokemon_id=p.species_id and stat_id=4) as baseSpAtt
				,(select base_stat from pokemon_stats sub_ps where sub_ps.pokemon_id=p.species_id and stat_id=5) as baseSpDef
				,(select base_stat from pokemon_stats sub_ps where sub_ps.pokemon_id=p.species_id and stat_id=6) as baseSpeed
				,(select sum(base_stat) from pokemon_stats sub_ps where sub_ps.pokemon_id=p.species_id) as baseTotal
			from 		pokemon p
			join		pokemon_species ps on ps.id=p.species_id
			where		is_default=1
						and p.id in (select pokemon_id from pokemon_game_indices sub_pgi where sub_pgi.generation_id=" . $_COOKIE['generation_id'] . ")
						and p.species_id >= " . $genStartID . "
						and p.species_id <= " . $genStopID . "
			order by	'ps.order'
		");
	dbClose();



	echo '<p align="center">';
	for ($idxGen=1; $idxGen<=$_COOKIE['generation_id']; $idxGen++){
		echo '<a href="/pokedex/?' . $idxGen . '">' . dspGen($idxGen) . '</a> ';
	}
	echo '</p>';

	echo '<table class="datagrid" width="100%">';
	echo '<tr>';
	echo '	<th width="1%">ID</th>';
	echo '	<th width="1%">Icon</th>';
	echo '	<th width="12%">Name</th>';
	echo '	<th width="12%">Type</th>';
	echo '	<th width="12%">Abilities</th>';
	echo '	<th width="12%">Egg Groups</th>';
	echo '	<th width="7%">HP</th>';
	echo '	<th width="7%">Att</th>';
	echo '	<th width="7%">Def</th>';
	echo '	<th width="7%">SpAtt</th>';
	echo '	<th width="7%">SpDef</th>';
	echo '	<th width="7%">Speed</th>';
	echo '	<th width="10%">Total</th>';
	echo '	</tr>';
	$alternateRow = true;// alternating rows
	while ($rowPokemon = mysql_fetch_assoc($qryPokemon)){
		echo '<tr' . (($alternateRow = !$alternateRow)?' class="odd"':'') . '>';
		echo '	<td align="right">' . $rowPokemon["id"] . '</td>';
		echo '	<td>' . dspPokemonIcon($rowPokemon["id"]) . '</td>';
		echo '	<td>' . dspPokemonName($rowPokemon["identifier"]) . '</td>';

		echo '	<td align="center">' . dspType($rowPokemon["type1"]);
		if ($rowPokemon["type2"] != ''){
			echo dspType($rowPokemon["type2"]);
		}
		echo '</td>';

		echo '	<td align="right">' . dspAbility($rowPokemon["ability1"]);
		if ($rowPokemon["ability2"] != ''){
			echo '<br>' . dspAbility($rowPokemon["ability2"]);
		}
		if ($rowPokemon["abilityDream"] != ''){
			echo '<br>' . dspAbility($rowPokemon["abilityDream"]). '*';
		}
		echo '</td>';

		echo '	<td align="right">' . dspEggGroup($rowPokemon["eggGroup1"]);
		if ($rowPokemon["eggGroup2"] != $rowPokemon["eggGroup1"]){
			echo '<br>' . dspEggGroup($rowPokemon["eggGroup2"]);
		}
		echo '</td>';

		echo '	<td align="right">' . $rowPokemon["baseHP"] . '</td>';
		echo '	<td align="right">' . $rowPokemon["baseAtt"] . '</td>';
		echo '	<td align="right">' . $rowPokemon["baseDef"] . '</td>';
		echo '	<td align="right">' . $rowPokemon["baseSpAtt"] . '</td>';
		echo '	<td align="right">' . $rowPokemon["baseSpDef"] . '</td>';
		echo '	<td align="right">' . $rowPokemon["baseSpeed"] . '</td>';
		echo '	<td align="right">' . $rowPokemon["baseTotal"] . '</td>';
		echo '</tr>';
	}
	echo '</table>';
?>
