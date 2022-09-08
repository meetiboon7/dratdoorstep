<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Employee Master</h5>
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
						<form id="add_pharmacy_employee_form" class="form" action="<?php echo base_url(); ?>insertEmployee" id="add_user_employee_form" method="post" enctype="multipart/form-data">
								<div class="card-header">
									<h3 class="card-title">
										Add Employee Info
									</h3>
								</div>
								<div class="card-body">

								<div class="row">
									<div class="form-group col-md-4">
										<label>User Type * </label>
										<select class="form-control select2 droplistID user_type_validate"  name="user_type_id" required="" id="kt_select2_1">
											<option value="0" selected disabled hidden> Select User Type </option>
											<?php 
												foreach($user_type as $u){
													echo '<option value="'.$u['user_type_id'].'">'.$u['user_type_name'].'</option>';
												}
											?>
										</select>
										 <div id="user_type_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
									<div class="form-group col-md-4">
										<label>First Name *</label>
										<input type="text" class="form-control" placeholder="First Name" name="first_name" id="first_name"/>
										 <div id="first_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
									<div class="form-group col-md-4">
										<label>Last Name *</label>
										<input type="text" class="form-control" placeholder="Last Name" name="last_name" id="last_name"/>
										 <div id="last_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
									
							    </div>

							    <div class="row">
							    	
									
									<div class="form-group col-md-4">
										<label>Email *</label>
										<input type="email" class="form-control" placeholder="Email Address" name="email" id="email" />
										 <div id="email_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									<div class="form-group col-md-4">
										<label>Mobile No *</label>
										
										<input type="text" name="mobile_no" id="mobile_no" class="form-control"  placeholder="Mobile No"  
										onkeypress="return isNumber(event)"  maxlength="10">
										 <div id="mobile_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
								
							   
									<div class="form-group col-md-4">
										<label>Date of Birth</label>
										<input type="date" class="form-control"   placeholder="Date of Birth" name="date_of_birth" />
										<div class="validation"></div>
									</div>
									
								</div>	

								 <div class="row">
							    	
									
									<div class="form-group col-md-3">
										<label>Gender</label>
										<select class="form-control select2"  name="gender"  id="kt_select2_2">
											<option value="none" selected disabled hidden> Select Gender </option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
										</select>
										
									</div>
									
									<div class="form-group col-md-3">
										<label>Address Line1</label>
										<textarea class="form-control"  placeholder="Enter Address Line 1" name="address_1"> </textarea> 
										
									</div>
									
								
								<div class="form-group col-md-3">
										<label>Address Line2</label>
								<textarea class="form-control"  placeholder="Enter Address Line 2" name="address_2"> </textarea> 
										
									</div>

									<div class="form-group col-md-3">
										<label>Pin Code</label>
										<input type="text" class="form-control" placeholder="Pin Code" name="area_pincode" id="area_pincode" onkeypress="return isNumber(event)" />
										<div class="validation"></div>
									</div>
							   
									
									
								</div>	

								 <div class="row">
							    	
									
									<!-- <div class="form-group col-md-4">
										<label>Country</label>
										<select class="form-control select2" id="kt_select2_3" name="country_id" >
											<option value="none" selected disabled hidden> Select Country </option>
											<?php 
												foreach($country as $con){
													echo '<option value="'.$con['country_id'].'">'.$con['country_name'].'</option>';
												}
											?>
										</select>
										
									</div> -->
									<div class="form-group col-md-4">
											<label><b>Country *</b></label>
											<input type="hidden" name="country_id" value="1" />

											<select class="form-control select2  country_validate" id="kt_select2_3" name="country_id" required="" disabled  >
												
												<option value="1" selected="">India</option>
												

											</select>
											<div class="validation"></div>
									</div>

									<div class="form-group col-md-4">
											<label><b>State *</b></label>
											<input type="hidden" name="state_id" value="12" />
											<select class="form-control select2  state_validate" id="kt_select2_13" name="state_id" required="" disabled  >
												<option value="" selected disabled hidden>Select State</option>
												<option value="12" selected="">Gujarat (GJ)</option>
												

											</select>
											<div class="validation"></div>
										</div>
									
									<!-- <div class="form-group col-md-4">
										<label>State</label>
										<select class="form-control select2" id="kt_select2_13" name="state_id" >
											<option value="none" selected disabled hidden> Select State </option>
											<?php 
												foreach($state as $s){
													echo '<option value="'.$s['state_id'].'">'.$s['state'].'</option>';
												}
											?>
										</select>
										
									</div> -->
									
								<?php

								?>
								<div class="form-group col-md-4">
										<label>City *</label>
										<select class="form-control select2 city_valid" id="kt_select2_14" name="city_id" >
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
							    	
									
									<div class="form-group col-md-4" id="doctor_type_data">
										<label>Type Of Doctor *</label>
										<select class="form-control select2 doctor_type_valid" id="kt_select2_17" name="d_type_id" >
											<!-- <option value="none" selected disabled hidden> Select Doctor Type </option> -->
											<option value="0" selected disabled hidden> Select Doctor Type </option>
											<?php 
												foreach($doctor_type as $dt){
													echo '<option value="'.$dt['d_type_id'].'">'.$dt['doctor_type_name'].'</option>';
												}
											?>
										</select>
										 <div id="doctor_type_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>


									<div class="form-group col-md-4" id="degree_data">
										<label>Degree *</label>
										<input type="text" class="form-control" placeholder="Degree" name="degree" id="degree" />
										<div id="degree_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									<div class="form-group col-md-4" id="registration_no_data">
										<label>Registration No *</label>
										<input type="text" class="form-control" placeholder="Registration No" name="registration_no" id="registration_no" />
										<div id="registration_no_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>

								</div>	
								<br>
								<?php
								$blank_image = base_url().'assets/media/users/blank.png';
								if(!empty($view_user_profile->profile_pic)){
						
										$profile_image = base_url().'uploads/emp_profile/'.$view_user_profile->profile_pic;
								}else{
						
											$profile_image = $blank_image;
								}
								?>
								<div class="row">
									
									<div class="form-group col-md-4" id="profile_image_data">
														<label style="margin-bottom:10px;">Profile Image</label>&nbsp;&nbsp;
														<div class="image-input image-input-empty image-input-outline" id="div_profile_image"  style="background-image: url('<?php echo $profile_image ?>');">
														<div class="image-input-wrapper"   ></div>
														<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
															<i class="fa fa-pen icon-sm text-muted"></i>
														  	<input type="file" name="img_profile" accept=".png, .jpg, .jpeg"/>
														  	<input type="hidden" name="profile_avatar_remove"/>
														</label>

														<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
															<i class="ki ki-bold-close icon-xs text-muted"></i>
														</span>

														<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
															<i class="ki ki-bold-close icon-xs text-muted"></i>
														</span>
													</div>
													</div>

									<div class="form-group col-md-4" id="license_no_data">
										<label>License No *</label>
										<input type="text" class="form-control" placeholder="License No" name="license_no" id="license_no" />
										<div id="license_no_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>

										
									</div>
								</div>
								<div class="row">
								<div class="form-group col-md-4">
										<label>Status</label>
										<select class="form-control select2"  name="emp_status"  id="kt_select2_16">
											<option value="1">Active</option>
											<option value="0">Inactive</option>
										</select>
										
								</div>

								</div>
								
							</div>
												
							<div class="card-footer">
								<button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Save</button>
								<a href="<?php echo base_url(); ?>adminEmployee" class="btn btn-secondary">Cancel</a>
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

