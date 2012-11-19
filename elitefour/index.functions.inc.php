<?php
	function dspDamage($intDmg){
		$str = '<td align="right"';
		if ($intDmg == 4){
			$str .= ' class="damageGood">x4';
		}else if ($intDmg == 2){
			$str .= ' class="damageGood">x2';
		}else if ($intDmg == 1){
			$str .= ' class="damageNeutral">&nbsp;';
		}else if ($intDmg == 0.5){
			$str .= ' class="damageBad">1/2';
		}else if ($intDmg == 0.25){
			$str .= ' class="damageBad">1/4';
		}else if ($intDmg == 0){
			$str .= ' class="damageNone">-';
		}
		return $str . "</td>";
	}
?>
