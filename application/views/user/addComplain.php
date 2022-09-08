<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Feedback</h5>
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
						<form id="add_complain_form" class="form" action="<?php echo base_url(); ?>insertComplain"  method="post" enctype="multipart/form-data">
								<div class="card-header">
									<div class="card-title">
										<!-- 	<h3 class="card-label">Address </h3> -->

											<span style="color:grey;"> <?php echo $this->session->flashdata('message'); ?> </span>
										</div>
									<!-- <h3 class="card-title">
										Add Address Info
									</h3> -->
								</div>
								<div class="card-body">

								<div class="row">
									
									<div class="form-group col-md-6">
										<label>Option *</label>
										<select class="form-control select2 feedback_option_valid" id="kt_select2_14" name="feedback_options_id" >
											<option value="none" selected disabled hidden> Select Feedback Option </option>
											<?php 
												foreach($feedback_options as $fo){
													echo '<option value="'.$fo['feedback_options_id'].'">'.$fo['name'].'</option>';
												}
											?>
										</select>
										<div id="option_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>

									
											
									
							    </div>
							    <div class="row">
									
									<div class="form-group col-md-6">
										<label>Service *</label>
										<select class="form-control select2 feedback_service_valid" id="kt_select2_13" name="type" >
											<option value="none" selected disabled hidden> Select Service </option>
											<?php 
												foreach($feedback_services as $fs){
													echo '<option value="'.$fs['feedback_services_id'].'">'.$fs['name'].'</option>';
												}
											?>
										</select>
										<div id="service_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>

									
											
									
							    </div>
							   
								
							    <div class="row">
							   
									<div class="form-group col-md-6">
										<label>Description *</label>
										<textarea  class="form-control"   placeholder="Description" name="problem" id="desc"></textarea>
										<div id="desc_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									
								</div>	


								

							
								

							
												
							 <div class="card-footer">
								<button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Save</button>
								<!-- <a href="<?php echo base_url(); ?>userComplain" class="btn btn-secondary">Cancel</a> -->
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
           var feedback_option_valid = $(".feedback_option_valid");
            var feedback_service_valid = $(".feedback_service_valid");


            if (feedback_option_valid.val() == null) {
                
                $('#option_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#option_valid_id').hide();
            }

            if (feedback_service_valid.val() == null) {
                
                $('#service_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#service_valid_id').hide();
            }

              if ($("#desc").val()=='') {
                
                $('#desc_id').show();
                
                return false;
            }
            else
            {
                 $('#desc_id').hide();
            }


            

            

            
			return true;

        });
    });
</script>


