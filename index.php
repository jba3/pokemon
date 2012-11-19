<?php
	$requestPath   = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
	$requestModule = 'login';
	$requestItem   = 'index';

	// this has some weird thing where the "/" counts as an item, even though it's the delimiter
	if ($requestPath[1] != '' && $requestPath[1] != 'index.php'){
		$requestModule = str_replace("%20", " ", $requestPath[1]);
	}
	if (sizeof($requestPath) > 2 && $requestPath[2] != ''){
		$requestItem = str_replace("%20", " ", $requestPath[2]);
	}

	// special case handlers
	if ($requestModule == 'pokemon' and $requestItem != 'index'){
		// we're looking for a specific pokemon here
		// and will parse the URL path inside the index
		$requestItem = 'index';
	}else if ($requestModule == 'abilities' and $requestItem != 'index'){
		// we're looking for a specific ability here
		// and will parse the URL path inside the index
		$requestItem = 'index';
	}else if ($requestModule == 'moves' and $requestItem != 'index'){
		// we're looking for a specific move here
		// and will parse the URL path inside the index
		$requestItem = 'index';
	}else if ($requestModule == 'items' and $requestItem != 'index'){
		// we're looking for a specific item here
		// and will parse the URL path inside the index
		$requestItem = 'index';
	}else if ($requestModule == 'locations' and $requestItem != 'index'){
		// we're looking for a specific location here
		// and will parse the URL path inside the index
		$requestItem = 'details';
	}



	include_once $_SERVER["DOCUMENT_ROOT"] . "/global/globals.inc.php";
	include_once $_SERVER["DOCUMENT_ROOT"] . "/global/functions.inc.php";
	include_once $_SERVER["DOCUMENT_ROOT"] . "/global/security.inc.php";

	// only for authenticated users
	if (isset($_COOKIE['playerID'])){
		include_once $_SERVER["DOCUMENT_ROOT"] . "/global/header.inc.php";
	}

	// grab the module based off path
	$fileVariables = $_SERVER["DOCUMENT_ROOT"] . "/" . $requestModule . "/" . $requestItem . ".variables.inc.php";
	$fileFunctions = $_SERVER["DOCUMENT_ROOT"] . "/" . $requestModule . "/" . $requestItem . ".functions.inc.php";
	$fileQueries   = $_SERVER["DOCUMENT_ROOT"] . "/" . $requestModule . "/" . $requestItem . ".queries.inc.php";
	$fileDisplay   = $_SERVER["DOCUMENT_ROOT"] . "/" . $requestModule . "/" . $requestItem . ".php";

	// helper file for page level variables / settings first
	if (file_exists($fileVariables)){
		include_once $fileVariables;
	}
	// helper file for functions next
	if (file_exists($fileFunctions)){
		include_once $fileFunctions;
	}
	// helper file for queries last
	if (file_exists($fileQueries)){
		dbOpen();
			include_once $fileQueries;
		dbClose();
	}

	// actual display file now
	include_once $fileDisplay;

	// only for authenticated users
	if (isset($_COOKIE['playerID'])){
		include_once $_SERVER["DOCUMENT_ROOT"] . "/global/footer.inc.php";
	}
?>
