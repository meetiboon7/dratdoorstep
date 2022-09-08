<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Book Package</h5>
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
						<form id="add_book_package_form" class="form" action="<?php echo base_url(); ?>updateBookPackage" method="post" enctype="multipart/form-data">
								<!-- <div class="card-header">
									<h3 class="card-title">
										Edit Package Info
									</h3>
								</div> -->
								<div class="card-body">

								<div class="row">
									<div class="form-group col-md-6">
										<label>Package Name *</label>
										<select class="form-control select2 package_valid" id="kt_select2_14" name="package_id" >
											<option value="none" selected disabled hidden> Select Package </option>
											<?php 
												foreach($manage_package as $p){
													$selected_package = "";
													if($p['package_id'] == $book_package['package_id']){ $selected_package = "selected"; }

													echo '<option value="'.$p['package_id'].'" '. $selected_package.'>'.$p['package_name'].'</option>';
												}
											?>
										</select>
										<div id="package_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>

								</div>

							    <div class="row">
								    <div class="form-group col-md-6">
											<label>Services *</label>
											<select class="form-control select2 service_valid" id="kt_select2_11" name="service_id" >
												<option value="none" selected disabled hidden> Select Service </option>
												<?php 
													foreach($service as $s){
														$selected_service = "";
														if($s['user_type_id'] == $book_package['service_id']){ $selected_service = "selected"; }

														echo '<option value="'.$s['user_type_id'].'" '. $selected_service.'>'.$s['user_type_name'].'</option>';
													}
												?>
											</select>
											<div id="service_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
											
									</div>
							    </div>

							    <div class="row">

							    <div class="form-group col-md-6" >
										<label><b>Patient *</b></label>
										<select class="form-control select2 member_validate" id="kt_select2_2" name="patient_id" >
											<option value="none" selected disabled hidden> Select Member</option>
											<?php 
												foreach($member as $m){
												  $selected_member = "";
													if($m['member_id'] == $book_package['patient_id']){ $selected_member = "selected"; }

													echo '<option value="'.$m['member_id'].'" '. $selected_member.'>'.$m['name'].'</option>';
												}
											?>
										</select>
										<div id="member_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
								</div>
								

								<div class="row">
							    	<div class="form-group col-md-3">
											<label><b>Date *</b></label>
											<input type="date" class="form-control" placeholder="DD/MM/YY" name="date" id="date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $book_package['date'] ?>"/>
											 <div id="date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										<div class="form-group col-md-3">
											<label><b>Time *</b></label>
											<input type="time" class="form-control" placeholder="HH:MM" name="time" id="time" value="<?php echo $book_package['time'] ?>"/>
											 <div id="time_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							    </div>

								
								
							</div>
												
							<div class="card-footer">
								
								<button type="submit" class="btn btn-primary mr-2" name="btn_update_book_package" value="<?php echo $book_package['id']; ?>" id="btnSubmit">Update</button>
								<a href="<?php echo base_url(); ?>adminPackageBook" class="btn btn-secondary">Cancel</a>
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
           
             var package_valid = $(".package_valid");
              var service_valid = $(".service_valid");
              var member_validate = $(".member_validate");
             
           
           if (package_valid.val() == null) {
                
                $('#package_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#package_valid_id').hide();
            }

            if (service_valid.val() == null) {
                
                $('#service_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#service_valid_id').hide();
            }

           if(member_validate.val() == null) 
			{
	           $('#member_valid_id').show();
	           return false;
	        }
	        else
	        {
	            $('#member_valid_id').hide();
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


<script type="text/javascript">
	function isNumberKey(evt) {
   var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
}
</script>




