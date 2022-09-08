<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Manage Package</h5>
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
						<form id="add_package_form" class="form" action="<?php echo base_url(); ?>updateManagePackage" method="post" enctype="multipart/form-data">
								<div class="card-header">
									<h3 class="card-title">
										Edit Package Info
									</h3>
								</div>
								<div class="card-body">

								<div class="row">
									<div class="form-group col-md-4">
										<label>City *</label>
										<select class="form-control select2 city_valid" id="kt_select2_14" name="city_id" >
											<option value="none" selected disabled hidden> Select City </option>
											<?php 
												foreach($city as $c){
													$selected_city = "";
													if($c['city_id'] == $manage_package['city_id']){ $selected_city = "selected"; }

													echo '<option value="'.$c['city_id'].'" '. $selected_city.'>'.$c['city'].'</option>';
												}
											?>
										</select>
										<div id="city_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>

									<div class="form-group col-md-4">
											<label>Service Name *</label>
											<input type="text" class="form-control isRequired" placeholder="Service Name" value="<?php echo $manage_package['service_name'] ?>" name="service_name" id="service_name"/>
											<div id="service_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									<div class="form-group col-md-4">
											<label>Package Name</label>
											<input type="text" class="form-control isRequired" placeholder="Package Name" value="<?php echo $manage_package['package_name'] ?>" name="package_name" id="package_name"/>
											<div id="package_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>

									
									
							    </div>

							    

								

								 <div class="row">

								 	
							    	
									<div class="form-group col-md-4" >
										<label>Fees(R.S) *</label>
										<input type="text" class="form-control"  placeholder="Fees Name" name="fees_name" id="fees_name" value="<?php  echo $manage_package['fees_name']?>" onkeypress="return isNumber(event)"/>
										<div id="fees_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>

									<div class="form-group col-md-4" >
										<label>Number of Visit *</label>
										<input type="number" class="form-control" placeholder="Number of Visit" name="no_visit" id="no_visit" value="<?php  echo $manage_package['no_visit']?>" />
										<div id="no_visit_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>

									<div class="form-group col-md-4" >
										<label>Validity(Months) *</label>
										<!-- <input type="number" class="form-control" placeholder="Validate Month" name="validate_month" id="validate_month" min="0" max="36" /> -->
											<div class="form-group">
									<input class="form-control" type="text" placeholder="Validate Month" name="validate_month" id="validate_month"  onkeypress="return isNumber(event)" maxlength="3" value="<?php  echo $manage_package['validate_month']?>"/>
										
											</div>
											<div id="validate_month_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>

									
								
							   
									
									
								</div>	
								<div class="row">
									<div class="form-group col-md-4">
										<label>Description *</label>
										<textarea class="form-control" name="description" id="description" rows="3" cols="30"><?php  echo $manage_package['description']?></textarea>
										<div id="description_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>

									
									<div class="form-group col-md-4">
										<label>Status</label>
										<select class="form-control select2" id="kt_select2_17" name="package_status" >
												
												<option value="1" <?php if($manage_package['package_status'] == 1 ) { echo "selected"; } ?>>Active</option>
												<option value="0" <?php if($manage_package['package_status'] == 0 ) { echo "selected"; } ?>>Inactive</option>
											</select>
										
									</div>

								</div>

								
								
							</div>
												
							<div class="card-footer">
								
								<button type="submit" class="btn btn-primary mr-2" name="btn_update_manage_package" value="<?php echo $manage_package['package_id']; ?>" id="btnSubmit">Update</button>
								<a href="<?php echo base_url(); ?>adminManagePackage" class="btn btn-secondary">Cancel</a>
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
             
           
           if (city_valid.val() == null) {
                
                $('#city_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#city_valid_id').hide();
            }

            if ($("#service_name").val()=='') {
                
                $('#service_name_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#service_name_valid').hide();
            }

            if ($("#package_name").val()=='') {
                
                $('#package_name_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#package_name_valid').hide();
            }

          if ($("#fees_name").val()=='') {
                
                $('#fees_name_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#fees_name_valid').hide();
            }

             if ($("#no_visit").val()=='') {
                
                $('#no_visit_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#no_visit_valid').hide();
            }


             if ($("#validate_month").val()=='') {
                
                $('#validate_month_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#validate_month_valid').hide();
            }

            if ($("#description").val()=='') {
                
                $('#description_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#description_valid').hide();
            }


            
			return true;

        });
    });
</script>


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




