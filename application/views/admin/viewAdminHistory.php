
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">View Booking History</h5>
									<!--end::Page Title-->
								</div>
								<!--end::Info-->
							</div>
						</div>
						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
								<!--begin::Card-->
								
						<div class="row">
					
						<div class="col-xl-4">
						
				<div class="card card-custom">
					<div class="card-body p-0">
						
										
								<div class="card-header">
									
										            <span class="card-icon">
										            	<?php
										            	 // echo "<pre>";
										            	 // print_r($visit_book_history);
										            	 // exit;
										            	if($visit_book_history[0]['appointment_book_id']!= '')
										            	{
										            		?>
										            		<img src="<?php echo base_url()?>uploads/image/doctor.svg" class="h-55 align-self-end" />&nbsp;<b>Doctor</b>
										            		<?php
										            	}
										            	if($visit_book_history[0]['book_nurse_id'] !='')
										            	{
										            		?>
										            		<!-- <i class="fa fa-user-md" aria-hidden="true"></i> -->
										            		<img src="<?php echo base_url()?>uploads/image/nurse.svg" class="h-55 align-self-end" />&nbsp;<b>Nurse</b>
										            		<?php
										            	}
										            	if($visit_book_history[0]['book_laboratory_test_id'] != '')
										            	{
										            		?>
										            		<img src="<?php echo base_url()?>uploads/image/lab.svg" class="h-55 align-self-end" />&nbsp;<b>Lab</b>
										            		<?php
										            	}
										            	if($visit_book_history[0]['book_medicine_id'] !='')
										            	{
										            		?>
										            		<img src="<?php echo base_url()?>uploads/image/drug.svg" class="h-55 align-self-end" />&nbsp;<b>E-Pharmacy</b>
										            		<?php
										            	}
										            	if($visit_book_history[0]['book_ambulance_id']!='')
										            	{
										            		?>
										            		<img src="<?php echo base_url()?>uploads/image/ambulance.svg" class="h-55 align-self-end" />&nbsp;<b>Ambulance</b>
										            		<?php
										            	}
										            	?>
										               
										            </span>
										   
											
								</div>
								<div class="card-body">

								
									
			
 										
									<?php
							   		if($visit_book_history[0]['book_medicine_id']!='')
  									{

  									 ?>
  									      <br>
  									  <?php
  								    }
  								    else
  								    {
  								    	?>
  								    	<label>&nbsp;&#x20b9 <b>Price : </b><?php  echo $visit_book_history[0]['total']; ?></label><br>
  								   <?php }
  								   
  								    ?>
							   		
							   		<label><i class="fa fa-user-md" aria-hidden="true"></i> <b>Patient Name : </b><?php  echo $visit_book_history[0]['name']." (<b>UID :</b> ".$visit_book_history[0]['patient_code'].")"; ?></label><br>
							   		<?php
							   		if($visit_book_history[0]['book_medicine_id']!='')
  									{
  										
  									 ?>
  									 <label><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<b>Date : </b><?php  echo date("d-m-Y",strtotime($visit_book_history[0]['created_date'])); ?></label><br>
  									  <?php
  								    }
  								    else
  								    {
  								    	?>
  								    	<label><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<b>Date : </b><?php  echo date("d-m-Y",strtotime($visit_book_history[0]['date'])); ?></label><br>
  								   <?php }
  								   
  								    ?>
							   		
							   		<?php
							   		if($visit_book_history[0]['book_medicine_id']!='')
  									{

  									 ?>
  									  <!-- <label><i class="fa fa-calendar" aria-hidden="true"></i> <b>Time : </b> - </label><br> -->
  									  <?php
  								    }
  								    else
  								    {
  								    	?>
  								    	<label><i class="fa fa-calendar" aria-hidden="true"></i> <b>Time : </b><?php  echo $visit_book_history[0]['time']; ?></label><br>
  								   <?php }
  								   
  								    ?>
  		
  		<?php
  		if($visit_book_history[0]['book_ambulance_id']!='')
  		{
  			$multi_location_explode=explode(',@#-0,',$visit_book_history[0]['multi_city']);
			$multi_location_implode=implode('<br>',$multi_location_explode);
			?>
			<label><i class="fa fa-map-marker" aria-hidden="true"></i><?php if($visit_book_history[0]['from_address']!= '' && $visit_book_history[0]['to_address']!= '') {?> <b>From Address : </b><?php  echo $visit_book_history[0]['from_address'] ?><br><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To Address : </b><?php  echo $visit_book_history[0]['to_address'];} else {?> <b>Multi Location : </b><br><?php  echo $multi_location_implode; } ?></label><br>
			<?php
  		}
  		elseif($visit_book_history[0]['book_medicine_id']!='')
  		{
  			?>
  			<label><i class="fa fa-map-marker" aria-hidden="true"></i> <b>Address : </b><?php  echo $visit_book_history[0]['address']; ?></label><br>
  			<?php
  		}
  		else
  		{
  			?>
  			<label><i class="fa fa-map-marker" aria-hidden="true"></i> <b>Address : </b><?php  echo $visit_book_history[0]['address_1']." ".$visit_book_history[0]['address_2']; ?></label><br>
  			<label><i class="fa fa-phone-square" aria-hidden="true"></i>
 <b>Contact : </b><?php  echo $visit_book_history[0]['contact_no']; ?></label><br>
  			<?php
  		}
  		?>
  		
  		<?php
  		
  		if($visit_book_history[0]['book_laboratory_test_id']!='')
  		{
  			if($visit_book_history[0]['prescription']!=''){
			?>
			<label><i class="fa fa-image"></i>&nbsp;<b>Report :</b></label>&nbsp;&nbsp;<img src="<?php echo base_url().'uploads/lab_report/'.$visit_book_history[0]['prescription'] ?>" width="50" height="50"/>
								 				 <a href="<?php echo base_url().'admin/AppointmentList/download_lab_report/'.$visit_book_history[0]['prescription'] ?>">
								 				 <i class="fa fa-download" aria-hidden="true"></i>
								 				</a> <br>
			<?php
			}
			else
			{
				?>
				<label><i class="fa fa-image"></i>&nbsp;<b>Report :</b></label> No Report uploded.<br>
				<?php
			}
  		}
  		
  		?>
       
								
						</div>
												
							
						
												
						
					</div>
				</div>
			
			</div>
			<?php
  		
  		if($visit_book_history[0]['appointment_book_id']!='' || $visit_book_history[0]['book_nurse_id']!='' || $visit_book_history[0]['book_laboratory_test_id']!='' || 
  		$visit_book_history[0]['book_ambulance_id']!='' || $visit_book_history[0]['id']!='')
  		{
  			
			?>
			<div class="col-xl-4">
						
				<div class="card card-custom">
					<div class="card-body p-0">
						
										
								<div class="card-header">
									
										            
										           
														<span><b><font style="font-size: 24px;">Assign Appointment</font></b></span>	

													
										   
								</div>
								<?php
								// echo "<pre>";
								// print_r($assign_appointment_list);
								// echo "</pre>";
								$datetime = $assign_appointment_list[0]['date_time'];
								$date = date('Y-m-d', strtotime($datetime));
								$time = date('H:i:s', strtotime($datetime));
								?>
								<div class="card-body">

								
									
										  
	       							

							   	
	        						<?php

	        						if($assign_appointment_list[0][appointment_id]!='')
	        						{
	        							if($assign_appointment_list[0]['team_id']!='')
		        						{
		        							?>
		        							<label><i class="fa fa-user-md" aria-hidden="true"></i> <b>Team Name : </b><?php  echo $assign_appointment_list[0]['team_name']; ?></label><br>
		        							<?php
		        						}
		        						else
		        						{
		        							?>
		        							<label><i class="fa fa-user-md" aria-hidden="true"></i> <b>Employee Name : </b><?php  echo $assign_appointment_list[0]['first_name']." ".$assign_appointment_list[0]['last_name']; ?></label><br>
		        							<?php
		        						}
								   		?>
								   		<label><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<b>Date : </b><?php  echo date("d-m-Y",strtotime($date)); ?></label><br>
	  									<label><i class="fa fa-calendar" aria-hidden="true"></i> <b>Time : </b><?php  echo $time; ?></label><br><br><br><br>
		        					<?php
		        					}
		        					else
		        					{
		        						?>
		        						<center><label style="color:red;"><b>No Record Found</b></label></center><br><br><br><br><br>
		        					<?php
		        					}

	        						?>
							   		
  								</div>
												
							
						
												
						
					</div>
				</div>
			
			</div>
			<?php 
		}
		?>
			<?php
  		
  		if($visit_book_history[0]['appointment_book_id']!='' || $visit_book_history[0]['book_nurse_id']!='' || $visit_book_history[0]['book_laboratory_test_id']!='' || $visit_book_history[0]['book_ambulance_id']!='')
  		{
  			
			?>
			<div class="col-xl-4">
						
				<div class="card card-custom">
					<div class="card-body p-0">
						

								<div class="card-header">

									<!-- <div class="form-group"> -->
    
    <div class="checkbox-inline">
        <label class="checkbox checkbox-lg">
            <input type="checkbox"   name="add_fee_box" id="add_fee_box"/>
            <span  style=" border: 2px solid #ddd;border-radius: 5%;"></span>
            <b><font style="font-size: 16px;">Additional Payment</font></b>
        </label>
      
    </div>
    
<!-- </div>
 -->									
										            
										           
													<!-- <label class="checkbox checkbox-lg" >
													            <input type="checkbox"  name="add_fee_box" id="add_fee_box"/>
													            <span style=" border: 4px solid #ddd;
    															border-radius: 5%;"></span>
													           
													        </label>	
													        <span><b><font style="font-size: 24px;">Additional Payment</font></b>
															</span> -->	<!-- <input type="checkbox"  name="add_fee_box"  id="add_fee_box"> -->
															
													        <span style="color:green;">
														<div id="error_message" class="ajax_response"></div>
													    <div id="success_message" class="ajax_response"></div> 
													</span>
													
										   
								</div>
								<form method="post">
										
									<div class="show_amount_details" style="display: none;">
									<div class="card-body">

									
										   <div class="row">
												<div class="form-group col-md-12">
													<label>Amount</label>
													<input type="text" class="form-control"  placeholder="Amount" name="additional_payment" id="additional_payment"  onkeypress="return isNumberKey(event)"/>
													<div id="amount_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
												</div>
										</div>
										<?php
										// echo "<pre>";
										// print_r($visit_book_history);
										if($visit_book_history[0]['appointment_book_id']!='')
										{
											?>
											<input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $visit_book_history[0]['appointment_book_id'];?>">
											<input type="hidden" name="user_type_id" id="user_type_id" value="1">
											<input type="hidden" name="user_id" id="user_id" value="<?php echo $visit_book_history[0]['user_id'];?>">
											<?php
										}
										elseif($visit_book_history[0]['book_nurse_id']!='')
										{
											?>
											<input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $visit_book_history[0]['book_nurse_id'];?>">
											<input type="hidden" name="user_type_id" id="user_type_id" value="2">
											<input type="hidden" name="user_id" id="user_id" value="<?php echo $visit_book_history[0]['user_id'];?>">
											<input type="hidden" name="user_id" id="user_id" value="<?php echo $visit_book_history[0]['user_id'];?>">
											<!-- <div class="row">
							    	
									
												<div class="form-group col-md-12" >
													<label><b>Type Of Service *</b></label>
													<select class="form-control select2 nurse_service_validate" id="kt_select2_17" name="nurse_service_id"  >
														<option value="none" selected disabled hidden> Select Service Type </option>
														<?php 
															foreach($nurse_service_type as $ns){
																echo '<option value="'.$ns['nurse_service_id'].'">'.$ns['nurse_service_name'].'</option>';
															}
														?>
													</select>
													<div id="nurse_service_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
			                        				</div>
										
											</div>
 -->
											<?php
										}
										elseif($visit_book_history[0]['book_laboratory_test_id']!='')
										{
											?>
											<input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $visit_book_history[0]['book_laboratory_test_id'];?>">
												<input type="hidden" name="user_type_id" id="user_type_id" value="3">
												<input type="hidden" name="user_id" id="user_id" value="<?php echo $visit_book_history[0]['user_id'];?>">
											
											<?php
										}
										elseif($visit_book_history[0]['book_ambulance_id']!='')
										{
											?>
											<input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $visit_book_history[0]['book_ambulance_id'];?>">
												<input type="hidden" name="user_type_id" id="user_type_id" value="5">
												<input type="hidden" name="user_id" id="user_id" value="<?php echo $visit_book_history[0]['user_id'];?>">
											
											<?php
										}
										?>									
										<div class="row">
												<div class="form-group col-md-12">
													<label>Note</label>
													<textarea  class="form-control" name="additional_note" id="additional_note"></textarea> 
													<!-- <div id="amount_valid" class="validation" style="display:none;color:red;">Please Enter Value</div> -->
												</div>
										</div>

										<div class="row">
							    	
									
												<div class="form-group  col-md-12" >
													<label>Type Of Payment</label><br>
													<select class="form-control addition_payment_type_validate" id="kt_select2_14" name="additional_payment_type" style="width: 100%;">
														<!-- <option value="none" selected disabled hidden> Select Payment Type </option> -->
														<option value="Cash">Cash</option>	
														<option value="Online">Online</option>	                           
														<!-- <option value="NEFT">NEFT</option>
														<option value="UPI">UPI</option>
														<option value="Paytm">Paytm</option>         
														<option value="card">Debit/Credit card</option> -->
													</select>
													<div id="payment_type_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
												</div>
										</div>
										
							        </div>
									<div class="card-footer">
										<button type="button" class="btn btn-primary mr-2" id="addPayment">Save</button>
										<a href="<?php echo base_url(); ?>adminAppointmentList" class="btn btn-secondary">Cancel</a>
									</div>
									</div>		  
	       							
								</form>
							   	
	        						
							   		
  				</div>
												
							
						
												
						
					</div>
				</div>

				<?php
			}
			?>
			
			</div>
		<!-- </div> -->
		<br>
		<?php
			//echo "<pre>";
			//print_r($assign_appointment_list);
	        if($assign_appointment_list[0][service_id]==1 || $assign_appointment_list[0][service_id]==2)
	        {
	        ?>
		<div class="row">
					
			<div class="col-xl-6">
					<form method="post">
				<div class="card card-custom">
					<div class="card-body p-0">
						
									<input type="hidden" name="assign_appointment_id" id="assign_appointment_id_note" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
								<div class="card-header">
									
										         
										           	  <span><b><font style="font-size: 24px;">Visit Notes</font></b></span>
													<span style="color:green;">
														<div id="error_message" class="ajax_response"></div>
													    <div id="success_message" class="ajax_response"></div> 
													</span>
													
										   
											
								</div>
								<div class="card-body">
									<div class="row">
									<div class="form-group col-md-12">
										<label><b>Visitor Note *</b></label>
										<textarea class="form-control" name="visit_history_text" required="" id="editor1" ><?php echo $assign_appointment_list[0]['visit_history_text'];?></textarea>
										<div id="description_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									
									
								</div>	
  			  		
       							</div>
						<div class="card-footer">
								<button type="button" class="btn btn-primary mr-2" id="btnSubmit">Save</button>
								<a href="<?php echo base_url(); ?>adminAppointmentList"  class="btn btn-secondary">Cancel</a>
						</div>
												
							
						
												
						
					</div>
				</div>
				</form>	
			
			</div>
			<div class="col-xl-6">
					<form method="post">
				<div class="card card-custom">
					<div class="card-body p-0">
						
									<input type="hidden" name="assign_appointment_id" id="assign_appointment_id_note" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
								<div class="card-header">
									
										         
										           	  <span><b><font style="font-size: 24px;">ECG and XRAY</font></b></span>
													<span style="color:green;">
														<div id="error_message1" class="ajax_response"></div>
													    <div id="success_message1" class="ajax_response"></div> 
													</span>
													
										   
											
								</div>
								<div class="card-body">
									<div class="row">
									<div class="form-group col-md-12">
										<label><b>ECG and XRAY *</b></label>
										<textarea class="form-control" name="ecg_xray_note" required="" id="editor2" ><?php echo $assign_appointment_list[0]['ecg_xray_note'];?></textarea>
										<div id="ecg_description_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									
									
								</div>	
  			  		
       							</div>
						<div class="card-footer">
								<button type="button" class="btn btn-primary mr-2" id="btnSubmitECG">Save</button>
								<a href="<?php echo base_url(); ?>adminAppointmentList"  class="btn btn-secondary">Cancel</a>
						</div>
												
							
						
												
						
					</div>
				</div>
				</form>	
			
			</div>

		</div>
		<br>
		<div class="row">

			<?php
			if($this->session->userdata('admin_user')['user_type_id']==1 || $this->session->userdata('admin_user')['user_type_id']==2)
			{
				?>
				<div class="col-xl-6">
					<form method="post" enctype="multipart/form-data" id="add_appointment_prescription">
				<div class="card card-custom">
					<div class="card-body p-0">
						
									<input type="hidden" name="assign_appointment_id" id="assign_appointment_id_note" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
								<div class="card-header">
									
										         
										           	  <span><b><font style="font-size: 24px;">Prescription Upload</font></b></span>
													<span style="color:green;">
														<div id="error_message" class="ajax_response"></div>
													    <div id="success_message" class="ajax_response"></div> 
													</span>
													
										   
											
								</div>
								<div class="card-body">
									<div class="row">
									<div class="form-group col-md-12">
										<label><b>Prescription :</b></label>
                                            <input type="file" name="prescription[]" id="prescription" multiple>
                                                    
									</div>
									<div id="profile_image_validate" class="validation" style="display:none;color:red;">Please Select Maximum 5 image</div>
									
									
								</div>
								<div class="row">	
								 <div class="col-md-12 img1">

								 			<?php
								 			//echo "<pre>";
								 			//print_r($assign_appointment_list);
								 			$image=explode(',',$assign_appointment_list[0]['prescription']);
								 			$result = count($image);
								 			//echo $result;
								 			if($assign_appointment_list[0]['prescription']!='')
								 			{
								 			
									 			foreach ($image as $value) {
									 				//echo $value;
									 				$ext_image=explode('.',$value);
									 				//print_r($ext_image);
									 				if($ext_image[1]=='pdf'){
									 				?>
									 				 <i class="fa fa-file fa-3x" aria-hidden="true"></i>
													<a href="<?php echo base_url().'admin/AppointmentList/download_prescription/'.$value ?>">
									 				 <i class="fa fa-download" aria-hidden="true"></i>
									 				</a>
									 				<?php
									 				}
									 				else
									 				{
									 					?>
									 					<img src="<?php echo base_url().'uploads/appointment/prescription/'.$value ?>" width="50" height="50"/>
									 				 <a href="<?php echo base_url().'admin/AppointmentList/download_prescription/'.$value ?>">
									 				 <i class="fa fa-download" aria-hidden="true"></i>
									 				</a>
									 					<?php
									 				}

									 				# code...
									 			}
								 		}

								 			?>
	                                    	
	                                    </div>
	                                </div>	
  			  		
       							</div>
						<div class="card-footer">
								<button type="button" class="btn btn-primary mr-2" id="btnSubmitImage">Save</button>
								<a href="<?php echo base_url(); ?>adminAppointmentList"  class="btn btn-secondary">Cancel</a>
						</div>
												
							
						
												
						
					</div>
				</div>
				</form>	
			
			</div>
				<?php
			}
			elseif($this->session->userdata('admin_user')['user_type_id']==999)
			{
			    //echo "teet";
				?>
				<div class="col-xl-6">
					<form method="post" enctype="multipart/form-data" id="add_appointment_prescription">
				<div class="card card-custom">
					<div class="card-body p-0">
						
									<input type="hidden" name="assign_appointment_id" id="assign_appointment_id_note" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
								<div class="card-header">
									
										         
										           	  <span><b><font style="font-size: 24px;">Prescription Upload</font></b></span>
													<span style="color:green;">
														<div id="error_message" class="ajax_response"></div>
													    <div id="success_message" class="ajax_response"></div> 
													</span>
													
										   
											
								</div>
								<div class="card-body">
									<div class="row">
									<div class="form-group col-md-12">
										<label><b>Prescription :</b></label>
                                            <input type="file" name="prescription[]" id="prescription" multiple>
                                                    
									</div>
									<div id="profile_image_validate" class="validation" style="display:none;color:red;">Please Select Maximum 5 image</div>
									
									
								</div>
								<div class="row">	
								 <div class="col-md-12 img1">

								 			<?php
								 			//echo "<pre>";
								 			//print_r($assign_appointment_list);
								 			$image=explode(',',$assign_appointment_list[0]['prescription']);
								 			$result = count($image);
								 			//echo $result;
								 			if($assign_appointment_list[0]['prescription']!='')
								 			{
								 			
									 			foreach ($image as $value) {
									 				//echo $value;
									 				$ext_image=explode('.',$value);
									 				//print_r($ext_image);
									 				if($ext_image[1]=='pdf'){
									 				?>
									 				 <i class="fa fa-file fa-3x" aria-hidden="true"></i>
													<a href="<?php echo base_url().'admin/AppointmentList/download_prescription/'.$value ?>">
									 				 <i class="fa fa-download" aria-hidden="true"></i>
									 				</a>
									 				<?php
									 				}
									 				else
									 				{
									 					?>
									 					<img src="<?php echo base_url().'uploads/appointment/prescription/'.$value ?>" width="50" height="50"/>
									 				 <a href="<?php echo base_url().'admin/AppointmentList/download_prescription/'.$value ?>">
									 				 <i class="fa fa-download" aria-hidden="true"></i>
									 				</a>
									 					<?php
									 				}

									 				# code...
									 			}
								 		}

								 			?>
	                                    	
	                                    </div>
	                                </div>	
  			  		
       							</div>
						<div class="card-footer">
								<button type="button" class="btn btn-primary mr-2" id="btnSubmitImage">Save</button>
								<a href="<?php echo base_url(); ?>adminAppointmentList"  class="btn btn-secondary">Cancel</a>
						</div>
												
							
						
												
						
					</div>
				</div>
				</form>	
			
			</div>
				<div class="col-xl-6">
					<form method="post" enctype="multipart/form-data" id="add_appointment_lab">
				<div class="card card-custom">
					<div class="card-body p-0">
						
									<input type="hidden" name="assign_appointment_id" id="assign_appointment_id_note" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
								<div class="card-header">
									
										         
										           	  <span><b><font style="font-size: 24px;">Lab Report</font></b></span>
													<span style="color:green;">
														<div id="error_message" class="ajax_response"></div>
													    <div id="success_message" class="ajax_response"></div> 
													</span>
													
										   
											
								</div>
								<div class="card-body">
									<div class="row">
									<div class="form-group col-md-12">
										<label><b>Lab Report:</b></label>
                                                      <input type="file" name="lab_report[]" id="lab_report" multiple="">
                                                    
									</div>
									<div id="profile_lab_validate" class="validation" style="display:none;color:red;">Please Select Maximum 5 image</div>
									
									
								</div>
								<div class="row">	
								 <div class="col-md-12 img1">

								 			<?php
								 			//echo "<pre>";
								 			//print_r($assign_appointment_list);
								 			$image=explode(',',$assign_appointment_list[0]['lab_report']);
								 			$result = count($image);
								 			//echo $result;
								 			if($assign_appointment_list[0]['lab_report']!='')
								 			{
								 			
									 			foreach ($image as $value) {
									 				//echo $value;
									 				$ext_image=explode('.',$value);
									 				//print_r($ext_image);
									 				if($ext_image[1]=='pdf'){
									 				?>
									 				 <i class="fa fa-file fa-3x" aria-hidden="true"></i>
													<a href="<?php echo base_url().'admin/AppointmentList/download_lab/'.$value ?>">
									 				 <i class="fa fa-download" aria-hidden="true"></i>
									 				</a>
									 				<?php
									 				}
									 				else
									 				{
									 					?>
									 					<img src="<?php echo base_url().'uploads/appointment/lab_report/'.$value ?>" width="50" height="50"/>
									 				 <a href="<?php echo base_url().'admin/AppointmentList/download_lab/'.$value ?>">
									 				 <i class="fa fa-download" aria-hidden="true"></i>
									 				</a>
									 					<?php
									 				}

									 				# code...
									 			}
								 		}

								 			?>
	                                    	
	                                    </div>
	                                </div>	
  			  		
       							</div>
						<div class="card-footer">
								<button type="button" class="btn btn-primary mr-2" id="btnSubmitLabImage">Save</button>
								<a href="<?php echo base_url(); ?>adminAppointmentList"  class="btn btn-secondary">Cancel</a>
						</div>
												
							
						
												
						
					</div>
				</div>
				</form>	
			
			</div>
				<?php
			}
			?>		
			
			
			
		</div>

			<?php
			}
			?>
			<?php
			if($assign_appointment_list[0][service_id]==3)
	        {
	        ?>
		<div class="row">
					
			<div class="col-xl-12">
					<form method="post">
				<div class="card card-custom">
					<div class="card-body p-0">
						
									<input type="hidden" name="assign_appointment_id" id="assign_appointment_id_note" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
								<div class="card-header">
									
										         
										           	  <span><b><font style="font-size: 24px;">Lab Notes</font></b></span>
													<span style="color:green;">
														<div id="error_message" class="ajax_response"></div>
													    <div id="success_message" class="ajax_response"></div> 
													</span>
													
										   
											
								</div>
								<div class="card-body">
									<div class="row">
									<div class="form-group col-md-12">
										<label><b>Lab Notes *</b></label>
										<textarea class="form-control" name="visit_history_text" required="" id="editor1" ><?php echo $assign_appointment_list[0]['visit_history_text'];?></textarea>
										<div id="description_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									
									
								</div>
								<!-- <div class="row">	
								 
	                                </div> -->
  			  		
       							</div>
						<div class="card-footer">
								<button type="button" class="btn btn-primary mr-2" id="btnSubmit">Save</button>
								<a href="<?php echo base_url(); ?>adminAppointmentList"  class="btn btn-secondary">Cancel</a>
						</div>
												
							
						
												
						
					</div>
				</div>
				</form>	
			
			</div>
		</div>
		<br>
		<div class="row">
			<!-- <div class="col-xl-6">
					<form method="post" enctype="multipart/form-data" id="add_appointment_prescription">
				<div class="card card-custom">
					<div class="card-body p-0">
						
									<input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
								<div class="card-header">
									
										         
										           	  <span><b><font style="font-size: 24px;">Prescription Upload</font></b></span>
													<span style="color:green;">
														<div id="error_message" class="ajax_response"></div>
													    <div id="success_message" class="ajax_response"></div> 
													</span>
													
										   
											
								</div>
								<div class="card-body">
									<div class="row">
									<div class="form-group col-md-12">
										<label><b>Prescription :</b></label>
                                                      <input type="file" name="prescription[]" id="prescription" multiple="">
                                                    
									</div>
									<div id="profile_image_validate" class="validation" style="display:none;color:red;">Please Select Profile image</div>
									
									
								</div>	
								<div class="row">	
								 <div class="col-md-12 img2">

								 			<?php
								 			//echo "<pre>";
								 			//print_r($assign_appointment_list);
								 			$image=explode(',',$assign_appointment_list[0]['prescription']);
								 			$result = count($image);
								 			if($assign_appointment_list[0]['prescription']!='')
								 			{
								 			
										 			foreach ($image as $value) {
										 				//echo $value;
										 				$ext_image=explode('.',$value);
										 				//print_r($ext_image);
										 				if($ext_image[1]=='pdf'){
										 				?>
										 				 <i class="fa fa-file fa-3x" aria-hidden="true"></i>
														<a href="<?php echo base_url().'admin/AppointmentList/download_prescription/'.$value ?>">
										 				 <i class="fa fa-download" aria-hidden="true"></i>
										 				</a>
										 				<?php
										 				}
										 				else
										 				{
										 					?>
										 					<img src="<?php echo base_url().'uploads/appointment/prescription/'.$value ?>" width="50" height="50"/>
										 				 <a href="<?php echo base_url().'admin/AppointmentList/download_prescription/'.$value ?>">
										 				 <i class="fa fa-download" aria-hidden="true"></i>
										 				</a>
										 					<?php
										 				}

										 				# code...
										 			}
								 		    }
								 			

								 			?>
	                                    	
	                                    </div>
	                                </div>
  			  		
       							</div>
						<div class="card-footer">
								<button type="button" class="btn btn-primary mr-2" id="btnSubmitImage">Save</button>
								<a href="<?php echo base_url(); ?>adminAppointmentList"  class="btn btn-secondary">Cancel</a>
						</div>
												
							
						
												
						
					</div>
				</div>
				</form>	
			
			</div> -->
			<div class="col-xl-12">
					<form method="post" enctype="multipart/form-data" id="add_appointment_lab">
				<div class="card card-custom">
					<div class="card-body p-0">
						
									<input type="hidden" name="assign_appointment_id" id="assign_appointment_id_note" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
								<div class="card-header">
									
										         
										           	  <span><b><font style="font-size: 24px;">Lab Report</font></b></span>
													<span style="color:green;">
														<div id="error_message" class="ajax_response"></div>
													    <div id="success_message" class="ajax_response"></div> 
													</span>
													
										   
											
								</div>
								<div class="card-body">
									<div class="row">
									<div class="form-group col-md-12">
										<label><b>Lab Report:</b></label>
                                                      <input type="file" name="lab_report[]" id="lab_report" multiple="">
                                                    
									</div>
									<div id="profile_image_validate" class="validation" style="display:none;color:red;">Please Select Maximum 5 image</div>
									
									
								</div>
								<div class="row">	
								 <div class="col-md-12 img1">

								 			<?php
								 			//echo "<pre>";
								 			//print_r($assign_appointment_list);
								 			$image=explode(',',$assign_appointment_list[0]['lab_report']);
								 			$result = count($image);
								 			//echo $result;
								 			if($assign_appointment_list[0]['lab_report']!='')
								 			{
								 			
									 			foreach ($image as $value) {
									 				//echo $value;
									 				$ext_image=explode('.',$value);
									 				//print_r($ext_image);
									 				if($ext_image[1]=='pdf'){
									 				?>
									 				 <i class="fa fa-file fa-3x" aria-hidden="true"></i>
													<a href="<?php echo base_url().'admin/AppointmentList/download_lab/'.$value ?>">
									 				 <i class="fa fa-download" aria-hidden="true"></i>
									 				</a>
									 				<?php
									 				}
									 				else
									 				{
									 					?>
									 					<img src="<?php echo base_url().'uploads/appointment/lab_report/'.$value ?>" width="50" height="50"/>
									 				 <a href="<?php echo base_url().'admin/AppointmentList/download_lab/'.$value ?>">
									 				 <i class="fa fa-download" aria-hidden="true"></i>
									 				</a>
									 					<?php
									 				}

									 				# code...
									 			}
								 		    }

								 			?>
	                                    	
	                                    </div>
	                                </div>	
  			  		
       							</div>
						<div class="card-footer">
								<button type="button" class="btn btn-primary mr-2" id="btnSubmitLabImage">Save</button>
								<a href="<?php echo base_url(); ?>adminAppointmentList"  class="btn btn-secondary">Cancel</a>
						</div>
												
							
						
												
						
					</div>
				</div>
				</form>	
			
			</div>
		</div>

		
		<br>
		
			<?php
			}
			?>	
			<?php
			if($assign_appointment_list[0][service_id]==4)
	        {
	        ?>
		<div class="row">
					
			<div class="col-xl-12">
					<form method="post">
				<div class="card card-custom">
					<div class="card-body p-0">
						
									<input type="hidden" name="assign_appointment_id" id="assign_appointment_id_note" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
								<div class="card-header">
									
										         
										           	  <span><b><font style="font-size: 24px;">Prescription Notes</font></b></span>
													<span style="color:green;">
														<div id="error_message" class="ajax_response"></div>
													    <div id="success_message" class="ajax_response"></div> 
													</span>
													
										   
											
								</div>
								<div class="card-body">
									<div class="row">
									<div class="form-group col-md-12">
										<label><b>Prescription Notes *</b></label>
										<textarea class="form-control" name="visit_history_text" required="" id="editor1" ><?php echo $assign_appointment_list[0]['visit_history_text'];?></textarea>
										<div id="description_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									
									
								</div>	

  			  		
       							</div>
						<div class="card-footer">
								<button type="button" class="btn btn-primary mr-2" id="btnSubmit">Save</button>
								<a href="<?php echo base_url(); ?>adminAppointmentList"  class="btn btn-secondary">Cancel</a>
						</div>
												
							
						
												
						
					</div>
				</div>
				</form>	
			
			</div>

		</div>
		<br>
		<div class="row">
			<div class="col-xl-12">
					<form method="post" enctype="multipart/form-data" id="add_appointment_prescription">
				<div class="card card-custom">
					<div class="card-body p-0">
						
									<input type="hidden" name="assign_appointment_id" id="assign_appointment_id_note" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
								<div class="card-header">
									
										         
										           	  <span><b><font style="font-size: 24px;">Prescription Upload</font></b></span>
													<span style="color:green;">
														<div id="error_message" class="ajax_response"></div>
													    <div id="success_message" class="ajax_response"></div> 
													</span>
													
										   
											
								</div>
								<div class="card-body">
									<div class="row">
									<div class="form-group col-md-12">
										<label><b>Prescription :</b></label>
                                                      <input type="file" name="prescription[]" id="prescription" multiple="">
                                                    
									</div>
									<div id="profile_image_validate" class="validation" style="display:none;color:red;">Please Select Profile image</div>
									
									
								</div>
								<div class="row">	
								 <div class="col-md-12 img1">

								 			<?php
								 			//echo "<pre>";
								 			//print_r($assign_appointment_list);
								 			$image=explode(',',$assign_appointment_list[0]['prescription']);
								 			$result = count($image);
								 			if($assign_appointment_list[0]['prescription']!='')
								 			{
										 			foreach ($image as $value) {
										 				//echo $value;
										 				$ext_image=explode('.',$value);
										 				//print_r($ext_image);
										 				if($ext_image[1]=='pdf'){
										 				?>
										 				 <i class="fa fa-file fa-3x" aria-hidden="true"></i>
														<a href="<?php echo base_url().'admin/AppointmentList/download_prescription/'.$value ?>">
										 				 <i class="fa fa-download" aria-hidden="true"></i>
										 				</a>
										 				<?php
										 				}
										 				else
										 				{
										 					?>
										 					<img src="<?php echo base_url().'uploads/appointment/prescription/'.$value ?>" width="50" height="50"/>
										 				 <a href="<?php echo base_url().'admin/AppointmentList/download_prescription/'.$value ?>">
										 				 <i class="fa fa-download" aria-hidden="true"></i>
										 				</a>
										 					<?php
										 				}

										 				# code...
										 			}
								 		    }
								 			// echo $result;
								 			// foreach ($variable as $key => $value) {
								 			// 	# code...
								 			// }
								 			//$image=implode(',',$assign_appointment_list[0]['prescription']);

								 			?>
	                                    	
	                                    </div>
	                                </div>	
  			  		
       							</div>
						<div class="card-footer">
								<button type="button" class="btn btn-primary mr-2" id="btnSubmitImage">Save</button>
								<a href="<?php echo base_url(); ?>adminAppointmentList"  class="btn btn-secondary">Cancel</a>
						</div>
												
							
						
												
						
					</div>
				</div>
				</form>	
			
			</div>
			<!-- <div class="col-xl-6">
					<form method="post" enctype="multipart/form-data" id="add_appointment_lab">
				<div class="card card-custom">
					<div class="card-body p-0">
						
									<input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
								<div class="card-header">
									
										         
										           	  <span><b><font style="font-size: 24px;">Lab Report</font></b></span>
													<span style="color:green;">
														<div id="error_message" class="ajax_response"></div>
													    <div id="success_message" class="ajax_response"></div> 
													</span>
													
										   
											
								</div>
								<div class="card-body">
									<div class="row">
									<div class="form-group col-md-12">
										<label><b>Lab Report:</b></label>
                                                      <input type="file" name="lab_report[]" id="lab_report" multiple="">
                                                    
									</div>
									<div id="lab_report_validate" class="validation" style="display:none;color:red;">Please Select Maximum 5 image</div>
									
									
								</div>
								<div class="row">	
								 <div class="col-md-12 img1">

								 			<?php
								 			//echo "<pre>";
								 			//print_r($assign_appointment_list);
								 			$image=explode(',',$assign_appointment_list[0]['lab_report']);
								 			$result = count($image);
								 			//echo $result;
								 			if($assign_appointment_list[0]['lab_report']!='')
								 			{
								 			
									 			foreach ($image as $value) {
									 				//echo $value;
									 				$ext_image=explode('.',$value);
									 				//print_r($ext_image);
									 				if($ext_image[1]=='pdf'){
									 				?>
									 				 <i class="fa fa-file fa-3x" aria-hidden="true"></i>
													<a href="<?php echo base_url().'admin/AppointmentList/download/'.$value ?>">
									 				 <i class="fa fa-download" aria-hidden="true"></i>
									 				</a>
									 				<?php
									 				}
									 				else
									 				{
									 					?>
									 					<img src="<?php echo base_url().'uploads/appointment/lab_report/'.$value ?>" width="50" height="50"/>
									 				 <a href="<?php echo base_url().'admin/AppointmentList/download_lab/'.$value ?>">
									 				 <i class="fa fa-download" aria-hidden="true"></i>
									 				</a>
									 					<?php
									 				}

									 				# code...
									 			}
								 		}

								 			?>
	                                    	
	                                    </div>
	                                </div>	
  			  		
       							</div>
						<div class="card-footer">
								<button type="button" class="btn btn-primary mr-2" id="btnSubmitLabImage">Save</button>
								<a href="<?php echo base_url(); ?>adminAppointmentList"  class="btn btn-secondary">Cancel</a>
						</div>
												
							
						
												
						
					</div>
				</div>
				</form>	
			
			</div> -->
		</div>
		</div>
		<br>
		
			<?php
			}
			?>
				
			
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>

				</div>

	
					<!--end::Content-->



