
<?php
	// database var
		$host = 'localhost';
		$user = 'asaltour_asltrgc';
		$pass = 'H^}r_3;aA@%;';
		$dbname = 'asaltour_aslgcms';
	// connect database
		$link = mysql_connect($host,$user,$pass);
		mysql_select_db($dbname,$link);

echo "test <br>";
 $tableName  = 'gcms_login';
$backupFile = 'mypet.sql';
$query      = "SELECT * INTO OUTFILE '$backupFile' FROM $tableName";
$query2      = "SELECT * FROM $tableName";

$result = mysql_query($query , $link );
$result2 = mysql_query($query2 , $link );

echo $result ;
echo "<br>
$query <br>$query2  ";

echo $result2 ;

mysql_close($link);

?>