<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Edit Ambulance Appointment</h5>
									<!--end::Page Title-->
								</div>
								<!--end::Info-->
							</div>
						</div>
		<!--begin::Entry-->
		<div class="d-flex flex-column-fluid">
			<!--begin::Container-->

			<div class="container">

				<!-- Pharmacy Details -->
				<div class="card card-custom">
					<div class="card-body p-0">
						<form id="add_pharmacy_employee_form" class="form" action="<?php echo base_url(); ?>insertambulanceAppointment" id="add_ambulance_appointment_form" method="post" enctype="multipart/form-data">
								<!-- <div class="card-header">
									<h3 class="card-title">
										Add Doctor Appointment
									</h3>
								</div> -->
								<input type="hidden" name="cart_id" id="cart_id" value="<?php echo $cart['cart_id'];?>">
								<div class="card-body">

								<div class="row">
							    	<div class="form-group col-md-6">
										<label><b>Patient *</b></label>
										<select class="form-control select2  member_validate" id="kt_select2_1" name="member_id" >
											<option value="" selected disabled hidden> Select Patient</option>
											<?php 
											foreach($member as $m){

													$selected_member = "";
													
													if($m['member_id'] == $cart['patient_id']){ $selected_member = "selected"; }
													echo '<option value="'.$m['member_id'].'" '.$selected_member.'>'.$m['name'].'</option>';
												}
											?>
										</select>
										 <div id="member_id_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
									<div class="form-group col-md-6 mr-7" >
										<label><b>Not found patient above ?</b>&nbsp;<a href="<?php echo base_url()."addMember"?>">Click here</a></label>
										
									</div>
									
										
										
							    </div>
							    
							 
							    <div class="row">
							    	
										<div class="form-group col-md-3">
											<label><b>Mobile No</b></label>
											<input type="text" class="form-control" placeholder="Enter Number" name="mobile2" id="mobile2" onkeypress="return isNumber(event)"  maxlength="10" value="<?php if($cart['mobileNumber']==0){ echo ""; }else{echo $cart['mobileNumber'];} ?>"/>
											<div id="mobile2_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										<div class="form-group col-md-3">
											<label><b>Landline</b></label>

											<input type="text" class="form-control" placeholder="Enter Number" name="landline" id="landline" onkeypress="return isNumberKey(event)"  maxlength="15" value="<?php echo $cart['landlineNumber'];?>" />
											<div id="landline_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							    </div>
							   
							   <div class="row">
							   		<div class="form-group col-md-4">
											<label><b>Type *</b></label>
											<select class="form-control select2 type_valid type_change" id="kt_select2_14" name="type" >
											<option value="none" selected disabled hidden> Select Type </option>
											<option value="ONEWAY"<?=$cart['type'] == "1" ? ' selected="selected"' : ''?>>ONEWAY</option> 
    										<option value="ROUND TRIP"<?=$cart['type'] == "2" ? ' selected="selected"' : ''?>>ROUND TRIP</option>
    											<option value="MULTI CITY"<?=$cart['type'] == "3" ? ' selected="selected"' : ''?>>MULTI CITY</option>
											</select>
											 <div id="type_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							   </div>
							   <?php 
							   	if($cart['type']!=3){
							   ?>
							   <div class="row">
							    	
										
										<div class="form-group col-md-6" id="from_address_show" >
											<label><b>From Address *</b></label>
											<!-- <textarea class="form-control" name="from_address" id="from_address"></textarea> -->
											<input type="text" class="form-control" name="from_address" id="from_address" value="<?php echo $cart['from_address']?>">
											<div id="from_address_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										
							    </div>

							    <div class="row">
							    	<div class="form-group col-md-6" id="to_address_show" >
											<label><b>To Address *</b></label>
											<!-- <textarea class="form-control" name="to_address" id="to_address"></textarea> -->
											<input type="text" class="form-control" name="to_address" id="to_address" value="<?php echo $cart['to_address']?>">
											<div id="to_address_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
								</div>

								<?php 

							}
							else
							{
								?>
								 <div class="row">
							    	
										
										<div class="form-group col-md-6 from_address_show_mul" id="from_address_show" style="display:none;">
											<label><b>From Address *</b></label>
											<!-- <textarea class="form-control" name="from_address" id="from_address"></textarea> -->
											<input type="text" class="form-control" name="from_address" id="from_address" value="<?php echo $cart['from_address']?>">
											<div id="from_address_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										
							    </div>

							    <div class="row">
							    	<div class="form-group col-md-6 to_address_show_mul" id="to_address_show" style="display:none;" >
											<label><b>To Address *</b></label>
											<!-- <textarea class="form-control" name="to_address" id="to_address"></textarea> -->
											<input type="text" class="form-control" name="to_address" id="to_address" value="<?php echo $cart['to_address']?>">
											<div id="to_address_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
								</div>
								<?php
							}

							?>
							     <div class="row">
							    	<div class="form-group col-md-4" id="city_id_show">
											<label><b>City *</b></label><br>
											<select class="form-control select2 city_valid" id="kt_select2_11" name="city_id" style="width:100%" >
											<option value="none" selected disabled hidden> Select City </option>
											<?php 
												foreach($city as $c){

													$selected_city = "";
													
													if($c['city_id'] == $cart['cityId']){ $selected_city = "selected"; }
													echo '<option value="'.$c['city_id'].'" '.$selected_city.'>'.$c['city'].'</option>';
												}
											?>
										</select>
											 <div id="city_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
								</div>
									
								<!-- <div class="row">
								 	  	<div class="form-group col-md-6" id="condition_id_show" style="display: none;">
											<label><b>Condition *</b></label>
											
											<input type="text" class="form-control" name="condition" id="condition">
											<div id="condition_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
								</div> -->
								 <div class="row">
							    	<div class="form-group col-md-3" id="s_startdate_id_show">
											<label><b>Start Date *</b></label>
											<input type="date" class="form-control" placeholder="DD/MM/YY" name="date" id="date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $cart['date']?>"/>
											<div id="s_date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										<div class="form-group col-md-3" id="s_starttime_id_show" >
											<label><b>Start Time *</b></label>
											<input type="time" class="form-control" placeholder="HH:MM" name="time" id="time"  value="<?php echo $cart['time']?>"/>
											<div id="s_time_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							    </div>
							    <?php
								// }
								// else{
									?>
									 <!-- <div class="row">
							    	
										
										<div class="form-group col-md-6" id="from_address_show" style="display: none;">
											<label><b>From Address *</b></label>
											
											<input type="text" class="form-control" name="from_address" id="from_address" >
											<div id="from_address_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										
							    </div>

							    <div class="row">
							    	<div class="form-group col-md-6" id="to_address_show" style="display: none;">
											<label><b>To Address *</b></label>
											
											<input type="text" class="form-control" name="to_address" id="to_address">
											<div id="to_address_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
								</div>


							     <div class="row">
							    	<div class="form-group col-md-4" id="city_id_show" style="display: none;">
											<label><b>City *</b></label><br>
											<select class="form-control select2 city_valid" id="kt_select2_11" name="city_id" style="width:100%" >
											<option value="none" selected disabled hidden> Select City </option>
											<?php 
												foreach($city as $c){
													echo '<option value="'.$c['city_id'].'">'.$c['city'].'</option>';
												}
											?>
										</select>
											 <div id="city_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
								</div>
									
								
								 <div class="row">
							    	<div class="form-group col-md-3" id="s_startdate_id_show" style="display: none;">
											<label><b>Start Date *</b></label>
											<input type="date" class="form-control" placeholder="DD/MM/YY" name="date" id="date" min="<?php echo date('Y-m-d'); ?>" />
											<div id="s_date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										<div class="form-group col-md-3" id="s_starttime_id_show" >
											<label><b>Start Time *</b></label>
											<input type="time" class="form-control" placeholder="HH:MM" name="time" id="time"  />
											<div id="s_time_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							    </div> -->
									<?php
								//}
							    ?>
							   

							    
									
								
								
							    <?php 
							    $multi_city=explode(',@#-0,',$cart['multi_city']);
							    //echo COUNT($multi_city);
							   // print_r($multi_city);
							    if($cart['type']==3){
							    	$i=1;
							    	$j=1;
							    	$k=1;
							    foreach($multi_city as $row)
							    {
							    	

							    	?>
							    	 <div class="row multi_city_show remove_location"  id="multi_city_show"  >

							    	<div class="form-group col-md-5"> 
											<label class="location_lable_<?php echo $k++;?>" style="display: none;"><b>Location *</b></label>
											<input type="text" class="form-control multi_textbox_validation" placeholder="Select Location" name="multi_city[]" id="multi_city" value="<?php echo $row;?>" />
											<div id="multi_text_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										<div class="form-group col-md-1">
											<button type="button" class="remove" value="Remove" style="margin-top: 5px;"  id="first_button_remove_<?php echo $i++;?>"><i class="ki ki-bold-close text-danger" ></i></button>
											<button  id="btnAdd" type="button" style="margin-top: 30px;display: none;" value="Add" class="first_button_add_<?php echo $j++;?>" ><i class="ki ki-plus text-success" ></i></button>
										</div>

										
							    </div>

							    	
							    <!-- <div class="row"><div class="form-group col-md-5"><input name="multi_city[]" placeholder="Select Location" type="text" class="form-control" value=""></div>&nbsp;</div> -->
							    <?php
							    
								}
							}
							else
							{
								?>
								<div class="row multi_city_show"  id="multi_city_show" style="display: none" >
							    	<div class="form-group col-md-5">
											<label><b>Location *</b></label>
											<input type="text" class="form-control multi_textbox_validation" placeholder="Select Location" name="multi_city[]" id="multi_city" />
											<div id="multi_text_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										<div class="form-group col-md-1">
											<button  id="btnAdd" type="button" style="margin-top: 30px;" value="Add" ><i class="ki ki-plus text-success"></i></button>
											
										</div>

										
							    </div>
								<?php
							}
							    ?>

							    
							   

							    	<div id="TextBoxContainer">
    									<!--Textboxes will be added here -->
									</div>
							    <div class="row">
							    	
									
									<div class="form-group col-md-6" >
										By booking appointment at dratdoorstep you accept our. <a href="<?php echo base_url()?>userTermsCondition" target="_blank"><u> Terms & Conditions</u></a>
									</div>



								</div>	

								
								
								<!-- <div class="row">
								<div class="form-group col-md-4">
										<label>Status</label>
										<select class="form-control select2"  name="emp_status"  id="kt_select2_16">
											<option value="1">Active</option>
											<option value="0">Inactive</option>
										</select>
										
								</div>

								</div> -->
								
							</div>
												
							<div class="card-footer">
								<!-- <button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Save</button>
								<a href="<?php echo base_url(); ?>adminAppointmentList" class="btn btn-secondary">Cancel</a> -->
								<!-- <button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Booking Now</button> -->
								<button type="button" class="btn btn-primary mr-2" id="btnSubmit">Book Now</button>

								<!-- <a href="<?php echo base_url()?>userCart"  class="btn btn-primary mr-2">Book Now</a> -->
								<button type="button" class="btn btn-primary mr-2" id="butsave">Add to Cart</button>
								<!-- <a href="<?php echo base_url(); ?>AppointmentList" class="btn btn-secondary">Cancel</a> -->
							</div>
						</form>
					</div>
				</div>
				<!-- End of Pharmacy Details -->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Entry-->
	</div>
