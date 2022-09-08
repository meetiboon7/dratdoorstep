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
						<form id="add_pharmacy_employee_form" class="form" action="<?php echo base_url(); ?>insert_package" id="add_doctor_appointment_form" method="post" enctype="multipart/form-data">
								<!-- <div class="card-header">
									<h3 class="card-title">
										Add Doctor Appointment
									</h3>
								</div> -->
								<span style="color:green;" style="font-size:18px;margin-left:30px"> <?php echo $this->session->flashdata('message'); ?> </span>
								<div class="card-body">

								<div class="row">
									<div class="form-group col-md-4">

										<label><b>User *</b></label>
										<select class="form-control select2 droplistID user_type_validate" id="kt_select2_1" name="user_id" required="" onChange="getMemberData(this.value)">
											<option value="" selected disabled hidden> Select User</option>
											<?php
foreach ($user as $u) {
    if ($u['first_name'] != '' || $u['last_name'] != '' || $u['mobile'] != '') {
        echo '<option value="' . $u['user_id'] . '">' . $u['first_name'] . " " . $u['last_name'] . " - " . $u['mobile'] . '</option>';
    }

}
?>
										</select>
										 <div id="user_type_id" class="validation" style="display:none;color:red;">Please Select User</div>

									</div>

									<div class="form-group col-md-4">
										<label><b>Patient *</b></label>
										<select class="form-control select2 display_member_list member_validate" id="kt_select2_2" name="patient_id" required="" >
											<option value="0" selected disabled hidden> Select Member</option>

										</select>
										 <div id="member_valid_id" class="validation" style="display:none;color:red;">Please Select Member</div>

									</div>
									<div class="form-group col-md-4">
										<label><b>Select Address *</b></label><br>
										<select class="form-control select2 display_address address_validate"  name="address_id" id="kt_select2_9" style="width: 100%;">
												<option value="none" selected disabled hidden> Select Address</option>
										</select>
										<div id="address_valid_id" class="validation" style="display:none;color:red;">Please Select Address</div>
									</div>

							    </div>

							    <div class="row">
							    	<div class="form-group col-md-4">
											<label><b>Start Date *</b></label>
											<input type="date" class="form-control" placeholder="DD/MM/YY" name="start_date" id="date" />
											 <div id="date_valid" class="validation" style="display:none;color:red;">Please Enter Start Date</div>
									</div>
									<div class="form-group col-md-4">
											<label><b>End Date *</b></label>
											<input type="date" class="form-control" placeholder="DD/MM/YY" name="end_date" id="time"/>
											 <div id="time_valid" class="validation" style="display:none;color:red;">Please Enter End Date</div>
									</div>
									<div class="form-group col-md-4">
										<label><b>Select City *</b></label>
										<select class="form-control select2 doctor_type_validate" id="kt_select2_10" name="city_id" onChange="getService(this.value)">
											<option value="none" selected disabled hidden> Select City</option>
											<?php
												foreach ($city as $c) {
												    echo '<option value="' . $c['city_id'] . '">' . $c['city'] . '</option>';
												}
											?>
										</select>
										<div id="doctor_type_valid_id" class="validation" style="display:none;color:red;">Please Select Service Type</div>
									</div>

							    </div>

								<div class="row">
								<div class="form-group col-md-4">
										<label><b>Type Of Service *</b></label>
										<select class="form-control select2 doctor_type_validate display_package" id="kt_select2_17" name="service_type_id" >
											<option value="none" selected disabled hidden> Select Package Service</option>

										</select>
										<div id="doctor_type_valid_id" class="validation" style="display:none;color:red;">Please Select Service Type</div>
									</div>
								    <!-- <div class="form-group col-md-4" >
										<label><b>Fees(&#x20b9) *</b></label>
										<input type="text" class="form-control" placeholder="Fees" name="amount" id="amount" onkeypress="return isNumberKey(event)"/>
										<div id="amount_valid" class="validation" style="display:none;color:red;">Please Enter Fees</div>

									</div>	 -->
									<div class="form-group col-md-4" >
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
										<div id="payment_type_valid_id" class="validation" style="display:none;color:red;">Please Select Type of Payment</div>
									</div>

									<!-- <div class="form-group col-md-4" >
										<label><b>Remark</b></label>
										<input type="text" class="form-control" placeholder="Remark" name="bank_name" id="bank_name"/>
										 <div id="amount_valid" class="validation" style="display:none;color:red;">Please Enter Fees</div>

									</div> -->
								</div>

								<div class="row">
									<div class="form-group col-md-6">
										<label>Other Details</label>
										<!-- <input type="text" /> -->
										<!--  <div id="first_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div> -->
										<textarea class="form-control" placeholder="Other Details" name="bank_name" id="bank_name"></textarea>
									</div>
								</div>

								<!-- <div class="row" >
									<div class="form-group col-md-6" >
										By booking appointment at dratdoorstep you accept our. <a href="<?php echo base_url() ?>adminTermsCondition" target="_blank"><u> Terms & Conditions</u></a>
									</div>
								</div>	 -->




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
								<button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Book Package</button>
								<a href="<?php echo base_url().'adminDashboard'; ?>" class="btn btn-secondary">Cancel</a>
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
            var doctor_type_validate = $(".doctor_type_validate");
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

           if (doctor_type_validate.val() == null) {

                $('#doctor_type_valid_id').show();

                return false;
            }
            else
            {
            	 $('#doctor_type_valid_id').hide();
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
                // alert(html);
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
					//alert(html)
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
    function getService(city_id){
          //alert(city_id)
		  if(city_id){
			jQuery.ajax({
				type:'POST',
				url:BASE_URL+'admin/PackageBook/service_package_display',
				data:'city_id='+city_id,
				success:function(html){
					 //alert(html)
					jQuery('.display_package').html(html)
				}
			});
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