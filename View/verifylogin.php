<?php
include 'common.php';
/* These are our valid username and passwords */


if (isset($_POST['username']) && isset($_POST['password'])) {//include 'db.php';
	  
    if (isset($_POST['rememberme'])) {
        /* Set cookie to last 1 year */
        setcookie('username', $_POST['username'], time()+60*60*24*365, '/account', 'www.example.com');
        setcookie('password', md5($_POST['password']), time()+60*60*24*365, '/account', 'www.example.com'); //Might have to change md5 once I figure out how the password encryption/cookies will work.
    
    } else {
        /* Cookie expires when browser closes */
        setcookie('username', $_POST['username'], false, '/account', 'www.example.com');
        setcookie('password', md5($_POST['password']), false, '/account', 'www.example.com');
    }
	include 'db.php';
	
	dbConnect("logininfo");

	/* Search for matching user/pw combination in database */
	$query = "SELECT * FROM registrationdata WHERE
	userid = '$_POST[username]'";// AND password = PASSWORD('$_POST[password]')";
	$result = mysql_query($query);
	if (!$result) {
		error('A database error occurred while checking your '.
		'login details.\\nIfhis error persists, please '.
		'contact you@example.com.');
	}
	
	if (mysql_num_rows($result) == 0) {
		header('Location: accessdenied.php');
		exit();
	}
	
	//At this point, username and password were found in database.
	setcookie('username', $_POST['username']);
    header('Location: welcomepage.php');
	} 
else { //If user left either username or password field blank.
    echo 'You must supply a username and password.';
}
?>