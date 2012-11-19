<?php
	$qryPokemon = dbSelectAssoc("
		*
			,(select identifier from pokemon_types sub_pt join types sub_t on sub_pt.type_id=sub_t.id where sub_pt.pokemon_id=p.species_id and slot=1) as type1
			,(select identifier from pokemon_types sub_pt join types sub_t on sub_pt.type_id=sub_t.id where sub_pt.pokemon_id=p.species_id and slot=2) as type2

			,(select identifier from abilities sub_a join pokemon_abilities sub_pa on sub_a.id=sub_pa.ability_id where sub_pa.pokemon_id=p.species_id and slot=1) as ability1
			,(select effect from ability_prose sub_ap where local_language_id=".$_COOKIE['language']." and sub_ap.ability_id=(select ability_id from pokemon_abilities sub_pa where sub_pa.pokemon_id=p.species_id and sub_pa.slot=1)) as ability1effect
			,(select short_effect from ability_prose sub_ap where local_language_id=".$_COOKIE['language']." and sub_ap.ability_id=(select ability_id from pokemon_abilities sub_pa where sub_pa.pokemon_id=p.species_id and sub_pa.slot=1)) as ability1effectshort
			,(select identifier from abilities sub_a join pokemon_abilities sub_pa on sub_a.id=sub_pa.ability_id where sub_pa.pokemon_id=p.species_id and slot=2) as ability2
			,(select effect from ability_prose sub_ap where local_language_id=".$_COOKIE['language']." and sub_ap.ability_id=(select ability_id from pokemon_abilities sub_pa where sub_pa.pokemon_id=p.species_id and sub_pa.slot=2)) as ability2effect
			,(select short_effect from ability_prose sub_ap where local_language_id=".$_COOKIE['language']." and sub_ap.ability_id=(select ability_id from pokemon_abilities sub_pa where sub_pa.pokemon_id=p.species_id and sub_pa.slot=2)) as ability2effectshort
			,(select identifier from abilities sub_a join pokemon_abilities sub_pa on sub_a.id=sub_pa.ability_id where sub_pa.pokemon_id=p.species_id and slot=3) as abilityDream
			,(select effect from ability_prose sub_ap where local_language_id=".$_COOKIE['language']." and sub_ap.ability_id=(select ability_id from pokemon_abilities sub_pa where sub_pa.pokemon_id=p.species_id and sub_pa.slot=3 and is_dream=1)) as abilityDreameffect
			,(select short_effect from ability_prose sub_ap where local_language_id=".$_COOKIE['language']." and sub_ap.ability_id=(select ability_id from pokemon_abilities sub_pa where sub_pa.pokemon_id=p.species_id and sub_pa.slot=3 and is_dream=1)) as abilityDreameffectshort

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
		where		ps.identifier = '" . $urlPokemon . "'
	");
	$qryEvolution = dbSelect("
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
		where evolution_chain_id=" . $qryPokemon['evolution_chain_id'] . "
		order by	ps.is_baby desc,
					pe.minimum_level asc"
	);

	$qryMovesLevelUp = dbSelect("
				m.identifier as moveName,
				m.power,
				m.accuracy,
				m.pp,
				m.priority,
				pm.level,
				t.identifier as moveType,
				mdc.identifier as moveDamageClass,
				mep.short_effect
		from pokemon_moves pm
		join moves m on pm.move_id=m.id
		join pokemon_move_methods pmm on pm.pokemon_move_method_id=pmm.id
		join types t on m.type_id=t.id
		join move_damage_classes mdc on m.damage_class_id=mdc.id
		join move_effect_prose mep on m.effect_id=mep.move_effect_id
				and mep.local_language_id=".$_COOKIE['language']."
		where version_group_id=".$_COOKIE['version_group_id']."
				and pokemon_id=".$qryPokemon['id']."
				and pmm.id=1
		order by 	pm.level,
					pmm.identifier
	");
	$qryMovesLevelUpOtherEvolutions = dbSelect("
				m.identifier as moveName,
				m.power,
				m.accuracy,
				m.pp,
				m.priority,
				pm.level,
				t.identifier as moveType,
				mdc.identifier as moveDamageClass,
				mep.short_effect,
				ps.identifier as pokemonName
		from pokemon_moves pm
		join moves m on pm.move_id=m.id
		join pokemon_move_methods pmm on pm.pokemon_move_method_id=pmm.id
		join types t on m.type_id=t.id
		join move_damage_classes mdc on m.damage_class_id=mdc.id
		join move_effect_prose mep on m.effect_id=mep.move_effect_id
				and mep.local_language_id=".$_COOKIE['language']."
		join pokemon_species ps on pm.pokemon_id=ps.id
		where version_group_id=".$_COOKIE['version_group_id']."
				and pokemon_id in (select id from pokemon_species sub_p where sub_p.evolution_chain_id=".$qryPokemon['evolution_chain_id'].")
				and pokemon_id != ".$qryPokemon['id']."
				and m.id not in (
					select distinct move_id
					from pokemon_moves sub_pm
					where sub_pm.pokemon_id=".$qryPokemon['id']."
						and sub_pm.version_group_id=".$_COOKIE['version_group_id']."
						and sub_pm.pokemon_move_method_id=1
				)
				and pmm.id=1
		order by 	ps.identifier,
					pm.level
	");

	$qryMovesMachine = dbSelect("
				m.identifier as moveName,
				m.power,
				m.accuracy,
				m.pp,
				m.priority,
				t.identifier as moveType,
				mdc.identifier as moveDamageClass,
				mep.short_effect,
				ma.machine_number
		from pokemon_moves pm
		join moves m on pm.move_id=m.id
		join pokemon_move_methods pmm on pm.pokemon_move_method_id=pmm.id
		join types t on m.type_id=t.id
		join move_damage_classes mdc on m.damage_class_id=mdc.id
		join move_effect_prose mep on m.effect_id=mep.move_effect_id
				and mep.local_language_id=".$_COOKIE['language']."
		join machines ma on pm.move_id=ma.move_id
				and ma.version_group_id=".$_COOKIE['version_group_id']."
		where pm.version_group_id=".$_COOKIE['version_group_id']."
				and pm.pokemon_id=".$qryPokemon['id']."
				and pmm.id=4
		order by 	ma.machine_number
	");

	$qryMovesEgg = dbSelect("
				m.identifier as moveName,
				m.power,
				m.accuracy,
				m.pp,
				m.priority,
				t.identifier as moveType,
				mdc.identifier as moveDamageClass,
				mep.short_effect
		from pokemon_moves pm
		join moves m on pm.move_id=m.id
		join pokemon_move_methods pmm on pm.pokemon_move_method_id=pmm.id
		join types t on m.type_id=t.id
		join move_damage_classes mdc on m.damage_class_id=mdc.id
		join move_effect_prose mep on m.effect_id=mep.move_effect_id
				and mep.local_language_id=".$_COOKIE['language']."
		where version_group_id=".$_COOKIE['version_group_id']."
				and pokemon_id in (select id from pokemon_species sub_p where sub_p.evolution_chain_id=".$qryPokemon['evolution_chain_id'].")
				and pmm.id=2
		order by 	pm.level,
					pmm.identifier
	");

	$qryMovesMoveTutor = dbSelect("
				m.identifier as moveName,
				m.power,
				m.accuracy,
				m.pp,
				m.priority,
				t.identifier as moveType,
				mdc.identifier as moveDamageClass,
				mep.short_effect
		from pokemon_moves pm
		join moves m on pm.move_id=m.id
		join pokemon_move_methods pmm on pm.pokemon_move_method_id=pmm.id
		join types t on m.type_id=t.id
		join move_damage_classes mdc on m.damage_class_id=mdc.id
		join move_effect_prose mep on m.effect_id=mep.move_effect_id
				and mep.local_language_id=".$_COOKIE['language']."
		where version_group_id=".$_COOKIE['version_group_id']."
				and pokemon_id=".$qryPokemon['id']."
				and pmm.id=3
		order by 	pm.level,
					pmm.identifier
	");

	$qryLocations = dbSelect("
		l.identifier as locationName,
		e.min_level,
		e.max_level,
		es.rarity,
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
		left outer join `encounter_condition_value_map` ecvm on e.id=ecvm.encounter_id
		left outer join `encounter_condition_values` ecv on ecvm.encounter_condition_value_id=ecv.id
		where e.pokemon_id=".$qryPokemon['id']."
			and version_id=".$_COOKIE['version_id']."
	");
?>
