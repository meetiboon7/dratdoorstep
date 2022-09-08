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
						<form class="form add_cart_lab_appointment_form" id="add_Lab_appointment_form" method="post" enctype="multipart/form-data" name="sub">
								<!-- <div class="card-header">
									<h3 class="card-title">
										Add Doctor Appointment
									</h3>
								</div> -->
								<div class="card-body">

							
							   <input type="hidden" name="cart_id" id="cart_id" value="<?php echo $cart['cart_id'];?>">
							    <div class="row">
							    	<div class="form-group col-md-6">
										<label><b>Patient *</b></label>
										<select class="form-control select2  member_validate" id="kt_select2_1" name="member_id" onChange="getAddress(<?php echo $this->session->userdata('user')['user_id'];?>)">
											<option value="" selected disabled hidden> Select Patient</option>
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
                                  <select class="form-control select2 display_address address_validate"  name="address" id="kt_select2_13" style="width: 100%;">

                                        <option value="" selected disabled hidden> Select Address *</option>
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
							    	<div class="form-group col-md-6">
										<label><b>Type *</b></label>
										<select class="form-control select2  lab_test_validate" id="kt_select2_14" name="lab_test_id" >
											<option value="" selected disabled hidden> Select Test Type</option>
											<?php 
												
                        foreach($lab_test_type as $lt){

                          $selected_type = "";
                          
                          if($lt['lab_test_id'] == $cart['lab_test_id']){ $selected_type = "selected"; }
                          echo '<option value="'.$lt['lab_test_id'].'" '.$selected_type.'>'.$lt['lab_test_type_name'].'</option>';
                        }
											?>

										</select>
										 <div id="lab_test_id_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
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
                                    
                                        
                                        <div class="form-group col-md-6">
                                            <label><b>Complain</b></label>
                                            <textarea class="form-control" name="complain" id="complain"><?php echo $cart['complain']?></textarea>
                                            
                                        </div>
                                        
                                </div>
							  

								<?php
								// $blank_image = base_url().'assets/media/users/blank.png';
								// if(!empty($view_user_profile->profile_pic)){
						
								// 		$profile_image = base_url().'uploads/emp_profile/'.$view_user_profile->profile_pic;
								// }else{
						
								// 			$profile_image = $blank_image;
								// }
								?>
								
								 	 <div class="row">
							<?php
                  if($cart['prescription']!='')
                  {
                      //echo "1";
                  ?>
                      
                                      
                                       <div class="form-group col-md-3">
                                        <label><b>Report Upload:</b></label>
                                                      <input type="file" name="img_profile" id="img_profile">
                                                    </div>
                                                    <div class="col-md-2 img1">
                                         <img src="<?php echo base_url().'uploads/lab_report/'.$cart['prescription'] ?>" width="100" height="100"/>

                                      </div>


                  <?php
                }
                else
                {

                  //echo "2";
                  ?>

                    <div class="form-group col-md-3" >
                                         <label><b>Report Upload:</b></label>
                                                 <input type="file" name="img_profile" id="img_profile">
                                         
                                      </div>
                                      <!-- <div class="col-md-2 img1">
                                         <img src="<?php echo base_url().'uploads/lab_report/'.$cart['prescription'] ?>" width="100" height="100"/>

                                      </div> -->
                                       
                                     
                  <?php
                }
                ?>
              </div>
                                <!-- <div class="row">
                                    <div class="form-group col-md-3">
                                        <label><b>Report Upload:</b></label>
                                                      <input type="file" name="img_profile" id="img_profile">
                                                    </div>
                                                    </div> -->

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
								<!-- <button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Save</button>
								<a href="<?php echo base_url(); ?>AppointmentList" class="btn btn-secondary">Cancel</a> -->
								<!-- <a href="<?php echo base_url()?>userCart" id="btnSubmit" class="btn btn-primary mr-2">Book Now</a> -->
                                <!--  <button type="submit" name="book" value="1" class="btn btn-primary mr-2" id="btnSubmit">Book Now</button>
                                <button type="submit" value="2" name="addtocart" class="btn btn-primary mr-2" id="butsave">Add to Cart</button> -->
								<button type="button" name="book" value="1" class="btn btn-primary mr-2" id="btnSubmit">Book Now</button>
                                <button type="button" value="2" name="addtocart" class="btn btn-primary mr-2" id="butsave">Add to Cart</button>
							</div>
						</form>
                          <!-- <button type="button" name="book" value="1" class="btn btn-primary mr-2" id="btnSubmit">Book Now</button>
                                <button type="button" value="2" name="addtocart" class="btn btn-primary mr-2" id="butsave">Add to Cart</button> -->
                       
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

$('#btnSubmit,#butsave').click(function(e){

    e.preventDefault(); 
    var btn1=$(this).val();
    var member_id =$('.member_validate option:selected').val();
    var address =$('.address_validate option:selected').val();
    var lab_test_id =$('.lab_test_validate option:selected').val();
    var date = $('#date').val();
    var time = $('#time').val();
    var complain = $('#complain').val();
    var cart_id = $('#cart_id').val();
    
    //var img_profile = $('#img_profile').val();
//alert(btn1);
    

    if(member_id !="" && address !="" && lab_test_id!="" && date!="" && time!="")
    {
        
            var fd = new FormData(add_Lab_appointment_form);
            fd.append('btn',btn1);
         $.ajax({
             url: "<?php echo base_url('updateLabCart'); ?>",
             type:"POST",
              dataType: 'text',
             //data:new FormData(this),
           // data:$('#add_Lab_appointment_form').serialize() + "&btn1=" + btn1,
           data : fd,
            processData:false,
             contentType:false,
             cache:false,
             // async:false,
            //fileElementId   :'img_profile',
           // dataType: 'html',
              success: function(data){
              	var obje = JSON.parse(data);

              	//data.btn
               // alert(obje);
                if(obje.btn=="1")
                {
                    window.location.href = '<?php echo base_url('userCart'); ?>';
                }
                else
                {
                    window.location.href = '<?php echo base_url('AppointmentList'); ?>';
                }
              
                 
           }
         });
     }
     else
     {
        
            var member_validate = $(".member_validate");
              var address_validate = $(".address_validate");
             var lab_test_validate = $(".lab_test_validate");
           
            if (member_validate.val() == null) {
                
                $('#member_id_valid').show();
                
                return false;
            }
            else
            {
                 $('#member_id_valid').hide();
            }

            if (address_validate.val() == null) {
                
                $('#address_valid_id').show();
                
                return false;
            }
            else
            {
                 $('#address_valid_id').hide();
            }

            if (lab_test_validate.val() == null) {
                
                $('#lab_test_id_valid').show();
                
                return false;
            }
            else
            {
                 $('#lab_test_id_valid').hide();
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
     }
});  
</script>