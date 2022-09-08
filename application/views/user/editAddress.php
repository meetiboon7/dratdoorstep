<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Address Master</h5>
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
						<form id="add_address_form" class="form" action="<?php echo base_url(); ?>updateAddress"  method="post" enctype="multipart/form-data">
								<div class="card-header">
									<!-- <h3 class="card-title">
										Edit Address Info
									</h3> -->
								</div>
								<div class="card-body">

								<div class="row">
									
									<div class="form-group col-md-4">
										<label>Address 1 *</label>
										<input type="text" class="form-control" value="<?php echo $address_member['address_1']?>" placeholder="Enter Name" name="address_1" id="address_1"/>
										<div id="address_1_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>

									<div class="form-group col-md-4">
										<label>Address 2 *</label>
										<input type="text" class="form-control" value="<?php echo $address_member['address_2']?>" placeholder="Enter Name" name="address_2" id="address_2"/>
										<div id="address_2_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									
									 <div class="form-group col-md-4">
											<label><b>Country *</b></label>
											<input type="hidden" name="country_id" value="1" />

											<select class="form-control select2  country_validate" id="kt_select2_3" name="country_id" required="" disabled  >
												
												<option value="1" selected="">India</option>
												

											</select>
											<div id="country_id_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
								
									
							    </div>

							   
								

							    <div class="row">
							    	
									
									<div class="form-group col-md-4">
											<label><b>State *</b></label>
											<input type="hidden" name="state_id" value="12" />
											<select class="form-control select2  state_validate" id="kt_select2_13" name="state_id" required="" disabled  >
												<!-- <option value="" selected disabled hidden>Select State</option> -->
												<option value="12" selected="">Gujarat (GJ)</option>
												

											</select>
											<div id="state_id_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
								</div>
									<div class="form-group col-md-4">
										<label>City *</label>
										<select class="form-control select2 city_valid" id="kt_select2_14" name="city_id" >
											<option value="none" selected disabled hidden> Select City </option>
											<?php 
												foreach($city as $c){

													$selected_city = "";
													
													if($c['city_id'] == $address_member['city_id']){ $selected_city = "selected"; }
													echo '<option value="'.$c['city_id'].'" '.$selected_city.'>'.$c['city'].'</option>';
												}
											?>
										</select>
										
									</div>
									<div id="city_id_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
							   
									<div class="form-group col-md-4">
										<label>Pincode</label>
										<input type="text" class="form-control"   placeholder="Pincode" name="pincode"  value="<?php echo $address_member['pincode']?>" onkeypress="return isNumber(event)" maxlength="8" />
										<div id="pincode_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									
								</div>	

								

								 <div class="row">
							    	
									
									


									<div class="form-group col-md-4">
											<label>status</label>
											<select class="form-control select2" id="kt_select2_17" name="status" >
												
												<option value="1" <?php if($address_member['status'] == 1 ) { echo "selected"; } ?>>Active</option>
												<option value="0" <?php if($address_member['status'] == 0 ) { echo "selected"; } ?>>Inactive</option>
											</select>
										
										</div>
								
									
								</div>	

								

							
												
							<div class="card-footer">
								
								<button type="submit" class="btn btn-primary mr-2" name="btn_update_address" id="btnSubmit" value="<?php echo $address_member['address_id']; ?>">Update</button>
								<a href="<?php echo base_url(); ?>userAddress" class="btn btn-secondary">Cancel</a>
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
             

            if ($("#address_1").val()=='') {
                
                $('#address_1_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#address_1_valid').hide();
            }

            if ($("#address_2").val()=='') {
                
                $('#address_2_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#address_2_valid').hide();
            }

            

            if (city_valid.val() == null) {
                
                $('#city_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#city_valid_id').hide();
            }

            // if ($("#pincode").val()=='') {
                
            //     $('#pincode_valid_id').show();
        		
            //     return false;
            // }
            // else
            // {
            // 	 $('#pincode_valid_id').hide();
            // }

            
			return true;

        });
    });
</script>


