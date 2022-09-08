<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Edit Nurse Appointment</h5>
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
						<form id="add_pharmacy_employee_form" class="form" id="add_nurse_appointment_form" method="post" enctype="multipart/form-data">
								<!-- <div class="card-header">
									<h3 class="card-title">
										Add Doctor Appointment
									</h3>
								</div> -->
								<div class="card-body">

								<!-- <div class="row">
									<div class="form-group col-md-4">
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
									
									
									
							    </div> -->
							   <input type="hidden" name="cart_id" id="cart_id" value="<?php echo $cart['cart_id'];?>">
							    <div class="row">
							    	<div class="form-group col-md-6">
										<label><b>Patient *</b></label>
										<select class="form-control select2  member_validate" id="kt_select2_1" name="member_id" required="" onChange="getAddress(<?php echo $this->session->userdata('user')['user_id'];?>)">
											<option value="none" selected disabled hidden> Select Patient</option>
											<?php 
												foreach($member as $m){

													$selected_member = "";
													
													if($m['member_id'] == $cart['patient_id']){ $selected_member = "selected"; }
													echo '<option value="'.$m['member_id'].'" '.$selected_member.'>'.$m['name'].'</option>';
												}
											?>
										</select>
										 <div id="member_id_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
									<div class="form-group col-md-6 mr-7"  >
										<label><b>Not found patient above ?</b>&nbsp;<a href="<?php echo base_url()."addMember"?>">Click here</a></label>
										
									</div>
										
										
							    </div>
							    <div class="row">
							 
                   
                        <div class="form-group col-md-6">
                          <label><b>Select Address *</b></label><br>
                          <!-- <select class="form-control select2 display_address address_validate"  name="address" id="kt_select2_9" style="width: 100%;">

                                <option value="none" selected disabled hidden> Select Address</option>
                          </select> -->
                          <select class="form-control select2 display_address_user address_validate" id="kt_select2_9" name="address" style="width: 100%;">
											<option value="none" selected disabled hidden> Select Address *</option>
											<?php 
												
												foreach($address as $a){

													$selected_address = "";
													
													if($a['address_id'] == $cart['address']){ $selected_address = "selected"; }
													echo '<option value="'.$a['address_id'].'" '.$selected_address.'>'.$a['address_1']." ".$a['address_2'].'</option>';
												}
											?>
										</select>
                          <div id="address_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
                        </div>
                         <div class="form-group col-md-6 mr-7" >
										<label><b>Not found address above ?</b>&nbsp;<a href="<?php echo base_url()."addAddress"?>">Click here</a></label>
										
						</div>
          
                    </div>

							    <div class="row">
							    	<div class="form-group col-md-3">
											<label><b>Date *</b></label>
											<input type="date" class="form-control" placeholder="DD/MM/YY" name="date" id="date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $cart['date'];?>"/>
											<div id="date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										<div class="form-group col-md-3">
											<label><b>Time *</b></label>
											<input type="time" class="form-control" placeholder="HH:MM" name="time" id="time" value="<?php echo $cart['time'];?>"/>
											<div id="time_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							    </div>

							  

								
								 	

								<div class="row">
							    	
									
									<div class="form-group col-md-6" >
										<label><b>Type Of Service *</b></label>
										<select class="form-control select2 type_validate" id="kt_select2_17" name="nurse_service_id" onChange="getDaily(this)">
											<option value="none" selected disabled hidden> Select Service Type </option>
											<?php 
												foreach($nurse_service_type as $ns){
													$selected_type = "";
													if($ns['nurse_service_id'] == $cart['nurse_service_id']){ $selected_type = "selected"; }
													echo '<option value="'.$ns['nurse_service_id'].'" '.$selected_type.'>'.$ns['nurse_service_name'].'</option>';
												}
												
											?>
										</select>
										<div id="type_validate_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>



								</div>	
								<?php
								if($cart['nurse_service_id']==2)
								{
									?>
									<div class="row">
										<div class="form-group col-md-6 daily_days">
											<label>Days *</label>
											<input type="text" class="form-control" placeholder="Days" name="days" id="days" onkeypress="return isNumberKey(event)" value="<?php echo $cart['days']?>" />
											<div id="days_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
											
										</div>
									</div>
									<?php
								}
								else
								{
									?>
									<div class="row">
										<div class="form-group col-md-6 daily_days" style="display:none;">
											<label>Days *</label>
											<input type="text" class="form-control" placeholder="Days" name="days" id="days" onkeypress="return isNumberKey(event)" value="<?php echo $cart['days']?>" />
											<div id="days_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
											
										</div>
									</div>
									<?php
								}
								?>
								

								<div class="row">
                                    
                                        
                                        <div class="form-group col-md-6">
                                            <label><b>Complain</b></label>
                                            <textarea class="form-control" name="complain" id="complain"><?php echo $cart['complain']?></textarea>
                                            
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
								<!-- <button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Save</button>
								<a href="<?php echo base_url(); ?>AppointmentList" class="btn btn-secondary">Cancel</a> -->
								<!-- <a href="<?php echo base_url()?>userCart"  class="btn btn-primary mr-2">Book Now</a> -->
								<button type="button" class="btn btn-primary mr-2" id="btnSubmit">Book Now</button>
								<button type="button" class="btn btn-primary mr-2" id="butsave">Add to Cart</button>
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

    function getDaily(id){
        

      var type=id.value;
       //alert(type);
      if(type==2)
      {
      	$(".daily_days").show();
      } 
      else
      {
      	$(".daily_days").hide();
      } 
           
        
       
       
    }
  
