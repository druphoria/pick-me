<form method="POST" enctype="multipart/form-data">
<table width="350" border="0" cellpadding="1" cellspacing="1" class="box">
<tr> 
<td width="246">
<input type="hidden" name="MAX_FILE_SIZE" value="5000000">
<input name="userfile" type="file" id="userfile"> 
</td>
<td width="80"><input name="upload" type="submit" class="box" id="upload" value=" Upload "></td>
</tr>
</table>
</form>

<?php

$dbcnx = @mysql_connect("localhost", "andrew", "pickme")
or die("The site database appears to be down.");
 
if (!@mysql_select_db("logininfo")) {
die("The site database is unavailable.");
}
else{
	echo "connection successful";
} 

if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0)
{
	echo "type is {$_FILES['userfile']['name']}~";
	echo "tmp name is {$_FILES['userfile']['tmp_name']}~";
	echo "size is {$_FILES['userfile']['size']}~";
	echo "type is {$_FILES['userfile']['type']}~";
	
	echo "whatupdawg";
$fileName = $_FILES['userfile']['name'];
$tmpName  = $_FILES['userfile']['tmp_name'];
$fileSize = $_FILES['userfile']['size'];
$fileType = $_FILES['userfile']['type'];

$fp      = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));
$content = addslashes($content);
fclose($fp);

if(!get_magic_quotes_gpc())
{
    $fileName = addslashes($fileName);
}


$query = "INSERT INTO images (name, size, type, content ) ".
"VALUES ('$fileName', '$fileSize', '$fileType', '$content')";

mysql_query($query) or die('Error, query failed'); 

echo "<br>File $fileName uploaded<br>";
} 
?>