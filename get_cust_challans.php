<?php
include('dewdb.inc');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());
$custid=$_GET['custid'];
$cid=$_GET['cid'];

//print_r($_GET);

$query="SELECT Ex_Challan_No,Ex_Challan_Date,Drawing_NO,Component_Name,odc.DC_NO,odc.DC_Date,Remarks,odc.Outward_Qty,Qty FROM Outward_DC as odc ";
$query.="INNER JOIN Components AS comp ON odc.Drawing_ID=comp.Drawing_ID ";
$query.="INNER JOIN Material_Incomming as mi ON mi.MI_ID=odc.MI_ID ";
$query.="INNER JOIN Incomming_Challans as ic ON ic.Incomming_ID=mi.Challan_ID ";
$query.="WHERE odc.Customer_ID='$custid' AND mi.Challan_ID='$cid' ORDER BY odc.DC_Date;";

print($query);

$res=mysql_query($query,$cxn) or die(mysql_error());
print('<table border="1px"><tr><th>Challan No</th><th>Challan Date</th><th>Drawing No</th><th>Component</th><th>DC No</th><th>DC Date</th>');
print('<th>Challan Qty</th><th>Disp. Qty</th><th>Remarks</th></tr>');
while($row=mysql_fetch_assoc($res))
{
	print("<tr><td>$row[Ex_Challan_No]</td><td>$row[Ex_Challan_Date]</td><td>$row[Drawing_NO]</td><td>$row[Component_Name]</td><td>$row[DC_NO]</td><td>$row[DC_Date]</td>");
	print("<td>$row[Qty]</td><td>$row[Outward_Qty]</td><td>$row[Remarks]</td></tr>");
}
print('</table>');

?>