</script>
<script type="text/javascript">

    function getAddress(user_id){
        
        if(user_id){
            jQuery.ajax({
                type:'POST',
                 url: "<?php echo base_url('memberUser'); ?>",
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

// Ajax post
$(document).ready(function() 
{
$("#butsave").click(function() 
{
var member =$('.member_validate option:selected').val();
var address =$('.address_validate option:selected').val();
//alert(member);
var cart_id = $('#cart_id').val();
var date = $('#date').val();
var time = $('#time').val();
var complain = $('#complain').val();
var days = $('#days').val();
var type_validate =$('.type_validate option:selected').val();
//alert(doctor_type_validate);
	if(member!="none" &&  address!="none" && date!="" && time!="" && type_validate!="none")
	{
			jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url('updateNurseCart'); ?>",
			dataType: 'html',
			data: {cart_id:cart_id,member:member,date: date, time: time,type_validate:type_validate,address:address,complain:complain,days:days},
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
		//alert(member_validate);
		var type_validate = $(".type_validate");
		if(member_validate.val() == null) 
		{
           $('#member_id_valid').show();
           return false;
        }
        else
        {
            $('#member_id_valid').hide();
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

           if (type_validate.val() == null) {
                
                $('#type_validate_id').show();
        		
                return false;
            }
            else
            {
            	 $('#type_validate_id').hide();
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
//alert(member);

var date = $('#date').val();
var time = $('#time').val();
 var complain = $('#complain').val();
 var days = $('#days').val();
var type_validate =$('.type_validate option:selected').val();
var cart_id = $('#cart_id').val();
//alert(doctor_type_validate);
	if(member!="none" && address!="none" && date!="" && time!="" && type_validate!="none")
	{
			jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url('updateNurseCart'); ?>",
			dataType: 'html',
			data: {cart_id:cart_id,member:member,date: date, time: time,type_validate:type_validate,address:address,complain:complain,days:days},
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

		//alert(member_validate);
		var type_validate = $(".type_validate");
		if(member_validate.val() == null) 
		{
           $('#member_id_valid').show();
           return false;
        }
        else
        {
            $('#member_id_valid').hide();
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

           if (type_validate.val() == null) {
                
                $('#type_validate_id').show();
        		
                return false;
            }
            else
            {
            	 $('#type_validate_id').hide();
            }
        return true;
	}

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

