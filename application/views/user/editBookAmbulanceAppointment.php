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
						<form id="add_ambulance_employee_form" class="form" action="<?php echo base_url(); ?>updateAmbulanceBooking" id="add_ambulance_appointment_form" method="post" enctype="multipart/form-data">
								<!-- <div class="card-header">
									<h3 class="card-title">
										Add Doctor Appointment
									</h3>
								</div> -->
								<div class="card-body">
									 <input type="hidden" name="book_ambulance_id" id="book_ambulance_id" value="<?php echo $appointment_book['book_ambulance_id'];?>">
								
							   
							    <div class="row">
							    	<div class="form-group col-md-6">
										<label><b>Patient *</b></label>
										<select class="form-control select2 display_member_list member_validate" id="kt_select2_2" name="patient_id" required="" disabled>
											<option value="0" selected disabled hidden> Select Member</option>
											<?php 
												foreach($member as $m){

													$selected_member = "";
													
													if($m['member_id'] == $appointment_book['patient_id']){ $selected_member = "selected"; }
													echo '<option value="'.$m['member_id'].'" '.$selected_member.'>'.$m['name'].'</option>';
												}
											?>
										</select>
										 <div id="member_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
										
										
							    </div>
							    
							  
							    <div class="row">
							    	<div class="form-group col-md-3">
											<label><b>Mobile No</b></label>
											<input type="text" class="form-control" placeholder="Enter Number" name="mobile1" id="mobile1" onkeypress="return isNumber(event)"  maxlength="10" value="<?php if($appointment_book['mobile1']==0){ echo ""; }else{echo $appointment_book['mobile1'];} ?>" disabled />
											<div id="mobile1_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										
										<div class="form-group col-md-3">
											<label><b>Landline</b></label>
											<input type="text" class="form-control" placeholder="Enter Number" name="landline" id="landline" onkeypress="return isNumber(event)"  maxlength="15" value="<?php if($appointment_book['landline']==0){ echo ""; }else{echo $appointment_book['landline'];} ?>" disabled/>
											<div id="landline_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							    </div>
							    
							   <div class="row">
							   		<div class="form-group col-md-4">
											<label><b>Type *</b></label>
											<select class="form-control select2 type_valid type_change" id="kt_select2_14" name="type" disabled >
											
											<option value="none" selected disabled hidden> Select Type </option>
											<option value="ONEWAY"<?=$appointment_book['type_id'] == "1" ? ' selected="selected"' : ''?>>ONEWAY</option> 
    										<option value="ROUND TRIP"<?=$appointment_book['type_id'] == "2" ? ' selected="selected"' : ''?>>ROUND TRIP</option>
    											<option value="MULTI CITY"<?=$appointment_book['type_id'] == "3" ? ' selected="selected"' : ''?>>MULTI CITY</option>
										</select>
											 <div id="type_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							   </div>


							   <?php 
							   if($appointment_book['type_id']==1){

							   ?>

							   <div class="row">
							    	
										
										<div class="form-group col-md-6" id="from_address_show" disabled>
											<label><b>From Address *</b></label>
											<!-- <textarea class="form-control" name="from_address" id="from_address"></textarea> -->
											<input type="text" class="form-control" name="from_address" id="from_address" value="<?php echo $appointment_book['from_address']?>" disabled>
											<div id="from_address_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										
							    </div>

							    <div class="row">
							    	<div class="form-group col-md-6" id="to_address_show" >
											<label><b>To Address *</b></label>
											<!-- <textarea class="form-control" name="to_address" id="to_address"></textarea> -->
											<input type="text" class="form-control" name="to_address" id="to_address" value="<?php echo $appointment_book['to_address']?>" disabled>
											<div id="to_address_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
								</div>


							     <div class="row">
							    	<div class="form-group col-md-4" id="city_id_show" >
											<label><b>City *</b></label><br>
											<select class="form-control select2 city_valid" id="kt_select2_11" name="city_id" style="width:100%" disabled>
											<option value="none" selected disabled hidden> Select City </option>
											<?php 
												foreach($city as $c){

													$selected_city = "";
													
													if($c['city_id'] == $appointment_book['city_id']){ $selected_city = "selected"; }
													echo '<option value="'.$c['city_id'].'" '.$selected_city.'>'.$c['city'].'</option>';
												}
											?>
										</select>
											 <div id="city_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
								</div>
									
								
								 <div class="row">
							    	<div class="form-group col-md-3" id="s_startdate_id_show" >
											<label><b>Start Date *</b></label>
											<input type="date" class="form-control" placeholder="DD/MM/YY" name="date" id="date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $appointment_book['date']?>"/>
											<div id="s_date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										<div class="form-group col-md-3" id="s_starttime_id_show" >
											<label><b>Start Time *</b></label>
											<input type="time" class="form-control" placeholder="HH:MM" name="time" id="time" value="<?php echo $appointment_book['time']?>"/>
											<div id="s_time_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							    </div>
							    <?php
								}
								else if($appointment_book['type_id']==2)
								{
									?>
									   <div class="row">
							    	
										
										<div class="form-group col-md-6" id="from_address_show" >
											<label><b>From Address *</b></label>
											<!-- <textarea class="form-control" name="from_address" id="from_address"></textarea> -->
											<input type="text" class="form-control" name="from_address" id="from_address" value="<?php echo $appointment_book['from_address']?>" disabled>
											<div id="from_address_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										
							    </div>

							    <div class="row">
							    	<div class="form-group col-md-6" id="to_address_show" >
											<label><b>To Address *</b></label>
											<!-- <textarea class="form-control" name="to_address" id="to_address"></textarea> -->
											<input type="text" class="form-control" name="to_address" id="to_address" value="<?php echo $appointment_book['to_address']?>" disabled>
											<div id="to_address_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
								</div>


							     <div class="row">
							    	<div class="form-group col-md-4" id="city_id_show" >
											<label><b>City *</b></label><br>
											<select class="form-control select2 city_valid" id="kt_select2_11" name="city_id" style="width:100%" disabled>
											<option value="none" selected disabled hidden> Select City </option>
											<?php 
												foreach($city as $c){

													$selected_city = "";
													
													if($c['city_id'] == $appointment_book['city_id']){ $selected_city = "selected"; }
													echo '<option value="'.$c['city_id'].'" '.$selected_city.'>'.$c['city'].'</option>';
												}
											?>
										</select>
											 <div id="city_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
								</div>
									
								
								 <div class="row">
							    	<div class="form-group col-md-3" id="s_startdate_id_show">
											<label><b>Start Date *</b></label>
											<input type="date" class="form-control" placeholder="DD/MM/YY" name="date" id="date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $appointment_book['date']?>"/>
											<div id="s_date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										<div class="form-group col-md-3" id="s_starttime_id_show" >
											<label><b>Start Time *</b></label>
											<input type="time" class="form-control" placeholder="HH:MM" name="time" id="time" value="<?php echo $appointment_book['time']?>"/>
											<div id="s_time_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							    </div>
									<?php
								}else if($appointment_book['type_id']==3)
								{
									//$multi_city=explode(',',$appointment_book['multi_city']);
									?>
									 <div class="row">
							    	<div class="form-group col-md-4" id="city_id_show" >
											<label><b>City *</b></label><br>
											<select class="form-control select2 city_valid" id="kt_select2_11" name="city_id" style="width:100%" disabled>
											<option value="none" selected disabled hidden> Select City </option>
											<?php 
												foreach($city as $c){

													$selected_city = "";
													
													if($c['city_id'] == $appointment_book['city_id']){ $selected_city = "selected"; }
													echo '<option value="'.$c['city_id'].'" '.$selected_city.'>'.$c['city'].'</option>';
												}
											?>
										</select>
											 <div id="city_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
								</div>
									
								
								 <div class="row">
							    	<div class="form-group col-md-3" id="s_startdate_id_show">
											<label><b>Start Date *</b></label>
											<input type="date" class="form-control" placeholder="DD/MM/YY" name="date" id="date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $appointment_book['date']?>" />
											<div id="s_date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										<div class="form-group col-md-3" id="s_starttime_id_show" >
											<label><b>Start Time *</b></label>
											<input type="time" class="form-control" placeholder="HH:MM" name="time" id="time" value="<?php echo $appointment_book['time']?>"/>
											<div id="s_time_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							    </div>
									<?php
									 $multi_city=explode(',@#-0,',$appointment_book['multi_city']);
									  foreach($multi_city as $row)
							    	{
							    	

							    	?>
								    	 <div class="row multi_city_show remove_location"  id="multi_city_show"  >

								    	<div class="form-group col-md-5">
												<label><b>Location *</b></label>
												<input type="text" class="form-control multi_textbox_validation" placeholder="Select Location" name="multi_city[]" id="multi_city" value="<?php echo $row;?>" disabled/>
												<div id="multi_text_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
											</div>
											<!-- <div class="form-group col-md-1">
												<button type="button" class="remove" value="Remove" style="margin-top: 30px;"><i class="ki ki-bold-close text-danger"></i></button>
												<button  id="btnAdd" type="button" style="margin-top: 30px;" value="Add" ><i class="ki ki-plus text-success"></i></button>


												
											</div> -->

											
								    </div>
								   
							    <?php
							    
									}
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
								<button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Save</button>
								<a href="<?php echo base_url(); ?>BookingHistory" class="btn btn-secondary">Cancel</a>

								
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


<script type="text/javascript">
	function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
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
          //alert(value);
              if(value=="ONEWAY"){
              	//alert("1");
                
                	jQuery("#from_address_show").show();
                	jQuery("#to_address_show").show();
                	jQuery("#city_id_show").show();
                	jQuery("#condition_id_show").show();
                	jQuery("#s_startdate_id_show").show();
                 	jQuery("#s_starttime_id_show").show();
                 	 jQuery("#multi_city_show").hide();
               
                // jQuery('#textareashow').val('');
                // to_address_show
                  //$("#textareashow").show();
              }
              else if(value=="ROUND TRIP")
              {
              	//alert("2");
              		jQuery("#from_address_show").show();
                	jQuery("#to_address_show").show();
                	jQuery("#city_id_show").show();
                	jQuery("#condition_id_show").show();
                	jQuery("#s_startdate_id_show").show();
                 	jQuery("#s_starttime_id_show").show();
                 	//jQuery("#e_enddate_id_show").show();
                 	//jQuery("#e_endtime_id_show").show();
                 	 jQuery("#multi_city_show").hide();
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
                  //jQuery("#e_endtime_id_show").hide();
                

              		jQuery("#multi_city_show").show();
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
                 // jQuery("#e_endtime_id_show").hide();
                  jQuery("#multi_city_show").hide();
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
        $(this).closest("div").remove();
    });
});
function GetDynamicTextBox(value) {
    return '<div class="row"><div class="form-group col-md-5"><input name = "multi_city[]" placeholder="Select Location" type="text"  class="form-control" value = "' + value + '" /></div>&nbsp;' +
            '<button type="button" class="remove" value="Remove" style="height:25px;margin-top: 10px;margin-left:10px;" ><i class="ki ki-bold-close text-danger"></i></button></div>'
}
  </script>
  <script type="text/javascript">
 

    function getMemberData(user_id){
        
        //alert(user_id);
		if(user_id){

            jQuery.ajax({
                type:'POST',
                 url: BASE_URL+'admin/AppointmentList/member_list_display',
                data:'user_id='+user_id,
                success:function(html){
                //  alert(html);
				        //	console.log(html);
                    jQuery('.display_member_list').html(html);
                    getAddress(user_id);
                     
                }
            }); 
        }else{
            //	jQuery('#state').html('<option value="">Select country first</option>');
          
        }
    }
    
</script>
<script type="text/javascript">
    $(function () {

        $("#btnSubmit").click(function () {
        	// var user_type_validate = $(".user_type_validate");
             var member_validate = $(".member_validate");
		     //var gender_type_validate = $(".gender_type_validate");
             var city_valid = $(".city_valid");
           	 var type_valid = $(".type_valid");   
               var type_value = $('.type_change').val();
            

            if (member_validate.val() == null) {
                
                $('#member_valid_id').show();
                
                return false;
            }
            else
            {
                 $('#member_valid_id').hide();
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
        });
    });
</script>
