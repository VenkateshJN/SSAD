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
<th>Day</th>
<th>StartTime</th>
<th>EndTime</th>
</tr>";
$con = mysql_connect("localhost");
if(!$con)
{
	die('Could not connect: '.mysql_error());
}
if (mysql_query("CREATE DATABASE parse",$con))
{
	echo "Database created";
}
else
{
	echo "Error creating database: " . mysql_error();
}

mysql_select_db("parse", $con);
	$sql = "CREATE TABLE Tablem
	(
	 Code varchar(10),
	 Name varchar(100),
	 Day varchar(5),
	 StartTime varchar(10),
	 EndTime varchar(10)
	)";

	mysql_query($sql,$con);
$file=fopen($_FILES["file1"]["tmp_name"],"r");
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
	$gold++;
	if($line[0]!=',')
	{
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
		while($line[$i2]!=',')
		{
			$i2--;
		}
		$i2--;
		$z=5;
		$et='';
		while($z>0)
		{
			$et=$line[$i2].$et;
			$i2--;
			$z=$z-1;
		}
		$i2--;
		$z=5;
		$st='';
		while($z>0)
		{
			$st=$line[$i2].$st;
			$i2--;
			$z=$z-1;
		}
		$i2=$i2-1;
		$da='';
		$z=3;
		while($z>0)
		{
			$da=$line[$i2].$da;
			$i2--;
			$z--;
		}
		$na='';
		while($i1<$i2)
		{
			$na=$na.$line[$i1];
			$i1++;
		}
		mysql_query("INSERT INTO Tablem (Code, Name, Day, StartTime, EndTime) 
				VALUES ('$co','$na','$da','$st','$et')");
		//		echo $co." ".$na." ".$da." ".$st." ".$et."\n";
		if($gold%2==0)
		{
			echo"
				<tr>
				<td>$co</td>
				<td>$na</td>
				<td>$da</td>
				<td>$st</td>
				<td>$et</td>
				</tr>";
			//			sleep(1);
			ob_flush();
			flush();
		}
		else
		{
			echo"
				<tr class=alt>
				<td>$co</td>
				<td>$na</td>
				<td>$da</td>
				<td>$st</td>
				<td>$et</td>
				</tr>";
			//			sleep(1);
			ob_flush();
			flush();
		}
	}
	else 
	{
		$i=2;
		$da=$line[$i].$line[$i+1].$line[$i+2];
		$st=$line[$i+4].$line[$i+5].$line[$i+6].$line[$i+7].$line[$i+8];
		$i=$i+10;
		$et=$line[$i].$line[$i+1].$line[$i+2].$line[$i+3].$line[$i+4];
		mysql_query("INSERT INTO Tablem (Code, Name, Day, StartTime, EndTime) 
				VALUES ('$co','$na','$da','$st','$et')");
		//		echo $co." ".$na." ".$da." ".$st." ".$et."\n";
		if($gold%2==0)
		{
			echo"
				<tr>
				<td>$co</td>
				<td>$na</td>
				<td>$da</td>
				<td>$st</td>
				<td>$et</td>
				</tr>";
			//			sleep(1);
			ob_flush();
			flush();
		}
		else
		{
			echo"
				<tr class=alt>
				<td>$co</td>
				<td>$na</td>
				<td>$da</td>
				<td>$st</td>
				<td>$et</td>
				<tr>
				";
			//			sleep(1);
			ob_flush();
			flush();
		}
	}

}
mysql_close($con);
echo"
</table>
</body>
</html>"
?>
