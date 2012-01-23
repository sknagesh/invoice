<?php
include('dewdb.inc');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());
//print_r($_GET);
$custid=$_GET['custid'];
$query="SELECT * FROM Customer WHERE Customer_ID='$custid';"; 
$resa = mysql_query($query, $cxn) or die(mysql_error($cxn));
while ($row = mysql_fetch_assoc($resa))
{
	$cdetail[0]=$row['Customer_Name'];	
	$cdetail[1]=$row['Address_L1'];
	$cdetail[2]=$row['Address_L2'];
	$cdetail[3]=$row['Phone_No'];
	$cdetail[4]=$row['TIN_NO'];
	$cdetail[5]=$row['PAN_NO'];
}

$data=$cdetail[0].'<|>'.$cdetail[1].'<|>'.$cdetail[2].'<|>'.$cdetail[3].'<|>'.$cdetail[4].'<|>'.$cdetail[5];
print($data);

?>