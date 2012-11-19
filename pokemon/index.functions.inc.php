<?php
	function dspEvolution($id,$triggerID,$name,$method,$itemUse,$level,$happiness,$beauty,$moveID,$time,$itemHeld,$locationID,$genderName){
		echo dspPokemonSprite($id) . '<br>';
		echo '#'.$id.'<br>';
		echo dspPokemonName($name) . '<br>';
		if ($method != ""){
			echo $method;
			
			// general evolution methods
			if ($triggerID == 1){// LEVEL UP
				// show nothing else
			}else if ($triggerID == 2){// TRADE
				// show nothing else
			}else if ($triggerID == 3){// USE ITEM
				echo dspItem($itemUse);
			}else if ($triggerID == 4){// SHED
				// show nothing else
			}

			// special conditions
			if ($level != ''){
				echo '<br>at level ' . $level;
			}
			if ($happiness){
				echo '<br>with minimum happiness of ' . $happiness;
			}
			if ($beauty){
				echo '<br>with minimum beauty of ' . $beauty;
			}
			if ($moveID){
				echo '<br>knowing move ' . $moveID;
			}
			if ($time){
				echo '<br>at ' . $time;
			}
			if ($itemHeld){
				echo '<br>holding item ' . dspItem($itemHeld);
			}
			if ($locationID){
				echo '<br>at location ' . $locationID;
			}
			if ($genderName){
				echo '<br>of gender ' . $genderName;
			}
		}
	}

	function dspMoveHeader($strHeader){
		echo '<tr><th colspan="9">'.$strHeader.'</th></tr>';
		echo '<tr>';
		echo '<th></th>';
		echo '<th>Move</th>';
		echo '<th>Type</th>';
		echo '<th>Class</th>';
		echo '<th>Power</th>';
		echo '<th>Acc</th>';
		echo '<th>PP</th>';
		echo '<th>Pri</th>';
		echo '<th>Description</th>';
		echo '</tr>';
	}

	function dspMoveRow($attStatPreference, $pokemonType1, $pokemonType2, $intLevel, $strMoveName, $strMoveType, $strMoveDamageClass, $intPower, $intAccuracy, $intPP, $intPriority, $strDescription){
		$thisClass = '';
		if (
			($strMoveType == $pokemonType1 || $strMoveType == $pokemonType2)
			&& ($strMoveDamageClass == 'physical' || $strMoveDamageClass == 'special')
		){
			$thisClass .= ' bonusSTAB';
		}
		if (
			($attStatPreference == 'Att' && $strMoveDamageClass == 'physical') ||
			($attStatPreference == 'SpAtt' && $strMoveDamageClass == 'special')
		){
			$thisClass .= ' bonusDC';
		}

		echo '<tr class="'.$thisClass.'">';
		if ($intLevel == 1){
			echo '<td align="right">-</td>';
		}else if ($intLevel == ""){
			echo '<td class="transparent">&nbsp;</td>';
		}else{
			echo '<td align="right">'.$intLevel.'</td>';
		}
		echo '	<td>'.$strMoveName.'</td>';
		echo '	<td>'.dspType($strMoveType).'</td>';
		echo '	<td>'.dspMoveType($strMoveDamageClass).'</td>';
		echo '	<td align="right">';
		if ($intPower == 0){
			echo '-';
		}else if ($intPower == 1){
			echo '*';//varied power moves, like trump card or grass knot
		}else{
			echo $intPower;
		}
		echo '	</td>';
		echo '	<td align="right">';
		if ($intAccuracy == ""){
			echo '-';
		}else{
			echo $intAccuracy;
		}
		echo '	</td>';
		echo '	<td align="right">'.$intPP.'</td>';
		echo '	<td align="right">';
		if ($intPriority == 0){
			echo '&nbsp;';
		}else if ($intPriority > 0){
			echo '<span style="font-weight:bold;color:#090;">+'.$intPriority.'</span>';
		}else if ($intPriority < 0){
			echo '<span style="font-weight:bold;color:#F00;">'.$intPriority.'</span>';
		}else{
			echo $intPriority;
		}
		echo '	</td>';
		echo '	<td>'.$strDescription.'</td>';
		echo '</tr>';
	}
?>
