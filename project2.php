<?php
echo"
<html>
<head>
<style>
#customers
{
	font-family:Trebuchet MS, Arial, Helvetica, sans-serif;
width:100%;
      border-collapse:collapse;
}
#customers td, #customers th 
{
	font-size:1em;
border:1px solid #98bf21;
padding:3px 7px 2px 7px;
}
#customers th 
{
	font-size:1.1em;
	text-align:left;
	padding-top:5px;
	padding-bottom:4px;
	background-color:#A7C942;
color:#ffffff;
}
#customers tr.alt td 
{
color:#000000;
      background-color:#EAF2D3;
}
</style>
</head>

<body>
<table id=customers>
<tr>
<th>Code</th>
<th>Name</th>
<th>Type</th>
</tr>";
$con = mysql_connect("localhost");
if(!$con)
{
	die('Could not connect: '.mysql_error());
}

/*if (mysql_query("CREATE DATABASE parse2",$con))
  {
  echo "Database created";
  }
  else
  {
  echo "Error creating database: " . mysql_error();
  }*/

mysql_select_db("parse", $con);
	$sql = "CREATE TABLE Tableme
	(
	 Code varchar(10),
	 Name varchar(100),
	 Type varchar(10)
	)";

	mysql_query($sql,$con);
	
$file=fopen($_FILES["file2"]["tmp_name"],"r");
$linecount=0;
$gold=0;
while(1)
{
	$line = fgets($file);
	$q=strlen($line);
	if($q===0)
	{
		break;
	}
	if($gold===0)
	{
		$gold++;
		continue;
	}
	$i1=0;
	$co='';
	while($line[$i1]!=',')
	{
		if($line[$i1]!=' ' and $line[$i1]!='"')
		{
			$co=$co.$line[$i1];
		}
		$i1++;
	}
	$i1++;
	$i2=$q-1;
	$z=strrpos($line,"\n");
	if($i2==$z)
	{
		$i2=$i2-1;
	}
	//	$i2=$z-1;
	$ty='';
	while($line[$i2]!=',')
	{
		if($line[$i2]!=' ' and $line[$i2]!='"')
		{
			$ty=$line[$i2].$ty;
		}
		$i2--;
	}
	$na='';
	while($i1<$i2)
	{
		$na=$na.$line[$i1];
		$i1++;
	}
	mysql_query("INSERT INTO Tableme (Code, Name, Type) 
			VALUES ('$co','$na','$ty')");
	//	echo $co." ".$na." ".$ty."\n";
	if($gold%2==0)
	{
		echo"
			<tr>
			<td>$co</td>
			<td>$na</td>
			<td>$ty</td>
			</tr>";
//		sleep(1);
		ob_flush();
		flush();
	}
	else
	{
		echo"
			<tr class=alt>
			<td>$co</td>
			<td>$na</td>
			<td>$ty</td>
			</tr>";
//		sleep(1);
		ob_flush();
		flush();
	}
	$gold++;
}
mysql_close($con);
echo"
</table>
</body>
</html>
";
?>
