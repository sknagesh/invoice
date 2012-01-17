<?php
include('dewdb.inc');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());
//print_r($_GET);
$drawingid=$_GET['drawingid'];
$incommingid=$_GET['incommingid'];
$qty=$_GET['qty'];


$q="SELECT * FROM Outward_DC WHERE Incomming_ID='$incommingid';";
$r = mysql_query($q, $cxn) or die(mysql_error($cxn));
$n=mysql_affected_rows();
if($n==0)
{
$query="SELECT Ex_Challan_NO, Ex_Challan_Date,GP_NO,GP_Date,DA_NO,DA_Date,Drawing_NO,Qty FROM Incomming_Challans as ic "; 
$query.="INNER JOIN Material_Incomming AS mi ON mi.Challan_ID=ic.Incomming_ID ";
$query.="INNER JOIN Components as comp ON comp.Drawing_ID=mi.Drawing_ID ";
$query.="WHERE mi.Drawing_ID='$drawingid' AND ic.Incomming_ID='$incommingid';";
//print($query);
$resa = mysql_query($query, $cxn) or die(mysql_error($cxn));
while ($row = mysql_fetch_assoc($resa))
{
$data[0]=$row['Drawing_NO'];
$data[1]=$row['Ex_Challan_NO'];
$data[2]=$row['Ex_Challan_Date'];
$data[3]=$row['GP_NO'];
$data[4]=$row['GP_Date'];
$data[5]=$row['DA_NO'];
$data[6]=$row['DA_Date'];
$data[7]=$row['Qty'];
}
$data[8]=$drawingid;
$data[9]=$qty;
$data[10]=$incommingid;
$str=$data[0]."<|>".$data[1]."<|>".$data[2]."<|>".$data[3]."<|>".$data[4]."<|>".$data[5]."<|>".$data[6]."<|>".$data[7];
$str.="<|>".$data[8]."<|>".$data[9]."<|>".$data[10];
print($str);	
	
}

else {
	
$query="SELECT Ex_Challan_NO, Ex_Challan_Date,GP_NO,GP_Date,DA_NO,DA_Date,Drawing_NO,Qty FROM Incomming_Challans as ic "; 
$query.="INNER JOIN Material_Incomming AS mi ON mi.Challan_ID=ic.Incomming_ID ";
$query.="INNER JOIN Components as comp ON comp.Drawing_ID=mi.Drawing_ID ";
$query.="WHERE mi.Drawing_ID='$drawingid' AND ic.Incomming_ID='$incommingid';";
//print($query);
$resa = mysql_query($query, $cxn) or die(mysql_error($cxn));
while ($row = mysql_fetch_assoc($resa))
{
	
	
}


}


//return $str;
?>