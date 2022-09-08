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
						<form id="add_fees_form" class="form" action="<?php echo base_url(); ?>insertManagePackage" method="post" enctype="multipart/form-data">
								<div class="card-header">
									<h3 class="card-title">
										Add Package Info
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
													echo '<option value="'.$c['city_id'].'">'.$c['city'].'</option>';
												}
											?>
										</select>
										 <div id="city_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
								</div>

								<div class="form-group col-md-4">
										<label>Services *</label>
										<select class="form-control select2 service_valid" id="kt_select2_4" name="service_id" >
											<option value="none" selected disabled hidden> Select Service </option>
											<?php 
												foreach($service as $s){
													echo '<option value="'.$s['user_type_id'].'">'.$s['user_type_name'].'</option>';
												}
											?>
										</select>
										 <div id="service_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
								</div>

									
									<div class="form-group col-md-4">
											<label>Package Name *</label>
											<input type="text" class="form-control isRequired" placeholder="Package Name" name="package_name" id="package_name" required="" />
											<div id="package_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									
									
							    </div>

							    

								

								 <div class="row">

								 	<div class="form-group col-md-4" >
										<label>Fees(&#x20b9) *</label>
										<input type="text" class="form-control" placeholder="Fees" name="fees_name" id="fees_name" onkeypress="return isNumberKey(event)"/>
										<div id="fees_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
							    	
							    	<div class="form-group col-md-4" >
										<label>Number of Visit *</label>
										<input type="number" class="form-control" placeholder="Number of Visit" name="no_visit" id="no_visit" />
										<div id="no_visit_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>

									<div class="form-group col-md-4" >
										<label>Validity(Days) *</label>
										<!-- <input type="number" class="form-control" placeholder="Validate Month" name="validate_month" id="validate_month" min="0" max="36" /> -->
											<div class="form-group">
									<input class="form-control" type="text" placeholder="Validate Days" name="validate_month" id="validate_month"  onkeypress="return isNumber(event)" maxlength="3"/>
									<div id="validate_month_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
											</div>
										
									</div>
									

									
									
								
							   
									
									
								</div>

								<div class="row">
									<div class="form-group col-md-12">
										<label>Description *</label>
										<textarea class="form-control" name="description" required="" id="editor1"></textarea>
										<div id="description_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									
									
								</div>	
								<div class="row">
									<div class="form-group col-md-4">
										<label>Status</label>
										<select class="form-control select2"  name="package_status"  id="kt_select2_16">
											<option value="1">Active</option>
											<option value="0">Inactive</option>
										</select>
										
								</div>
								</div>

								
								
							</div>
												
							<div class="card-footer">
								<button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Save</button>
								<a href="<?php echo base_url(); ?>adminManagePackage"  class="btn btn-secondary">Cancel</a>
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
              var service_valid = $(".service_valid");
             
           
           if (city_valid.val() == null) {
                
                $('#city_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#city_valid_id').hide();
            }

            if (service_valid.val() == null) {
                
                $('#service_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#service_valid_id').hide();
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
            
            //var desc = CKEDITOR.instances.description.getData();
            var ckValue = CKEDITOR.instances["editor1"].getData();
           // alert(ckValue);
            if (ckValue=='') {
                
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
	function isNumberKey(evt) {
   var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
}
</script>


