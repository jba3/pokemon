<?php
	$qryLocationID = dbSelectAssoc("id from locations where identifier='".$urlLocation."'");
	$qryLocation   = dbSelectAssoc("name from location_names where local_language_id=9 and location_id=".$qryLocationID['id']);
	$qryEncounters = dbSelect("
			ifnull((select 1 from playerPokedex sub_pp where sub_pp.pokemonID=ps.id and caught=1 and gameID=".$_COOKIE['version_id']."),0) as pokemonCaught,
			ps.id as pokemonID,
			ps.identifier as pokemonName,
			l.identifier as locationName,
			la.identifier as locationNameSub,
			min(min_level) as min_level,
			max(max_level) as max_level,
			sum(es.rarity) as rarity,
			em.identifier as encounterMethodName,
			emp.name as encounterMethodNameProse,
			ecv.identifier as encounterCondition
		from `encounters` e
		join `location_areas` la on e.location_area_id=la.id
		join `locations` l on la.location_id=l.id
		join `encounter_slots` es on e.encounter_slot_id=es.id
			and es.version_group_id=".$_COOKIE['version_group_id']."
		join `encounter_methods` em on es.encounter_method_id=em.id
		join `encounter_method_prose` emp on es.encounter_method_id=emp.encounter_method_id
		join `pokemon_species` ps on e.pokemon_id=ps.id
		left outer join `encounter_condition_value_map` ecvm on e.id=ecvm.encounter_id
		left outer join `encounter_condition_values` ecv on ecvm.encounter_condition_value_id=ecv.id
		where la.location_id=".$qryLocationID['id']."
			and e.version_id=".$_COOKIE['version_id']."
			and es.version_group_id=".$_COOKIE['version_group_id']."
		group by
			ps.identifier,
			l.identifier,
			la.identifier,
			em.identifier,
			emp.name,
			ecv.identifier
		order by la.identifier,
			em.identifier,
			emp.name,
			ecv.identifier,
			sum(es.rarity) desc,
			ps.identifier
	");
?>
