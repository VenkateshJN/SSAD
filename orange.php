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
<th>Room</th>
</tr>";
$con=mysql_connect("localhost");
if(!$con)
{
	die('Could not connect: '.mysql_error());
}
mysql_select_db("parse", $con);
$sql="CREATE VIEW Tablet AS select DISTINCT Tablem.Code,Tablem.Name,Type,Day,StartTime,EndTime from Tablem,Tableme where Tablem.Code=Tableme.Code";
mysql_query($sql,$con);
$sql="CREATE VIEW Tablet1 AS select * from Tablet where Type='BC' OR Type='Elective' AND Name NOT LIKE '%Lab%' order by Type,Code,StartTime";
mysql_query($sql,$con);
$R60=array("H101","H102","H201","H202","H301","H302","B4-304","B4-301","B6-309","C1-302");
$R100=array("SH1","SH2","CR1","CR2","H103","H104","H203","H204","H303","H304","N104");
	$sql="CREATE TABLE Rooms
	(
	 Code varchar(10),
	 Name varchar(100),
	 Room varchar(10),
	 Day varchar(10),
	 StartTime varchar(10),
	 EndTime varchar(10)
	)";
	mysql_query($sql,$con);
	$sql=mysql_query("select * from Tablet1");
	$count=0;
while($row[$count] = mysql_fetch_array($sql))
{
	$count++;
}
$j=0;
$k=0;
$n=0;
$bang=0;
$kap=0;
$save=0;
$gold=0;
$zz5="08.30";
$zz6="12.30";
$pp=array("Mon","Tue","Wed","Thu","Fri","Sat");
$zz1="UG1";
$zz2="UG1COURSE";
$zz3=$_POST["ug1seca"];
foreach($pp as $zz4)
{
	mysql_query("insert into Rooms(Code,Name,Room,Day,StartTime,EndTime) values ('$zz1','$zz2','$zz3','$zz4','$zz5','$zz6')");
}
$zz3=$_POST["ug1secb"];
foreach($pp as $zz4)
{
	mysql_query("insert into Rooms(Code,Name,Room,Day,StartTime,EndTime) values ('$zz1','$zz2','$zz3','$zz4','$zz5','$zz6')");
}
$zz1="PG1";
$zz2="PG1COURSE";
$zz3=$_POST["pg1"];
$zz5="10.00";
$zz6="13.00";
foreach($pp as $zz4)
{
	mysql_query("insert into Rooms(Code,Name,Room,Day,StartTime,EndTime) values ('$zz1','$zz2','$zz3','$zz4','$zz5','$zz6')");
}
$zz1="UG2CSE";
$zz2="UG2CSECOURSE";
$zz3=$_POST["ug2cse"];
foreach($pp as $zz4)
{
	mysql_query("insert into Rooms(Code,Name,Room,Day,StartTime,EndTime) values ('$zz1','$zz2','$zz3','$zz4','$zz5','$zz6')");
}
$zz1="UG2ECE";
$zz2="UG2ECECOURSE";
$zz3=$_POST["ug2ece"];
foreach($pp as $zz4)
{
	mysql_query("insert into Rooms(Code,Name,Room,Day,StartTime,EndTime) values ('$zz1','$zz2','$zz3','$zz4','$zz5','$zz6')");
}
for($i=1;$i<$count;$i++)
{
	if($row[$i]['Code']!==$row[$i-1]['Code'] or $i===$count-1)
	{
		$zz1=$row[$i-1]['Code'];
		$zz2=$row[$i-1]['Name'];
		if($bang===0)
		{
			$zz3=$R100[$k];
		}
		else
		{
			$zz3=$R60[$n];
		}
		for($l=$j;$l<$i;$l++)
		{
			$zz4=$row[$l]['Day'];
			$zz5=$row[$l]['StartTime'];
			$zz6=$row[$l]['EndTime'];
			mysql_query("insert into Rooms(Code,Name,Room,Day,StartTime,EndTime) values ('$zz1','$zz2','$zz3','$zz4','$zz5','$zz6')");
			//			echo $zz3." ".$zz4." ".$zz5." ".$zz6 ."\n";
		}
		$j=$i;
		$kap++;
		$gold++;
	}
	if($kap<=1)
	{
//		continue;
	}
	$flag=0;
	$save=0;
	while($flag===0)
	{
		$sql1=mysql_query("select * from Rooms");
		$count1=0;
		while($row2 = mysql_fetch_array($sql1))
		{
			$count1++;
		}
		$count2=0;
		$sql2=mysql_query("select * from Rooms");
		while($row1 = mysql_fetch_array($sql2))
		{
//			if(($row1['StartTime']===$row[$i]['StartTime']) and $row1['Day']===$row[$i]['Day'] and $row1['Room']===$R100[$k])
			if((($row1['StartTime']>=$row[$i]['StartTime'] and $row1['StartTime']<=$row[$i]['EndTime']) or ($row1['EndTime']>=$row[$i]['StartTime'] and $row1['EndTime']<=$row[$i]['EndTime']) or ($row1['StartTime']>=$row[$i]['StartTime'] and $row1['EndTime']<=$row[$i]['EndTime']) or ($row1['StartTime']<=$row[$i]['StartTime'] and $row1['EndTime']>=$row[$i]['EndTime'])) and $row1['Day']===$row[$i]['Day'] and $row1['Room']===$R100[$k])
			{
				break;
			}
			if($count2===$count1-1)
			{
				$flag=1;
			}
			$count2++;
		}
		$bang=0;
		if($flag===1)
		{
			break;
		}
		if($save===11)
		{
			break;
		}
		$save++;
		$k=($k+1)%11;
	}
	while($flag===0)
	{
		$count2=0;
		$sql3=mysql_query("select * from Rooms");
		while($row2 = mysql_fetch_array($sql3))
		{
			if($row2['StartTime']===$row[$i]['StartTime'] and $row2['Day']===$row[$i]['Day'] and $row2['Room']===$R60[$n])
			{
				break;
			}
			if($count2===$count1-1)
			{
				$flag=1;
			}
			$count2++;
		}
		$bang=1;
		if($flag===1)
		{
			break;
		}
		$n=($n+1)%10;
	}
	$kap++;
}
$result = mysql_query("SELECT * FROM Rooms where Code not like 'UG1' and Code not like 'PG1' and Code not like 'UG2CSE' and code not like 'UG2ECE'order by Day,StartTime");
$gold=0;
while($row = mysql_fetch_array($result))
{
	$co=$row['Code'];
	$na=$row['Name'];
	$da=$row['Day'];
	$st=$row['StartTime'];
	$et=$row['EndTime'];
	$ro=$row['Room'];
	if($gold%2==0)
	{
		echo"
			<tr>
			<td>$co</td>
			<td>$na</td>
			<td>$da</td>
			<td>$st</td>
			<td>$et</td>
			<td>$ro</td>
			</tr>";
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
			<td>$ro</td>
			</tr>";
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
