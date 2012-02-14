<?php
include('dewdb.inc');
require('fpdf.php');
$cxn = mysql_connect($dewhost,$dewname,$dewpswd) or die(mysql_error());
mysql_select_db('Invoice',$cxn) or die("error opening db: ".mysql_error());
//print_r($_POST);
if(isSet($_POST['Customer_ID'])){$custid=$_POST['Customer_ID'];}else{$custid="";}
$noofcomp=$_POST['noofcomp'];
if(isSet($_POST['data'])){$data=$_POST['data'];}else{$data="";}//from outward_dc.html
if(isSet($_POST['item'])){$item=$_POST['item'];}else{$item="";}//from outward_dc_misc.html
$dcno=$_POST['dcno'];
$dcdate=$_POST['dcdate'];
$cremark=$_POST['cremark'];
$dbcremarks=addslashes($cremark);
$db_dcdate=change_date_format_for_db($dcdate);
if(isSet($_POST['yref'])){$yref=$_POST['yref'];}else{$yref="";}
if(isSet($_POST['ydate'])){$ydate=$_POST['ydate'];}else{$ydate="";}
if(isSet($_POST['dmode'])){$dmode=$_POST['dmode'];}else{$dmode="";}
if(isSet($_POST['status'])){$status=$_POST['status'];}else{$status="";}

if(isSet($_POST['name'])){$custname=$_POST['name'];}//these fields are for miscllaneous dc
if(isSet($_POST['addl1'])){$addl1=$_POST['addl1'];}
if(isSet($_POST['addl2'])){$addl2=$_POST['addl2'];}
if(isSet($_POST['phone'])){$phone=$_POST['phone'];}else{$phone="";}
if(isSet($_POST['tinno'])){$tinno=$_POST['addl1'];}else{$tinno="";}
if(isSet($_POST['exciseno'])){$exciseno=$_POST['exciseno'];}else{$exciseno="";}
if(isSet($_POST['panno'])){$panno=$_POST['panno'];}else{$panno="";}
$pview=$_POST['pview'];




if($data!="")
{
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
		$drawingname[$j]=urldecode($datasplit[$k]);
		$k++;
		$miid[$j]=$datasplit[$k];
		$k++;
		$drawingid[$j]=$datasplit[$k];
		$k++;
		$dispatchqty[$j]=$datasplit[$k];
		$k++;
		$challanid[$j]=$datasplit[$k];
		$k++;
		$remarks[$j]=$datasplit[$k];
		$dbremarks[$j]=addslashes($remarks[$j]);
		$k++;
		$j++;
	}
	
}else if($item!="")
{
	$datasplit=explode(",",$item);
	$j=0;
	$k=0;
	while($j<=$noofcomp)
	{
		$drawingname[$j]=urldecode($datasplit[$k]);
		$k++;
		$dispatchqty[$j]=$datasplit[$k];
		$k++;
		$remarks[$j]=$datasplit[$k];
		$dbremarks[$j]=addslashes($remarks[$j]);
		$k++;
		$Ex_Challan_NO[$j]="";
		
		$Ex_Challan_Date[$j]="";
		
		$GP_NO[$j]="";
		
		$GP_Date[$j]="";
		
		$DA_NO[$j]="";
		
		$DA_Date[$j]="";
		
		$Qty[$j]="";
		
		$Drawing_NO[$j]="";
		
		$miid[$j]="";		
		
		$drawingid[$j]="";
		
		$challanid[$j]="";
		
		$j++;
	}
	
}
	


