<?php
include 'common.php';
/* These are our valid username and passwords */


if (isset($_POST['username']) && isset($_POST['password'])) {//include 'db.php';
	  
    if (isset($_POST['rememberme'])) {
        /* Set cookie to last 1 year */
        setcookie('username', $_POST['username'], time()+60*60*24*365, '/account', 'www.example.com');
        setcookie('password', md5($_POST['password']), time()+60*60*24*365, '/account', 'www.example.com');
    
    } else {
        /* Cookie expires when browser closes */
        setcookie('username', $_POST['username'], false, '/account', 'www.example.com');
        setcookie('password', md5($_POST['password']), false, '/account', 'www.example.com');
    }
	include 'db.php';

	/* Search for matching user/pw combination in database */
	$query = "SELECT * FROM registrationdata WHERE
	userid = '$_POST[username]'";// AND password = PASSWORD('$_POST[password]')";
	$result = mysql_query($query);
	if (!$result) {
		// error('A database error occurred while checking your '.
		// 'login details.\\nIfhis error persists, please '.
		// 'contact you@example.com.');		error('fuck you');
	}
	
	if (mysql_num_rows($result) == 0) {
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title> Access Denied </title>
	<meta http-equiv="Content-Type"
	content="text/html; charset=iso-8859-1" />
	</head>
	<body>
	<h1> Access Denied </h1>
	<p>Your user ID or password is incorrect, or you are not a
	registered user on this site. To try logging in again, click
	<a href="<?=$_SERVER['PHP_SELF']?>">here</a>. To register for instant
	access, click <a href="signup.php">here</a>.</p>
	</body>
	</html>
	<?php
	exit;
	}
	
    header('Location: landing.php');
        
	} 
else {
    echo 'You must supply a username and password.';
}
?>