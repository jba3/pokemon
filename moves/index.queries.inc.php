<?php
	$qryMoves = dbSelect("
					m.identifier AS moveName,
					m.generation_id AS generation_id,
					m.power AS power,
					m.pp AS pp,
					m.accuracy AS accuracy,
					m.priority AS priority,
					m.effect_chance AS effect_chance,
					t.identifier AS moveType,
					mt.identifier AS moveTarget,
					mdc.identifier AS moveDamageClass,
					mep.short_effect AS short_effect,
					mep.effect AS effect,
					mm.min_hits AS min_hits,
					mm.max_hits AS max_hits,
					mm.min_turns AS min_turns,
					mm.max_turns AS max_turns,
					mm.recoil AS recoil,
					mm.healing AS healing,
					mm.crit_rate AS crit_rate,
					mm.ailment_chance AS ailment_chance,
					mm.flinch_chance AS flinch_chance,
					mm.stat_chance AS stat_chance,
					mma.identifier AS moveMetaAilment,
					mmc.identifier AS moveMetaCategory
		from 		moves m
		left join 	move_meta mm on m.id = mm.move_id
		left join 	move_meta_ailments mma on mma.id = mm.meta_ailment_id
		left join 	move_meta_categories mmc on mmc.id = mm.meta_category_id
		join 		types t on m.type_id = t.id
		join 		move_targets mt on m.target_id = mt.id
		join 		move_damage_classes mdc on m.damage_class_id = mdc.id
		join 		move_effect_prose mep on m.effect_id = mep.move_effect_id
						and mep.local_language_id = 9
		where		m.generation_id = " . $_COOKIE['generation_id'] . "
		order by	moveName
	");
?>
