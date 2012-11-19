<!DOCTYPE html>
<html>
<head>
	<title>PokedexPal.com</title>
	<link rel="stylesheet" href="/global/css/style.css">
	<script type="text/javascript" src="/global/js/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="/global/js/layout.js"></script>
</head>

<body>

<div id="layoutHeader"><a href="/home/">PokedexPal.com</a></div>
<div id="layoutSelectGame">
	<form id="frmSetGame" method="post" action="/setgame/">
		<?php if (isset($_COOKIE['version_id']) && $_COOKIE['version_id'] != ""){ echo dspVersion(); } ?>
		<select name="version_id" id="selNewGame" onchange="javascript:setGame();">
			<option value="">-- Select game --</option>
			<?php
				dbOpen();
					$qryVersion = dbSelect("
									vn.name as gameName,
									v.id,
									generation_id
						from 		versions v
						join 		version_groups vg on v.version_group_id=vg.id
						join 		version_names vn on v.id=vn.version_id
									and local_language_id=9
						where 		v.identifier not in ('xd','colosseum')
						order by 	vg.order asc");
				dbClose();

				$old_generation_id = 0;
				while ($rowVersion = mysql_fetch_assoc($qryVersion)){
					if ($old_generation_id != $rowVersion['generation_id']){
						if ($old_generation_id != 0){
							echo '</optgroup>';
						}
						echo '<optgroup label="GEN '.$rowVersion['generation_id'].'">';
					}
					echo '<option value="'.$rowVersion['id'].'">'.$rowVersion['gameName'].'</option>';

					$old_generation_id = $rowVersion['generation_id'];
				}
				echo '</optgroup>';
			?>
		</select>
	</form>
</div>
<div id="layoutMenu">
	<table>
		<tr>
			<?php
				if (isset($_COOKIE['version_id']) && $_COOKIE['version_id'] != ""){
					echo '	<td width="9%" class="account"><a href="/mypokedex/">My Pokedex</a></td>';
					echo '	<td class="account"><a href="/myboxes/">My Boxes</a></td>';
					echo '	<td class="account"><a href="/locations/">Locations</a></td>';
					echo '	<td><a href="/elitefour/">Elite Four</a></td>';
					echo '	<td><a href="/pokedex/">Pokedex</a></td>';
					echo '	<td><a href="/moves/">Moves</a></td>';
					echo '	<td><a href="/abilities/">Abilities</a></td>';
					echo '	<td><a href="/items/">Items</a></td>';
					echo '	<td><a href="/natures/">Natures</a></td>';
					echo '	<td><a href="/types/">Types</a></td>';
					echo '	<td><a href="/machines/">Machines</a></td>';
				}else{
					echo '	<td width="90%">Select game from the dropdown at the top right</td>';
				}
			?>
			<td width="10%" class="logout"><a href="/logout/">Log out</a></td>
		</tr>
	</table>
</div>
<div id="layoutContent">
