<?php

if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
	
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
?>
    
<!DOCTYPE html>
<head>
	Welcome to Pick Me!
</head>
<body>
<form method="post" action="signup.php">
	<input type="submit" value="Register"/>
</form>
<form method="post" action="login.php">
	<input type="submit" value="Sign In"/>
</form>
</body>
</html>
<?php    
} else {
    header('Location: login.php');
}
?>

<!-- <!DOCTYPE html>
<head>
	Welcome to Pick Me!
</head>
<body>
<form method="post" action="signup.php">
	<input type="submit" value="Register"/>
</form>
<form method="post" action="login.php">
	<input type="submit" value="Sign In"/>
</form>
</body>
</html> -->