<script src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	CKEDITOR.replace('editor1');
	CKEDITOR.replace('editor2');
</script>

<script type="text/javascript">

// Ajax post
$(document).ready(function() 
{
$("#btnSubmit").click(function() 
{
//var member =$('.member_validate option:selected').val();
//var address =$('.address_validate option:selected').val();
 //var note = $('#vi').val();
 var visit_history_text = CKEDITOR.instances['editor1'].getData();
 //var visit_history_text = CKEDITOR.instances.visit_history_text.getData();

// alert(visit_history_text);

//alert(member);

	var assign_appointment_id = $('#assign_appointment_id_note').val();
	//alert(assign_appointment_id);
	//var time = $('#time').val();
	//var doctor_type_validate =$('.doctor_type_validate option:selected').val();

	
			jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url('addVisitNotes'); ?>",
			dataType: 'html',
			data: {visit_history_text:visit_history_text,assign_appointment_id:assign_appointment_id},
			success: function(data) 
			{

					$('#success_message').fadeIn().html(data);
					window.location.href = '<?php echo base_url('adminAppointmentList'); ?>';
					setTimeout(function() {
						$('#success_message').fadeOut("slow");
					}, 5000 );
			},
			error:function()
			{
				//alert('data not saved');	
			}
		});
	

});
});
</script>
<script type="text/javascript">

