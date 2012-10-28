<?php
$con=mysql_connect("localhost");
if(!$con)
{
die('Could not connect: ' . mysql_error());
}
mysql_select_db("parse",$con);

$sql1="Insert Into Tablem(Code,Name,Day,StartTime,EndTime)values
	('$_POST[Code]','$_POST[Name]','$_POST[Day]','$_POST[StartTime]','$_POST[EndTime]')";
if(!mysql_query($sql1,$con))
{
	die('Error: ' . mysql_error());
}

$sql2="Insert Into Tableme(Code,Name,Type)values('$_POST[Code]','$_POST[Name]','$_POST[TType]')";
if(!mysql_query($sql2,$con))
{
	die('Error: ' . mysql_error());
}
else
{
	echo "New Course Added!";
}
mysql_close($con);
?>
