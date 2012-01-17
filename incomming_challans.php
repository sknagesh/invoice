<?php
include('dewdb.inc');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());
//print_r($_POST);

$custid=$_POST['Customer_ID'];
$excno=$_POST['excno'];
$excdate=change_date_format_for_db($_POST['excdate']);
$gpcno=$_POST['gpno'];
$gpcdate=change_date_format_for_db($_POST['gpdate']);
if(isSet($_POST['dano'])){$dano=$_POST['dano'];}else {$dano="";}
if(isSet($_POST['dadate'])){$dadate=change_date_format_for_db($_POST['dadate']);}else{$dadate="";}
$noofcomp=$_POST['noofcomp'];
$i=0; 
while($i<=$noofcomp)
{
	$Drawing_ID[$i]=$_POST['Drawing_ID'.$i];
	$Qty[$i]=$_POST['qty'.$i];
	if(isSet($_POST['mdesc'.$i])){$mdesc[$i]=$_POST['mdesc'.$i];}else{$mdesc[$i]="";}
$i++;	
}

$query="INSERT INTO Incomming_Challans (Customer_ID,Ex_Challan_NO,Ex_Challan_Date,GP_NO,GP_Date,DA_NO,DA_Date,Open) ";
$query.="VALUES('$custid','$excno','$excdate','$gpcno','$gpcdate','$dano','$dadate','1');";

//print($query);

$res=mysql_query($query) or die(mysql_error());

$result=mysql_affected_rows();
if($result!=0)
{
	$challanid=mysql_insert_id();
print("<br>Record ID=$challanid");	
	
}else
	{
		print("<br>Error Adding New Data");
	}



$i=0;
while($i<=$noofcomp)
{
$q="INSERT INTO Material_Incomming (Challan_ID,Drawing_ID,Qty,Outward_Qty,Material_Desc) ";
$q.="VALUES('$challanid','$Drawing_ID[$i]','$Qty[$i]','$Qty[$i]','$mdesc[$i]');";
//	print("<br>$q");
$r=mysql_query($q) or die(mysql_error());

$res=mysql_affected_rows();
if($res!=0)
{
	$materialid=mysql_insert_id();
print("<br>Material Insertion ID=$materialid");	
}else{print("<br>error inserting Material");}
$i++;

}

?>