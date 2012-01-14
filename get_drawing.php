<?php
include('dewdb.inc');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());
$custid=$_GET['custid'];
$noofcomp=$_GET['noofcomp'];
//print_r($_POST);
$query="SELECT * FROM Components WHERE Customer_ID='$custid';";
//print($query);
print("<select name=\"Drawing_ID$noofcomp\" id=\"Drawing_ID$noofcomp\" class=\"required\" style=\"width:100px\">");
echo '<option value="">Select Drawing</option>';
$resa = mysql_query($query, $cxn) or die(mysql_error($cxn));
while ($row = mysql_fetch_assoc($resa))
{
echo "<option value=".$row['Drawing_ID'].">";
echo "$row[Component_Name]</option>";
}
print("</select>");
print("<input id=\"qty$noofcomp\" name=\"qty$noofcomp\"  class=\"required decimal\" value=\"\" />");
print("<input id=\"mdesc$noofcomp\" name=\"mdesc$noofcomp\"  value=\"\" />");
print("<div id=\"dwgqty$noofcomp\" class=\"drawingqty\"></div>");



?>