<!-- <script src="<?php echo base_url(); ?>assets/js/employee.js"></script> -->


<!-- <script type="text/javascript">
	$(":input").inputmask();

$("#contact_number").inputmask({"mask": "(999) 999-9999"});
</script> --> 

<script type="text/javascript">
	jQuery(function() {
          jQuery("#doctor_type_data").hide();
         
          jQuery("#degree_data").hide();
          jQuery("#registration_no_data").hide();
          jQuery("#profile_image_data").hide();
           jQuery("#license_no_data").hide();
          
          jQuery(".droplistID").change(function() {
              //alert("test")
        // jQuery(this).val() == 'select' ? jQuery("#textarea").hide() : jQuery("#textarea").show();
        // $("#lableaddress").show();
            var value = jQuery(this).val();
            
          // alert(value);
              if(value=="1")
              {


              	jQuery("#license_no_data").hide();
                jQuery("#doctor_type_data").show();
          		jQuery("#registration_no_data").show();
          		jQuery("#degree_data").show();
          		jQuery("#profile_image_data").show();


          		
              }
              else if(value=="2")
              {
              	
              		jQuery("#license_no_data").hide();
              		 jQuery("#doctor_type_data").hide();
          			jQuery("#registration_no_data").show();
          			jQuery("#degree_data").show();
          			jQuery("#profile_image_data").show();
          			
              }
              
             else if(value=="5")
              {
              		 jQuery("#doctor_type_data").hide();
          			jQuery("#registration_no_data").hide();
          			jQuery("#degree_data").hide();
          			jQuery("#license_no_data").show();
          			jQuery("#profile_image_data").show();
          			
              }
              else
              {
              	 jQuery("#doctor_type_data").hide();
         
          			jQuery("#degree_data").hide();
          			jQuery("#registration_no_data").hide();
          			jQuery("#profile_image_data").hide();
           				jQuery("#license_no_data").hide();
              }
              
             
              

          });
});


