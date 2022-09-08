<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Manage Fees</h5>
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
						<form id="add_fees_form" class="form" action="<?php echo base_url(); ?>updateManageFees" method="post" enctype="multipart/form-data">
								<div class="card-header">
									<h3 class="card-title">
										Edit Fees Info
									</h3>
								</div>
								<div class="card-body">

								<div class="row">
									<div class="form-group col-md-4">
										<label>Fees Type * </label>
										<select class="form-control select2 droplistID fees_type_validate" id="kt_select2_1" name="fees_type_id" >
											<option value="none" selected disabled hidden> Select Fees Type </option>
											<?php 
												foreach($fees_type as $ft){
														$selected_type = "";
													if($ft['fees_type_id'] == $manage_fees['fees_type_id']){ $selected_type = "selected"; }
													echo '<option value="'.$ft['fees_type_id'].'" '.$selected_type.'>'.$ft['fees_type_name'].'</option>';
													
												}
											?>

											
										</select>
										<div id="fees_type_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									<div class="form-group col-md-2">
											<label>Start Time *</label>
											<input type="time" class="form-control form-control-solid h-auto py-4 px-8 isRequired" placeholder="HH:MM" name="from_time" id="from_time" value="<?php  echo $manage_fees['from_time']?>" />
											<div id="from_time_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									<div class="form-group col-md-2">
											<label>End Time *</label>
											<input type="time" class="form-control form-control-solid h-auto py-4 px-8 isRequired" placeholder="HH:MM" name="to_time" id="to_time" value="<?php  echo $manage_fees['to_time']?>" />
											<div id="to_time_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									<div class="form-group col-md-4" >
										<label>Fees(R.S) *</label>
										<input type="text" class="form-control"  placeholder="Fees" name="fees_name" id="fees_name" value="<?php  echo $manage_fees['fees_name']?>"  onkeypress="return isNumber(event)"/>
										<div id="fees_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
									
							    </div>

							    

								

								 <div class="row">

								 	
							    	
									<div class="form-group col-md-4">
										<label>City *</label>
										<select class="form-control select2 city_valid" id="kt_select2_14" name="city_id" >
											<option value="none" selected disabled hidden> Select City </option>
											<?php 
												foreach($city as $c){
													$selected_city = "";
													if($c['city_id'] == $manage_fees['city_id']){ $selected_city = "selected"; }

													echo '<option value="'.$c['city_id'].'" '. $selected_city.'>'.$c['city'].'</option>';
												}
											?>
										</select>
										<div id="city_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
								</div>

									<div class="form-group col-md-4">
										<label>Role *</label>
										<select class="form-control select2 role_valid" id="kt_select2_3" name="role_id" >
											<option value="none" selected disabled hidden> Select Role </option>
											<?php 
												foreach($manage_roles as $role){
													$selected_role = "";
													if($role['role_id'] == $manage_fees['role_id']){ $selected_role = "selected"; }
													echo '<option value="'.$role['role_id'].'" '.$selected_role.'>'.$role['role_name'].'</option>';
												}
											?>
										</select>
										<div id="role_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
									
									<div class="form-group col-md-4">
										<label>Status</label>
										<select class="form-control select2" id="kt_select2_17" name="fees_status" >
												
												<option value="1" <?php if($manage_fees['fees_status'] == 1 ) { echo "selected"; } ?>>Active</option>
												<option value="0" <?php if($manage_fees['fees_status'] == 0 ) { echo "selected"; } ?>>Inactive</option>
											</select>
										
								</div>

									
								
							   
									
									
								</div>	

								
								
							</div>
												
							<div class="card-footer">
								
								<button type="submit" id="btnSubmit" class="btn btn-primary mr-2" name="btn_update_manage_fees" value="<?php echo $manage_fees['fees_id']; ?>">Update</button>
								<a href="<?php echo base_url(); ?>adminManageFees" class="btn btn-secondary">Cancel</a>
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
            var fees_type_validate = $(".fees_type_validate");
            
            var city_valid = $(".city_valid");
              var role_valid = $(".role_valid");
           
            if (fees_type_validate.val() == null) {
                
                $('#fees_type_id').show();
        		
                return false;
            }
            else
            {
            	 $('#fees_type_id').hide();
            }

            if ($("#from_time").val()=='') {
                
                $('#from_time_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#from_time_valid').hide();
            }

             if ($("#to_time").val()=='') {
                
                $('#to_time_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#to_time_valid').hide();
            }

             if ($("#fees_name").val()=='') {
                
                $('#fees_name_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#fees_name_valid').hide();
            }
            

            if (city_valid.val() == null) {
                
                $('#city_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#city_valid_id').hide();
            }

            if (role_valid.val() == null) {
                
                $('#role_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#role_valid_id').hide();
            }
			return true;

        });
    });
</script>