class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->SetY(10);
    $this->Image('logo.png',8,10,30);
    // Arial bold 15
    $this->SetFont('Arial','',22);
    // Move to the right
    $this->Ln(10);
    $this->Cell(80);
    // Title
    $this->Cell(60,0,'Divya Engineering Works (P) Ltd',0,0,'C');
	// Line break
    $this->Ln(10);
	$this->SetFont('Arial','',11);
	$this->Cell(220,0,'Plot No 31, Hootagalli Industrial Area, Mysore-570018',0,0,'C');
	$this->Ln(6);
	$this->Cell(220,0,'Ph: 0821 2402941, Fax 0821 2402754, email: divyaeng@divyaengineering.com',0,0,'C');
	$this->Ln(6);
	$this->SetFont('Courier','B',11);
	$this->Cell(220,0,'Certified For ISO:9001',0,0,'C');
	$this->Ln(10);
	$this->line(0,45,220,45);
	$this->Ln(0);
	$this->line(0,55,220,55);
	$this->SetFont('Arial','',16);
	$this->Cell(105,0,'Delivery Challan',0,'0','R');
	$this->Ln(4);
}
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-35);
    // Arial italic 8
    $this->SetFont('Arial','B',8);
    // Page number
    $this->Cell(200,6,'Commissionerate: Mysore. Division II,S1 & S2,Vinaya Marg, Siddhartha Nagar, Mysore -11 ',0,1,'L');
	$this->Cell(100,6,'Range: Mysore West, Vinaya Marg, Siddartha Nagar, Mysore - 11   C.E.Reg No AAACD6353QXM001   Ser.Tax.Reg. AAACD6353QST002',0,1,'L');
    $this->SetFont('Arial','B',11);
	$this->Cell(50,6,'TIN: 29570120027',0,'0','L');
	$this->Cell(70,6,'CST: 21261027 Dt. 11-9-1992',0,'0','L');	
	$this->Cell(50,6,'PAN: AAACD6353Q',0,'0','L');
}
}


if($custid!='')
{
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
}


