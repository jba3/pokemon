<?php
	$qryLocations = dbSelect("
		distinct
			e.version_id,
			ps.identifier as pokemonName,
			ps.id as pokemonID,
			l.identifier as locationName,
			ifnull((
				select 1
				from playerPokedex sub_pp
				where e.pokemon_id=sub_pp.pokemonID
					and sub_pp.gameID=".$_COOKIE['version_id']."
					and sub_pp.caught=1
			),0) as hasCaughtPokemon
		FROM `encounters` e
			join `pokemon_species` ps on e.pokemon_id=ps.id
			join `location_areas` la on e.location_area_id=la.id
			join `locations` l on la.location_id=l.id
		WHERE
			version_id=".$_COOKIE['version_id']."
		ORDER BY
			l.identifier,
			ifnull((
				select 1
				from playerPokedex sub_pp
				where e.pokemon_id=sub_pp.pokemonID
					and sub_pp.gameID=".$_COOKIE['version_id']."
					and sub_pp.caught=1
			),0) ASC,
			ps.identifier
	");
?>