</script>

<script type="text/javascript">
    $(function () {

        $("#btnSubmit").click(function () {
            var user_type_validate = $(".user_type_validate");
            // var doctor_type_valid = $(".doctor_type_valid");
             var city_valid = $(".city_valid");

             //alert(doctor_type_valid);
             var user_droplistID = $('.droplistID').val();
            //alert(user_droplistID);
           
            if (user_type_validate.val() == null) {
                
                $('#user_type_id').show();
        		
                return false;
            }
            else
            {
            	 $('#user_type_id').hide();
            }

            if ($("#first_name").val()=='') {
                
                $('#first_name_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#first_name_valid').hide();
            }

            if ($("#last_name").val()=='') {
                
                $('#last_name_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#last_name_valid').hide();
            }

            if ($("#email").val()=='') {
                
                $('#email_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#email_valid').hide();
            }


            if ($("#mobile_no").val()=='') {
                
                $('#mobile_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#mobile_valid').hide();
            }

            if (city_valid.val() == null) {
                
                $('#city_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#city_valid_id').hide();
            }
             if(user_droplistID=="1")
            {
            	//var doctor_type_valid=(".doctor_type_valid");
            	 var doctor_type_valid = $(".doctor_type_valid");
            	//alert(doctor_type_valid);
            	//alert("dsfgd");
            	 if (doctor_type_valid.val() == null) 
            	 {
                	
	            	$('#doctor_type_valid_id').show();
	        		
	                return false;
	            }
	            else
	            {
	            		
	            	 $('#doctor_type_valid_id').hide();
	            }

	            if ($("#degree").val()=='') {
                
                $('#degree_valid_id').show();
        		
                return false;
            	}
	            else
	            {
	            	 $('#degree_valid_id').hide();
	            }

	            if ($("#registration_no").val()=='') {
	                
	                $('#registration_no_valid_id').show();
	        		
	                return false;
	            }
	            else
	            {
	            	 $('#registration_no_valid_id').hide();
	            }
	            return true;
            }

             if(user_droplistID=="2")
            {
            	 

	            if ($("#degree").val()=='') {
                
                $('#degree_valid_id').show();
        		
                return false;
            	}
	            else
	            {
	            	 $('#degree_valid_id').hide();
	            }

	            if ($("#registration_no").val()=='') {
	                
	                $('#registration_no_valid_id').show();
	        		
	                return false;
	            }
	            else
	            {
	            	 $('#registration_no_valid_id').hide();
	            }
	            return true;
            }


            if(user_droplistID=="5")
            {
            	 

	            if ($("#license_no").val()=='') {
                
                $('#license_no_valid_id').show();
        		
               		 return false;
            	}
	            else
	            {
	            	 $('#license_no_valid_id').hide();
	            }

	           
	            return true;
            }


		

        });
    });
</script>
