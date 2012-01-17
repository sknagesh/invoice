<?php
include('dewdb.inc');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());
//print_r($_GET);
$drawingid=$_GET['drawingid'];
$incommingid=$_GET['incommingid'];
$qty=$_GET['qty'];


$query="SELECT Qty,Outward_Qty FROM Material_Incomming WHERE Challan_ID='$incommingid' AND Drawing_ID='$drawingid';"; 
//print($query);
$resa = mysql_query($query, $cxn) or die(mysql_error($cxn));
while ($row = mysql_fetch_assoc($resa))
{
	$cqty=$row['Outward_Qty'];
}

print($cqty);

?>