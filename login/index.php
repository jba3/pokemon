<?php
//	if (isset($_GET["failed"])){
//		echo '<p align="center"><strong><em>INVALID USERNAME AND/OR PASSWORD</em></strong></p><hr>';
//	}elseif (isset($_GET["expired"])){
//		echo '<p align="center"><strong><em>YOUR LOGIN AUTHENTICATION HAS EXPIRED. PLEASE LOG IN AGAIN.</em></strong></p><hr>';
//	}

	echo '<p align="center"><strong>POKEDEX PAL.com</strong></p>';
	echo '<p align="center">Enter your account login below.</p>';
	echo '<form action="/login/submit" method="post">';
	echo '	<table align="center">';
	echo '		<tr>';
	echo '			<td>Email:</td>';
	echo '			<td><input type="text" name="email" size="16" maxlength="32"></td>';
	echo '		</tr>';
	echo '		<tr>';
	echo '			<td>Password:</td>';
	echo '			<td><input type="password" name="password" size="16" maxlength="16"></td>';
	echo '		<tr>';
	echo '			<td>&nbsp;</td>';
	echo '			<td align="center"><input type="submit" value="Log In"></td>';
	echo '		</tr>';
	echo '	</table>';
	echo '</form>';
?>
