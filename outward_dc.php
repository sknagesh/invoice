<?php
include('dewdb.inc');
require('fpdf.php');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());
//print_r($_POST);
$custid=$_POST['Customer_ID'];
$noofcomp=$_POST['noofcomp'];
$data=$_POST['data'];
$dcno=$_POST['dcno'];
$dcdate=$_POST['dcdate'];
$db_dcdate=change_date_format_for_db($dcdate);
if(isSet($_POST['yref'])){$yerf=$_POST['yref'];}else{$yref="";}
if(isSet($_POST['ydate'])){$yerf=$_POST['ydate'];}else{$ydate="";}
if(isSet($_POST['dmode'])){$dmode=$_POST['dmode'];}else{$dmode="";}
if(isSet($_POST['status'])){$status=$_POST['status'];}else{$status="";}
$pview=$_POST['pview'];

$datasplit=explode(",",$data);
$j=0;
$k=1;
while($j<$noofcomp)
{
$Drawing_NO[$j]=$datasplit[$k];
$k++;
$Ex_Challan_NO[$j]=$datasplit[$k];
$k++;
$Ex_Challan_Date[$j]=$datasplit[$k];
$k++;
$GP_NO[$j]=$datasplit[$k];
$k++;
$GP_Date[$j]=$datasplit[$k];
$k++;
$DA_NO[$j]=$datasplit[$k];
$k++;
$DA_Date[$j]=$datasplit[$k];
$k++;
$Qty[$j]=$datasplit[$k];
$k++;
$drawingname[$j]=$datasplit[$k];
$k++;
$drawingid[$j]=$datasplit[$k];
$k++;
$dispatchqty[$j]=$datasplit[$k];
$k++;
$challanid[$j]=$datasplit[$k];
$k++;
$j++;
}
class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('logo.jpg',0,0,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(60,0,'Divya Engineering Works (P) Ltd',0,0,'C');
	// Line break
    $this->Ln(10);
	$this->SetFont('Arial','B',10);
	$this->Cell(220,0,'Plot No 31, Hotagalli Ind Area, Mysore-570018',0,0,'C');
	$this->Ln(6);
	$this->Cell(220,0,'Ph: 0821 2402941, Fax 0821 2402754, email: divyaeng@divyaengineering.com',0,0,'C');
	$this->Ln(10);
	$this->line(0,30,220,30);
	$this->Ln(0);
	$this->line(0,40,220,40);
	$this->Cell(105,0,'Delivery Challan',0,'0','R');
	$this->Cell(85,0,'TIN 29570120027',0,'0','R');
	$this->Ln(10);
}
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(200,6,'Commissionerate: Mysore. Division II,S1 & S2,Vinaya Marg, Siddhartha Nagar, Mysore -11 ',0,1,'C');
	$this->Cell(200,6,'Range: Mysore West, Vinaya Marg, Siddartha Nagar, Mysore - 11',0,0,'C');
}
}
$q="SELECT * FROM Customer WHERE Customer_ID='$custid';";
$res=mysql_query($q,$cxn) or die(mysql_error());
while($row=mysql_fetch_array($res))
{
	
	$custname=$row['Customer_Name'];
	$addl1=$row["Address_L1"];
	$addl2=$row["Address_L2"];
	$phone=$row["Phone_No"];
	$tinno=$row['TIN_NO'];
	$exciseno=$row['Excise_No'];
	$panno=$row['PAN_NO'];
}

$pdf = new PDF();
//$pdf->AliasNbPages();
$pdf->setAutoPageBreak(10);
$pdf->AddPage();
$pdf->SetFont('Arial');

