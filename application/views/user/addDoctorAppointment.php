<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Doctor Appointment</h5>
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
						<form class="form"  id="add_doctor_appointment_form" method="post" enctype="multipart/form-data">
								<!-- <div class="card-header">
									<h3 class="card-title">
										Add Doctor Appointment
									</h3>
								</div> -->
								<div class="card-body">

								
							      <div class="row">

							    <div class="form-group col-md-6" >
										<label><b>Patient *</b></label>
										<select class="form-control select2 member_validate" id="kt_select2_2" name="patient_id" onChange="getAddress(<?php echo $this->session->userdata('user')['user_id'];?>)">
											<option value="none" selected disabled hidden> Select Member</option>
											<?php 
												foreach($member as $m){
													echo '<option value="'.$m['member_id'].'">'.$m['name'].'</option>';
												}
											?>
										</select>
										<div id="member_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									 <div class="form-group col-md-6 mr-7"  >
										<label><b>Not found patient above ?</b>&nbsp;<a href="<?php echo base_url()."addMember"?>">Click here</a></label>
										
									</div>
								</div>

					<div class="row">
							 
                   
                        <div class="form-group col-md-6">
                          <label><b>Select Address *</b></label><br>
                          <select class="form-control select2 display_address_user address_validate"  name="address" id="kt_select2_9" style="width: 100%;">

                                <option value="none" selected disabled hidden> Select Address</option>
                          </select>
                          <div id="address_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
                        </div>
                        <div class="form-group col-md-6 mr-7">
										<label><b>Not found address above ?</b>&nbsp;<a href="<?php echo base_url()."addAddress"?>">Click here</a></label>
										
						</div>
          
                    </div>


							    <div class="row">
							    	<div class="form-group col-md-3">
											<label><b>Date *</b></label>
											<input type="date" class="form-control" placeholder="DD/MM/YY" name="date" id="date" min="<?php echo date('Y-m-d'); ?>"/>
											 <div id="date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										<div class="form-group col-md-3">
											<label><b>Time *</b></label>
											<input type="time" class="form-control" placeholder="HH:MM" name="time" id="time"/>
											 <div id="time_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							    </div>

							  

								
								 	

								<div class="row">
							    	
									
									<div class="form-group col-md-6" >
										<label><b>Type Of Doctor *</b></label>
										<select class="form-control select2 doctor_type_validate" id="kt_select2_17" name="d_type_id" >
											<option value="none" selected disabled hidden> Select Doctor Type </option>
											<?php 
												foreach($doctor_type as $dt){
													echo '<option value="'.$dt['d_type_id'].'">'.$dt['doctor_type_name'].'</option>';
												}
											?>
										</select>
										<div id="doctor_type_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
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
										By booking appointment at dratdoorstep you accept our. <a href="<?php echo base_url()?>userTermsCondition" target="_blank"><u> Terms & Conditions</u></a>
									</div>



								</div>	
								
								
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
								<!-- <button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Booking Now</button> -->
								<button type="button" class="btn btn-primary mr-2" id="btnSubmit">Book Now</button>

								<!-- <a href="<?php echo base_url()?>userCart"  class="btn btn-primary mr-2">Book Now</a> -->
								<button type="button" class="btn btn-primary mr-2" id="butsave">Add to Cart</button>
								<!-- <a href="<?php echo base_url(); ?>AppointmentList" class="btn btn-secondary">Cancel</a> -->
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

    function getAddress(user_id){
        //alert(user_id);
        if(user_id){
            jQuery.ajax({
                type:'POST',
                url: "<?php echo base_url('memberUser'); ?>",
                dataType: 'html',
                data:'user_id='+user_id,
                success:function(html){
                
                    jQuery('.display_address_user').html(html);

                    
                     
                }
            });
        }
       
       
    }
    
</script>
<!-- <script type="text/javascript">
 

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
                     
                }
            }); 
        }else{
            //	jQuery('#state').html('<option value="">Select country first</option>');
          
        }
    }
    
</script> -->
<script type="text/javascript">

// Ajax post
$(document).ready(function() 
{
$("#butsave").click(function() 
{
var member =$('.member_validate option:selected').val();
var address =$('.address_validate option:selected').val();
//alert(member);

	var date = $('#date').val();
	var time = $('#time').val();
    var complain = $('#complain').val();
	var doctor_type_validate =$('.doctor_type_validate option:selected').val();
//alert(doctor_type_validate);
	if(member!="none" && address!="none" && date!="" && time!="" &&  doctor_type_validate!="none")
	{
			jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url('addCart'); ?>",
			dataType: 'html',
			data: {member:member,date: date, time: time,doctor_type_validate:doctor_type_validate,address:address,complain:complain},
			success: function(res) 
			{

				
				window.location.href = '<?php echo base_url('AppointmentList'); ?>';

				
				
			},
			error:function()
			{
				//alert('data not saved');	
			}
		});
	}
	else
	{
		//alert("pls fill all fields first");
		var member_validate = $(".member_validate");
        var address_validate = $(".address_validate");
		var doctor_type_validate = $(".doctor_type_validate");
		if(member_validate.val() == null) 
		{
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
        return true;
	}

});
});
</script>

<script type="text/javascript">

// Ajax post
$(document).ready(function() 
{
$("#btnSubmit").click(function() 
{
var member =$('.member_validate option:selected').val();
var address =$('.address_validate option:selected').val();
 var complain = $('#complain').val();
//alert(member);

	var date = $('#date').val();
	var time = $('#time').val();
	var doctor_type_validate =$('.doctor_type_validate option:selected').val();

	if(member!="none" && address!="none" && date!="" && time!="" &&  doctor_type_validate!="none")
	{
			jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url('addCart'); ?>",
			dataType: 'html',
			data: {member:member,date: date, time: time,doctor_type_validate:doctor_type_validate,address:address,complain:complain},
			success: function(res) 
			{
				window.location.href = '<?php echo base_url('userCart'); ?>';
			},
			error:function()
			{
				//alert('data not saved');	
			}
		});
	}
	else
	{
		//alert("pls fill all fields first");
		var member_validate = $(".member_validate");
        var address_validate = $(".address_validate");
		var doctor_type_validate = $(".doctor_type_validate");
		if(member_validate.val() == null) 
		{
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
        return true;
	}

});
});
</script>

