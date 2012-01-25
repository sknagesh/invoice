<?php
include('dewdb.inc');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());
$drawingid=$_GET['drawingid'];
$custid=$_GET['custid'];
//print_r($_GET);
$query="SELECT Ex_Challan_NO, Incomming_ID,Ex_Challan_Date,Qty,Outward_Qty,Material_Desc FROM Incomming_Challans as ic "; 
$query.="INNER JOIN Material_Incomming AS mi ON mi.Challan_ID=ic.Incomming_ID ";
$query.="WHERE mi.Drawing_ID='$drawingid' AND mi.Outward_Qty!=0;";
//print($query);
print("<td><label for=\"drwqty\">Challan Detals</label></td>");
print("<td><select name=\"Challan_ID\" id=\"Challan_ID\" class=\"required\">");
echo '<option value="">Select Challan</option>';
$resa = mysql_query($query, $cxn) or die(mysql_error($cxn));
$grn="";
while ($row = mysql_fetch_assoc($resa))
{
	if($custid==23){$grn="GRN:$row[Material_Desc]";}
echo "<option value=".$row['Incomming_ID'].">";
echo "CNo:$row[Ex_Challan_NO]-Dated: $row[Ex_Challan_Date] $grn Qty: $row[Qty]/$row[Outward_Qty]</option>";
}
print("</select></td>");
print("<td><label for=\"drwqty\">Enter Quantity</label></td>");
print("<td><input id=\"qty\" name=\"qty\"  class=\"required number\" size=\"10\" value=\"\" /></td>");
print("<td><label for=\"remarks\">Remarks </label></td>");
print("<td><input id=\"remarks\" name=\"remarks\"  value=\"\" /></td>");

?>