<?php
include('dewdb.inc');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());
//print_r($_POST);

$custname=$_POST['name'];
$addl1=$_POST['addl1'];
if(isSet($_POST['addl2'])){$addl2=$_POST['addl2'];}else {$addl2="";}
if(isSet($_POST['phone'])){$phone=$_POST['phone'];}else{$phone="";}
$tinno=$_POST['tinno'];
$panno=$_POST['panno'];
if(isSet($_POST['excise'])){$excise=$_POST['excise'];}else{$excise="";}

$query="INSERT INTO Customer (Customer_Name,Address_L1,Address_L2,Phone_No,TIN_NO,Excise_NO,PAN_NO) ";
$query.="VALUES('$custname','$addl1','$addl2','$phone','$tinno','$excise','$panno');";

//print($query);

$res=mysql_query($query) or die(mysql_error());

$result=mysql_affected_rows();
if($result!=0)
{
print("Added new Customer $custname");	
	
}else
	{
		print("Error Adding");
	}


?>