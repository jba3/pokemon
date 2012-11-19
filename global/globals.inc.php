<?php
	// set english for default language
	if (!(isset($_COOKIE['language']))){
		$_COOKIE['language'] = 9;
	}

	// generation start/stop info
	$arrGenStart = array(
		1 => 1,
		2 => 152,
		3 => 252,
		4 => 387,
		5 => 496
	);
	$arrGenStop = array(
		1 => 151,
		2 => 251,
		3 => 386,
		4 => 495,
		5 => 649
	);
?>
