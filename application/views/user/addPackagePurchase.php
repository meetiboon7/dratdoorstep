<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Package Purchase</h5>
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
				<div class="row">
					<div class="col-xl-6">
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

							    <div class="form-group col-md-8" >
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
								</div>

					<div class="row">
							 
                   
                        <div class="form-group col-md-8">
                          <label><b>Select Address *</b></label><br>
                          <select class="form-control select2 display_address address_validate"  name="address" id="kt_select2_9" style="width: 100%;">

                                <option value="none" selected disabled hidden> Select Address</option>
                          </select>
                          <div id="address_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
                        </div>
          
                    </div>

                    <input type="hidden" name="package_id" id="package_id" value="<?php echo $manage_package['package_id'];?>">
                    <input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $manage_package['service_id'];?>">
                     <input type="hidden" name="amount" id="amount" value="<?php echo $manage_package['fees_name'];?>">
                      <input type="hidden" name="package_name" id="package_name" value="<?php echo $manage_package['package_name'];?>">


							  

							  

								
								 	

								
                               
								
								
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
			</div>
			<div class="col-xl-6">
				<div class="card card-custom">
					<div class="card-body p-0">
						
														<div class="card-header">
									<h3 class="card-title">
										Package Information
									</h3>
								</div>
								<div class="card-body">

								
								<?php echo $manage_package['description'];?>
 
  	
  		<label>&nbsp;&#x20b9 <b>Price: </b><?php  echo $manage_package['fees_name']; ?></label><br><br>
  		<label><i class="fa fa-user-md" aria-hidden="true"></i> <b>Visits: </b><?php  echo $manage_package['no_visit']; ?></label><br><br>
  		<label><i class="fa fa-map-marker" aria-hidden="true"></i> <b>City: </b><?php  echo $manage_package['city']; ?></label><br><br>
  		<label><i class="fa fa-calendar" aria-hidden="true"></i> <b>Days: </b><?php  echo $manage_package['validate_month']; ?></label>

							  

								
								 	

								
                               
								
								
							</div>
												
						
					</div>
				</div>
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
 var user_type_id = $('#user_type_id').val();
  var amount = $('#amount').val();
   var package_id = $('#package_id').val();
   var package_name = $('#package_name').val();

//alert(member);

	

//alert(doctor_type_validate);
	if(member!="none" && address!="none")
	{
			jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url('addPackageCart'); ?>",
			dataType: 'html',
			data: {member:member,address: address, user_type_id: user_type_id,amount:amount,package_id:package_id,package_name:package_name},
			success: function(res) 
			{
				window.location.href = '<?php echo base_url('userPackage'); ?>';
				//var currentLocation = window.location;
				//window.location.href=currentLocation;


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
 var user_type_id = $('#user_type_id').val();
  var amount = $('#amount').val();
   var package_id = $('#package_id').val();
var package_name = $('#package_name').val();
	if(member!="none" && address!="none")
	{
			jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url('addPackageCart'); ?>",
			dataType: 'html',
			data: {member:member,address: address, user_type_id: user_type_id,amount:amount,package_id:package_id,package_name:package_name},

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
       
        return true;
	}

});
});
</script>

