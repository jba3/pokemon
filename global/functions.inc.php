<?php
	function dspVersion(){
		return '<img src="/global/img/versions/' . $_COOKIE['version'] . '.png" width="16" height="16"> ' . $_COOKIE['version'];
	}
	function dspGen($intGen){
		return '<img src="/global/img/generations/generation-' . $intGen . '.png">';
	}
	function dspType($strType){
		return '<img src="/global/img/types/' . $strType . '.png" width="32" height="14" alt="' .$strType. '">';
	}
	function dspMoveType($strMoveType){
		return '<img src="/global/img/move-types/' . $strMoveType . '.png" width="32" height="14" alt="' .$strMoveType. '">';
	}

	function dspPokemonName($strName){
		return '<a href="/pokemon/' . $strName . '">' . $strName . '</a>';
	}
	function dspPokemonIcon($intID){
		return '<img height="32" width="32" src="/global/img/icons/' . $intID . '.png" border="0">';
	}
	function dspPokemonIconCaught($intID){
		return '<img height="32" width="32" src="/global/img/icons/' . $intID . '.png" border="0" class="pokemonCaught">';
	}
	function dspPokemonIconToBox($intID){
		return '<img height="32" width="32" src="/global/img/icons/' . $intID . '.png" border="0" class="pokemonToBox">';
	}
	function dspPokemonSprite($intID){
		return '<img src="/global/img/main-sprites/black-white/' . $intID . '.png" border="0">';
	}

	function dspAbility($strAbility){
		return '<a href="/abilities/' . $strAbility . '">' . $strAbility . '</a>';
	}

	function dspEggGroup($strEggGroup){
		return '<a href="/egg-groups/' . $strEggGroup . '">' . $strEggGroup . '</a>';
	}

	function dspItem($strItem){
		return '<a href="/items/' . $strItem . '">' . $strItem . '</a>';
	}

	function dspLocation($strLocation){
		return '<a href="/locations/' . $strLocation . '">' . $strLocation . '</a>';
	}

	function checkPokedexEntry($arrGenStop){
		// check for entry
		$qryCheck = dbSelect("* from playerPokedex where playerID=" . $_COOKIE['playerID'] . " and gameID=" . $_COOKIE['version_id']);

		// if no entry, create a set
		if (mysql_num_rows($qryCheck) == 0){
			for ($idxInsert=1; $idxInsert <= $arrGenStop[$_COOKIE['generation_id']]; $idxInsert++){
				dbInsert("
					playerPokedex(
						playerID,
						gameID,
						pokemonID,
						seen,
						caught,
						boxed
					)values (
						".$_COOKIE['playerID'].",
						".$_COOKIE['version_id'].",
						".$idxInsert.",
						0,
						0,
						0
					)
				");
			}
		}
	}

	/***************************************************************************************************
	****************************************************************************************************
	date helpers
	****************************************************************************************************
	***************************************************************************************************/
	function now(){
		return date('H:i:s');
	}


	/***************************************************************************************************
	****************************************************************************************************
	include from root path helper
	****************************************************************************************************
	***************************************************************************************************/
	function includeFile($filepath){
		include($_SERVER["DOCUMENT_ROOT"] . $filepath);
	}


	/***************************************************************************************************
	****************************************************************************************************
	icons / images
	****************************************************************************************************
	***************************************************************************************************/
	function dspIcon($icon){
		return('<img src="/img/icons/' . $icon . '.png" height="16" width="16" border="0" alt="' . $icon . '">');
	}


	/***************************************************************************************************
	****************************************************************************************************
	standard admin messages
	****************************************************************************************************
	***************************************************************************************************/
	function dspMsgInfo($msg){
		return('
			<div class="ui-widget">
				<div class="ui-corner-all" style="padding: 1px 1em;background-color:#9f9 !important;"> 
					<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
					' . $msg . '</p>
				</div>
			</div>
		');
	}
	function dspMsgWarning($msg){
		return('
			<div class="ui-widget">
				<div class="ui-state-error ui-corner-all" style="padding: 1 1em;"> 
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					' . $msg . '</p>
				</div>
			</div>
		');
	}


	/***************************************************************************************************
	****************************************************************************************************
	database
	****************************************************************************************************
	***************************************************************************************************/
	function dbOpen(){
		require $_SERVER["DOCUMENT_ROOT"] . "/global/settings.db.inc.php";

		mysql_connect($application_dbserver, $application_dbuser, $application_dbpass);
		mysql_select_db($application_dbname);
	}

	function dbSelect($strQuery){
		$tmpQuery = mysql_query("select " . $strQuery) or die(mysql_error());
		return $tmpQuery;
	}

	function dbSelectAssoc($strQuery){
		return mysql_fetch_assoc(dbSelect($strQuery));
	}

	function dbUpdate($strQuery){
		mysql_query("update " .$strQuery) or die(mysql_error());
	}

	function dbDelete($strQuery){
		mysql_query("delete from " .$strQuery) or die(mysql_error());
	}

	function dbInsert($strQuery){
		mysql_query("insert into " .$strQuery) or die(mysql_error());
	}

	function dbClose(){
		mysql_close();
	}



	/***************************************************************************************************
	****************************************************************************************************
	global queries
	****************************************************************************************************
	***************************************************************************************************/
	function getEvolutionBaby($intEvolutionChainID){
		return $qryTemp = dbSelect("
							ps.id,
							ps.identifier pokemonName,
							pe.evolution_trigger_id,
							et.identifier as evolveMethod,
							pe.minimum_level,
							pe.minimum_happiness,
							pe.minimum_beauty,
							pe.known_move_id,
							pe.time_of_day,
							pe.location_id,
							it_use.identifier as itemNameUse,
							it_held.identifier as itemNameHeld,
							g.identifier as genderName,
							ps.is_baby

			from 			pokemon_species ps
			left outer join pokemon_evolution pe on ps.id=pe.evolved_species_id
			left outer join evolution_triggers et on pe.evolution_trigger_id=et.id
			left outer join items it_use on pe.trigger_item_id=it_use.id
			left outer join items it_held on pe.held_item_id=it_held.id
			left outer join genders g on pe.gender_id=g.id
			where 			evolution_chain_id={$intEvolutionChainID}
							and is_baby=1
			order by		ps.is_baby desc,
							pe.minimum_level asc"
		);
	}

	function getEvolutionBase($intEvolutionChainID){
		return dbSelect("
			ps.id,
			ps.identifier pokemonName,
			pe.evolution_trigger_id,
			et.identifier as evolveMethod,
			pe.minimum_level,
			pe.minimum_happiness,
			pe.minimum_beauty,
			pe.known_move_id,
			pe.time_of_day,
			pe.location_id,
			it_use.identifier as itemNameUse,
			it_held.identifier as itemNameHeld,
			g.identifier as genderName,
			ps.is_baby

			from pokemon_species ps
			left outer join pokemon_evolution pe on ps.id=pe.evolved_species_id
			left outer join evolution_triggers et on pe.evolution_trigger_id=et.id
			left outer join items it_use on pe.trigger_item_id=it_use.id
			left outer join items it_held on pe.held_item_id=it_held.id
			left outer join genders g on pe.gender_id=g.id
			where evolution_chain_id={$intEvolutionChainID}
						and is_baby=0
						and 
							(
								ps.evolves_from_species_id IS NULL or
								ps.evolves_from_species_id = ''
							) OR (
							 	ps.evolves_from_species_id = (
							 		select id from pokemon_species sub_ps where sub_ps.is_baby=1 and sub_ps.evolution_chain_id=" . $intEvolutionChainID . "
							 	)
							)
			order by	ps.is_baby desc,
						pe.minimum_level asc"
		);
	}

	function getEvolutionStages($intEvolvesFrom){
		return dbSelect("
			ps.id,
			ps.identifier pokemonName,
			pe.evolution_trigger_id,
			et.identifier as evolveMethod,
			pe.minimum_level,
			pe.minimum_happiness,
			pe.minimum_beauty,
			pe.known_move_id,
			pe.time_of_day,
			pe.location_id,
			it_use.identifier as itemNameUse,
			it_held.identifier as itemNameHeld,
			g.identifier as genderName,
			ps.is_baby

			from pokemon_species ps
			left outer join pokemon_evolution pe on ps.id=pe.evolved_species_id
			left outer join evolution_triggers et on pe.evolution_trigger_id=et.id
			left outer join items it_use on pe.trigger_item_id=it_use.id
			left outer join items it_held on pe.held_item_id=it_held.id
			left outer join genders g on pe.gender_id=g.id
			where ps.evolves_from_species_id=" . $intEvolvesFrom . "
				and ps.is_baby=0
			order by	ps.is_baby desc,
						pe.minimum_level asc,
						ps.identifier asc"
		);
	}


	/***************************************************************************************************
	****************************************************************************************************
	jQuery buttons
	****************************************************************************************************
	***************************************************************************************************/
	function dspButtonSave($label){
		$strButton = '';
		$strButton = $strButton . '<script type="text/javascript">';
		$strButton = $strButton . '	$(function(){';
		$strButton = $strButton . '		$("#btnSave").click(function(event){';
		$strButton = $strButton . '			event.preventDefault();';
		$strButton = $strButton . '			$("#frmAdmin").submit();';
		$strButton = $strButton . '		});';
		$strButton = $strButton . '	});';
		$strButton = $strButton . '</script>';
		$strButton = $strButton . '<button class="btnSave" id="btnSave">' . $label . '</button>';

		return $strButton;
	}

	function dspButtonDelete($url){
		$strButton = '';
		$strButton = $strButton . '<script type="text/javascript">';
		$strButton = $strButton . '	$(function(){';
		$strButton = $strButton . '		$("#btnDelete").click(function(event){';
		$strButton = $strButton . '			event.preventDefault();';
		$strButton = $strButton . '			confirmDelete(\'' . $url . '\');';
		$strButton = $strButton . '		});';
		$strButton = $strButton . '	});';
		$strButton = $strButton . '</script>';
		$strButton = $strButton . '<button class="btnSave" id="btnDelete">Delete</button>';

		return $strButton;
	}

	function dspButtonDeleteWithId($url, $id){
		$strButton = '';
		$strButton = $strButton . '<script type="text/javascript">';
		$strButton = $strButton . '	$(function(){';
		$strButton = $strButton . '		$("#' . $id . '").click(function(event){';
		$strButton = $strButton . '			event.preventDefault();';
		$strButton = $strButton . '			confirmDelete(\'' . $url . '\');';
		$strButton = $strButton . '		});';
		$strButton = $strButton . '	});';
		$strButton = $strButton . '</script>';
		$strButton = $strButton . '<button class="btnSave" id="' . $id . '">Delete</button>';

		return $strButton;
	}
?>
