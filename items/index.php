<?php
	// have to do complicated parsing because of URL rewrites
	$strUrlPath = $_SERVER['REQUEST_URI'];
	$arrPathFile = explode("?", $strUrlPath);
	$itemPocket = end($arrPathFile);

	dbOpen();
		$qryItemPockets = dbSelect("identifier as itemPocket from item_pockets order by identifier asc");

		if ($itemPocket != ""){
			$qryItems = dbSelect("
							i.id,
							i.identifier as itemName,
							i.cost,
							ic.identifier as itemCategory,
							ip.identifier as itemPocket,
							ipr.short_effect,
							ipr.effect,
							ift.flavor_text
				from		items i
				left outer join		item_categories ic on i.category_id=ic.id
				left outer join 	item_pockets ip on ic.pocket_id=ip.id
				left outer join 	item_prose ipr on ipr.item_id=i.id
				left outer join 	item_flavor_text ift on i.id=ift.item_id
									and ift.version_group_id=" . $_COOKIE['version_group_id'] . "
									and language_id=" . $_COOKIE['language'] . "
				where ip.identifier = '" . $itemPocket . "'
				order by	ip.identifier,
							ic.identifier,
							i.identifier
			");
		}
	dbClose();



	echo '<p align="center">';
	while ($rowItemPockets = mysql_fetch_assoc($qryItemPockets)){
		echo '[ <a href="?' . $rowItemPockets['itemPocket'] . '">' . $rowItemPockets['itemPocket'] . '</a> ]';
	}
	echo '</p>';

	if ($itemPocket != ""){
		echo '<table class="datagrid" width="100%">';
		echo '<tr>';
		echo '	<th>Pocket</th>';
		echo '	<th>Category</th>';
		echo '	<th>Name</th>';
		echo '	<th>Effect</th>';
		echo '</tr>';
		$alternateRow = true;// alternating rows
		while ($rowItems = mysql_fetch_assoc($qryItems)){
			echo '<tr' . (($alternateRow = !$alternateRow)?' class="odd"':'') . '>';
			echo '	<td>' . $rowItems["itemPocket"] . '</td>';
			echo '	<td>' . $rowItems["itemCategory"] . '</td>';
			echo '	<td>' . $rowItems["itemName"] . '</td>';
			echo '	<td>' . $rowItems["short_effect"] . '</td>';
			echo '</tr>';
		}
		echo '</table>';
	}
?>
