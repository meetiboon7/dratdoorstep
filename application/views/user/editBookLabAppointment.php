<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Edit Lab Appointment</h5>
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
						<form id="add_pharmacy_employee_form" class="form" action="<?php echo base_url(); ?>updateLabBooking" id="add_Lab_appointment_form" method="post" enctype="multipart/form-data">
								<!-- <div class="card-header">
									<h3 class="card-title">
										Add Doctor Appointment
									</h3>
								</div> -->
								<input type="hidden" name="book_laboratory_test_id" id="book_laboratory_test_id" value="<?php echo $appointment_book['book_laboratory_test_id'];?>">
								<div class="card-body">

								
							   
							    <div class="row">
							    	<div class="form-group col-md-6">
										<label><b>Patient *</b></label>
										<select class="form-control select2 display_member_list member_validate" id="kt_select2_2" name="patient_id" required="" disabled>
											<option value="0" selected disabled hidden> Select Member</option>
											<?php 
												 foreach($member as $m){

						                          $selected_member = "";
						                          
						                          if($m['member_id'] == $appointment_book['patient_id']){ $selected_member = "selected"; }
						                          echo '<option value="'.$m['member_id'].'" '.$selected_member.'>'.$m['name'].'</option>';
                        					}
											?>
										</select>
										 <div id="member_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
										
										
							    </div>
							     <div class="row">
							 
                   
                        <div class="form-group col-md-6">
                          <label><b>Select Address *</b></label><br>
                          <select class="form-control select2 display_address address_validate"  name="address_id" id="kt_select2_9" style="width: 100%;" disabled>

                                <option value="none" selected disabled hidden> Select Address</option>
                                 <?php 
                        
                                          foreach($address as $a){

                                            $selected_address = "";
                                            
                                            if($a['address_id'] == $appointment_book['address_id']){ $selected_address = "selected"; }
                                            echo '<option value="'.$a['address_id'].'" '.$selected_address.'>'.$a['address_1']." ".$a['address_2'].'</option>';
                                          }
                                  ?>
                          </select>
                          <div id="address_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
                        </div>
          
                    </div>
							   
							    <div class="row">
							    	<div class="form-group col-md-3">
											<label><b>Date *</b></label>
											<input type="date" class="form-control" placeholder="DD/MM/YY" name="date" id="date" min="<?php echo date('Y-m-d'); ?>"  value="<?php echo $appointment_book['date'];?>"/>
											 <div id="date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										<div class="form-group col-md-3">
											<label><b>Time *</b></label>
											<input type="time" class="form-control" placeholder="HH:MM" name="time" id="time"  value="<?php echo $appointment_book['time'];?>"/>
											 <div id="time_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
							    </div>

							  
							     <div class="row">
							    	<div class="form-group col-md-6">
										<label><b>Type *</b></label>
										<select class="form-control select2  lab_test_validate" id="kt_select2_14" name="lab_test_id" required="" disabled>
											<option value="" selected disabled hidden> Select Test Type</option>
											<?php 
												
						                        foreach($lab_test_type as $lt){

						                          $selected_type = "";
						                          
						                          if($lt['lab_test_id'] == $appointment_book['lab_test_id']){ $selected_type = "selected"; }
						                          echo '<option value="'.$lt['lab_test_id'].'" '.$selected_type.'>'.$lt['lab_test_type_name'].'</option>';
						                        }
											?>
										</select>
										 <div id="lab_test_id_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
										
										
							    </div>
								
								 <div class="row">
                                    <div class="form-group col-md-3">
                                        <label><b>Report Upload:</b></label>
                                                      <input type="file" name="img_profile" id="img_profile" disabled="">
                                                    </div>
                                                    <?php 
                                                    if($appointment_book['prescription']!=''){
                                                    ?>
                                                     <div class="col-md-2 img1">
                                         <img src="<?php echo base_url().'uploads/lab_report/'.$appointment_book['prescription'] ?>" width="100" height="100"/>

                                      </div>
                                      <?php
                                  }
                                      ?>

                                                    </div>
                                                      <div class="row">
                                    
                                         <?php 
                                                    if($appointment_book['complain']!=''){
                                                    ?>
                                        <div class="form-group col-md-6">
                                            <label><b>Complain</b></label>
                                            <textarea class="form-control" name="complain" id="complain" readonly="" style="    background-color: #F3F6F9;
    opacity: 1;"><?php echo $appointment_book['complain']?></textarea>
                                            
                                        </div>
                                        <?php 
                                    	}
                                    	else
                                    	{
                                    		?>
                                    		<div class="form-group col-md-6">
                                            <label><b>Complain</b></label>
                                            <textarea class="form-control" name="complain" id="complain" ></textarea>
                                            
                                        </div>
                                    		<?php
                                    	}
                                        ?>
                                        
                                </div>
                                <div class="row">
							    	
									
									<div class="form-group col-md-6" >
										By booking appointment at dratdoorstep you accept our. <a href="<?php echo base_url()?>userTermsCondition" target="_blank"><u> Terms & Conditions</u></a>
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
								<a href="<?php echo base_url(); ?>BookingHistory" class="btn btn-secondary">Cancel</a>
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
          //  var user_type_validate = $(".user_type_validate");
             var member_validate = $(".member_validate");
               var lab_test_validate = $(".lab_test_validate");
               var address_validate = $(".address_validate");
           
            // if (user_type_validate.val() == null) {
                
            //     $('#user_type_id').show();
        		
            //     return false;
            // }
            // else
            // {
            // 	 $('#user_type_id').hide();
            // }

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
