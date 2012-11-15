<?php
include 'common.php';

if (isset($_COOKIE['username'])){//} && isset($_COOKIE['password'])) { //STILL NEED TO FIGURE OUT PASSWORD ENCRYPTION/DECRYPTION
	include 'db.php';

	/* Search for matching user/pw combination in database */
	$query = "SELECT * FROM registrationdata WHERE
	userid = '$_COOKIE[username]' AND password = PASSWORD('$_COOKIE[password]')";
	$result = mysql_query($query);
	if (!$result) {
		error('A database error occurred while checking your '.
		'login details.\\nIfhis error persists, please '.
		'contact you@example.com.');
	}
	
	if (mysql_num_rows($result) == 0) {
		unset($_COOKIE['username']);
		unset($_COOKIE['password']);
		header('Location: accessdenied.php');
	}
	header('Location: welcomepage.php');  
} else { //COOKIE IS NOT SET
    header('Location: login.php');
    //echo "the cookie isn't set. it is '$_COOKIE[username]'";
}
?>