// Ajax post
$(document).ready(function() 
{
$("#btnSubmitECG").click(function() 
{

	 var ecg_and_xray_text = CKEDITOR.instances['editor2'].getData();
	 var assign_appointment_id = $('#assign_appointment_id_note').val();
	

	
	jQuery.ajax({
	type: "POST",
	url: "<?php echo base_url('addEcgXrayNotes'); ?>",
	dataType: 'html',
	data: {ecg_and_xray_text:ecg_and_xray_text,assign_appointment_id:assign_appointment_id},
		success: function(data) 
		{

				$('#success_message1').fadeIn().html(data);
				setTimeout(function() {
					$('#success_message1').fadeOut("slow");
				}, 5000 );
		},
		error:function()
		{
			//alert('data not saved');	
		}
	});
	

});
});
</script>
<script type="text/javascript">

$('#btnSubmitImage').click(function(e){

	//alert("testete");
    e.preventDefault(); 
    //alert("test");
    var fileInput = $('#prescription')[0];
     if(fileInput.files.length > 0 && fileInput.files.length < 6){
            //var formData = new FormData();
             var formData = new FormData(add_appointment_prescription);
            // $.each(fileInput.files, function(k,file){
            //     formData.append('prescription[]', file);
            // });
             //alert(form)
            $.ajax({
                method: 'post',
                //url:"/multi_uploader/process",
                url: "<?php echo base_url('uploadPrescription'); ?>",
                data: formData,
                dataType: 'text',
                contentType: false,
                processData: false,
                success: function(data){

                	var dataResult = JSON.parse(data);
                	//alert(dataResult);
                	if(dataResult.message!='')
                	{
                			window.location.href = '<?php echo base_url('adminAppointmentList'); ?>';
                	}
                	
                	//alert(dataResult.message);
    //                 $('#success_message').fadeIn().html(dataResult.message);
				// setTimeout(function() {
				// 	$('#success_message').fadeOut("slow");
				// }, 5000 );
               }
            });
        }
        else{

        	 //var fileInput = $('#prescription')[0];
        	//alert(fileInput.files.length);
        	if(fileInput.files.length == 0 || fileInput.files.length >= 6)
        	{

        		$('#profile_image_validate').show();
                
                return false;
        	}
        	else
        	{
        		$('#profile_image_validate').hide();
                
               
        	}
        	return true;

          //  console.log('No Files Selected');
        }
     //alert(fileInput);
});  
</script>
<script type="text/javascript">

