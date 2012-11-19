/*cleans up fresh install, removes contest and conquest tables*/

drop table conquest_episodes;
drop table conquest_episode_names;
drop table conquest_episode_warriors;
drop table conquest_kingdoms;
drop table conquest_kingdom_names;
drop table conquest_max_links;
drop table conquest_move_data;
drop table conquest_move_displacements;
drop table conquest_move_displacement_prose;
drop table conquest_move_effects;
drop table conquest_move_effect_prose;
drop table conquest_move_ranges;
drop table conquest_move_range_prose;
drop table conquest_pokemon_abilities;
drop table conquest_pokemon_evolution;
drop table conquest_moves;
drop table conquest_stats;
drop table conquest_stats;
drop table conquest_stat_names;
drop table conquest_transformation_pokemon;
drop table conquest_transformation_warriors;
drop table conquest_warriors;
drop table conquest_warrior_archetypes;
drop table conquest_warrior_names;
drop table conquest_warrior_ranks;
drop table conquest_warrior_rank_stat_map;
drop table conquest_warrior_skills;
drop table conquest_warrior_skill_names;
drop table conquest_warrior_specialties;
drop table conquest_warrior_stats;
drop table conquest_warrior_stat_names;
drop table conquest_warrior_transformation;

drop table contest_combos;
drop table contest_effect_prose;
drop table contest_effects;
drop table contest_type_names;
drop table contest_types;

drop table pokeathlon_stat_names;
drop table pokeathlon_stats;

drop table super_contest_combos;
drop table super_contest_effect_prose;
	drop table super_contest_effects;

drop table nature_pokeathlon_stats;

ALTER TABLE  `conquest_warriors` DROP FOREIGN KEY  `conquest_warriors_ibfk_1` ;

ALTER TABLE  `conquest_warriors` DROP FOREIGN KEY  `conquest_warriors_ibfk_2` ;

ALTER TABLE  `moves` DROP FOREIGN KEY  `moves_ibfk_6` ;

ALTER TABLE  `moves` DROP FOREIGN KEY  `moves_ibfk_7` ;

ALTER TABLE  `moves` DROP FOREIGN KEY  `moves_ibfk_8` ;

ALTER TABLE pokeathlon_stats DROP FOREIGN KEY `pokemon_form_pokeathlon_stats_ibfk_2`;
