<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Ambulance Appointment</h5>
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
						<form id="add_pharmacy_employee_form" class="form" action="<?php echo base_url(); ?>insertAmbulanceAppointment" id="add_ambulance_appointment_form" method="post" enctype="multipart/form-data">
								<!-- <div class="card-header">
									<h3 class="card-title">
										Add Doctor Appointment
									</h3>
								</div> -->
								<div class="card-body">

								 <div class="row">
									<div class="form-group col-md-6">
										<label><b>User *</b></label>
										<select class="form-control select2  user_type_validate" id="kt_select2_1" name="user_id" required="" >
											<option value="" selected disabled hidden> Select User</option>
											<?php 
												foreach($user as $u){
													if($u['first_name']!='' || $u['last_name']!='' || $u['mobile']!='')
													{
														echo '<option value="'.$u['user_id'].'">'.$u['first_name']." ".$u['last_name']." - ".$u['mobile'].'</option>';
													}
													
												}
											?>
										</select>
										 <div id="user_type_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
									
									
									
							    	</div>
							    
							    <div class="row">
							    	<div class="form-group col-md-3">
											<label><b>First Name *</b></label>
											<input type="text" class="form-control" placeholder="Enter Name" name="first_name" id="first_name"/>
											<div id="first_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										<div class="form-group col-md-3">
											<label><b>Last Name *</b></label>
											<input type="text" class="form-control" placeholder="Enter Name" name="last_name" id="last_name"/>
											<div id="last_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										
							    </div>

							    <div class="row">
							    	<div class="form-group col-md-3">
											<label><b>Age *</b></label>
											<input type="number" class="form-control" placeholder="Enter Age" name="age" id="age"/>
											<div id="age_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							    	<div class="form-group col-md-3">
											<label><b>Gender *</b></label>
											<select  class="form-control select2  gender_type_validate" id="kt_select2_16" name="gender" required="" > 
												<option value="" selected disabled hidden>Select Gender</option>
												<option value="Male">Male</option>
												<option value="Female">Female</option>
											</select>
											<div id="gender_type_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										
							    </div>
							    <div class="row">
							    	<div class="form-group col-md-2">
											<label><b>Mobile No1 *</b></label>
											<input type="text" class="form-control" placeholder="Enter Number" name="mobile1" id="mobile1" onkeypress="return isNumber(event)"  maxlength="10"/>
											<div id="mobile1_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										<div class="form-group col-md-2">
											<label><b>Mobile No2 *</b></label>
											<input type="text" class="form-control" placeholder="Enter Number" name="mobile2" id="mobile2" onkeypress="return isNumber(event)"  maxlength="10"/>
											<div id="mobile2_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										<div class="form-group col-md-2">
											<label><b>Landline *</b></label>
											<input type="number" class="form-control" placeholder="Enter Number" name="landline" id="landline" />
											<div id="landline_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							    </div>
							     <div class="row">
							    	
										
										<div class="form-group col-md-3">
											<label><b>From Address *</b></label>
											<textarea class="form-control" name="from_address" id="from_address"></textarea>
											<div id="from_address_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										<div class="form-group col-md-3">
											<label><b>To Address *</b></label>
											<textarea class="form-control" name="to_address" id="to_address"></textarea>
											<div id="to_address_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							    </div>
							  

								  <div class="row">
							    	<div class="form-group col-md-2">
											<label><b>Country *</b></label>
											<input type="hidden" name="country_id" value="1" />

											<select class="form-control select2  country_validate" id="kt_select2_11" name="country_id" required="" disabled  >
												<!-- <option value="" selected disabled hidden>Select Country</option> -->
												<option value="1" selected="">India</option>
												

											</select>
											<div class="validation"></div>
										</div>
										<div class="form-group col-md-2">
											<label><b>State *</b></label>
											<input type="hidden" name="state_id" value="12" />
											<select class="form-control select2  state_validate" id="kt_select2_13" name="state_id" required="" disabled  >
												<option value="" selected disabled hidden>Select State</option>
												<option value="12" selected="">Gujarat (GJ)</option>
												

											</select>
											<div class="validation"></div>
										</div>
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
								 	
								 	  <div class="row">
								 	  	<div class="form-group col-md-6">
											<label><b>Condition *</b></label>
											<textarea class="form-control" name="condition" id="condition"></textarea>
											<div id="condition_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										</div>
										
							   
								<div class="row">
							    	<div class="form-group col-md-2">
											<label><b>Date *</b></label>
											<input type="date" class="form-control" placeholder="DD/MM/YY" name="date" id="date"/>
											<div id="date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										<div class="form-group col-md-2">
											<label><b>Time *</b></label>
											<input type="time" class="form-control" placeholder="HH:MM" name="time" id="time"/>
											<div id="time_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
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
            var user_type_validate = $(".user_type_validate");
              var gender_type_validate = $(".gender_type_validate");
             var city_valid = $(".city_valid");
           
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

            if ($("#age").val()=='') {
                
                $('#age_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#age_valid').hide();
            }

            if (gender_type_validate.val() == null) {
                
                $('#gender_type_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#gender_type_valid').hide();
            }

            if ($("#mobile1").val()=='') {
                
                $('#mobile1_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#mobile1_valid').hide();
            }

            if ($("#mobile2").val()=='') {
                
                $('#mobile2_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#mobile2_valid').hide();
            }

            if ($("#landline").val()=='') {
                
                $('#landline_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#landline_valid').hide();
            }

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


            if ($("#condition").val()=='') {
                
                $('#condition_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#condition_valid').hide();
            }

              if ($("#date").val()=='') {
                
                $('#date_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#date_valid').hide();
            }

              if ($("#time").val()=='') {
                
                $('#time_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#time_valid').hide();
            }
			return true;

        });
    });
</script>
