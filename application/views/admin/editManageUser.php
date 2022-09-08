<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Manage User</h5>
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
						<form id="add_user_manage_form" class="form" action="<?php echo base_url(); ?>updateManageUser" method="post" enctype="multipart/form-data">
								<div class="card-header">
									<h3 class="card-title">
										Edit Manage User
									</h3>
								</div>
								<div class="card-body">

								<div class="row">
									<div class="form-group col-md-4">
										<label>Select Employee *</label>
										<select class="form-control select2 emp_valid" id="kt_select2_17" name="emp_id" >
											<option value="none" selected disabled hidden> Select Employee </option>

											<?php 
												foreach($employee_master as $em){
													$selected_emp = "";
													if($em['emp_id'] == $user_manage['emp_id']){ $selected_emp = "selected"; }
													echo '<option value="'.$em['emp_id'].'" '. $selected_emp.'>'.$em['first_name']." ".$em['last_name'].'</option>';
												}
											?>
										</select>
										<div id="emp_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>

									<div class="form-group col-md-4">
										<label>Role *</label>
										<select class="form-control select2 role_valid" id="kt_select2_2" name="role_id" >
											<option value="none" selected disabled hidden> Select Role </option>

											<?php 
												foreach($manage_roles as $mr){
													$selected_role = "";
													if($mr['role_id'] == $user_manage['role_id']){ $selected_role = "selected"; }

													echo '<option value="'.$mr['role_id'].'" '. $selected_role.'>'.$mr['role_name'].'</option>';
												}
											?>
										</select>
										<div id="role_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
									
									
									
							    </div>

							    


								<div class="row">
									
									
									<div class="form-group col-md-4">
										<label>Status</label>
										<select class="form-control select2" id="kt_select2_16" name="status" >
												
												<option value="1" <?php if($user_manage['status'] == 1 ) { echo "selected"; } ?>>Active</option>
												<option value="0" <?php if($user_manage['status'] == 0 ) { echo "selected"; } ?>>Inactive</option>
											</select>
										
									</div>

								
								
							</div>
												
							<div class="card-footer">
								<button type="submit" class="btn btn-primary mr-2" name="btn_update_manage_user" value="<?php echo $user_manage['user_m_id']; ?>" id="btnSubmit">Update</button>
								<a href="<?php echo base_url(); ?>adminManageUser" class="btn btn-secondary">Cancel</a>
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
          
             var emp_valid = $(".emp_valid");
              var role_valid = $(".role_valid");
              //var emp_valid = $(".emp_valid");
             // alert(emp_valid);
            if (emp_valid.val() == null) {
                
                $('#emp_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#emp_valid_id').hide();
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



