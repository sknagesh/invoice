<?php
include('dewdb.inc');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());
$drawinno=$_POST['dno'];
$drawinname=$_POST['dname'];
$drawingid=$_POST['Drawing_ID'];
//print_r($_POST);
$query="UPDATE Components SET Drawing_NO='$drawinno', Component_Name='$drawinname' WHERE Drawing_ID='$drawingid';";
//print($query);


$resa = mysql_query($query, $cxn) or die(mysql_error($cxn));

$result=mysql_affected_rows();
if($result==1)
{
print("<br>Drawing $drawinno Updated");	
}


?>