$('#btnSubmitLabImage').click(function(e){

	//alert("testete");
    e.preventDefault(); 
    //alert("test");
    var fileInput = $('#lab_report')[0];
     if(fileInput.files.length > 0 && fileInput.files.length < 6){
            //var formData = new FormData();
             var formData = new FormData(add_appointment_lab);
            // $.each(fileInput.files, function(k,file){
            //     formData.append('prescription[]', file);
            // });
             //alert(form)
            $.ajax({
                method: 'post',
                //url:"/multi_uploader/process",
                url: "<?php echo base_url('uploadLabReport'); ?>",
                data: formData,
                dataType: 'text',
                contentType: false,
                processData: false,
                success: function(data){

                	var dataResult = JSON.parse(data);
                	//alert(dataResult);
                	if(dataResult.message!='')
                	{
                			window.location.href = '<?php echo base_url('adminAppointmentList'); ?>';
                	}
                	
                	//alert(dataResult.message);
    //                 $('#success_message').fadeIn().html(dataResult.message);
				// setTimeout(function() {
				// 	$('#success_message').fadeOut("slow");
				// }, 5000 );
               }
            });
        }
        else{

        	 //var fileInput = $('#prescription')[0];
        	//alert(fileInput.files.length);
        	if(fileInput.files.length == 0 || fileInput.files.length >= 6)
        	{

        		$('#profile_image_validate').show();
                
                return false;
        	}
        	else
        	{
        		$('#profile_image_validate').hide();
                
               
        	}
        	return true;

          //  console.log('No Files Selected');
        }
     //alert(fileInput);
});  
</script>
<script>
    $(document).ready(function () {

      $('input[id^="add_fee_box"]').click(function () {
      

        if ($(this).prop('checked')) {
           // do what you need here    
            
           $(".show_amount_details").show();
           // alert("Checked");
        }
        else {
           // do what you need here 
           $(".show_amount_details").hide();        
           //alert("Unchecked");
        }
      });

  });
