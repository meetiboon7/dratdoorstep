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
						<form id="add_pharmacy_employee_form" class="form" action="<?php echo base_url(); ?>updateEmployee" id="add_user_employee_form" method="post" enctype="multipart/form-data">
								<!-- <div class="card-header">
									<h3 class="card-title">
										Edit Employee Info
									</h3>
								</div> -->
								<div class="card-body">

								<div class="row">
									<div class="form-group col-md-4">
										<label>User Type * </label>
										<select class="form-control select2 droplistID user_type_validate" id="kt_select2_1" name="user_type_id" >
											<option value="none" selected disabled hidden> Select User Type </option>
											<?php 
												foreach($user_type as $u){
													$selected_type = "";
													if($u['user_type_id'] == $emp_master['user_type_id']){ $selected_type = "selected"; }
													echo '<option value="'.$u['user_type_id'].'" '.$selected_type.'>'.$u['user_type_name'].'</option>';
												}
											?>

											
										</select>
										 <div id="user_type_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
									
									</div>
									<?php
									if($emp_master['laboratory_name']!=''){
									?>
									<div class="form-group col-md-4" id="laboratory_name_show" >
										<label>Laboratory Name *</label>
										<input type="text" class="form-control" placeholder="Laboratory Name" name="laboratory_name" id="laboratory_name" value="<?php echo $emp_master['laboratory_name'];?>" />
										 <div id="laboratory_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
									<?php
									}
									else
									{
										?>
										<div class="form-group col-md-4" id="laboratory_name_show" style="display: none;">
										<label>Laboratory Name *</label>
										<input type="text" class="form-control" placeholder="Laboratory Name" name="laboratory_name" id="laboratory_name"/>
										 <div id="laboratory_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
										<?php
									}
									?>
									
									
							    </div>

							     <div class="row">
							     	<div class="form-group col-md-6">
										<label>First Name *</label>
										<input type="text" class="form-control" placeholder="First Name" name="first_name" value="<?php echo $emp_master['first_name']?>" id="first_name"/>
										<div id="first_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									<div class="form-group col-md-6">
										<label>Last Name *</label>
										<input type="text" class="form-control" placeholder="Last Name" value="<?php echo $emp_master['last_name']?>" name="last_name" id="last_name"/>
										<div id="last_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
							     </div>

							    <div class="row">
							    	
									
									<div class="form-group col-md-4">
										<label>Email *</label>
										<input type="email" class="form-control" placeholder="Email Address" name="email" id="email" value="<?php echo $emp_master['email']?>"/>
										<div id="email_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									<div class="form-group col-md-4">
										<label>Mobile No *</label>
										
										<input type="text" name="mobile_no" id="mobile_no" class="form-control"  placeholder="Mobile No"  
										onkeypress="return isNumber(event)"  maxlength="10" value="<?php echo $emp_master['mobile_no']?>">
										 <div id="mobile_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
								
							   
									<div class="form-group col-md-4">
										<label>Date of Birth</label>
										<input type="date" class="form-control" value="<?php echo $emp_master['date_of_birth']?>"  placeholder="Date of Birth" name="date_of_birth" max="<?php echo date('Y-m-d');?>"/>
										<div class="validation"></div>
									</div>
									
								</div>	

								 <div class="row">
							    	
									
									<div class="form-group col-md-3">
										<label>Gender</label>
										<select class="form-control select2"  name="gender"  id="kt_select2_2">
											<option value="none" selected disabled hidden> Select Gender </option>
											
											<option value="Male"<?=$emp_master['gender'] == "Male" ? ' selected="selected"' : ''?>>Male</option> 
    										<option value="Female"<?=$emp_master['gender'] == "Female" ? ' selected="selected"' : ''?>>Female</option> 
										</select>
										
									</div>
									
									<div class="form-group col-md-3">
										<label>Address Line1</label>
										
										<input type="text" class="form-control"   placeholder="Enter Address Line1" name="address_1" id="address_1" value="<?php echo $emp_master['address_1']?> " />
									</div>
									
								
								<div class="form-group col-md-3">
										<label>Address Line2</label>
								
								<input type="text" class="form-control"   placeholder="Enter Address Line2" name="address_2" id="address_2" value="<?php echo $emp_master['address_2']?>" /> 
										
									</div>

									<div class="form-group col-md-3">
										<label>Pin Code</label>
										<input type="text" class="form-control" placeholder="Pin Code" value="<?php echo $emp_master['area_pincode']?>"  name="area_pincode" id="area_pincode" onkeypress="return isNumber(event)" />
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

													$selected_country = "";
													
													if($con['country_id'] == $emp_master['country_id']){ $selected_country = "selected"; }
													echo '<option value="'.$con['country_id'].'" '.$selected_country.'>'.$con['country_name'].'</option>';
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

													$selected_state = "";
													
													if($s['state_id'] == $emp_master['state_id']){ $selected_state = "selected"; }
													echo '<option value="'.$s['state_id'].'" '.$selected_state.'>'.$s['state'].'</option>';
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

													$selected_city = "";
													
													if($c['city_id'] == $emp_master['city_id']){ $selected_city = "selected"; }
													echo '<option value="'.$c['city_id'].'" '.$selected_city.'>'.$c['city'].'</option>';
												}
											?>
										</select>
										 <div id="city_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
								</div>
							   
									
									
								</div>	

								<div class="row">
							    	
								<?php
									if($emp_master['d_type_id']!=NULL)
									{
									    
									?>
									<div class="form-group col-md-4" id="doctor_type_data">
										<label>Type Of Doctor *</label>
										<select class="form-control select2 doctor_type_valid" id="kt_select2_5" name="d_type_id" >
											<option value="none" selected disabled hidden> Select Doctor Type </option>
											<?php 
												
												foreach($doctor_type as $dt){

													$selected_type = "";
													
													if($dt['d_type_id'] == $emp_master['d_type_id']){ $selected_type = "selected"; }
													echo '<option value="'.$dt['d_type_id'].'" '.$selected_type.'>'.$dt['doctor_type_name'].'</option>';
												}
											?>
										</select>
										<div id="doctor_type_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>

									<?php
								}
								else
								{
									?>
									<div class="form-group col-md-4" id="doctor_type_data" style="display:none"> 
										<label>Type Of Doctor *</label>
										<select class="form-control select2 doctor_type_valid" id="kt_select2_5" name="d_type_id" >
											<option value="none" selected disabled hidden> Select Doctor Type </option>
											<?php 
												
												foreach($doctor_type as $dt){

													$selected_type = "";
													
													if($dt['d_type_id'] == $emp_master['d_type_id']){ $selected_type = "selected"; }
													echo '<option value="'.$dt['d_type_id'].'" '.$selected_type.'>'.$dt['doctor_type_name'].'</option>';
												}
											?>
										</select>
										<div id="doctor_type_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
									<?php
								}
								if($emp_master['degree']!=NULL)
								{
									
								?>


									<div class="form-group col-md-4" id="degree_data">
										<label>Degree *</label>
										<input type="text" class="form-control" value="<?php echo $emp_master['degree']?>" placeholder="Degree" name="degree" id="degree" />
										<div id="degree_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>

									<?php
								}
								else
								{
									
									?>
									<div class="form-group col-md-4" id="degree_data" style="display: none">
										<label>Degree *</label>
										<input type="text" class="form-control" value="<?php echo $emp_master['degree']?>" placeholder="Degree" name="degree" id="degree" />
										<div id="degree_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
									<?php
								}
								if($emp_master['registration_no']!=NULL)
								{
									
									?>
									<div class="form-group col-md-4" id="registration_no_data">
										<label>Registration No *</label>
										<input type="text" class="form-control" placeholder="Registration No" value="<?php echo $emp_master['registration_no']?>"  name="registration_no" id="registration_no" />
										<div id="registration_no_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
								<?php
							}
							else
							{
									
								?>
								<div class="form-group col-md-4" id="registration_no_data" style="display: none">
										<label>Registration No *</label>
										<input type="text" class="form-control" placeholder="Registration No" value="<?php echo $emp_master['registration_no']?>"  name="registration_no" id="registration_no" />
										<div id="registration_no_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
								<?php
							}
							?>
									
									
							</div>	
							
							<div class="row">
							    	
								<?php
									if($emp_master['aadhaar_card']!=NULL)
									{
									    //echo "1";
									?>
									  	<div class="form-group col-md-2" id="aadhaar_card_data">
	                                        <label>Aadhaar Card :</label>
	                                                <input type="file" name="aadhaar_card" id="aadhaar_card">
	                                               

	                                        <div id="aadhaar_card_data_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
	                                         
	                                    </div>
	                                    <div class="col-md-2 img1">
	                                    	 <img src="<?php echo base_url().'uploads/emp_profile/aadhaar/'.$emp_master['aadhaar_card'] ?>" width="100" height="100"/>
	                                    </div>
	                                     


									<?php
								}
								else
								{

									//echo "2";
									?>

										<div class="form-group col-md-2" id="aadhaar_card_data" style="display: none">
	                                        <label>Aadhaar Card :</label>
	                                                <input type="file" name="aadhaar_card" id="aadhaar_card">
	                                        <div id="aadhaar_card_data_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
	                                    </div>
	                                    <!--  <div class="col-md-2 ">
	                                    	 <img src="<?php echo base_url().'uploads/emp_profile/aadhaar/'.$emp_master['aadhaar_card'] ?>" width="100" height="100"/>
	                                    </div> -->
	                                     
	                                   
									<?php
								}
								if($emp_master['certificate']!=NULL)
								{
									
								?>


									 <div class="form-group col-md-2" id="certificate_data">
	                                        <label>Certificate :</label>
	                                                <input type="file" name="certificate" id="certificate">
	                                        <div id="certificate_data_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
	                                    </div>
	                                    <div class="col-md-2 img2">
	                                    	 <img src="<?php echo base_url().'uploads/emp_profile/certificate/'.$emp_master['certificate'] ?>" width="100" height="100"/>
	                                    </div>

									<?php
								}
								else
								{
									
									?>
									 <div class="form-group col-md-2" id="certificate_data"  style="display: none">
	                                        <label>Certificate :</label>
	                                                <input type="file" name="certificate" id="certificate">
	                                        <div id="certificate_data_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
	                                    </div>
	                                   <!--  <div class="col-md-2">
	                                    	 <img src="<?php echo base_url().'uploads/emp_profile/certificate/'.$emp_master['certificate'] ?>" width="100" height="100"/>
	                                    </div> -->
									<?php
								}
								
								if($emp_master['fees']!=NULL)
								{
									
									?>
									<div class="form-group col-md-4" id="fees_data">
											<label>Fees(&#x20b9) *</label>
											<input type="text" class="form-control" placeholder="Fees" name="fees_name" id="fees_name" value="<?php echo $emp_master['fees']?>" onkeypress="return isNumberKey(event)"/>
											<div id="fees_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
											
										</div>
								<?php
							}
							else
							{
									
								?>
								<div class="form-group col-md-4" id="fees_data" style="display: none">
											<label>Fees(&#x20b9) *</label>
											<input type="text" class="form-control" placeholder="Fees" name="fees_name" id="fees_name" value="<?php echo $emp_master['fees']?>" onkeypress="return isNumberKey(event)"/>
											<div id="fees_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
											
										</div>
								<?php
							}
							?>
									
									
									
							   
									
									
								</div>	
								<br>
								<br>
								<?php
								$blank_image = base_url().'assets/media/users/blank.png';
								if(!empty($emp_master['proof_pic'])){
						
										$profile_image = base_url().'uploads/emp_profile/'.$emp_master['proof_pic'];
								}else{
						
											$profile_image = $blank_image;
								}
								?>
								<div class="row">
									<?php
									if($emp_master['proof_pic']!=NULL)
								{
									?>
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

													<?php
												}
												else
												{
													?>
													<div class="form-group col-md-4" id="profile_image_data" style="display: none;">
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
													<?php
												}
											?>

											<?php
									if($emp_master['license_no']!=NULL)
								{
									?>
													<div class="form-group col-md-4" id="license_no_data">
										<label>License No *</label>
										<input type="text" class="form-control" placeholder="License No" value="<?php echo $emp_master['license_no']?>" name="license_no" id="license_no" />
										<div id="license_no_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
									<?php
								}
								else
								{
									?>
									<div class="form-group col-md-4" id="license_no_data" style="display: none">
										<label>License No *</label>
										<input type="text" class="form-control" placeholder="License No" value="<?php echo $emp_master['license_no']?>" name="license_no" id="license_no" />
										<div id="license_no_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									<?php
								}
								?>
								</div>
								<div class="row">
										<div class="col-lg-3">
											<label>status</label>
											<select class="form-control select2" id="kt_select2_17" name="emp_status" >
												
												<option value="1" <?php if($emp_master['emp_status'] == 1 ) { echo "selected"; } ?>>Active</option>
												<option value="0" <?php if($emp_master['emp_status'] == 0 ) { echo "selected"; } ?>>Inactive</option>
											</select>
										
										</div>



								</div>
								<br>
								<div class="row">
									<div class="col-md-3">
											<div class="form-group">
											<label><b>City Permission*</b></label><br>

											<?php 
												$city_permission=explode(',',$emp_master['city_permission']);
												// $city_permission=implode(',',$city_permission);
												// echo $city_permission;                                                                                                     
									            foreach($city as $data){
									          ?>
									        	  <input type="checkbox" class="permission_check"  name="permission_city_id[]" <?php if(in_array($data['city_id'], $city_permission)){ echo "checked"; } ?> value="<?php echo $data['city_id']; ?>">&nbsp;&nbsp;	<?php echo $data['city']?> &nbsp;&nbsp;&nbsp;
											
												<?php }?>
											</div>
											<div id="permission_city_data_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
											
										</div>
								</div>


								
								
							</div>
												
							<div class="card-footer">
								<button type="submit" class="btn btn-primary mr-2" name="btn_update_employee" value="<?php echo $emp_master['emp_id']; ?>" id="btnSubmit">Update</button>
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

<script src="<?php echo base_url(); ?>assets/js/employee.js"></script>

<!-- <script type="text/javascript">
	$(":input").inputmask();

$("#contact_number").inputmask({"mask": "(999) 999-9999"});
</script> -->
<script type="text/javascript">
	jQuery(function() {
          // jQuery("#doctor_type_data").hide();
         
          // jQuery("#degree_data").hide();
          // jQuery("#registration_no_data").hide();
          // jQuery("#profile_image_data").hide();
          //  jQuery("#license_no_data").hide();
          
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
          		 jQuery("#aadhaar_card_data").show();
          		  jQuery("#certificate_data").show();
                 jQuery("#fees_data").show();
                  jQuery("#laboratory_name_show").hide();

          		
              }
              else if(value=="2")
              {
              	
              		jQuery("#license_no_data").hide();
              		 jQuery("#doctor_type_data").hide();
          			jQuery("#registration_no_data").show();
          			jQuery("#degree_data").show();
          			jQuery("#profile_image_data").show();
          			 jQuery("#aadhaar_card_data").show();
          		    jQuery("#certificate_data").show();
                    jQuery("#fees_data").hide();
                     jQuery("#laboratory_name_show").hide();
          			
              }
               else if(value=="3")
              {
              		 jQuery("#laboratory_name_show").show();
              		 jQuery("#registration_no_data").show();	
              		jQuery("#doctor_type_data").hide();
         
          			jQuery("#degree_data").hide();
          			
          			jQuery("#profile_image_data").hide();
           				jQuery("#license_no_data").hide();
           				jQuery("#aadhaar_card_data").hide();
             		jQuery("#certificate_data").hide();
                    jQuery("#fees_data").hide();
                     
          			
              }
              
             else if(value=="5")
              {
              		 jQuery("#doctor_type_data").hide();
          			jQuery("#registration_no_data").hide();
          			jQuery("#degree_data").hide();
          			jQuery("#license_no_data").show();
          			jQuery("#profile_image_data").show();
          			 jQuery("#aadhaar_card_data").show();
          		    jQuery("#certificate_data").hide();
                    jQuery("#fees_data").hide();
          			 jQuery("#laboratory_name_show").hide();
              }
              else
              {
              	 jQuery("#doctor_type_data").hide();
         
          			jQuery("#degree_data").hide();
          			jQuery("#registration_no_data").hide();
          			jQuery("#profile_image_data").hide();
           				jQuery("#license_no_data").hide();
           				jQuery("#aadhaar_card_data").hide();
             		jQuery("#certificate_data").hide();
                    jQuery("#fees_data").hide();
                     jQuery("#laboratory_name_show").hide();
              }
              
             
              

          });
});
</script>
<script type="text/javascript">
    $(function () {

        $("#btnSubmit").click(function () {
            var user_type_validate = $(".user_type_validate");
             var city_valid = $(".city_valid");
             var user_droplistID = $('.droplistID').val();
           
           
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


              if(user_droplistID==1)
            {

            	//alert($('.img1 img').attr('src'));

            	  var doctor_type_valid=$(".doctor_type_valid");
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

	            if ($('.img1 img').attr('src') =='') {
                
                	$('#aadhaar_card_data_valid').show();
                
                	return false;
	            }
	            else
	            {
	                 $('#aadhaar_card_data_valid').hide();
	            }


	            if ($('.img2 img').attr('src')=='') {
                
                	$('#certificate_data_valid').show();
                
                	return false;
	            }
	            else
	            {
	                 $('#certificate_data_valid').hide();
	            }

	             if ($("#fees_name").val()=='') {
                
                    $('#fees_name_valid').show();
        		
                   return false;
	            }
	            else
	            {
	            	 $('#fees_name_valid').hide();
	            }
	            return true;
            }

             if(user_droplistID==2)
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
	             if ($('.img1 img').attr('src') =='') {
                
                	$('#aadhaar_card_data_valid').show();
                
                	return false;
	            }
	            else
	            {
	                 $('#aadhaar_card_data_valid').hide();
	            }


	            if ($('.img2 img').attr('src')=='') {
                
                	$('#certificate_data_valid').show();
                
                	return false;
	            }
	            else
	            {
	                 $('#certificate_data_valid').hide();
	            }
	            return true;
            }
             if(user_droplistID=="3")
            {
            	 

	            if ($("#laboratory_name").val()=='') {
                
                $('#laboratory_name_valid').show();
        		
                return false;
            	}
	            else
	            {
	            	 $('#laboratory_name_valid').hide();
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


            if(user_droplistID==5)
            {
            	 

	            if ($("#license_no").val()=='') {
                
                $('#license_no_valid_id').show();
        		
               		 return false;
            	}
	            else
	            {
	            	 $('#license_no_valid_id').hide();
	            }
	             if ($('.img1 img').attr('src') =='') {
                
                	$('#aadhaar_card_data_valid').show();
                
                	return false;
	            }
	            else
	            {
	                 $('#aadhaar_card_data_valid').hide();
	            }
	           
	            return true;
            }
			return true;

        });
    });
</script>
<script type="text/javascript">
	function isNumberKey(evt) {
   var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
}
</script>


