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
						<form id="add_member_form" class="form" action="<?php echo base_url(); ?>adminupdateMember"  method="post" enctype="multipart/form-data">
								<div class="card-header">
								<!-- 	<h3 class="card-title">
										Edit Member Info
									</h3> -->
								</div>
								<div class="card-body">

								<div class="row">
									
									<div class="form-group col-md-4">
										<label>Name *</label>
										<input type="text" class="form-control" value="<?php echo $member['name']?>" placeholder="Enter Name" name="name" id="name"/>
										<div id="name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									
								
									
								</div>	

								</div>

							
												
							<div class="card-footer">
								
								<button type="submit" class="btn btn-primary mr-2" name="btn_update_member" id="btnSubmit" value="<?php echo $member['member_id']; ?>">Update</button>
								<a href="<?php echo base_url(); ?>adminAllPatient" class="btn btn-secondary">Cancel</a>
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
          
             
        //  alert($("#img_profile").val());
            if ($("#name").val()=='') {
                
                $('#name_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#name_valid').hide();
            }

            

             
            

            
			return true;

        });
    });
</script>

