<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Lab Appointment</h5>
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
						<form id="add_pharmacy_employee_form" class="form" action="<?php echo base_url(); ?>insertLabAppointment" id="add_Lab_appointment_form" method="post" enctype="multipart/form-data">
								<!-- <div class="card-header">
									<h3 class="card-title">
										Add Doctor Appointment
									</h3>
								</div> -->
								<div class="card-body">

								 <div class="row">
									<div class="form-group col-md-6">
										<label><b>User *</b></label>
										<select class="form-control select2 droplistID user_type_validate" id="kt_select2_1" name="user_id" required="" onChange="getMemberData(this.value)">
											<option value="" selected disabled hidden> Select User</option>
											<?php 
												foreach($user as $u){
													if($u['first_name']!='' || $u['last_name']!='' || $u['mobile']!='')
													{
														echo '<option value="'.$u['user_id'].'">'.$u['first_name']." ".$u['last_name']." - ".$u['mobile'].'</option>';
													}
													
												}
											?>
										</select>
										 <div id="user_type_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
									
									
									
							    </div>
							   
							    <div class="row">
							    	<div class="form-group col-md-6">
										<label><b>Patient *</b></label>
										<select class="form-control select2 display_member_list member_validate" id="kt_select2_2" name="patient_id" required="">
											<option value="0" selected disabled hidden> Select Member</option>
											<?php 
												foreach($member as $m){
													
														echo '<option value="'.$m['member_id'].'">'.$m['name'].' - '.$m['contact_no'].'</option>';
													
													
												}
											?>
										</select>
										 <div id="member_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
										
										
							    </div>
							     <div class="row">
							 
                   
                        <div class="form-group col-md-6">
                          <label><b>Select Address *</b></label><br>
                          <select class="form-control select2 display_address address_validate"  name="address_id" id="kt_select2_9" style="width: 100%;">

                                <option value="none" selected disabled hidden> Select Address</option>
                          </select>
                          <div id="address_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
                        </div>
          
                    </div>
							   
							    <div class="row">
							    	<div class="form-group col-md-3">
											<label><b>Date *</b></label>
											<input type="date" class="form-control" placeholder="DD/MM/YY" name="date" id="date" />
											 <div id="date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										<div class="form-group col-md-3">
											<label><b>Time *</b></label>
											<input type="time" class="form-control" placeholder="HH:MM" name="time" id="time"/>
											 <div id="time_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							    </div>

							  
							     <div class="row">
							    	<div class="form-group col-md-6">
										<label><b>Type *</b></label>
										<select class="form-control select2  lab_test_validate" id="kt_select2_14" name="lab_test_id" required="">
											<option value="" selected disabled hidden> Select Test Type</option>
											<?php 
												foreach($lab_test_type as $lt){
													
														echo '<option value="'.$lt['lab_test_id'].'">'.$lt['lab_test_type_name'].'</option>';
													
													
												}
											?>
										</select>
										 <div id="lab_test_id_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
										
										
							    </div>
							    <div class="row">
								<div class="form-group col-md-6" >
										<label>Fees(&#x20b9) *</label>
										<input type="text" class="form-control" placeholder="Fees" name="amount" id="amount" onkeypress="return isNumberKey(event)"/>
										<div id="amount_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>	
								</div>
								<div class="row">
							    	<div class="form-group col-md-6" >
										<label><b>Type Of Payment *</b></label>
										<select class="form-control select2 payment_type_validate" id="kt_select2_7" name="payment_type" >
											<option value="none" selected disabled hidden> Select Payment Type </option>
											<option value="Cash">Cash</option>	
											<option value="Cheque">Cheque</option>	                           
											<option value="NEFT">NEFT</option>
											<option value="UPI">UPI</option>
											<option value="Paytm">Paytm</option>         
											<option value="card">Debit/Credit card</option>
										</select>
										<div id="payment_type_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
								</div>

								<div class="row">
									<div class="form-group col-md-6">
										<label>Other Details</label>
										<input type="text" class="form-control" placeholder="Other Details" name="bank_name" id="bank_name"/>
										<!--  <div id="first_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div> -->
										
									</div>
								</div>
								
								 <div class="row">
                                    <div class="form-group col-md-3">
                                        <label><b>Report Upload:</b></label>
                                                      <input type="file" name="img_profile" id="img_profile">
                                                    </div>
                                                    </div>
                                                      <div class="row">
                                    
                                        
                                        <div class="form-group col-md-6">
                                            <label><b>Complain</b></label>
                                            <textarea class="form-control" name="complain" id="complain"></textarea>
                                            
                                        </div>
                                        
                                </div>
                                <div class="row">
							    	
									
									<div class="form-group col-md-6" >
										By booking appointment at dratdoorstep you accept our. <a href="<?php echo base_url()?>adminTermsCondition" target="_blank"><u> Terms & Conditions</u></a>
									</div>



								</div>	
							
            				<?php
            				//print_r($error);
            				//exit;
            				 if($this->session->flashdata('message')){ ?>
							
							    
							    <div id="infoMessage"  class="text-danger"><?php echo $this->session->flashdata('message'); ?></div>
							   
							
							<?php } ?>
								
								<!-- <div class="row">
								<div class="form-group col-md-4">
										<label>Status</label>
										<select class="form-control select2"  name="emp_status"  id="kt_select2_16">
											<option value="1">Active</option>
											<option value="0">Inactive</option>
										</select>
										
								</div>

								</div> -->
								
							</div>
												
							<div class="card-footer">
								<button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Save</button>
								<a href="<?php echo base_url(); ?>adminAppointmentList" class="btn btn-secondary">Cancel</a>
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
            var user_type_validate = $(".user_type_validate");
             var member_validate = $(".member_validate");
               var lab_test_validate = $(".lab_test_validate");
               var address_validate = $(".address_validate");
                var payment_type_validate= $(".payment_type_validate");
           
            if (user_type_validate.val() == null) {
                
                $('#user_type_id').show();
        		
                return false;
            }
            else
            {
            	 $('#user_type_id').hide();
            }

             if (member_validate.val() == null) {
                
                $('#member_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#member_valid_id').hide();
            }
             if(address_validate.val() == null) 
	        {
	           $('#address_valid_id').show();
	           return false;
	        }
	        else
	        {
	            $('#address_valid_id').hide();
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

           if (lab_test_validate.val() == null) {
                
                $('#lab_test_id_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#lab_test_id_valid').hide();
            }
            if ($("#amount").val()=='') {
                
                $('#amount_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#amount_valid').hide();
            }
            if (payment_type_validate.val() == null) {
                
                $('#payment_type_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#payment_type_valid_id').hide();
            }
			return true;

        });
    });
</script>
<script type="text/javascript">
 

    function getMemberData(user_id){
        
        //alert(user_id);
		if(user_id){

            jQuery.ajax({
                type:'POST',
                 url: BASE_URL+'admin/AppointmentList/member_list_display',
                data:'user_id='+user_id,
                success:function(html){
                //  alert(html);
				        //	console.log(html);
                    jQuery('.display_member_list').html(html);
                    getAddress(user_id);
                     
                }
            }); 
        }else{
            //	jQuery('#state').html('<option value="">Select country first</option>');
          
        }
    }
    
</script>
<script type="text/javascript">

    function getAddress(user_id){
       // alert(user_id);
        if(user_id){
            jQuery.ajax({
                type:'POST',
                 url: BASE_URL+'admin/Dashboard/member_address_display',
               data:'user_id='+user_id,
                success:function(html){
                
                    jQuery('.display_address').html(html);

                    
                     
                }
            });
        }
        else
        {

        }
       
    }
    
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