</script>
<script type="text/javascript">

// Ajax post
$(document).ready(function() 
{
$("#addPayment").click(function() 
{


//alert(member);
var assign_appointment_id = $('#assign_appointment_id').val();

	var additional_payment = $('#additional_payment').val();
	var message = $('textarea#additional_note').val();

	var user_type_id = $('#user_type_id').val();
	var user_id = $('#user_id').val();
	var nurse_type_validate =$('.nurse_service_validate option:selected').val();
	var lab_test_validate =$('.lab_test_validate option:selected').val();
	//alert(type_validate);
	var additional_payment_type =$('.addition_payment_type_validate option:selected').val();

	//alert(additional_payment_type);
	//var time = $('#time').val();
	//var doctor_type_validate =$('.doctor_type_validate option:selected').val();

	
			jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url('addAdditonalPayment'); ?>",
			dataType: 'html',
			data: {additional_payment:additional_payment,assign_appointment_id:assign_appointment_id,message:message,user_type_id:user_type_id,nurse_type_validate:nurse_type_validate,lab_test_validate:lab_test_validate,user_id:user_id,additional_payment_type:additional_payment_type},
			success: function(data) 
			{
				var additional_payment = $('#additional_payment').val('');
				var message = $('textarea#additional_note').val('');
					$('#success_message').fadeIn().html(data);
					setTimeout(function() {
						$('#success_message').fadeOut("slow");
					}, 5000 );
			},
			error:function()
			{
				//alert('data not saved');	
			}
		});
	

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
<!-- <script type="text/javascript">

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


 