$pdf = new PDF();
//$pdf->AliasNbPages();
$pdf->setAutoPageBreak(10);
$pdf->AddPage();
$pdf->SetFont('Arial','B',13);
$pdf->Cell(125,8,$custname,0,0,'L');
$pdf->SetFont('Arial','B',14);
$pdf->Cell(100,8,"DC NO: $dcno",0,1,'L');
$pdf->SetFont('Arial','',13);
$pdf->Cell(125,8,$addl1,0,0,'L');$pdf->Cell(100,8,"Date: $dcdate",0,1,'L');
$pdf->Cell(125,8,$addl2,0,0,'L');$pdf->Cell(100,8,"Your Ref: $yref",0,1,'L');
$pdf->Cell(125,8,$phone,0,0,'L');$pdf->Cell(100,8,"Date: $ydate",0,1,'L');
$pdf->ln(8);
$pdf->line(0,97,220,97);//line before mode of dispatch
$pdf->Cell(135,8,"Mode Of Dispatch: $dmode",0,0,'L');$pdf->Cell(100,8,"Status: $status",0,1,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(150,8,"Please receive the following materials and acknowledge the receipt",0,1,'L');
$pdf->line(0,110,220,110);//line after mode of dispatch
$pdf->line(135,55,135,97);//vertical line b/w address and dc no
$pdf->line(135,72,220,72);//horizontal line b/w dc no and cust ref
$pdf->SetFont('Arial','B',11);
$pdf->Cell(20,8,"SL NO",0,0,'L');$pdf->Cell(80,8,"Description",0,0,'L');
$pdf->Cell(20,8,"Qty",0,0,'L');$pdf->Cell(50,8,"Remarks",0,0,'L');
$pdf->line(0,120,220,120);//line after slno, desc and remarks
$pdf->ln(6);
//loop to display componet details
$pdf->SetFont('Arial','',11); //body font
$j=0;
if($data==''){$noofcomp+=1;}
while($j<$noofcomp)
{
$pdf->ln(8);
$pdf->Cell(20,8,$j+1,0,0,'C');
$pdf->Cell(80,8,"$drawingname[$j]  $Drawing_NO[$j]",0,0,'L');
$pdf->Cell(20,8,"$dispatchqty[$j]",0,0,'L');
$pdf->Cell(50,8,"$remarks[$j]",0,0,'L');
$j++;
}


//loop to display challan details
if($data!='')
{
	if($custid=='24')
	{

	$j=0;
	$l=$k;
	$pdf->setX(2);$pdf->setY(175); //set x and y position
	$pdf->Cell(20,8,"SL NO",0,0,'L');
	$pdf->Cell(32,8,"Ex Challan No",0,0,'L');$pdf->Cell(28,8,"Date",0,0,'L');
	$pdf->Cell(32,8,"Gate Pass No",0,0,'L');$pdf->Cell(28,8,"Date",0,0,'L');
	$pdf->Cell(36,8,"Delivery Advice No",0,0,'L');$pdf->Cell(28,8,"Date",0,0,'L');
	while($j<$noofcomp)
		{
		$pdf->ln(8);
		$pdf->Cell(20,8,$j+1,0,0,'C');
		$pdf->Cell(32,8,"$Ex_Challan_NO[$j]",0,0,'L');
		$dedate=change_date_format_for_dispaly($Ex_Challan_Date[$j]);
		$pdf->Cell(28,8,$dedate,0,0,'L');
		$pdf->Cell(32,8,"$GP_NO[$j]",0,0,'L');
		$dgdate=change_date_format_for_dispaly($GP_Date[$j]);
		$pdf->Cell(28,8,$dgdate,0,0,'L');
		$pdf->Cell(36,8,"$DA_NO[$j]",0,0,'L');
		$dadate=change_date_format_for_dispaly($DA_Date[$j]);
		$pdf->Cell(28,8,$dadate,0,0,'L');
		$j++;

		}

	
	}



	else if($custid=='23'){
		//do nothing as we dont want to repeate dc no here also
		}
	
	else {
	$j=0;
	$l=$k;
	$pdf->setX(10);$pdf->setY(175); //set x and y position
	$pdf->Cell(200,8,"Challan Details",0,0,'L');
	while($j<$noofcomp)
	{
		$pdf->ln(8);
		$pdf->Cell(20,8,$j+1,0,0,'C');
		$ddate=change_date_format_for_dispaly($Ex_Challan_Date[$j]);
		$pdf->Cell(50,8,"Excise Challan No: $Ex_Challan_NO[$j] Dated: $ddate",0,0,'L');
		$j++;
	}

	}


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
	if($custid=='24')
	{
$pdf->setX(20);$pdf->setY(218);
$pdf->SetFont('Arial','',12);
$pdf->Cell(200,8,"Vendor Code: 1247",0,0,'L');
	}

$pdf->setX(20);$pdf->setY(225);
$pdf->SetFont('Arial','',14);
$pdf->Cell(140,8,"TIN NO: $tinno",0,1,'L');
$pdf->Cell(200,8,"$cremark",0,0,'L');

$pdf->line(0,240,220,240);//horizontal line b/w dc no and cust ref
$pdf->setX(0);$pdf->setY(240);
$pdf->SetFont('Arial','',11);
$pdf->Cell(90,8,"Received the above materials in good condition",0,0,'L');
$pdf->Cell(100,8,"For Divya Engineering Works (P) Ltd",0,1,'R');

$pdf->setX(0);$pdf->setY(255);
$pdf->Cell(90,8,"Receiver's Signature",0,0,'L');
$pdf->Cell(100,8,"Authorised Signatory",0,1,'R');


if($pview==0)
{

	if($data!="")//if we are not dealing with miscc. dc then
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
			$odcquery="INSERT INTO Outward_DC (Customer_ID,MI_ID,Drawing_ID,Outward_Qty,DC_NO,DC_Date,Remarks,YRef,YDate,CStatus,DMode) ";
			$odcquery.="VALUES('$custid','$miid[$j]','$drawingid[$j]','$dispatchqty[$j]','$dcno','$db_dcdate','$dbremarks[$j]','$yref','$ydate','$status','$dmode');";
			$odcres=mysql_query($odcquery,$cxn) or die(mysql_error());
			if(($odcupdated=mysql_affected_rows())==0)
			{print("error updating outward dc");
			break;}
			$j++;
		}
	}else //we are dealing with misc dc
	
	{
		$j=0;
		while($j<$noofcomp)
			{
				$odcquery="INSERT INTO Outward_DC (Customer_ID,MI_ID,Drawing_ID,Outward_Qty,DC_NO,DC_Date,Remarks,YRef,YDate,CStatus,DMode) ";
				$odcquery.="VALUES('$custid','$miid[$j]','$drawingid[$j]','$dispatchqty[$j]','$dcno','$db_dcdate','$dbremarks[$j]','$yref','$ydate','$status','$dmode');";
				$odcres=mysql_query($odcquery,$cxn) or die(mysql_error());
				if(($odcupdated=mysql_affected_rows())==0)
				{print("error updating outward dc");
				break;}
				$j++;
			}
	}		
		
		$name="$dcno".".pdf";
		$pdf->Output($name,'D');

}
else{
$pdf->Output('temp.pdf','F');	
}



?>