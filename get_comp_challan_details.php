<?php
include('dewdb.inc');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());
//print_r($_GET);
$drawingid=$_GET['drawingid'];
$incommingid=$_GET['incommingid'];
$qty=$_GET['qty'];

$query="SELECT Ex_Challan_NO, Ex_Challan_Date,GP_NO,GP_Date,DA_NO,DA_Date,Drawing_NO,Qty FROM Incomming_Challans as ic "; 
$query.="INNER JOIN Material_Incomming AS mi ON mi.Challan_ID=ic.Incomming_ID ";
$query.="INNER JOIN Components as comp ON comp.Drawing_ID=mi.Drawing_ID ";
$query.="WHERE mi.Drawing_ID='$drawingid' AND ic.Incomming_ID='$incommingid';";
//print($query);
$resa = mysql_query($query, $cxn) or die(mysql_error($cxn));
while ($row = mysql_fetch_assoc($resa))
{
print("$row[Drawing_NO], $row[Ex_Challan_NO]-$row[Ex_Challan_Date], $row[GP_NO] - $row[GP_Date], $row[DA_NO] - $row[DA_Date], $row[Qty]");
}

?>