<!--end::Content-->


<!-- <script type="text/javascript">
	function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script> -->
 <script type="text/javascript">
	function isNumberKey(evt) {
   var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 45 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
}
</script>
  <script type="text/javascript">
    jQuery(function() {
         // jQuery("#refname").hide()
          jQuery(".type_change").change(function() {
              //alert("test")
        // jQuery(this).val() == 'select' ? jQuery("#textarea").hide() : jQuery("#textarea").show();
         //$("#lableaddress").show();
           var value = $('.type_change').val();
           var city_valid =$('.city_valid option:selected').val();
          //alert(value);
              if(value=="ONEWAY"){
              	//alert("1");
                
                	jQuery("#from_address_show").show();
                	jQuery(".from_address_show_mul").show();
                	
                	jQuery('#from_address').val("");
                	jQuery("#to_address_show").show();
                	jQuery(".to_address_show_mul").show();
                	jQuery('#to_address').val("");
                	jQuery("#city_id_show").show();
                	
                	//$("#city_valid option[value='']").attr('selected', true);



                	//jQuery("#condition_id_show").show();
                	jQuery("#s_startdate_id_show").show();
                	jQuery('#date').val("");
                 	jQuery("#s_starttime_id_show").show();
                 	jQuery('#time').val("");
                 	 jQuery(".multi_city_show").hide();
                 	 //multi_city
               
                // jQuery('#textareashow').val('');
                // to_address_show
                  //$("#textareashow").show();
              }
              else if(value=="ROUND TRIP")
              {
              	//alert("2");
              		jQuery("#from_address_show").show();
              		jQuery(".from_address_show_mul").show();
              		jQuery(".to_address_show_mul").show();
              		jQuery('#from_address').val("");
                	jQuery("#to_address_show").show();
                	jQuery('#to_address').val("");
                	jQuery("#city_id_show").show();
                	//jQuery("#kt_select2_11").val('none');
                	//jQuery(".city_valid option").prop("selected", false);
                	// $('.city_valid').prop('selectedIndex',0);
                	//jQuery(".city_valid option[value='']").attr('selected', false)



                	
                	//jQuery("#condition_id_show").show();
                	jQuery("#s_startdate_id_show").show();
                	jQuery('#date').val("");
                 	jQuery("#s_starttime_id_show").show();
                 	jQuery('#time').val("");
                 	//jQuery("#e_enddate_id_show").show();
                 	//jQuery("#e_endtime_id_show").show();
                 	// jQuery("#multi_city_show").hide();
                 	 jQuery(".multi_city_show").hide();
              }
              else if(value=="MULTI CITY")
              {
              	//	alert("3");
              		  jQuery("#from_address_show").hide();

                  jQuery("#to_address_show").hide();
                  jQuery("#city_id_show").show();
                  jQuery("#condition_id_show").hide();
                  jQuery("#s_startdate_id_show").show();
                  jQuery("#s_starttime_id_show").show();
                  //jQuery("#e_enddate_id_show").hide();
                //  jQuery("#e_endtime_id_show").hide();
                

              		//jQuery("#multi_city_show").show();
              		 jQuery(".multi_city_show").show();
              }
              else
              {
                   // jQuery("#refname").hide()
                  jQuery("#from_address_show").hide();
                  jQuery("#to_address_show").hide();
                  jQuery("#city_id_show").hide();
                  jQuery("#condition_id_show").hide();
                  jQuery("#s_startdate_id_show").hide();
                  jQuery("#s_starttime_id_show").hide();
                 // jQuery("#e_enddate_id_show").hide();
                  //jQuery("#e_endtime_id_show").hide();
                  //jQuery("#multi_city_show").hide();
                   jQuery(".multi_city_show").hide();
              }
             
              

          });
        });
  </script>
  <script type="text/javascript">
  	$(function () {
    $("#btnAdd").bind("click", function () {
    	//alert("test");
        var div = $("<div />");
        div.html(GetDynamicTextBox(""));
        $("#TextBoxContainer").append(div);
    });
    $("#btnGet").bind("click", function () {
        var values = "";
        $("input[name=multi_city[]]").each(function () {
            values += $(this).val() + "\n";
        });
      //  alert(values);
    });
    $("body").on("click", ".remove", function () {
        $(this).closest("div.remove_location").remove();
       // $("div.remove_location").remove();
    });
});
function GetDynamicTextBox(value) {
    return '<div class="row remove_location"><div class="form-group col-md-5"><input name = "multi_city[]" placeholder="Select Location" type="text"  class="form-control" value = "' + value + '" /></div>&nbsp;' +
            '<button type="button" class="remove" value="Remove" style="height:25px;margin-top: 10px;margin-left:10px;" ><i class="ki ki-bold-close text-danger"></i></button></div>'
}
  </script>


