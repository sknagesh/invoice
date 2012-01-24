<?php
include('dewdb.inc');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());
$custid=$_GET['custid'];

$query="SELECT * FROM Incomming_Challans WHERE Customer_ID='$custid';";
//print($query);
print("<td><label for=\"drwqty\">Challan Detals</label>");
print("<select name=\"Challan_ID\" id=\"Challan_ID\" class=\"required\">");
echo '<option value="">Select Challan</option>';
$resa = mysql_query($query, $cxn) or die(mysql_error($cxn));
while ($row = mysql_fetch_assoc($resa))
{
echo "<option value=".$row['Incomming_ID'].">";
echo "Ex Challan:$row[Ex_Challan_NO]-Dated: $row[Ex_Challan_Date]</option>";
}
print("</select></td>");

?>