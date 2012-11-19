<?php
	// make sure there's a pokedex entry
	// have to pass the array of gen stop numbers since function can't access it
	// should try to figure out global arrays so i don't need to do this...
	checkPokedexEntry($arrGenStop);

	$qryBoxes = dbSelect("
		ps.id,
		ps.identifier,
		pp.caught,
		pp.boxed
		from 		pokemon p
		join		pokemon_species ps on ps.id=p.species_id
		join 		playerPokedex pp on pp.pokemonID=p.id
					and gameID=".$_COOKIE['version_id']."
					and playerID=".$_COOKIE['playerID']."
		where		is_default=1
					and p.id in (
						select pokemon_id
						from pokemon_game_indices sub_pgi
						where sub_pgi.generation_id=" . $_COOKIE['generation_id'] . "
					)
	");
?>