<script type="text/javascript">

// Ajax post
$(document).ready(function() 
{
$("#butsave").click(function() 
{
//
//alert(member);
	var member_id =$('.member_validate option:selected').val();

	//var first_name = $('#first_name').val();
	//var last_name = $('#last_name').val();
	//var age = $('#age').val();
	//var gender_type_validate =$('.gender_type_validate option:selected').val();
	//var mobile1 = $('#mobile1').val();
	var mobile2 = $('#mobile2').val();
	var landline = $('#landline').val();
	var type_valid =$('.type_valid option:selected').val();
    var city_valid =$('.city_valid option:selected').val();
    var from_address = $('#from_address').val();
    var to_address = $('#to_address').val();
   // var to_address = $('#to_address').val();
   // var condition = $('#condition').val();
    var date = $('#date').val();
    var time = $('#time').val();
    var cart_id = $('#cart_id').val();
    //var return_date = $('#return_date').val();
    //var return_time=$('#return_time').val();
    //var multi_city=$('#multi_city').val();

	// var time = $('#time').val();
	// var doctor_type_validate =$('.doctor_type_validate option:selected').val();
//alert(doctor_type_validate);

var myarraydata=[];
	var arraydata = $("input[name^='multi_city']");
	//alert(arraydata);
for(i=0;i<arraydata.length;i++)
{

	var multi_city_data1 =  arraydata[i].value;
	myarraydata.push(multi_city_data1); 
 
}
	if(type_valid=="MULTI CITY")
    {
    	if(member_id !="" && type_valid!="none" && city_valid!="" &&  date!="" && time!="" && myarraydata!="")
		{
				jQuery.ajax({
				type: "POST",
				url: "<?php echo base_url('updateAmbulanceCart'); ?>",
				dataType: 'html',
				data: {cart_id:cart_id,member_id:member_id,mobile2:mobile2,landline:landline,type_valid:type_valid,city_valid:city_valid,from_address:from_address,to_address:to_address,date:date,time:time,multi_city_data:myarraydata},
				success: function(res) 
				{

					
					window.location.href = '<?php echo base_url('AppointmentList'); ?>';
				},
				error:function()
				{
					//alert('data not saved');	
				}
			});
		}
		else
		{
			var member_validate = $(".member_validate");
			//var gender_type_validate = $(".gender_type_validate");
	        var city_valid = $(".city_valid");
	           
	                var type_valid = $(".type_valid");   
	               var type_value = $('.type_change').val();

	            if (member_validate.val() == null) {
	                
	                $('#member_id_valid').show();
	                
	                return false;
	            }
	            else
	            {
	                 $('#member_id_valid').hide();
	            }
	            


	            if (type_valid.val() == null) {
	                
	                $('#type_valid_id').show();
	        		
	                return false;
	            }
	            else
	            {
	            	 $('#type_valid_id').hide();
	            }



	            if(type_value=="ONEWAY")
	            {
		            if ($("#from_address").val()=='') {
		                
		                $('#from_address_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#from_address_valid').hide();
		            }

		            if ($("#to_address").val()=='') {
		                
		                $('#to_address_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#to_address_valid').hide();
		            }



		            // if (city_valid.val() == null) {
		                
		            //     $('#city_valid_id').show();
		        		
		            //     return false;
		            // }
		            // else
		            // {
		            // 	 $('#city_valid_id').hide();
		            // }


		            // if ($("#condition").val()=='') {
		                
		            //     $('#condition_valid').show();
		        		
		            //     return false;
		            // }
		            // else
		            // {
		            // 	 $('#condition_valid').hide();
		            // }

		            if ($("#date").val()=='') {
		                
		                $('#s_date_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#s_date_valid').hide();
		            }

		              if ($("#time").val()=='') {
		                
		                $('#s_time_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#s_time_valid').hide();
		            }
		            return true;
	            }
	            
	            if(type_value=="ROUND TRIP")
	            {
		            	if ($("#from_address").val()=='') {
		                
		                $('#from_address_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#from_address_valid').hide();
		            }

		            if ($("#to_address").val()=='') {
		                
		                $('#to_address_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#to_address_valid').hide();
		            }



		            // if (city_valid.val() == null) {
		                
		            //     $('#city_valid_id').show();
		        		
		            //     return false;
		            // }
		            // else
		            // {
		            // 	 $('#city_valid_id').hide();
		            // }


		            // if ($("#condition").val()=='') {
		                
		            //     $('#condition_valid').show();
		        		
		            //     return false;
		            // }
		            // else
		            // {
		            // 	 $('#condition_valid').hide();
		            // }

		            if ($("#date").val()=='') {
		                
		                $('#s_date_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#s_date_valid').hide();
		            }

		              if ($("#time").val()=='') {
		                
		                $('#s_time_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#s_time_valid').hide();
		            }

		            // if ($("#return_date").val()=='') {
		                
		            //     $('#e_date_valid').show();
		        		
		            //     return false;
		            // }
		            // else
		            // {
		            // 	 $('#e_date_valid').hide();
		            // }

		            //   if ($("#return_time").val()=='') {
		                
		            //     $('#e_time_valid').show();
		        		
		            //     return false;
		            // }
		            // else
		            // {
		            // 	 $('#e_time_valid').hide();
		            // }
		            return true;
	            }

	             if(type_value=="MULTI CITY")
	            {
		            	//  if (city_valid.val() == null) {
			                
			            //     $('#city_valid_id').show();
			        		
			            //     return false;
			            // }
			            // else
			            // {
			            // 	 $('#city_valid_id').hide();
			            // }
			             if ($("#date").val()=='') {
		                
		                $('#s_date_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#s_date_valid').hide();
		            }

		              if ($("#time").val()=='') {
		                
		                $('#s_time_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#s_time_valid').hide();
		            }
		             if ($(".multi_textbox_validation").val()=='') {
		                
		                $('#multi_text_valid').show();
		        		
		                return false;
		            	}
		            	else
		           	 {
		            	 $('#multi_text_valid').hide();
		           	 }
		           	 return true;
	            }
			}
    }
    else
    {
    	if(member_id !="" && type_valid!="none" && from_address!="" && to_address!="" && city_valid!="" &&  date!="" && time!="" && myarraydata!="")
		{
				jQuery.ajax({
				type: "POST",
				url: "<?php echo base_url('updateAmbulanceCart'); ?>",
				dataType: 'html',
				data: {cart_id:cart_id,member_id:member_id,mobile2:mobile2,landline:landline,type_valid:type_valid,city_valid:city_valid,from_address:from_address,to_address:to_address,date:date,time:time,multi_city_data:myarraydata},
				success: function(res) 
				{

					
					window.location.href = '<?php echo base_url('AppointmentList'); ?>';
				},
				error:function()
				{
					//alert('data not saved');	
				}
			});
		}
		else
		{
			var member_validate = $(".member_validate");
			//var gender_type_validate = $(".gender_type_validate");
	        var city_valid = $(".city_valid");
	           
	                var type_valid = $(".type_valid");   
	               var type_value = $('.type_change').val();

	            if (member_validate.val() == null) {
	                
	                $('#member_id_valid').show();
	                
	                return false;
	            }
	            else
	            {
	                 $('#member_id_valid').hide();
	            }
	            


	            if (type_valid.val() == null) {
	                
	                $('#type_valid_id').show();
	        		
	                return false;
	            }
	            else
	            {
	            	 $('#type_valid_id').hide();
	            }



	            if(type_value=="ONEWAY")
	            {
		            if ($("#from_address").val()=='') {
		                
		                $('#from_address_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#from_address_valid').hide();
		            }

		            if ($("#to_address").val()=='') {
		                
		                $('#to_address_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#to_address_valid').hide();
		            }



		            // if (city_valid.val() == null) {
		                
		            //     $('#city_valid_id').show();
		        		
		            //     return false;
		            // }
		            // else
		            // {
		            // 	 $('#city_valid_id').hide();
		            // }


		            // if ($("#condition").val()=='') {
		                
		            //     $('#condition_valid').show();
		        		
		            //     return false;
		            // }
		            // else
		            // {
		            // 	 $('#condition_valid').hide();
		            // }

		            if ($("#date").val()=='') {
		                
		                $('#s_date_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#s_date_valid').hide();
		            }

		              if ($("#time").val()=='') {
		                
		                $('#s_time_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#s_time_valid').hide();
		            }
		            return true;
	            }
	            
	            if(type_value=="ROUND TRIP")
	            {
		            	if ($("#from_address").val()=='') {
		                
		                $('#from_address_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#from_address_valid').hide();
		            }

		            if ($("#to_address").val()=='') {
		                
		                $('#to_address_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#to_address_valid').hide();
		            }



		            // if (city_valid.val() == null) {
		                
		            //     $('#city_valid_id').show();
		        		
		            //     return false;
		            // }
		            // else
		            // {
		            // 	 $('#city_valid_id').hide();
		            // }


		            // if ($("#condition").val()=='') {
		                
		            //     $('#condition_valid').show();
		        		
		            //     return false;
		            // }
		            // else
		            // {
		            // 	 $('#condition_valid').hide();
		            // }

		            if ($("#date").val()=='') {
		                
		                $('#s_date_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#s_date_valid').hide();
		            }

		              if ($("#time").val()=='') {
		                
		                $('#s_time_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#s_time_valid').hide();
		            }

		            // if ($("#return_date").val()=='') {
		                
		            //     $('#e_date_valid').show();
		        		
		            //     return false;
		            // }
		            // else
		            // {
		            // 	 $('#e_date_valid').hide();
		            // }

		            //   if ($("#return_time").val()=='') {
		                
		            //     $('#e_time_valid').show();
		        		
		            //     return false;
		            // }
		            // else
		            // {
		            // 	 $('#e_time_valid').hide();
		            // }
		            return true;
	            }

	             if(type_value=="MULTI CITY")
	            {
		            	//  if (city_valid.val() == null) {
			                
			            //     $('#city_valid_id').show();
			        		
			            //     return false;
			            // }
			            // else
			            // {
			            // 	 $('#city_valid_id').hide();
			            // }
			             if ($("#date").val()=='') {
		                
		                $('#s_date_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#s_date_valid').hide();
		            }

		              if ($("#time").val()=='') {
		                
		                $('#s_time_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#s_time_valid').hide();
		            }
		             if ($(".multi_textbox_validation").val()=='') {
		                
		                $('#multi_text_valid').show();
		        		
		                return false;
		            	}
		            	else
		           	 {
		            	 $('#multi_text_valid').hide();
		           	 }
		           	 return true;
	            }
			}
    }
	

});
});
</script>
<script type="text/javascript">

