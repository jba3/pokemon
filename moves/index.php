<?php
	echo '<table class="datagrid" width="100%">';
	echo '<tr>';
	echo '	<th>Name</th>';
	echo '	<th>Type</th>';
	echo '	<th>Damage<br>Class</th>';
	echo '	<th>Power</th>';
	echo '	<th>PP</th>';
	echo '	<th>Accuracy</th>';
	echo '	<th>Priority</th>';
	echo '	<th>Target</th>';
	echo '	<th>Effect%</th>';
	echo '	<th>Effect</th>';
	echo '	<th>Effect(Short)</th>';
	echo '	<th>Hits</th>';
	echo '	<th>Turns</th>';
	echo '	<th>Recoil</th>';
	echo '	<th>Healing</th>';
	echo '	<th>Crit%</th>';
	echo '	<th>Ailment%</th>';
	echo '	<th>Flinch%</th>';
	echo '	<th>Stat%</th>';
	echo '	<th>Ailment</th>';
	echo '	<th>Category</th>';
	echo '</tr>';
	$alternateRow = true;// alternating rows
	while ($rowMoves = mysql_fetch_assoc($qryMoves)){
		echo '<tr' . (($alternateRow = !$alternateRow)?' class="odd"':'') . '>';
		echo '	<td>' . $rowMoves["moveName"] . '</td>';
		echo '	<td>' . dspType($rowMoves["moveType"]) . '</td>';
		echo '	<td>' . dspMoveType($rowMoves["moveDamageClass"]) . '</td>';
		echo '	<td>' . $rowMoves["power"] . '</td>';
		echo '	<td>' . $rowMoves["pp"] . '</td>';
		echo '	<td>' . $rowMoves["accuracy"] . '</td>';
		echo '	<td>' . $rowMoves["priority"] . '</td>';
		echo '	<td>' . $rowMoves["moveTarget"] . '</td>';
		echo '	<td>' . $rowMoves["effect_chance"] . '</td>';
		echo '	<td>' . $rowMoves["effect"] . '</td>';
		echo '	<td>' . $rowMoves["short_effect"] . '</td>';
		echo '	<td>' . $rowMoves["min_hits"] . '-' . $rowMoves["max_hits"] . '</td>';
		echo '	<td>' . $rowMoves["min_turns"] . '-' . $rowMoves["max_turns"] . '</td>';
		echo '	<td>' . $rowMoves["recoil"] . '</td>';
		echo '	<td>' . $rowMoves["healing"] . '</td>';
		echo '	<td>' . $rowMoves["crit_rate"] . '</td>';
		echo '	<td>' . $rowMoves["ailment_chance"] . '</td>';
		echo '	<td>' . $rowMoves["flinch_chance"] . '</td>';
		echo '	<td>' . $rowMoves["stat_chance"] . '</td>';
		echo '	<td>' . $rowMoves["moveMetaAilment"] . '</td>';
		echo '	<td>' . $rowMoves["moveMetaCategory"] . '</td>';
		echo '</tr>';
	}
	echo '</table>';
?>
