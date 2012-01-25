<?php
include('dewdb.inc');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());

$query="SELECT comp.Drawing_NO,ic.Ex_Challan_NO,ic.Customer_ID,comp.Drawing_ID,Customer_Name, ic.Ex_Challan_Date,DATEDIFF(CURDATE(),Ex_Challan_Date) as age FROM Incomming_Challans as ic "; 
$query.="INNER JOIN Material_Incomming AS mi ON mi.Challan_ID=ic.Incomming_ID ";
$query.="INNER JOIN Components AS comp ON comp.Drawing_ID=mi.Drawing_ID ";
$query.="INNER JOIN Customer AS cust ON cust.Customer_ID=ic.Customer_ID ";
$query.="WHERE mi.Outward_Qty!=0 ORDER BY ic.Ex_Challan_Date;";

print("<h2>Currently Open Challans</h2>");
$res=mysql_query($query,$cxn) or die(mysql_error());
print('<table border="1px"><tr><th>Customer</th><th>Challan No</th><th>Challan Date</th><th>Age</th>');
while($row=mysql_fetch_assoc($res))
{
	print("<tr><td>$row[Customer_Name]</td><td>$row[Ex_Challan_NO]</td><td>$row[Ex_Challan_Date]</td><td>$row[age]</td>");
}
print('</table>');



?>