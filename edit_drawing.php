<?php
include('dewdb.inc');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());
$drawingid=$_GET['drawingid'];
//print_r($_POST);
$query="SELECT * FROM Components WHERE Drawing_ID='$drawingid';";
//print($query);
$resa = mysql_query($query, $cxn) or die(mysql_error($cxn));



while ($row = mysql_fetch_assoc($resa))
{
		$drawingno=$row['Drawing_NO'];
		$drawingname=$row['Component_Name'];
	
}

	print("<p><label for=\"dno\">Drawing No</label>");
	print("<input type=\"text\" size=\"25\" name=\"dno\" class=\"required\" value=\"$drawingno\"></p>");
	
	print("<p><label for=\"dno\">Component Name</label>");
	print("<input type=\"text\" size=\"25\" name=\"dname\" class=\"required\" value=\"$drawingname\"></p>");



?>