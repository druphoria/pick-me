<?php // signup.php
include 'common.php';
include 'db.php';

// make a note of the current working directory relative to root. 
$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']); 

// make a note of the location of the upload handler script 
$uploadHandler = 'http://' . $_SERVER['HTTP_HOST'] . $directory_self . 'upload.processor.php'; 

// set a max file size for the html upload form 
$max_file_size = 30000; // size in bytes 
if (!isset($_POST['submitok'])):
// Display the user signup form
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>New User Registration</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>
  <h3>New User Registration Form</h3>
  <p><font color="orangered" size="+1"><tt><b>*</b></tt></font> indicates a required field</p>
  <form method="post" action="<?=$_SERVER['PHP_SELF']?>">
    <table border="0" cellpadding="0" cellspacing="5">
      <tr>
        <td align="right">
          User ID
        </td>
        <td>
          <input name="newid" type="text" maxlength="100" size="25" />
         <font color="orangered" size="+1"><tt><b>*</b></tt></font>
       </td>
    </tr>
    <tr>
        <td align="right">
          Password
        </td>
        <td>
          <input name="newpw" type="password" maxlength="100" size="25" />
         <font color="orangered" size="+1"><tt><b>*</b></tt></font>
       </td>
    </tr>
    <tr>
        <td align="right">
          Re-enter Password
        </td>
        <td>
          <input name="confirmpw" type="password" maxlength="100" size="25" />
         <font color="orangered" size="+1"><tt><b>*</b></tt></font>
       </td>
    </tr>
    <tr>
      <td align="right">
        Full Name
      </td>
      <td>
        <input name="newname" type="text" maxlength="100" size="25" />
      </td>
    </tr>
    <tr>
      <td align="right">
        E-Mail Address
      </td>
      <td>
        <input name="newemail" type="text" maxlength="100" size="25" />
        <font color="orangered" size="+1"><tt><b>*</b></tt></font>
      </td>
    </tr>
    <tr valign="top">
      <td align="right">
        <p>Other Notes</p>
      </td>
      <td>
        <textarea wrap="soft" name="newnotes" rows="5" cols="30"></textarea>
      </td>
    </tr>
    <tr>
      <td align="right" colspan="2">
        <hr noshade="noshade" />
        <input type="reset" value="Reset Form" />
        <input type="submit" name="submitok" value="   OK   " />
      </td>
    </tr>
  </table>
</form>
</body>
</html>

 <?php
else:
// Process signup submission
	dbConnect('logininfo');
 	if ($_POST['newid']==''
	or $_POST['newemail']=='') {
		error('One or more required fields were left blank.\\n'.
		'Please fill them in and try again.');
	}
	
	
	if(strcmp($_POST['newpw'], $_POST['confirmpw']) !=0) {
		error('Passwords do not match. Please re-enter.');
	}
	
	 // Check for existing user with the new id
	$sql = "SELECT COUNT(*) FROM registrationdata WHERE userid = '$_POST[newid]'";
	$result = mysql_query($sql);
	if (!$result) {
		error('A database error occurred in processing your '.
		'submission.\\nIf this error persists, please '.
		'contact druphoria89@gmail.com.');
	}
	if (@mysql_result($result,0,0)>0) { //Checks row 0 column 0 of the result, which is just the count. The result set is only one element.
		error('A user already exists with your chosen userid.\\n'.
		'Please try another.');
	}
	
	
	 $sql = "INSERT INTO registrationdata SET
		userid = '$_POST[newid]',
		password = PASSWORD('$_POST[newpw]'),
		fullname = '$_POST[newname]',
		email = '$_POST[newemail]',
		notes = '$_POST[newnotes]'";
		
	if (!mysql_query($sql))
		error('A database error occurred in processing your '.
		'submission.\\nIf this error persists, please '.
		'contact druphoria89@gmail.com.');
	
	 ?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<title> Registration Complete </title>
		<meta http-equiv="Content-Type"
		content="text/html; charset=iso-8859-1" />
		</head>
		<body>
		<p><strong>User registration successful!</strong></p>
		<p> To log in,
		click <a href="landing.php">here</a> to return to the login
		page, and enter your new personal userid and password.</p>
		</body>
		</html>
<?php
endif;
?>