<?php
include('dewdb.inc');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());
$drawingid=$_GET['drawingid'];
//print_r($_GET);
$query="SELECT Ex_Challan_NO, Incomming_ID,Ex_Challan_Date,Qty FROM Incomming_Challans as ic "; 
$query.="INNER JOIN Material_Incomming AS mi ON mi.Challan_ID=ic.Incomming_ID ";
$query.="WHERE mi.Drawing_ID='$drawingid';";
//print($query);
print("<p><label for=\"drwqty\">Select Excise Challan Detals</label>");
print("<select name=\"Challan_ID\" id=\"Challan_ID\" class=\"required\">");
echo '<option value="">Select Challan</option>';
$resa = mysql_query($query, $cxn) or die(mysql_error($cxn));
while ($row = mysql_fetch_assoc($resa))
{
echo "<option value=".$row['Incomming_ID'].">";
echo "Ex Challan:$row[Ex_Challan_NO]-Dated: $row[Ex_Challan_Date] Qty: $row[Qty]</option>";
}
print("</select></p>");
print("<p><label for=\"drwqty\">Enter Quantity</label>");
print("<input id=\"qty\" name=\"qty\"  class=\"required number\" value=\"\" /></p>");

?>