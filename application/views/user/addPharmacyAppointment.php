<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">E-Pharmacy Appointment</h5>
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
						<form  class="form"  id="add_pharmacy_appointment_form" method="post" enctype="multipart/form-data">
								<!-- <div class="card-header">
									<h3 class="card-title">
										Add Doctor Appointment
									</h3>
								</div> -->
								<div class="card-body">

								 <!--  <div class="row">
							    	<div class="form-group col-md-6">
										<label><b>Patient *</b></label>
										<select class="form-control select2  member_validate" id="kt_select2_1" name="member_id" onChange="getAddress(<?php echo $this->session->userdata('user')['user_id'];?>)">
											<option value="" selected disabled hidden> Select Patient</option>
											<?php 
												foreach($member as $m){
													
														echo '<option value="'.$m['member_id'].'">'.$m['name'].' - '.$m['contact_no'].'</option>';
													
													
												}
											?>
										</select>
										 <div id="member_id_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
										
										
							    </div> -->

<!-- 							    <div class="row">
							 
                   
                        <div class="form-group col-md-6">
                          <label><b>Delivery Address *</b></label><br>
                          <select class="form-control select2 display_address_user address_validate"  name="address" id="kt_select2_9" style="width: 100%;">

                                <option value="none" selected disabled hidden> Select Address</option>
                          </select>
                          <div id="address_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
                        </div>
          
                    </div> -->
							    
							    <div class="row">
							    		<div class="form-group col-md-6">
											<label><b>Contact Name *</b></label>
											<input type="text" class="form-control" placeholder="Enter Name" name="name" id="name"/>
											<div id="name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										
										
							    </div>

							    <div class="row">
							    	<div class="form-group col-md-3">
											<label><b>Contact Mobile *</b></label>
											<input type="text" class="form-control" placeholder="Enter Number" name="mobile" id="mobile" onkeypress="return isNumber(event)"  maxlength="10"/>
											<div id="mobile_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										
										<div class="form-group col-md-3">
											<label><b>Landline </b></label>
											<input type="text" class="form-control" placeholder="Enter Number" name="landline" id="landline" onkeypress="return isNumber(event)" maxlength="15"/>
											<div id="landline_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							    </div>
							     <div class="row">
							    	
										
										<div class="form-group col-md-6">
											<label><b>Delivery Address *</b></label>
											<textarea class="form-control" name="address" id="address"></textarea>
											<div id="address_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										
							    </div>
							  

								  <div class="row">
							    	
										
										<div class="form-group col-md-6">
											<label><b>City *</b></label>
											<select class="form-control select2 city_valid" id="kt_select2_14" name="city_id" >
											<option value="none" selected disabled hidden> Select City </option>
											<?php 
												foreach($city as $c){
													echo '<option value="'.$c['city_id'].'">'.$c['city'].'</option>';
												}
											?>
										</select>
											 <div id="city_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>

							    </div>
								 	
								 	  
										
							   
								<?php
								$blank_image = base_url().'assets/media/users/blank.png';
								if(!empty($view_user_profile->profile_pic)){
						
										$profile_image = base_url().'uploads/emp_profile/'.$view_user_profile->profile_pic;
								}else{
						
											$profile_image = $blank_image;
								}
								?>
								<?php
                			if (isset($error)){
                    				echo $error;
                			}
            				?>
                            <div class="row">
                                    <div class="form-group col-md-2">
                                        <label><b>Prescription Upload *</b></label>
                                                      <input type="file" name="img_profile" id="img_profile">
                                                    </div>
                                                     <div id="profile_image_validate" class="validation" style="display:none;color:red;">Please upload Document</div>
                            </div>
								 	
							
								 <div class="row">
                                    
                                    
                                    <div class="form-group col-md-6" >
                                        By booking appointment at dratdoorstep you accept our. <a href="<?php echo base_url()?>userTermsCondition" target="_blank"><u> Terms & Conditions</u></a>
                                    </div>



                                </div>  
								
								
								
							</div>
												
							<div class="card-footer">
								<!-- <button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Save</button>
								<a href="<?php echo base_url(); ?>AppointmentList" class="btn btn-secondary">Cancel</a> -->
								<!-- <button type="button" class="btn btn-primary mr-2" id="btnSubmit">Book Now</button>
								<button type="submit" class="btn btn-primary mr-2" id="butsave">Add to Cart</button> -->
                                <button type="button" name="book" value="1" class="btn btn-primary mr-2" id="btnSubmit">Book Now</button>
                               <!--  <button type="button" value="2" name="addtocart" class="btn btn-primary mr-2" id="butsave">Add to Cart</button> -->
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
	function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>
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




<script type="text/javascript">

$('#btnSubmit').click(function(e){

    e.preventDefault(); 
    var btn1=$(this).val();
   
  //  var member_id =$('.member_validate option:selected').val();
    var name = $('#name').val();
   //alert(name);
    var mobile = $('#mobile').val();
    var landline = $('#landline').val();
    
    var address = $('#address').val();
    var city_id =$('.city_valid option:selected').val();
  var img_profile= $("#img_profile").val();
//  alert(img_profile);
   // alert(city_id);
    if(name !="" && mobile!="" && address!=""  && city_id!='none' && img_profile!='')
    {
        
        
            var fd = new FormData(add_pharmacy_appointment_form);
            fd.append('btn',btn1);
            $.ajax({
             
             url: "<?php echo base_url('addPharmacyCart'); ?>",
             type:"POST",
              dataType: 'json',
             //data:new FormData(this),
           // data:$('#add_Lab_appointment_form').serialize() + "&btn1=" + btn1,
             data : fd,
             processData:false,
            contentType:false,
            // contentType: "application/json",
             cache:false,
             async:false,
            //fileElementId   :'img_profile',
           
              success: function(data){
               
                // if(data=="1")
                // {
                    window.location.href = '<?php echo base_url('AppointmentList'); ?>';
                //}
                
                
                 
            }
         });
     }
     else
     {
        	
        	// var member_validate = $(".member_validate");
            var city_valid = $(".city_valid");
         //   var address_validate = $(".address_validate");
           
            
         //    if (member_validate.val() == null) {
                
         //        $('#member_id_valid').show();
                
         //        return false;
         //    }
         //    else
         //    {
         //         $('#member_id_valid').hide();
         //    }

         //    if(address_validate.val() == null) 
       		// {
         //   		$('#address_valid_id').show();
         //   		return false;
        	// }
        	// else
        	// {
         //   	 	$('#address_valid_id').hide();
        	// }
        	
            if ($("#name").val()=='') {
                
                $('#name_valid').show();
                
                return false;
            }
            else
            {
                 $('#name_valid').hide();
            }

            if ($("#mobile").val()=='') {
                
                $('#mobile_valid').show();
                
                return false;
            }
            else
            {
                 $('#mobile_valid').hide();
            }

            

            // if ($("#landline").val()=='') {
                
            //     $('#landline_valid').show();
                
            //     return false;
            // }
            // else
            // {
            //      $('#landline_valid').hide();
            // }

            if ($("#address").val()=='') {
                
                $('#address_valid').show();
                
                return false;
            }
            else
            {
                 $('#address_valid').hide();
            }

            


            //alert(city_valid);
            if (city_valid.val() == null) {
                
                $('#city_valid_id').show();
                
                return false;
            }
            else
            {
                 $('#city_valid_id').hide();
            }
              if ($("#img_profile").val()=='') {
                
                $('#profile_image_validate').show();
                
                return false;
            }
            else
            {
                 $('#profile_image_validate').hide();
            }

            return true;
     }
});  
</script>

