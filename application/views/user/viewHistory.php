
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
							   		
							   		<!-- <label><i class="fa fa-user-md" aria-hidden="true"></i> <b>Patient Name : </b><?php  echo $visit_book_history[0]['name']; ?></label><br> -->
							   		<label><i class="fa fa-user-md" aria-hidden="true"></i> <b>Patient Name : </b><?php  echo $visit_book_history[0]['name']." ( <b>UID :</b> ".$visit_book_history[0]['patient_code']." )"; ?></label><br>
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
			<label><i class="fa fa-phone-square" aria-hidden="true"></i>
 			<b>Contact : </b><?php  echo $visit_book_history[0]['contact_no']; ?></label><br>
			<?php
  		}
  		elseif($visit_book_history[0]['book_medicine_id']!='')
  		{
  			?>
  			<label><i class="fa fa-map-marker" aria-hidden="true"></i> <b>Address : </b><?php  echo $visit_book_history[0]['address']; ?></label><br>
  			<label><i class="fa fa-phone-square" aria-hidden="true"></i>
 			<b>Contact : </b><?php  echo $visit_book_history[0]['mobile']; ?></label><br>
 			<?php
  		
		  		// if($visit_book_history[0]['book_laboratory_test_id']!='')
		  		// {
		  			if($visit_book_history[0]['prescription']!=''){
					?>
					<label><i class="fa fa-image"></i>&nbsp;<b>Report :</b></label>&nbsp;&nbsp;<img src="<?php echo base_url().'uploads/pharmacy_document/'.$visit_book_history[0]['prescription'] ?>" width="50" height="50"/>
										 				 <a href="<?php echo base_url().'user/BookingHistory/download_pharmacy_report/'.$visit_book_history[0]['prescription'] ?>">
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
		  		//}
  		
  		?>

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

  		
  		if($visit_book_history[0]['appointment_book_id']!='' && $visit_book_history[0]['paid_flag']==0 && $visit_book_history[0]['total']!=0.00 
  			&& $visit_book_history[0]['responsestatus']=="TXN_PENDING")
  		{
  			?>
  			<form method="POST" action="<?php echo base_url(); ?>responsePaymentPay">
	  				<input type="hidden" name="user_type_id" id="user_type_id" value="1">
	  				<input type="hidden" name="appointment_id" id="appointment_id" value="<?php echo $visit_book_history[0]['appointment_book_id'];?>">
	  				<input type="hidden" name="amount" id="amount" value="<?php echo $visit_book_history[0]['total'];?>">
	  				<input type="hidden" name="user_id" value="<?php echo $visit_book_history[0]['user_id']; ?>"/>
					<input type="hidden" name="REQUEST_TYPE" value="SEAMLESS"/>
					<input type="hidden" name="ORDER_ID" value="<?php echo  "ORDS" . rand(10000,99999999)?>"/>
					<input type="hidden" name="INDUSTRY_TYPE_ID" value="Retail"/>
					<input type="hidden" name="CHANNEL_ID" value="WEB"/>
					<button type="submit" class="btn btn-primary mr-2" id="paymentPaid">Pay</button>
  			</form>
  			
  			<?php
  		}
  		elseif ($visit_book_history[0]['book_nurse_id']!='' && $visit_book_history[0]['paid_flag']==0 && $visit_book_history[0]['total']!=0.00 && $visit_book_history[0]['responsestatus']=='TXN_PENDING') {
  			?>
  			<form method="POST" action="<?php echo base_url(); ?>responsePaymentPay">
	  				<input type="hidden" name="user_type_id" id="user_type_id" value="2">
	  				<input type="hidden" name="appointment_id" id="appointment_id" value="<?php echo $visit_book_history[0]['book_nurse_id'];?>">
	  				<input type="hidden" name="amount" id="amount" value="<?php echo $visit_book_history[0]['total'];?>">
	  				<input type="hidden" name="user_id" value="<?php echo $visit_book_history[0]['user_id']; ?>"/>
					<input type="hidden" name="REQUEST_TYPE" value="SEAMLESS"/>
					<input type="hidden" name="ORDER_ID" value="<?php echo  "ORDS" . rand(10000,99999999)?>"/>
					<input type="hidden" name="INDUSTRY_TYPE_ID" value="Retail"/>
					<input type="hidden" name="CHANNEL_ID" value="WEB"/>
					<button type="submit" class="btn btn-primary mr-2" id="paymentPaid">Pay</button>
  			</form>
  			
  			<?php
  		}
  		elseif($visit_book_history[0]['book_laboratory_test_id']!='' && $visit_book_history[0]['paid_flag']==0 && $visit_book_history[0]['total']!=0.00 && $visit_book_history[0]['responsestatus']=='TXN_PENDING')
  		{
			?>
  			<form method="POST" action="<?php echo base_url(); ?>responsePaymentPay">
	  				<input type="hidden" name="user_type_id" id="user_type_id" value="3">
	  				<input type="hidden" name="appointment_id" id="appointment_id" value="<?php echo $visit_book_history[0]['book_laboratory_test_id'];?>">
	  				<input type="hidden" name="amount" id="amount" value="<?php echo $visit_book_history[0]['total'];?>">
	  				<input type="hidden" name="user_id" value="<?php echo $visit_book_history[0]['user_id']; ?>"/>
					<input type="hidden" name="REQUEST_TYPE" value="SEAMLESS"/>
					<input type="hidden" name="ORDER_ID" value="<?php echo  "ORDS" . rand(10000,99999999)?>"/>
					<input type="hidden" name="INDUSTRY_TYPE_ID" value="Retail"/>
					<input type="hidden" name="CHANNEL_ID" value="WEB"/>
					<button type="submit" class="btn btn-primary mr-2" id="paymentPaid">Pay</button>
  			</form>
  			<?php
  		}
  		elseif($visit_book_history[0]['book_ambulance_id']!='' && $visit_book_history[0]['paid_flag']==0 && $visit_book_history[0]['total']!=0.00 && $visit_book_history[0]['responsestatus']=='TXN_PENDING')
  		{
  			?>
  			<form method="POST" action="<?php echo base_url(); ?>responsePaymentPay">
	  				<input type="hidden" name="user_type_id" id="user_type_id" value="5">
	  				<input type="hidden" name="appointment_id" id="appointment_id" value="<?php echo $visit_book_history[0]['book_ambulance_id'];?>">
	  				<input type="hidden" name="amount" id="amount" value="<?php echo $visit_book_history[0]['amount'];?>">
	  				<input type="hidden" name="user_id" value="<?php echo $visit_book_history[0]['user_id']; ?>"/>
					<input type="hidden" name="REQUEST_TYPE" value="SEAMLESS"/>
					<input type="hidden" name="ORDER_ID" value="<?php echo  "ORDS" . rand(10000,99999999)?>"/>
					<input type="hidden" name="INDUSTRY_TYPE_ID" value="Retail"/>
					<input type="hidden" name="CHANNEL_ID" value="WEB"/>
					<button type="submit" class="btn btn-primary mr-2" id="paymentPaid">Pay</button>
  			</form>
  			<?php
  		}
  		?>
  		
       
							     

						

							  

							  

								
								 	

								
                               
								
								
								
						</div>
												
							
						
												
						
					</div>
				</div>
			
			</div>
			<?php if($visit_book_history[0]['book_medicine_id']=='')
			{
				?>
			<div class="col-xl-4">
						
				<div class="card card-custom">
					<div class="card-body p-0">
						
										
								<div class="card-header">
									
										            <!-- <span class="card-icon">
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
										            		<img src="<?php echo base_url()?>uploads/image/drug.svg" class="h-55 align-self-end" />&nbsp;<b>Pharmacy</b>
										            		<?php
										            	}
										            	if($visit_book_history[0]['book_ambulance_id']!='')
										            	{
										            		?>
										            		<img src="<?php echo base_url()?>uploads/image/ambulance.svg" class="h-55 align-self-end" />&nbsp;<b>Ambulance</b>
										            		<?php
										            	}
										            	?>
										               
										            </span> -->
										           
														<span><b><font style="font-size: 24px;">Appointment Details</font></b></span>	

														
													
										   
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
	  									<label><i class="fa fa-calendar" aria-hidden="true"></i> <b>Time : </b><?php  echo $time; ?></label><br><br><br>

	  									
		        					<?php
		        					}
		        					else
		        					{
		        						?>
		        						<center><label style="color:red;"><b>No Record Found</b></label></center><br><br><br><br><br>
		        					<?php
		        					}

	        						?>
	        						<?php
	        			// 				print_r($visit_book_history);
	  									// echo $visit_book_history[0][date]."<br>";
	  									// echo $visit_book_history[0][responsecode];
	  									// echo date('Y-m-d');
	  									$date_today_apt=date('Y-m-d');
	  									//
	  									if(($visit_book_history[0][date] < $date_today_apt) && ($visit_book_history[0][responsestatus]=="TXN_SUCCESS"))
	  									{
	  										?>
	  										 <label><a href="<?php echo base_url().'addComplain'?>">Post Feedback.</a></label>
	  										<?php

	  									}
	  										?>
							   		
  								</div>
												
							
						
												
						
					</div>
				</div>
			
			</div>
			<div class="col-xl-4">
						
				<div class="card card-custom">
					<div class="card-body p-0">
						

								<div class="card-header">
									
										            
										           
														<span><b><font style="font-size: 24px;">Additional Payment</font></b>
															</span>	<!-- <input type="checkbox"  name="add_fee_box"  id="add_fee_box"> -->
															<!-- <label class="checkbox checkbox-lg" style="margin-left: 74%;margin-top:-9%;">
													            <input type="checkbox"  name="add_fee_box" id="add_fee_box"/>
													            <span style=" border: 4px solid #ddd;
    															border-radius: 5%;"></span>
													           
													        </label>
													        <span style="color:green;">
														<div id="error_message" class="ajax_response"></div>
													    <div id="success_message" class="ajax_response"></div> 
													</span> -->
													
										   
								</div>

								<form method="post" action="<?php echo base_url()."userAdditionalPayment"?>">
										<!-- <input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $visit_book_history[0]['appointment_book_id'];?>"> -->
									<!-- <div class="show_amount_details" style="display: none;"> -->
									<div class="card-body">

									
										   <div class="row">
										   	<?php
										  //	echo "<pre>";
										  	// print_r($visit_book_history);
										  	// print_r($additional_payment);.
										  	//echo "TEST".$visit_book_history[0][appointment_book_id]."<br>";
										  	//echo "DATA".$additional_payment[0][appointment_id];
										  	//exit;
										   //	echo "test".$visit_book_history[0][appointment_book_id]."<br>";
										   	// 	echo "ferer".$visit_book_history[0][appointment_id]."<br>";
										   	if($visit_book_history[0][appointment_book_id] != '')
										   	{
										   		//echo "1";
										   	?>
										   <input type="hidden" name="id" id="id" value="<?php echo $additional_payment[0][id];?>">
										   	<input type="hidden" name="user_type_id" id="user_type_id" value="1">
										   	<input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $visit_book_history[0]['appointment_book_id'];?>">
										   		<input type="hidden" name="amount" id="amount" value="<?php echo $additional_payment[0][amount];?>">
										   		<input type="hidden" name="ORDER_ID" value="<?php echo  "ORDS" . rand(10000,99999999)?>"/>
												<div class="form-group col-md-12">
													<label><b>Additional Amount :</b></label>
													<label><?php echo $additional_payment[0][amount];?></label>
												
												</div>
												<div class="form-group col-md-12">
													<label><b>Additional Note :</b></label>
													<label><?php echo $additional_payment[0][note];?></label>
												
												</div>
												<?php
											}
											else if($visit_book_history[0][book_nurse_id] != '')
										   	{
										   		//echo "2";

										   	?>
										   	 <input type="hidden" name="id" id="id" value="<?php echo $additional_payment[0][id];?>">
										   		<input type="hidden" name="user_type_id" id="user_type_id" value="2">
										   	<input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $visit_book_history[0]['book_nurse_id'];?>">
										   	<input type="hidden" name="amount" id="amount" value="<?php echo $additional_payment[0][amount];?>">
										   	<input type="hidden" name="ORDER_ID" value="<?php echo  "ORDS" . rand(10000,99999999)?>"/>
												<div class="form-group col-md-12">
													<label><b>Additional Amount :</b></label>
													<label><?php echo $additional_payment[0][amount];?></label>
												
												</div>

												<!-- <div class="form-group col-md-12">
													<label><b>Extra Charge :</b></label>
													<label><?php echo $additional_payment[0][nurse_service_name];?></label>
												
												</div>
 -->
												<div class="form-group col-md-12">
													<label><b>Additional Note :</b></label>
													<label><?php echo $additional_payment[0][note];?></label>
												
												</div>
												<?php
											}
											else if($visit_book_history[0][book_laboratory_test_id] != '')
										   	{
										   		//echo "3";
										   		//echo "fdd";
										   	?>
										   	 <input type="hidden" name="id" id="id" value="<?php echo $additional_payment[0][id];?>">
										   	<input type="hidden" name="user_type_id" id="user_type_id" value="3">
										   	<input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $visit_book_history[0]['book_laboratory_test_id'];?>">
										   	<input type="hidden" name="amount" id="amount" value="<?php echo $additional_payment[0][amount];?>">
										   	<input type="hidden" name="ORDER_ID" value="<?php echo  "ORDS" . rand(10000,99999999)?>"/>
												<div class="form-group col-md-12">
													<label><b>Additional Amount :</b></label>
													<label><?php echo $additional_payment[0][amount];?></label>
												
												</div>

												<!-- <div class="form-group col-md-12">
													<label><b>Extra Charge :</b></label>
													<label><?php echo $additional_payment[0][lab_test_type_name];?></label>
												
												</div> -->

												<div class="form-group col-md-12">
													<label><b>Additional Note :</b></label>
													<label><?php echo $additional_payment[0][note];?></label>
												
												</div>
												<?php
											}
											else if($visit_book_history[0][book_ambulance_id] != '')
										   	{
										   		//echo "3";
										   		//echo "fdd";
										   	?>
										   	 <input type="hidden" name="id" id="id" value="<?php echo $additional_payment[0][id];?>">
										   	<input type="hidden" name="user_type_id" id="user_type_id" value="5">
										   	<input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $visit_book_history[0]['book_ambulance_id'];?>">
										   	<input type="hidden" name="amount" id="amount" value="<?php echo $additional_payment[0][amount];?>">
										   	<input type="hidden" name="ORDER_ID" value="<?php echo  "ORDS" . rand(10000,99999999)?>"/>
												<div class="form-group col-md-12">
													<label><b>Additional Amount :</b></label>
													<label><?php echo $additional_payment[0][amount];?></label>
												
												</div>

												<!-- <div class="form-group col-md-12">
													<label><b>Extra Charge :</b></label>
													<label><?php echo $additional_payment[0][lab_test_type_name];?></label>
												
												</div> -->

												<div class="form-group col-md-12">
													<label><b>Additional Note :</b></label>
													<label><?php echo $additional_payment[0][note];?></label>
												
												</div>
												<?php
											}
											else
											{
												?>
												<label><b>No Record Found</b></label>
												<?php
											}
											?>
										</div>
										
							        </div>

									<div class="card-footer">
										 <?php
										 /*echo "<pre>";
										 print_r($additional_payment);*/
							        	if($additional_payment[0][amount] != '' && $additional_payment[0][additional_payment_type] == 'Online'){
							        ?>
										<button type="submit" class="btn btn-primary mr-2" id="addPayment">Pay</button>
										<?php
									}
									?>
										<a href="<?php echo base_url(); ?>userdashboard" class="btn btn-secondary">Cancel</a>
									</div>
									<!-- </div>	 -->	  
	       							
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

	        if($assign_appointment_list[0][service_id]==1 || $assign_appointment_list[0][service_id]==2)
	        {
	        ?>
		<div class="row">
					
			<div class="col-xl-6">
					<form method="post">
				<div class="card card-custom">
					<div class="card-body p-0">
						<input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
							<div class="card-header">
								<span><b><font style="font-size: 24px;">Visit Notes</font></b></span>
									<span style="color:green;">
										<div id="error_message" class="ajax_response"></div>
									    <div id="success_message" class="ajax_response"></div> 
									</span>
							</div>
							<div class="card-body">
								<?php 
								if($assign_appointment_list[0]['visit_history_text']!='')
								{
									?>
									<label><?php echo $assign_appointment_list[0]['visit_history_text'];?></label>
									<?php
								}
								else
								{
									echo "<label><b><font color='red'>No Record Found</font></b></lable>";
								}
								?>
								

							</div>
					</div>
				</div>
				</form>	
			
			</div>
			<div class="col-xl-6">
					<form method="post">
				<div class="card card-custom">
					<div class="card-body p-0">
						<input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
							<div class="card-header">
								<span><b><font style="font-size: 24px;">ECG and XRAY</font></b></span>
									<span style="color:green;">
										<div id="error_message" class="ajax_response"></div>
									    <div id="success_message" class="ajax_response"></div> 
									</span>
							</div>
							<div class="card-body">
								<?php
								if($assign_appointment_list[0]['ecg_xray_note']!="")
								{
								?>
								<label><?php echo $assign_appointment_list[0]['ecg_xray_note'];?></label>
								<?php
							    }
							    else
							    {
							    	echo "<label><b><font color='red'>No Record Found</font></b></lable>";
							    }
							    ?>

							</div>
					</div>
				</div>
				</form>	
			</div>
			
		</div>
		<br>
		<div class="row">
					
			<div class="col-xl-6">
					<form method="post">
				<div class="card card-custom">
					<div class="card-body p-0">
						<input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
							<div class="card-header">
								<span><b><font style="font-size: 24px;">Prescription</font></b></span>
									
							</div>
							<div class="card-body">
								<?php
								 			//echo "<pre>";
								 			//print_r($assign_appointment_list);
								 			$image=explode(',',$assign_appointment_list[0]['prescription']);
								 			$result = count($image);
								 			if($assign_appointment_list[0]['prescription']!= ''){
								 			foreach ($image as $value) {
								 				//echo $value;
								 				$ext_image=explode('.',$value);
								 				//print_r($ext_image);
								 				if($ext_image[1]=='pdf'){
								 				?>
								 				 <i class="fa fa-file fa-3x" aria-hidden="true"></i>
												<a href="<?php echo base_url().'user/BookingHistory/download_prescription/'.$value ?>">
								 				 <i class="fa fa-download" aria-hidden="true"></i>
								 				</a>
								 				<?php
								 				}
								 				else
								 				{
								 					?>
								 					<img src="<?php echo base_url().'uploads/appointment/prescription/'.$value ?>" width="50" height="50"/>
								 				 <a href="<?php echo base_url().'user/BookingHistory/download_prescription/'.$value ?>">
								 				 <i class="fa fa-download" aria-hidden="true"></i>
								 				</a>
								 					<?php
								 				}

								 				# code...
								 			}
								 		}
								 		else
								 		{
								 			echo "<font color='red'>Document Not Available.</font>";
								 		}

								 			?>

							</div>
					</div>
				</div>
				</form>	
			
			</div>
			<div class="col-xl-6">
					<form method="post">
				<div class="card card-custom">
					<div class="card-body p-0">
						<input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
							<div class="card-header">
								<span><b><font style="font-size: 24px;">Lab Report</font></b></span>
									
							</div>
							<div class="card-body">
								<?php
								 			//echo "<pre>";
								 			//print_r($assign_appointment_list);
								 			$image=explode(',',$assign_appointment_list[0]['lab_report']);
								 			$result = count($image);
								 			if($assign_appointment_list[0]['lab_report']!= ''){
								 			foreach ($image as $value) {
								 				//echo $value;
								 				$ext_image=explode('.',$value);
								 				//print_r($ext_image);
								 				if($ext_image[1]=='pdf'){
								 				?>
								 				 <i class="fa fa-file fa-3x" aria-hidden="true"></i>
												<a href="<?php echo base_url().'user/BookingHistory/download_lab/'.$value ?>">
								 				 <i class="fa fa-download" aria-hidden="true"></i>
								 				</a>
								 				<?php
								 				}
								 				else
								 				{
								 					?>
								 					<img src="<?php echo base_url().'uploads/appointment/lab_report/'.$value ?>" width="50" height="50"/>
								 				 <a href="<?php echo base_url().'user/BookingHistory/download_lab/'.$value ?>">
								 				 <i class="fa fa-download" aria-hidden="true"></i>
								 				</a>
								 					<?php
								 				}

								 				# code...
								 				}
								 			}
								 			else
								 			{
								 				echo "<font color='red'>Document Not Available.</font>";
									 		}
								 			

								 			?>

							</div>
					</div>
				</div>
				</form>	
			
			</div>
			
			
		</div>
			<?php
			}
			?>		
			<br>
		<?php

	        if($assign_appointment_list[0][service_id]==3)
	        {
	        ?>
		<div class="row">
					
			<div class="col-xl-6">
					<form method="post">
				<div class="card card-custom">
					<div class="card-body p-0">
						<input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
							<div class="card-header">
								<span><b><font style="font-size: 24px;">Lab Notes</font></b></span>
									<span style="color:green;">
										<div id="error_message" class="ajax_response"></div>
									    <div id="success_message" class="ajax_response"></div> 
									</span>
							</div>
							<div class="card-body">
								<!-- <label><?php echo $assign_appointment_list[0]['visit_history_text'];?></label> -->
								<?php 
								if($assign_appointment_list[0]['visit_history_text']!='')
								{
									?>
									<label><?php echo $assign_appointment_list[0]['visit_history_text'];?></label>
									<?php
								}
								else
								{
									echo "<label><b><font color='red'>No Record Found</font></b></lable>";
								}
								?>

							</div>
					</div>
				</div>
				</form>	
			
			</div>
			<div class="col-xl-6">
					<form method="post">
				<div class="card card-custom">
					<div class="card-body p-0">
						<input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
							<div class="card-header">
								<span><b><font style="font-size: 24px;">Lab Report</font></b></span>
									
							</div>
							<div class="card-body">
								<?php
								 			//echo "<pre>";
								 			//print_r($assign_appointment_list);
								 			$image=explode(',',$assign_appointment_list[0]['lab_report']);
								 			$result = count($image);
								 			if($assign_appointment_list[0]['lab_report']!= ''){
								 			
								 			foreach ($image as $value) {
								 				//echo $value;
								 				$ext_image=explode('.',$value);
								 				//print_r($ext_image);
								 				if($ext_image[1]=='pdf'){
								 				?>
								 				 <i class="fa fa-file fa-3x" aria-hidden="true"></i>
												<a href="<?php echo base_url().'user/BookingHistory/download_lab/'.$value ?>">
								 				 <i class="fa fa-download" aria-hidden="true"></i>
								 				</a>
								 				<?php
								 				}
								 				else
								 				{
								 					?>
								 					<img src="<?php echo base_url().'uploads/appointment/lab_report/'.$value ?>" width="50" height="50"/>
								 				 <a href="<?php echo base_url().'user/BookingHistory/download_lab/'.$value ?>">
								 				 <i class="fa fa-download" aria-hidden="true"></i>
								 				</a>
								 					<?php
								 				}

								 				# code...
								 			}
								 		}
								 		else
								 		{
								 				echo "<font color='red'>Document Not Available.</font>";
									 	}
								 				

								 			?>

							</div>
					</div>
				</div>
				</form>	
			
			</div>
			
			
		</div>
		
			<?php
			}
			?>	
		<?php

	        if($assign_appointment_list[0][service_id]==4)
	        {
	        ?>
		<div class="row">
					
			<div class="col-xl-6">
					<form method="post">
				<div class="card card-custom">
					<div class="card-body p-0">
						<input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
							<div class="card-header">
								<span><b><font style="font-size: 24px;">Prescription Notes</font></b></span>
									<span style="color:green;">
										<div id="error_message" class="ajax_response"></div>
									    <div id="success_message" class="ajax_response"></div> 
									</span>
							</div>
							<?php
							if($assign_appointment_list[0]['visit_history_text']!='')
							{
							?>
							<center>
							<div class="card-body">
								<?php 
								if($assign_appointment_list[0]['visit_history_text']!='')
								{
									?>
									<label><?php echo $assign_appointment_list[0]['visit_history_text'];?></label>
									<?php
								}
								else
								{
									echo "<label><b><font color='red'>No Record Found</font></b></lable>";
								}
								?>
								<!-- <label><?php echo $assign_appointment_list[0]['visit_history_text'];?></label> -->

							</div>
						</center>
							<?php
						}
						else
						{
							echo "<div class='card-body'><label><b><font color='red'>No Record Found</font></b></lable></div>";
						}
						?>
					</div>
				</div>
				</form>	
			
			</div>
			<div class="col-xl-6">
					<form method="post">
				<div class="card card-custom">
					<div class="card-body p-0">
						<input type="hidden" name="assign_appointment_id" id="assign_appointment_id" value="<?php echo $assign_appointment_list[0]['assign_appointment_id'];?>">	
							<div class="card-header">
								<span><b><font style="font-size: 24px;">Prescription</font></b></span>
									
							</div>
							<div class="card-body">
								<?php
								 			//echo "<pre>";
								 			//print_r($assign_appointment_list);
								 			$image=explode(',',$assign_appointment_list[0]['prescription']);
								 			$result = count($image);
								 			if($assign_appointment_list[0]['lab_report']!= ''){
								 			
								 			foreach ($image as $value) {
								 				//echo $value;
								 				$ext_image=explode('.',$value);
								 				//print_r($ext_image);
								 				if($ext_image[1]=='pdf'){
								 				?>
								 				 <i class="fa fa-file fa-3x" aria-hidden="true"></i>
												<a href="<?php echo base_url().'user/BookingHistory/download_prescription/'.$value ?>">
								 				 <i class="fa fa-download" aria-hidden="true"></i>
								 				</a>
								 				<?php
								 				}
								 				else
								 				{
								 					?>
								 					<img src="<?php echo base_url().'uploads/appointment/prescription/'.$value ?>" width="50" height="50"/>
								 				 <a href="<?php echo base_url().'user/BookingHistory/download_prescription/'.$value ?>">
								 				 <i class="fa fa-download" aria-hidden="true"></i>
								 				</a>
								 					<?php
								 				}

								 				# code...
								 			}
								 		}
								 		else
								 		{
								 			echo "<font color='red'>Document Not Available.</font>";
								 		}
								 			

								 			?>

							</div>
					</div>
				</div>
				</form>	
			
			</div>
			
			
		</div>
		
			<?php
			}
			?>	
				
				
			
							
						</div>
						<!--end::Entry-->
					</div>

				</div>

	
					<!--end::Content-->



<script src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	CKEDITOR.replace('editor1');
</script>

<!-- <script type="text/javascript">

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

	var assign_appointment_id = $('#assign_appointment_id').val();
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
</script> -->
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

 