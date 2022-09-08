<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Member Master</h5>
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
						<form id="add_member_form" class="form" action="<?php echo base_url(); ?>insertMember"  method="post" enctype="multipart/form-data">
								<div class="card-header">
									<!-- <h3 class="card-title">
										Add Member Info
									</h3> -->
								</div>
								<div class="card-body">

								<div class="row">
									
									<div class="form-group col-md-4">
										<label>Name *</label>
										<input type="text" class="form-control" placeholder="Enter Name" name="name" id="name"/>
										<div id="name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										<!-- <div class="form-group"> 
											<label>Not found patient above ? <a href="add_patient.php">Click here</a></label>
										</div> -->
									</div>
									<div class="form-group col-md-4">
										<label>Contact No *</label>
										<input type="text" class="form-control" onkeypress="return isNumber(event)"  maxlength="10" placeholder="Contact No" name="contact_no" id="contact_no"/>
										<div id="contact_no_valid" class="validation" style="display:none;color:red;">Please Enter 10 digit number Value</div>
									</div>
									<?php
								$blank_image = base_url().'assets/media/users/blank.png';
								if(!empty($view_user_profile->profile_pic)){
						
										$profile_image = base_url().'uploads/emp_profile/'.$view_user_profile->profile_pic;
								}else{
						
											$profile_image = $blank_image;
								}
								?>
								<div class="col-md-2" style="margin-top: 35px;">
									<label >Profile Image</label>
								</div>
									<div class="form-group col-md-2"  >
														&nbsp;&nbsp;
														<div class="image-input image-input-empty image-input-outline" id="div_profile_image"  style="background-image: url('<?php echo $profile_image ?>');margin-left:-45%;" >
														<div class="image-input-wrapper"   ></div>
														<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
															<i class="fa fa-pen icon-sm text-muted"></i>
														  	<input type="file" name="img_profile" accept=".png, .jpg, .jpeg" id="img_profile"/>
														  	<input type="hidden" name="profile_avatar_remove"/>
														</label>

														<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
															<i class="ki ki-bold-close icon-xs text-muted"></i>
														</span>

														<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
															<i class="ki ki-bold-close icon-xs text-muted"></i>
														</span>
													</div>
													<div id="profile_image_validate" class="validation" style="display:none;color:red;">Please Select Profile image</div>
													</div>
													

									
											
									
							    </div>

							    

								 <div class="row">
							    	
									
									<div class="form-group col-md-4" style="margin-top: -5%;">
										<label>Gender *</label>
										<select class="form-control select2 gender_valid"  name="gender"  id="kt_select2_2">
											<option value="none" selected disabled hidden> Select Gender </option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
										</select>
										<div id="gender_validate" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
									<div class="form-group col-md-4" style="margin-top: -5%;">
										<label>Date of Birth</label>
										<input type="date" class="form-control"   placeholder="Date of Birth" name="date_of_birth" id="date_of_birth" max="<?php echo date('Y-m-d');?>" />
										<div id="date_of_birth_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									</div>
									<!-- <div class="row">
							    	
									
									
									<div class="form-group col-md-4" style="margin-top: -5%;">
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
							   
									<div class="form-group col-md-4" style="margin-top: -5%;">
										<label>Address *</label>
										<textarea class="form-control"  placeholder="Enter Address Line" name="address" id="address"></textarea> 
										<div id="address_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
									
								</div>	 -->
								<div class="row">
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
										<div class="form-group col-md-4">
										<label>Status</label>
										<select class="form-control select2"  name="status"  id="kt_select2_16">
											<option value="1">Active</option>
											<option value="0">Inactive</option>
										</select>
										
								</div>
								</div>
									
									

								

							
												
							<div class="card-footer">
								<button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Save</button>
								<a href="<?php echo base_url(); ?>userMember" class="btn btn-secondary">Cancel</a>
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
    $(function () {

        $("#btnSubmit").click(function () {
           var city_valid = $(".city_valid");
           var gender_valid = $(".gender_valid");
             

            // alert($("#img_profile").val());
             // alert($('#img_profile').val());
            if ($("#name").val()=='') {
                
                $('#name_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#name_valid').hide();
            }

   //          if ($("#contact_no").val()=='') {
                
   //              $('#contact_no_valid').show();
        		
   //              return false;
   //          }
			// else
   //          {
   //          	 $('#contact_no_valid').hide();
   //          }

             var mobile_count = $('#contact_no').val().length;
             //alert(mobile_count);
            
            
            if(mobile_count <= 10 && mobile_count >= 10)
            {
                $('#contact_no_valid').hide();
        		
            }
            else
            {
                  $('#contact_no_valid').show();
                   return false;
            }

            if (gender_valid.val() == null) {
                
                $('#gender_validate').show();
        		
                return false;
            }
            else
            {
            	 $('#gender_validate').hide();
            }

//             if ($("#date_of_birth").val()=='') {
                
//                 $('#date_of_birth_valid').show();
        		
//                 return false;
//             }
// 			else
//             {
//             	 $('#date_of_birth_valid').hide();
//             }

            if (city_valid.val() == null) {
                
                $('#city_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#city_valid_id').hide();
            }

           // if()

		
            	
            //  if ($("#img_profile").val()=='') {
                
            //     $('#profile_image_validate').show();
                
            //     return false;
            // }
            // else
            // {
            //      $('#profile_image_validate').hide();
            // }

            
			return true;

        });
    });
</script>


