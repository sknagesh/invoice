<?php
include('dewdb.inc');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());
//print_r($_POST);
$query="SELECT * FROM Customer;";

print("<select name=\"Customer_ID\" id=\"Customer_ID\" >");
$resa = mysql_query($query, $cxn) or die(mysql_error($cxn));
while ($row = mysql_fetch_assoc($resa))
{
echo "<option value=".$row['Customer_ID'].">";
echo "$row[Customer_Name]</option>";
}
print("</select></td></tr>");



?>