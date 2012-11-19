<?php
	$qryEliteFour = dbSelect("
					efp.sequence,
					ef.identifier as eliteFourName,
					efp.level,
					a.identifier as abilityName,
					i.identifier as itemName,
					ps.identifier as pokemonName,
					(select identifier from moves sub_m where id=efp.move_id_1) as moveName1,
					(select identifier from moves sub_m where id=efp.move_id_2) as moveName2,
					(select identifier from moves sub_m where id=efp.move_id_3) as moveName3,
					(select identifier from moves sub_m where id=efp.move_id_4) as moveName4,
					(select identifier from types sub_t where sub_t.id=(select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=1)) as type1,
					(select identifier from types sub_t where sub_t.id=(select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=2)) as type2,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=7  and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=1)) as damageBug1,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=7  and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=2)) as damageBug2,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=17 and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=1)) as damageDark1,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=17 and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=2)) as damageDark2,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=16 and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=1)) as damageDragon1,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=16 and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=2)) as damageDragon2,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=13 and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=1)) as damageElectric1,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=13 and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=2)) as damageElectric2,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=2  and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=1)) as damageFighting1,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=2  and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=2)) as damageFighting2,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=10 and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=1)) as damageFire1,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=10 and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=2)) as damageFire2,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=3  and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=1)) as damageFlying1,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=3  and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=2)) as damageFlying2,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=8  and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=1)) as damageGhost1,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=8  and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=2)) as damageGhost2,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=12 and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=1)) as damageGrass1,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=12 and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=2)) as damageGrass2,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=5  and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=1)) as damageGround1,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=5  and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=2)) as damageGround2,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=15 and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=1)) as damageIce1,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=15 and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=2)) as damageIce2,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=1  and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=1)) as damageNormal1,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=1  and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=2)) as damageNormal2,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=4  and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=1)) as damagePoison1,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=4  and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=2)) as damagePoison2,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=14 and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=1)) as damagePsychic1,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=14 and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=2)) as damagePsychic2,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=6  and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=1)) as damageRock1,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=6  and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=2)) as damageRock2,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=9  and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=1)) as damageSteel1,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=9  and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=2)) as damageSteel2,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=11 and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=1)) as damageWater1,
					(select damage_factor/100 from type_efficacy sub_te where damage_type_id=11 and target_type_id in (select type_id from pokemon_types sub_pt where pokemon_id=efp.pokemon_species_id and slot=2)) as damageWater2
		from		elite_four ef
		join 		elite_four_pokemon efp on efp.elite_four_id=ef.id
		left outer join 		abilities a on efp.ability_id=a.id
		left outer join items i on efp.item_id=i.id
		join 		pokemon_species ps on efp.pokemon_species_id=ps.id
		where		version_group_id=" . $_COOKIE['version_group_id'] . "
		order by	efp.sequence,
					ef.order,
					efp.level,
					ps.identifier
	");
?>
