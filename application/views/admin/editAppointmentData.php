<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Appointment Master</h5>
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
						<form id="add_appointment_form" class="form" action="<?php echo base_url(); ?>adminupdateAppointment"  method="post" enctype="multipart/form-data">
								<div class="card-header">
								<!-- 	<h3 class="card-title">
										Edit Member Info
									</h3> -->
								</div>
								<?php
									$invoice_date=$extra_invoice_data['appmt_date'];
									$date=explode(' ',$invoice_date);
									// echo "<pre>";
									// print_r($date);
								?>
								<div class="card-body">

								<!--  <div class="row">
							    	<div class="form-group col-md-4">
											<label><b>Date *</b></label>
											<input type="date" class="form-control" placeholder="DD/MM/YY" name="date" id="date" 
											value="<?php echo date("d-m-Y",strtotime($date[0])); ?>">
											 <div id="date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										
							    </div> -->
							    <div class="row">
							    <div class="form-group col-md-4">
											<label><b>Date *</b></label>
											<input type="date" class="form-control" placeholder="DD/MM/YY" name="date" id="date"  value="<?php echo $date[0];?>"/>
											 <div id="date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
								</div>
							    <div class="row">
								<div class="form-group col-md-4" >
										<label>Fees(&#x20b9) *</label>
										<input type="text" class="form-control" placeholder="Fees" name="amount" id="amount" onkeypress="return isNumberKey(event)" value="<?php echo $extra_invoice_data['price']?>" />
										<div id="amount_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>	
								</div>
								

								</div>

							
												
							<div class="card-footer">
								
								<button type="submit" class="btn btn-primary mr-2" name="btn_update_appointment" id="btnSubmit" value="<?php echo $extra_invoice_data['extra_invoice_id']; ?>">Update</button>
								<a href="<?php echo base_url(); ?>adminAllAppointment" class="btn btn-secondary">Cancel</a>
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
            
            

            if ($("#date").val()=='') {
                
                $('#date_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#date_valid').hide();
            }

            
            
            if ($("#amount").val()=='') {
                
                $('#amount_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#amount_valid').hide();
            }
            
			return true;

        });
    });
</script>