$pdf->Cell(150,8,$custname,0,0,'L');$pdf->Cell(100,8,"DC NO: $dcno",0,1,'L');
$pdf->Cell(150,8,$addl1,0,0,'L');$pdf->Cell(100,8,"Date: $dcdate",0,1,'L');
$pdf->Cell(150,8,$addl2,0,0,'L');$pdf->Cell(100,8,"Your Ref: ",0,1,'L');
$pdf->Cell(150,8,$phone,0,0,'L');$pdf->Cell(100,8,"Date: ",0,1,'L');
$pdf->Cell(150,8,"TIN NO: $tinno",0,1,'L');
$pdf->line(0,87,220,87);//line before mode of dispatch
$pdf->Cell(150,8,"Mode Of Dispatch: $dmode",0,0,'L');$pdf->Cell(100,8,"Status: $status",0,1,'L');
$pdf->line(0,94,220,94);//line after mode of dispatch
$pdf->line(150,40,150,87);//vertical line b/w address and dc no
$pdf->line(150,62,220,62);//horizontal line b/w dc no and cust ref
$pdf->Cell(20,8,"SL NO",0,0,'L');$pdf->Cell(80,8,"Description",0,0,'L');
$pdf->Cell(50,8,"Challan Details",0,0,'L');
$pdf->Cell(20,8,"Qty",0,0,'L');$pdf->Cell(50,8,"Remarks",0,0,'L');


$j=0;
$l=$k;
while($j<$noofcomp)
{
$pdf->ln(8);
$pdf->Cell(20,8,$j+1,0,0,'C');
$pdf->Cell(80,8,"$drawingname[$j] - $Drawing_NO[$j]",0,0,'L');
$pdf->Cell(50,8,"$Ex_Challan_NO[$j] - $Ex_Challan_Date[$j]",0,0,'L');
$pdf->Cell(30,8,$dispatchqty[$j],0,0,'L');


$j++;
}

/*
$pdf->Cell(50,20,"excno=$Ex_Challan_NO[$j]",1,1,'C');
$pdf->Cell(50,20,"exdate=$Ex_Challan_Date[$j]",1,1,'C');
$pdf->Cell(50,20,"gpno=$GP_NO[$j]",1,1,'C');
$pdf->Cell(50,20,"gpdate=$GP_Date[$j]",1,1,'C');
$pdf->Cell(50,20,"dano=$DA_NO[$j]",1,1,'C');
$pdf->Cell(50,20,"dadate=$DA_Date[$j]",1,1,'C');
$pdf->Cell(50,20,"chqty=$Qty[$j]",1,1,'C');
$pdf->Cell(50,20,"drawing id=$drawingid[$j]",1,1,'C');

$pdf->Cell(50,20,"incomming id=$incommingid[$j]",1,1,'C');
*/

$pdf->line(0,250,220,250);//horizontal line b/w dc no and cust ref
$pdf->setX(0);$pdf->setY(250);
$pdf->Cell(90,8,"Received the above materials in good condition",0,0,'L');
$pdf->Cell(100,8,"For Divya Engineering Works (P) Ltd",0,1,'R');

$pdf->setX(0);$pdf->setY(265);
$pdf->Cell(90,8,"Receive's Signature",0,0,'L');
$pdf->Cell(100,8,"Authorised Signatory",0,1,'R');


if($pview==0)
{
	$j=0;
	while($j<$noofcomp)
		{
			$q="SELECT Outward_Qty FROM Material_Incomming WHERE Challan_Id='$challanid[$j]' AND Drawing_ID='$drawingid[$j]';";

			$r=mysql_query($q,$cxn) or die(mysql_error());
			while($row=mysql_fetch_array($r))
			{
				$outwardqty=$row['Outward_Qty'];
			}
			$nq=$outwardqty-$dispatchqty[$j];
			if($nq<0){$nq=0;}
			$qry="UPDATE Material_Incomming SET Outward_Qty=$nq WHERE Challan_ID='$challanid[$j]' AND Drawing_ID='$drawingid[$j]';";
			$rr=mysql_query($qry,$cxn) or die(mysql_error());
			if(($updated=mysql_affected_rows())==0)
			{print("error updating");
			break;}
			$odcquery="INSERT INTO Outward_DC (Challan_ID,Drawing_ID,Outward_Qty,DC_NO,DC_Date) ";
			$odcquery.="VALUES('$challanid[$j]','$drawingid[$j]','$dispatchqty[$j]','$dcno','$db_dcdate');";
			$odcres=mysql_query($odcquery,$cxn) or die(mysql_error());
			if(($odcupdated=mysql_affected_rows())==0)
			{print("error updating outward dc");
			break;}
			$j++;
		}
$name="$dcno".".pdf";
		$pdf->Output($name,'D');

}
else{
$pdf->Output('temp.pdf','F');	
}



?>