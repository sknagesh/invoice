<?php
include('dewdb.inc');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());
$custid=$_GET['custid'];
$cid=$_GET['cid'];

//print_r($_GET);
$query="SELECT comp.Drawing_NO,ic.Ex_Challan_NO,odc.Customer_ID,comp.Drawing_ID, odc.Challan_ID, odc.Outward_Qty, DC_NO,DC_Date, Remarks,mi.Qty FROM Outward_DC as odc "; 
$query.="INNER JOIN Incomming_Challans AS ic ON ic.Incomming_ID=odc.Challan_ID ";
$query.="LEFT JOIN Material_Incomming AS mi ON mi.Drawing_ID=odc.Drawing_ID ";
$query.="INNER JOIN Components AS comp ON comp.Drawing_ID=odc.Drawing_ID ";
$query.="WHERE odc.Customer_ID='$custid' AND odc.Challan_ID='$cid' ORDER BY odc.DC_Date;";
//print($query);

$res=mysql_query($query,$cxn) or die(mysql_error());
print('<table border="1px"><tr><th>Challan No</th><th>DC No</th><th>DC Date</th><th>Drawing No</th>');
print('<th>Incomming Qty</th><th>Disp. Qty</th><th>Remarks</th></tr>');
while($row=mysql_fetch_assoc($res))
{
	print("<tr><td>$row[Ex_Challan_NO]</td><td>$row[DC_NO]</td><td>$row[DC_Date]</td><td>$row[Drawing_NO]</td>");
	print("<td>$row[Qty]</td><td>$row[Outward_Qty]</td><td>$row[Remarks]</td></tr>");
}
print('</table>');

?>