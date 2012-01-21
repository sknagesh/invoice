$(document).ready(function(){
  	$("#customer").load('get_customer.php');

    $("#deliverychallen").validate();

$('#added').hide();
$('#cdate').validate({
        rules :{
            cdate : {
                required: true,
                indianDate: true
                
                         }
             },
    });
$('#submit').attr("disabled",true);
$('#preview').attr("disabled",true);
	/*$("#submit").click(function(event) {

		 if($("#deliverychallen").valid())
		  	{
		  		event.preventDefault();
				$.ajax({
      					data: $('#deliverychallen').serializeArray(),
      					type: "POST",
      					url: "outward_dc.php",
      					success: function(html) {
						document.getElementById("footer").innerHTML=html;
						$('#deliverychallen')[0].reset();
						$('#added').hide();
      							}
    								});
 	
		  	}
						$('#deliverychallen')[0].reset();
						$('#added').hide();
		  	

	});*/
	
	
var noofcomp=0;
var data=new Array();
$('#customer').click(function(){
noofcomp=0;
	var custid=$('#Customer_ID').val();
var url='get_drawing_dc.php?custid='+custid+'&noofcomp='+noofcomp;
  		$("#Drawing_ID").load(url)
$('#noofcomp').val(noofcomp);
  		noofcomp++;
  		});


$('#add').click(function(){
	var drawingid=$('#Drawing').val();
	var incommingid=$('#Challan_ID').val();
	var qty=$('#qty').val();
	var Max_Qty=0;
	console.log("entered addclick "+Max_Qty,qty);
	var url='get_challan_qty.php?drawingid='+drawingid+'&incommingid='+incommingid+'&qty='+qty;
	$.ajax({
      					type: "GET",
      					url: url,
      					async:false,
      					success: function(html) {
						Max_Qty=html;
						console.log("back from ajax call "+Max_Qty,qty);
										}
    							});
		if(drawingid==''||incommingid==''||qty=='')
		{
			alert("Please select Corect Drawing, Challan No and Quantity");
			return false;
		}else if(Max_Qty<qty){
			console.log("inside if "+Max_Qty,qty);
			alert("Please enter correct quantity");
			return false;
		}	else{
		$('#preview').attr("disabled",false);
		var url='get_comp_challan_details.php?drawingid='+drawingid+'&incommingid='+incommingid+'&qty='+qty;
		$.get(url, function(result) {
   		data[noofcomp]=result.split("<|>");
   		//console.log(Max_Qty,data[noofcomp]);
   		var newtr="<tr><td>"+data[noofcomp][0]+"</td><td>"+data[noofcomp][1]+"</td><td>"+data[noofcomp][2]+"</td><td>"+data[noofcomp][10]+"</td></tr>";
		$('#added').show();
		$('#added').append(newtr);
		$('#data').val(data);
		$('#noofcomp').val(noofcomp);
   		noofcomp++;
		});
		}


  	});


	$("#preview").click(function(event) {

	$('#pview').val("1");
	$('#previewok').attr("disabled",false);
		 if($("#deliverychallen").valid())
		  	{
				$.ajax({
      					data: $('#deliverychallen').serializeArray(),
      					type: "POST",
      					url: "outward_dc.php",
      					success: function(html) {
			  window.open("temp.pdf");
			
		      							}
    				});
 	
		  	}
		  	

										});

$('#Drawing_ID').change(function(){
	var drawingid=$('#Drawing').val();
	var url='get_open_challans.php?drawingid='+drawingid;
  		$('#challan').load(url)
  		});

$('#previewok').click(function(){
alert("checked");
$('#pview').val("0");	
$('#submit').attr("disabled",false);
	
});






  });




function indianDate(value, element) {	

var dm=/^(0[1-9]|[12][0-9]|3[01])[- //.](0[1-9]|1[012])[- //.](19|20)\d\d$/;
                return value.match(dm);
}

$.validator.addMethod("indianDate",indianDate,"Please enter a date in the format dd/mm/yyyy");
