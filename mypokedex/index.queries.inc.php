<?php
	// make sure there's a pokedex entry
	// have to pass the array of gen stop numbers since function can't access it
	// should try to figure out global arrays so i don't need to do this...
	checkPokedexEntry($arrGenStop);

	// get pokemon list
	$qryMyPokedex = dbSelect("
				pp.pokemonID,
				pp.seen,
				pp.caught,
				ps.identifier as pokemonName,
				la.identifier as locationDetails,
				l.identifier as locationName,
				em.identifier as encounterMethod,
				sum(es.rarity) as encounterRate,
				(select min(min_level) from encounters sub_e where sub_e.pokemon_id=pp.pokemonID and sub_e.location_area_id=la.id) as min_level,
				(select max(max_level) from encounters sub_e where sub_e.pokemon_id=pp.pokemonID and sub_e.location_area_id=la.id) as max_level
		from	playerPokedex pp
		join 	pokemon_species ps on pp.pokemonID=ps.id
		left outer join encounters e on pp.pokemonID=e.pokemon_id
				and e.version_id=".$_COOKIE['version_id']."
		left outer join encounter_slots es on e.encounter_slot_id=es.id
		left outer join encounter_methods em on es.encounter_method_id=em.id
				and es.version_group_id=".$_COOKIE['version_group_id']."
		left outer join location_areas la on e.location_area_id=la.id
		left outer join locations l on la.location_id=l.id
		where	pp.caught=0
				and pp.playerID=" . $_COOKIE['playerID'] . "
				and pp.gameID=" . $_COOKIE['version_id'] . "
		group by pp.pokemonID,
				pp.seen,
				pp.caught,
				ps.identifier,
				la.identifier,
				l.identifier,
				em.identifier
		order by pp.pokemonID,
				sum(es.rarity) desc,
				l.identifier,
				la.identifier,
				em.order");
	$qryCountSeen   = dbSelectAssoc("count(*) as total from playerPokedex where playerID=" . $_COOKIE['playerID'] . " and gameID=" . $_COOKIE['version_id'] . " and seen=1");
		$qryCountCaught = dbSelectAssoc("count(*) as total from playerPokedex where playerID=" . $_COOKIE['playerID'] . " and gameID=" . $_COOKIE['version_id'] . " and caught=1");
?>