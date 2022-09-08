<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Lab Report</h5>
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
						<form id="add_address_form" class="form" action="<?php echo base_url(); ?>generateLabReport"  method="post" enctype="multipart/form-data">
								<div class="card-header">
									<!-- <h3 class="card-title">
										Add Address Info
									</h3> -->
									<span style="color:grey;"> <?php echo $this->session->flashdata('message'); ?> </span>
								</div>
								<div class="card-body">

								
									    
									    <div class="form-group col-md-4">
												<label>From Date *</label>
												<input type="date" class="form-control"   placeholder="Date of Birth" name="from_date" value="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d');?>"/>
												<div class="validation"></div>
										</div>

										<div class="form-group col-md-4">
												<label>To Date *</label>
												<input type="date" class="form-control"   placeholder="Date of Birth" name="to_date" value="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d');?>"/>
												<div class="validation"></div>
										</div>
									    


							    	
								</div>	


								

								
								

							
												
							 <div class="card-footer">
								<button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Save</button>
								<!-- <a href="<?php echo base_url(); ?>adminLabReport" class="btn btn-secondary">Cancel</a> -->
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
           //var city_valid = $(".city_valid");
             

            if ($("#title").val()=='') {
                
                $('#title_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#title_valid').hide();
            }

            if ($("#message").val()=='') {
                
                $('#message_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#message_valid').hide();
            }

            return true;

        });
    });
</script>


