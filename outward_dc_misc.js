$(document).ready(function(){
var noofcomp=0;
var item=new Array();


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

$('#customer').click(function(){
var custid=$('#Customer_ID').val();
var url='get_cust_address.php?custid='+custid;
	$.ajax({
      					type: "GET",
      					url: url,
      					async:false,
      					success: function(result) {
   		cdata=result.split("<|>");
console.log(cdata);
$('#name').val(cdata[0]);
$('#addl1').val(cdata[1]);
$('#addl2').val(cdata[2]);
$('#phone').val(cdata[3]);

										}
    							});
  		});


$('#add').click(function(){
	var desc=$('#desc').val();
	var qty=$('#qty').val();
	var remarks=$('#remarks').val();

		if(desc==''||qty=='')
		{
			alert("Please select Corect Description and Quantity");
			return false;
		}else{
		$('#preview').attr("disabled",false);
		var d=$('#desc').val()+"%"+$('#qty').val()+"%"+$('#remarks').val();
		item[noofcomp]=d.split("%");
   		var newtr="<tr><td>"+item[noofcomp][0]+"</td><td>"+item[noofcomp][1]+"</td><td>"+item[noofcomp][2]+"</td></tr>";
		$('#added').append(newtr);
		$('#added').show();
		$('#item').val(item);
		$('#noofcomp').val(noofcomp);
   		noofcomp++;
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
if(this.checked)
{
$('#pview').val("0");	
$('#submit').attr("disabled",false);
}else
{
$('#pview').val("1");	
$('#submit').attr("disabled",true);
}
});


$('#newcust').click(function(){
if(this.checked)
{
$('#Customer_ID').attr("disabled",true);
$('#name').val('');
$('#addl1').val('');
$('#addl2').val('');
$('#phone').val('');
$('#name').removeAttr("readonly");
$('#addl1').removeAttr("readonly");
$('#addl2').removeAttr("readonly");
$('#phone').removeAttr("readonly");

}else
{
$('#Customer_ID').attr("disabled",false);
$('#name').val('');
$('#addl1').val('');
$('#addl2').val('');
$('#phone').val('');
$('#name').attr("readonly",readonly);
$('#addl1').attr("readonly",readonly);
$('#addl2').attr("readonly",readonly);
$('#phone').attr("readonly",readonly);

}
});





  });




function indianDate(value, element) {	

var dm=/^(0[1-9]|[12][0-9]|3[01])[- //.](0[1-9]|1[012])[- //.](19|20)\d\d$/;
                return value.match(dm);
}

$.validator.addMethod("indianDate",indianDate,"Please enter a date in the format dd/mm/yyyy");
