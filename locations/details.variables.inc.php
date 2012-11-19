<?php
	// have to do complicated parsing because of URL rewrites
	$strUrlPath = $_SERVER['REQUEST_URI'];
	$arrPathFile = explode("/", $strUrlPath);
	$urlLocation = end($arrPathFile);
?>