// Ajax post
$(document).ready(function() 
{
$("#btnSubmit").click(function() 
{
	var member_id =$('.member_validate option:selected').val();
	// var first_name = $('#first_name').val();
	// var last_name = $('#last_name').val();
	// var age = $('#age').val();
	// var gender_type_validate =$('.gender_type_validate option:selected').val();
	// var mobile1 = $('#mobile1').val();
	var mobile2 = $('#mobile2').val();
	var landline = $('#landline').val();
	var type_valid =$('.type_valid option:selected').val();
  
    var from_address = $('#from_address').val();
    var to_address = $('#to_address').val();
    var city_valid =$('.city_valid option:selected').val();
   // var to_address = $('#to_address').val();
   // var condition = $('#condition').val();
    var date = $('#date').val();
    var time = $('#time').val();
    var cart_id = $('#cart_id').val();

   
    var myarray=[];
	var array = $("input[name^='multi_city']");
	for(i=0;i<array.length;i++)
	{

		var multi_city_data =  array[i].value;
		myarray.push(multi_city_data); 
	 
	}
	//alert(type_valid);
	if(type_valid=="MULTI CITY")
    {
    	
    	if(member_id!=""  && type_valid!="none" && city_valid!="" &&  date!="" && time!="" && myarray!="")
		{
				jQuery.ajax({
				type: "POST",
				url: "<?php echo base_url('updateAmbulanceCart'); ?>",
				dataType: 'html',
				data: {cart_id:cart_id,member_id:member_id,mobile2:mobile2,landline:landline,type_valid:type_valid,city_valid:city_valid,from_address:from_address,to_address:to_address,date:date,time:time,multi_city_data:myarray},                   
				success: function(res) 
				{
					window.location.href = '<?php echo base_url('userCart'); ?>';
				},
				error:function()
				{
					//alert('data not saved');	
				}
			});
		}
		else
		{ 
			 var member_validate = $(".member_validate");
			//var gender_type_validate = $(".gender_type_validate");
	        var city_valid = $(".city_valid");
	        var type_valid = $(".type_valid");   
	        var type_value = $('.type_change').val();
	        //alert(type_value);

	        	 if (member_validate.val() == null) {
	                
	                $('#member_id_valid').show();
	                
	                return false;
	            }
	            else
	            {
	                 $('#member_id_valid').hide();
	            }
	            // if ($("#first_name").val()=='') {
	                
	            //     $('#first_name_valid').show();
	        		
	            //     return false;
	            // }
	            // else
	            // {
	            // 	 $('#first_name_valid').hide();
	            // }

	            // if ($("#last_name").val()=='') {
	                
	            //     $('#last_name_valid').show();
	        		
	            //     return false;
	            // }
	            // else
	            // {
	            // 	 $('#last_name_valid').hide();
	            // }

	            // if ($("#age").val()=='') {
	                
	            //     $('#age_valid').show();
	        		
	            //     return false;
	            // }
	            // else
	            // {
	            // 	 $('#age_valid').hide();
	            // }

	            // if(gender_type_validate.val() == null) {
	                
	            //     $('#gender_type_valid').show();
	        		
	            //     return false;
	            // }
	            // else
	            // {
	            // 	 $('#gender_type_valid').hide();
	            // }

	            // if ($("#mobile1").val()=='') {
	                
	            //     $('#mobile1_valid').show();
	        		
	            //     return false;
	            // }
	            // else
	            // {
	            // 	 $('#mobile1_valid').hide();
	            // }

	            // if ($("#mobile2").val()=='') {
	                
	            //     $('#mobile2_valid').show();
	        		
	            //     return false;
	            // }
	            // else
	            // {
	            // 	 $('#mobile2_valid').hide();
	            // }

	            // if ($("#landline").val()=='') {
	                
	            //     $('#landline_valid').show();
	        		
	            //     return false;
	            // }
	            // else
	            // {
	            // 	 $('#landline_valid').hide();
	            // }


	            if (type_valid.val() == null) {
	                
	                $('#type_valid_id').show();
	        		
	                return false;
	            }
	            else
	            {
	            	 $('#type_valid_id').hide();
	            }



	            if(type_value=="ONEWAY")
	            {
		            if ($("#from_address").val()=='') {
		                
		                $('#from_address_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#from_address_valid').hide();
		            }

		            if ($("#to_address").val()=='') {
		                
		                $('#to_address_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#to_address_valid').hide();
		            }



		            if (city_valid.val() == null) {
		                
		                $('#city_valid_id').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#city_valid_id').hide();
		            }


		            // if ($("#condition").val()=='') {
		                
		            //     $('#condition_valid').show();
		        		
		            //     return false;
		            // }
		            // else
		            // {
		            // 	 $('#condition_valid').hide();
		            // }

		            if ($("#date").val()=='') {
		                
		                $('#s_date_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#s_date_valid').hide();
		            }

		              if ($("#time").val()=='') {
		                
		                $('#s_time_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#s_time_valid').hide();
		            }
		            return true;
	            }
	            
	            if(type_value=="ROUND TRIP")
	            {
		            	if ($("#from_address").val()=='') {
		                
		                $('#from_address_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#from_address_valid').hide();
		            }

		            if ($("#to_address").val()=='') {
		                
		                $('#to_address_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#to_address_valid').hide();
		            }



		            if (city_valid.val() == null) {
		                
		                $('#city_valid_id').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#city_valid_id').hide();
		            }


		            // if ($("#condition").val()=='') {
		                
		            //     $('#condition_valid').show();
		        		
		            //     return false;
		            // }
		            // else
		            // {
		            // 	 $('#condition_valid').hide();
		            // }

		            if ($("#date").val()=='') {
		                
		                $('#s_date_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#s_date_valid').hide();
		            }

		              if ($("#time").val()=='') {
		                
		                $('#s_time_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#s_time_valid').hide();
		            }

		            //   if ($("#return_date").val()=='') {
		                
		            //     $('#e_date_valid').show();
		        		
		            //     return false;
		            // }
		            // else
		            // {
		            // 	 $('#e_date_valid').hide();
		            // }

		            //   if ($("#return_time").val()=='') {
		                
		            //     $('#e_time_valid').show();
		        		
		            //     return false;
		            // }
		            // else
		            // {
		            // 	 $('#e_time_valid').hide();
		            // }
		            return true;
	            }

	             if(type_value=="MULTI CITY")
	            {
	            	 if (city_valid.val() == null) {
			                
			                $('#city_valid_id').show();
			        		
			                return false;
			            }
			            else
			            {
			            	 $('#city_valid_id').hide();
			            }

			             if ($("#date").val()=='') {
		                
		                $('#s_date_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#s_date_valid').hide();
		            }

		              if ($("#time").val()=='') {
		                
		                $('#s_time_valid').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#s_time_valid').hide();
		            }

		             if ($(".multi_textbox_validation").val()=='') {
		                
		                $('#multi_text_valid').show();
		        		
		                return false;
		            	}
		            	else
		           	 {
		            	 $('#multi_text_valid').hide();
		           	 }
		           	 return true;
	            }
		}
    }
    else
    {
    	// alert(member_id);
    	// alert(type_valid);
    	// alert(from_address);
    	// alert(to_address);
    	// alert(city_valid);
    	// alert(date);
    	// alert(time);
    	// alert(myarray);
    	if(member_id!=""  && type_valid!="none" && from_address!="" && to_address!="" && city_valid!="" &&  date!="" && time!="")
		{
			//alert("dsads");
			jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url('updateAmbulanceCart'); ?>",
			dataType: 'html',
			data: {cart_id:cart_id,member_id:member_id,mobile2:mobile2,landline:landline,type_valid:type_valid,city_valid:city_valid,from_address:from_address,to_address:to_address,date:date,time:time,multi_city_data:myarray},                   
			success: function(res) 
			{
				window.location.href = '<?php echo base_url('userCart'); ?>';
			},
			error:function()
			{
				//alert('data not saved');	
			}
		});
	}
	else
	{
		//alert("dsads12");
		 var member_validate = $(".member_validate");
		//var gender_type_validate = $(".gender_type_validate");
        var city_valid = $(".city_valid");
        var type_valid = $(".type_valid");   
        var type_value = $('.type_change').val();
        //alert(type_value);

        	 if (member_validate.val() == null) {
                
                $('#member_id_valid').show();
                
                return false;
            }
            else
            {
                 $('#member_id_valid').hide();
            }
            


            if (type_valid.val() == null) {
                
                $('#type_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#type_valid_id').hide();
            }



            if(type_value=="ONEWAY")
            {
	            if ($("#from_address").val()=='') {
	                
	                $('#from_address_valid').show();
	        		
	                return false;
	            }
	            else
	            {
	            	 $('#from_address_valid').hide();
	            }

	            if ($("#to_address").val()=='') {
	                
	                $('#to_address_valid').show();
	        		
	                return false;
	            }
	            else
	            {
	            	 $('#to_address_valid').hide();
	            }



	            if (city_valid.val() == null) {
	                
	                $('#city_valid_id').show();
	        		
	                return false;
	            }
	            else
	            {
	            	 $('#city_valid_id').hide();
	            }


	            // if ($("#condition").val()=='') {
	                
	            //     $('#condition_valid').show();
	        		
	            //     return false;
	            // }
	            // else
	            // {
	            // 	 $('#condition_valid').hide();
	            // }

	            if ($("#date").val()=='') {
	                
	                $('#s_date_valid').show();
	        		
	                return false;
	            }
	            else
	            {
	            	 $('#s_date_valid').hide();
	            }

	              if ($("#time").val()=='') {
	                
	                $('#s_time_valid').show();
	        		
	                return false;
	            }
	            else
	            {
	            	 $('#s_time_valid').hide();
	            }
	            return true;
            }
            
            if(type_value=="ROUND TRIP")
            {
	            	if ($("#from_address").val()=='') {
	                
	                $('#from_address_valid').show();
	        		
	                return false;
	            }
	            else
	            {
	            	 $('#from_address_valid').hide();
	            }

	            if ($("#to_address").val()=='') {
	                
	                $('#to_address_valid').show();
	        		
	                return false;
	            }
	            else
	            {
	            	 $('#to_address_valid').hide();
	            }



	            if (city_valid.val() == null) {
	                
	                $('#city_valid_id').show();
	        		
	                return false;
	            }
	            else
	            {
	            	 $('#city_valid_id').hide();
	            }


	            // if ($("#condition").val()=='') {
	                
	            //     $('#condition_valid').show();
	        		
	            //     return false;
	            // }
	            // else
	            // {
	            // 	 $('#condition_valid').hide();
	            // }

	            if ($("#date").val()=='') {
	                
	                $('#s_date_valid').show();
	        		
	                return false;
	            }
	            else
	            {
	            	 $('#s_date_valid').hide();
	            }

	              if ($("#time").val()=='') {
	                
	                $('#s_time_valid').show();
	        		
	                return false;
	            }
	            else
	            {
	            	 $('#s_time_valid').hide();
	            }

	            //   if ($("#return_date").val()=='') {
	                
	            //     $('#e_date_valid').show();
	        		
	            //     return false;
	            // }
	            // else
	            // {
	            // 	 $('#e_date_valid').hide();
	            // }

	            //   if ($("#return_time").val()=='') {
	                
	            //     $('#e_time_valid').show();
	        		
	            //     return false;
	            // }
	            // else
	            // {
	            // 	 $('#e_time_valid').hide();
	            // }
	            return true;
            }

             if(type_value=="MULTI CITY")
            {
            	 if (city_valid.val() == null) {
		                
		                $('#city_valid_id').show();
		        		
		                return false;
		            }
		            else
		            {
		            	 $('#city_valid_id').hide();
		            }

		             if ($("#date").val()=='') {
	                
	                $('#s_date_valid').show();
	        		
	                return false;
	            }
	            else
	            {
	            	 $('#s_date_valid').hide();
	            }

	              if ($("#time").val()=='') {
	                
	                $('#s_time_valid').show();
	        		
	                return false;
	            }
	            else
	            {
	            	 $('#s_time_valid').hide();
	            }

	             if ($(".multi_textbox_validation").val()=='') {
	                
	                $('#multi_text_valid').show();
	        		
	                return false;
	            	}
	            	else
	           	 {
	            	 $('#multi_text_valid').hide();
	           	 }
	           	 return true;
            }
	 }
    }
	

});
});
</script>

<script type="text/javascript">
$(document).ready(function(){    
   // alert('page loaded');  // alert to confirm the page is loaded  
   $('.location_lable_1').show();  
    $('#first_button_remove_1').hide(); //enter the class or id of the particular html element which you wish to hide. 
   
    // if($("#btnAdd").val()=="Add_1")
    // {
    		 $('.first_button_add_1').show();
   // }
  //  alert($("#btnAdd").val());
 	


});
</script>

