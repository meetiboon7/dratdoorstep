<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">E-Pharmacy Appointment</h5>
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
						<form id="add_pharmacy_employee_form" class="form" action="<?php echo base_url(); ?>insertPharmacyAppointment" id="add_pharmacy_appointment_form" method="post" enctype="multipart/form-data">
								<!-- <div class="card-header">
									<h3 class="card-title">
										Add Doctor Appointment
									</h3>
								</div> -->
								<div class="card-body">

								
							    
							    <div class="row">
							    		<div class="form-group col-md-4">
											<label><b>Contact Name *</b></label>
											<input type="text" class="form-control" placeholder="Enter Name" name="name" id="name"/>
											<div id="name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										
										
							    </div>

							    <div class="row">
							    	<div class="form-group col-md-2">
											<label><b>Contact Mobile *</b></label>
											<input type="text" class="form-control" placeholder="Enter Number" name="mobile" id="mobile" onkeypress="return isNumber(event)"  maxlength="10"/>
											<div id="mobile_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										
										<div class="form-group col-md-2">
											<label><b>Landline *</b></label>
											<input type="number" class="form-control" placeholder="Enter Number" name="landline" id="landline" />
											<div id="landline_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							    </div>
							     <div class="row">
							    	
										
										<div class="form-group col-md-3">
											<label><b>Delivery Address *</b></label>
											<textarea class="form-control" name="address" id="address"></textarea>
											<div id="address_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										
							    </div>
							  

								  <div class="row">
							    	
										
										<div class="form-group col-md-2">
											<label><b>City *</b></label>
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
								 	
								 	  
										
							   
								<?php
								$blank_image = base_url().'assets/media/users/blank.png';
								if(!empty($view_user_profile->profile_pic)){
						
										$profile_image = base_url().'uploads/emp_profile/'.$view_user_profile->profile_pic;
								}else{
						
											$profile_image = $blank_image;
								}
								?>
								<?php
                			if (isset($error)){
                    				echo "hii".$error;
                			}
            				?>
								 	
							<div class="row">
									
									<div class="form-group col-md-4" id="profile_image_data">
														<label style="margin-bottom:10px;">Prescription </label>&nbsp;&nbsp;
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

									
								</div>
								
								
								
								
							</div>
												
							<div class="card-footer">
								<button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Save</button>
								<a href="<?php echo base_url(); ?>adminAppointmentList" class="btn btn-secondary">Cancel</a>
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
    $(function () {

        $("#btnSubmit").click(function () {
            
            
             var city_valid = $(".city_valid");
           
            

            if ($("#name").val()=='') {
                
                $('#name_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#name_valid').hide();
            }

            

            

            

            if ($("#mobile").val()=='') {
                
                $('#mobile_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#mobile_valid').hide();
            }

            

            if ($("#landline").val()=='') {
                
                $('#landline_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#landline_valid').hide();
            }

            if ($("#address").val()=='') {
                
                $('#address_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#address_valid').hide();
            }

            



            if (city_valid.val() == null) {
                
                $('#city_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#city_valid_id').hide();
            }


            


              
			return true;

        });
    });
</script>
