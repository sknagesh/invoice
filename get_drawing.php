<?php
include('dewdb.inc');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());
$custid=$_GET['custid'];
//print_r($_POST);
$query="SELECT * FROM Components WHERE Customer_ID='$custid';";
//print($query);
print("<select name=\"Drawing_ID\" id=\"Drawing_ID\" >");
$resa = mysql_query($query, $cxn) or die(mysql_error($cxn));
while ($row = mysql_fetch_assoc($resa))
{
echo "<option value=".$row['Drawing_ID'].">";
echo "$row[Component_Name]</option>";
}
print("</select></td></tr>");



?>