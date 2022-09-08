<?php
//print_r($service_id);
?>
<div class="card-body tab_content">
												<div class="tab-content ">
<div class="table-responsive">
														<form method="post">
														<table class="table table-head-custom table-head-bg table-borderless table-vertical-center" id="appointmentListTable">
															<thead>
																<tr class="text-left text-uppercase">
																	<th style="min-width: 100px"  class="pl-7"><span class="text-dark-75">Service</span></th>
																	<th style="min-width: 100px">
																		<span class="text-dark-75">Patient</span>
																	</th>
																	<th style="min-width: 100px"><span class="text-dark-75">Address</span></th>
																	<th style="min-width: 100px"><span class="text-dark-75">Date</span></th>
																	<?php 
																	if($service_id!=4)
																	{
																		?>
																	<th style="min-width: 100px"><span class="text-dark-75">Time</span></th>
																	<?php
																	}
																	?>
																	<?php 
																	if($service_id!=4 && $service_id!=5)
																	{
																		?>
																		<th style="min-width: 100px"><span class="text-dark-75">Invoice</span></th>
																		<th style="min-width: 100px"><span class="text-dark-75">Cancel Appointment</span></th>
																		<?php
																	}
																	?>
																	<?php 
																	if($service_id!=4)
																	{
																		?>
																	<th style="min-width: 100px"><span class="text-dark-75">Status</span></th>
																	<?php
																	}
																	?>
																	<th style="min-width: 100px"><span class="text-dark-75">Action</span></th>
																	
																</tr>
															</thead>
															<tbody>
																<?php

												foreach($appointment_book as $appointment){ 
													
													?>
																<tr>
																	<td >
																			
																			<div class="symbol symbol-50 symbol-light mr-4">
																				<span class="symbol-label">
																					<?php
																					if($appointment['appointment_book_id']!='')
																					{
																						?>
																						<img src="<?php echo base_url()?>uploads/image/doctor.svg" class="h-75 align-self-end" /> 
																						<?php
																					}
																					if($appointment['book_nurse_id']!='')
																					{
																						?>
																						<img src="<?php echo base_url()?>uploads/image/nurse.svg" class="h-75 align-self-end" />
																						<?php
																					}
																					if($appointment['book_laboratory_test_id']!='')
																					{
																						?>
																						<img src="<?php echo base_url()?>uploads/image/lab.svg" class="h-75 align-self-end" />
																						<?php
																					}
																					if($appointment['book_medicine_id']!='')
																					{
																						?>
																						<img src="<?php echo base_url()?>uploads/image/drug.svg" class="h-75 align-self-end" />
																						<?php
																					}
																					if($appointment['book_ambulance_id']!='')
																					{
																						?>
																						<img src="<?php echo base_url()?>uploads/image/ambulance.svg" class="h-75 align-self-end" />
																						<?php
																					}

																					?>
																					
																				</span>
																			</div>
																			
																		
																	</td>
																	<td class="pl-0 py-8">
																		<div class="d-flex">
																			<?php
																			if($appointment['book_medicine_id']!='')
																			{
																			?>
																			<div>
																				<a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"><?php echo $appointment['name']?></a>
																				<span class="text-muted font-weight-bold d-block"><?php echo $appointment['mobile']?></span>
																			</div>
																			<?php
																		    }
																		    elseif($appointment['book_ambulance_id']!='')
																		    {
																		    	?>
																		    	<div>
																				<a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"><?php echo $appointment['patient_name']?></a>
																				<span class="text-muted font-weight-bold d-block"><?php echo $appointment['contact_no']?></span>
																			</div>
																		    	<?php
																		    }
																		    else{
																		    ?>
																		    <div>
																				<a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"><?php echo $appointment['name']?></a>
																				<span class="text-muted font-weight-bold d-block"><?php echo $appointment['contact_no']?></span>
																			</div>
																			<?php
																		}?>
																		</div>
																	</td>
																	<td>
																		
																		<?php
																			if($appointment['book_medicine_id']!='')
																			{
																			?>
																			<span class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"><?php echo $appointment['address']?></span>
																			<?php
																		    }
																		    elseif($appointment['book_ambulance_id']!='')
																		    {
																		    	if($appointment['from_address']!='' && $appointment['to_address']!=''){
																		    	?>
																		    	<span class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">From: </span><?php echo $appointment['from_address']?><br>
																		    		<span class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">To: </span><?php echo $appointment['to_address']?>
																		    	<?php
																		    	}
																		    	else
																		    	{
																		    		$multi_location_explode=explode(',@#-0,',$appointment['multi_city']);
																		    		$multi_location_implode=implode('<br>',$multi_location_explode);
																		    		

																		    		
																		    		?>
																		    		<span class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">Multi City: </span><br>
																		    		<?php echo $multi_location_implode?>
																		    		<?php
																		    	}
																		    }
																		    else{
																		    ?>
																		   <span class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"><?php echo $appointment['address_1']." ".$appointment['address_2']?></span>
																			<?php
																		}?>
																		
																	</td>
																	<td>
																		
																		<?php
																		
																			if($appointment['book_medicine_id']!='')
																			{
																			?>
																			<span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo date("d-m-Y",strtotime($appointment['created_date'])); ?></span>
																			<?php
																		    }
																		    else{
																		    ?>
																		 <span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo date("d-m-Y",strtotime($appointment['date'])); ?></span>
																			<?php
																		}?>
																		
																	</td>

																	<?php
																	if($service_id!=4){
																		?>
																	
																	<td>
																		<?php
																			if($appointment['book_medicine_id']!='')
																			{
																			?>
																			<span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo "-"; ?></span>
																			<?php
																		    }
																		    else{
																		    ?>
																		<span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $appointment['time']?></span>
																			<?php
																		}?>
																		
																		
																	</td>
																	<?php
																}
																?>
																	<!-- <td>
																		<form method="post" action="view_report.php">
																			<input type="hidden" name="case" value="<?php echo $case;?>" / >
																			<input type="submit" value="Report"/>
																	    </form>
																   </td> -->
																   <?php
																	if($appointment['appointment_book_id']!='' || $appointment['book_nurse_id']!='' || $appointment['book_laboratory_test_id']!='')
																	{
																	?>
																	<td>
																		<?php
																		if($appointment['appointment_book_id']!='')
																		{
																		?>
																		
																				<?php
																				if($appointment['responsestatus']=='TXN_SUCCESS'){
																								?>
																				<button formaction="<?php echo base_url(); ?>invoice" name="appointment_book_id" value="<?php echo $appointment['appointment_book_id']; ?>"  class="btn btn-secondary" title="View Receipt">

																				Receipt

																				</button>
																				<?php
																				}
																				else{
																					echo "<font color='Red'>No Data Available</font>";
																				}
																				?>
																		<?php
																		}
																		if($appointment['book_nurse_id']!='')
																		{
																		?>
																			<?php
																				if($appointment['responsestatus']=='TXN_SUCCESS'){
																								?>
																		<button formaction="<?php echo base_url(); ?>invoice" name="book_nurse_id" value="<?php echo $appointment['book_nurse_id']; ?>"  class="btn btn-secondary" title="View Receipt">

																		Receipt

																		</button>
																		<?php
																				}
																				else{
																					echo "<font color='Red'>No Data Available</font>";
																				}
																				?>
																		<?php
																		}
																		if($appointment['book_laboratory_test_id']!='')
																		{
																		?>
																		<?php
																				if($appointment['responsestatus']=='TXN_SUCCESS'){
																								?>
																		<button formaction="<?php echo base_url(); ?>invoice" name="book_laboratory_test_id" value="<?php echo $appointment['book_laboratory_test_id']; ?>"  class="btn btn-secondary" title="View Receipt">

																		Receipt

																		</button>
																		<?php
																				}
																				else{
																					echo "<font color='Red'>No Data Available</font>";
																				}
																				?>
																		<?php
																		}
																		?>
																	</td>

																	<td>

																		
																		<?php

																				
																				date_default_timezone_set('Asia/Kolkata');
																				        $script_tz = date_default_timezone_get();
																				        $cur       = date('Y-m-d');
																				 // $cancel = strtotime($cancel);
																				 //   $new = strtotime($cur);
																				 //   echo $new;
																				   $cancel = $appointment['date']; 
																				   $new = date("Y-m-d",strtotime($cur)); 
																				    // echo $cancel."<br>";
																				    // echo $new;
																				   // exit;
																				if($new < $cancel)
																				{

																					if($appointment['confirm']==1)
																					{
																						if($appointment['appointment_book_id']!='')
																						{
																							if($appointment['responsestatus']=='TXN_SUCCESS'){
																						?>

																								 <button formaction="<?php echo base_url(); ?>cancle" name="appointment_book_id" value="<?php echo $appointment['appointment_book_id']; ?>"  class="btn btn-danger" title="Cancel Appointment">

																								Cancel

																								</button>
																								<?php 
																								}
																								else
																								{
																									?>
																									Not Allowed
																									<?php

																								}
																								?>
																						<?php
																						}
																						if($appointment['book_nurse_id']!='')
																						{
																							if($appointment['responsestatus']=='TXN_SUCCESS'){
																						?>

																						 <button formaction="<?php echo base_url(); ?>cancle" name="book_nurse_id" value="<?php echo $appointment['book_nurse_id']; ?>"  class="btn btn-danger" title="Cancel Appointment">

																						Cancel

																						</button>
																						<?php 
																								}
																								else
																								{
																									?>
																									Not Allowed
																									<?php

																								}
																								?>
																						<?php
																						}
																						if($appointment['book_laboratory_test_id']!='')
																						{
																							if($appointment['responsestatus']=='TXN_SUCCESS'){
																						?>

																						 <button formaction="<?php echo base_url(); ?>cancle" name="book_laboratory_test_id" value="<?php echo $appointment['book_laboratory_test_id']; ?>"  class="btn btn-danger" title="Cancel Appointment">

																						 Cancel

																						 </button>
																						 <?php 
																								}
																								else
																								{
																									?>
																									Not Allowed
																									<?php

																								}
																								?>
																						<?php
																						}

																					}
																					else
																					{
																						?>
																						 Not allowed
																					<?php }
																					
																				 ?>

																				
																				<?php 
																				}
																				else
																				{ 
																					?>
																				         Not allowed
																				<?php 
																			    } 
																			    ?>

																	</td>
																	<?php
																    }
																    else
																    {
																    	if($service_id!=4 && $service_id!=5){
																    	?>
																    	<td>-</td>
																    	<td>-</td>
																    	<?php
																       }
																    }
																?>
																	<?php
																	if($service_id!=4){
																	?>
																	<td >
																		<?php
																		if($appointment['appointment_book_id']!='')
																		{
																			?>
																				 
																				 <?php 
																					if($appointment['responsestatus']=="TXN_SUCCESS")
																					{
																						?>
																						
																						<span class="label label-inline label-light-success font-weight-bold">Success</span>
																						<?php
																					}
																					else if ($appointment['responsestatus']=="TXN_CANCELLED") 
																					{
																						?>
																						<span class="label label-inline label-light-danger font-weight-bold">Cancelled</span>
																					<?php
																				    }
																				    else if ($appointment['responsestatus']=="TXN_PENDING") 
																					{
																						?>
																						<span class="label label-inline" style="background:orange;">Pending</span>
																					<?php
																				    }
																					else
																					{
																						?>
																						<span class="label label-inline label-light-danger font-weight-bold">Failure</span>
																						<?php
																					}

																				 ?>
																		<?php
																	    }
																	    ?>
																		<?php
																		if($appointment['book_nurse_id']!='')
																		{
																			?>
																				 <?php 
																					if($appointment['responsestatus']=="TXN_SUCCESS")
																					{
																						?>
																						
																						<span class="label label-inline label-light-success font-weight-bold">Success</span>
																						<?php
																					}
																					else if ($appointment['responsestatus']=="TXN_CANCELLED") 
																					{
																						?>
																						<span class="label label-inline label-light-danger font-weight-bold">Cancelled</span>
																					<?php
																				    }
																				    else if ($appointment['responsestatus']=="TXN_PENDING") 
																					{
																						?>
																						<span class="label label-inline" style="background:orange;">Pending</span>
																					<?php
																				    }
																					else
																					{
																						?>
																						<span class="label label-inline label-light-danger font-weight-bold">Failure</span>
																						<?php
																					}

																				 ?>
																		<?php
																	    }
																	    ?>
																	    <?php
																		if($appointment['book_laboratory_test_id']!='')
																		{
																			?>
																				 <?php 
																					if($appointment['responsestatus']=="TXN_SUCCESS")
																					{
																						?>
																						
																						<span class="label label-inline label-light-success font-weight-bold">Success</span>
																						<?php
																					}
																					else if ($appointment['responsestatus']=="TXN_CANCELLED") 
																					{
																						?>
																						<span class="label label-inline label-light-danger font-weight-bold">Cancelled</span>
																					<?php
																				    }
																				    else if ($appointment['responsestatus']=="TXN_PENDING") 
																					{
																						?>
																						<span class="label label-inline" style="background:orange;">Pending</span>
																					<?php
																				    }
																					else
																					{
																						?>
																						<span class="label label-inline label-light-danger font-weight-bold">Failure</span>
																						<?php
																					}

																				 ?>
																		<?php
																	    }
																	    ?>
																	    <?php
																	    /*
																		if($appointment['book_medicine_id']!='')
																		{
																			?>
																				 
																						
																						<span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo "-"; ?></span>
																						
																		<?php
																	    } */
																	    ?>
																	    <?php
																		if($appointment['book_ambulance_id']!='')
																		{
																			?>
																				 <?php 
																					if($appointment['responsestatus']=="TXN_SUCCESS")
																					{
																						?>
																						
																						<span class="label label-inline label-light-success font-weight-bold">Success</span>
																						<?php
																					}
																					else if ($appointment['responsestatus']=="TXN_PENDING") 
																					{
																						?>
																						<span class="label label-inline" style="background:orange;">Pending</span>
																					<?php
																				    }
																					else
																					{
																						?>
																						<span class="label label-inline label-light-danger font-weight-bold">Failure</span>
																						<?php
																					}

																				 ?>
																		<?php
																	    }
																	    ?>

																	</td>

																	<?php
																}
																?>




																	<td nowrap="nowrap">
																		<?php
																		if($appointment['appointment_book_id']!='')
																		{
																			?>
																				<!-- <a href="#" class="btn btn-sm btn-clean btn-icon mr-2 " data-id="<?php echo $appointment['book_nurse_id'];?>"> <i class="fa fa-eye" aria-hidden="true"></i></a> -->

																		
																		<button formaction="<?php echo base_url(); ?>viewBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['appointment_book_id']; ?>,<?php echo "1";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		<i class="fa fa-eye" aria-hidden="true"></i>

																		</button>
																		<?php
																		$date=date('Y-m-d');
																		if( $appointment['date'] > $date){
																			if($appointment['responsestatus']!="TXN_FAILURE" && $appointment['responsestatus']!="TXN_CANCELLED" && $appointment['responsestatus']!=""){
																		?>
																		<button formaction="<?php echo base_url(); ?>editBookDoctorAppointment" name="btn_edit_appointment" 
															value="<?php echo $appointment['appointment_book_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Edit Appointment">	             
															<span class="svg-icon svg-icon-md">
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">	
																	    <rect x="0" y="0" width="24" height="24"></rect>	
																	        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
																	        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
																	</g>
																</svg>
															</span>
														</button>
														<?php
														}
													}
													?>

														
																	
																		<?php
																	    }
																	    ?>
																		<?php
																		if($appointment['book_nurse_id']!='')
																		{
																			?>
																				<!-- <a href="#" class="btn btn-sm btn-clean btn-icon mr-2 " data-id="<?php echo $appointment['book_nurse_id'];?>"> <i class="fa fa-eye" aria-hidden="true"></i></a> -->
																				<button formaction="<?php echo base_url(); ?>viewBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['book_nurse_id']; ?>,<?php echo "2";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		        <i class="fa fa-eye" aria-hidden="true"></i>

																		        </button>
																		        <?php
																		$date=date('Y-m-d');
																		if( $appointment['date'] > $date){
																			if($appointment['responsestatus']!="TXN_FAILURE" && $appointment['responsestatus']!="TXN_CANCELLED" && $appointment['responsestatus']!=""){
																		?>
																		<button formaction="<?php echo base_url(); ?>editBookNurseAppointment" name="btn_edit_appointment" 
															value="<?php echo $appointment['book_nurse_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Edit Appointment">	             
															<span class="svg-icon svg-icon-md">
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">	
																	    <rect x="0" y="0" width="24" height="24"></rect>	
																	        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
																	        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
																	</g>
																</svg>
															</span>
														</button>
														<?php
														}
													}
													?>
																		<?php
																	    }
																	    ?>
																	    <?php
																		if($appointment['book_laboratory_test_id']!='')
																		{
																			?>
																				<!-- <a href="#" class="btn btn-sm btn-clean btn-icon mr-2 " data-id="<?php echo $appointment['book_laboratory_test_id'];?>"> <i class="fa fa-eye" aria-hidden="true"></i></a> -->
																				<button formaction="<?php echo base_url(); ?>viewBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['book_laboratory_test_id']; ?>,<?php echo "3";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		        <i class="fa fa-eye" aria-hidden="true"></i>

																		        </button>
																		        <?php
																		$date=date('Y-m-d');
																		if( $appointment['date'] > $date){
																			if($appointment['responsestatus']!="TXN_FAILURE" && $appointment['responsestatus']!="TXN_CANCELLED" && $appointment['responsestatus']!=""){
																		?>
																		<button formaction="<?php echo base_url(); ?>editBookLabAppointment" name="btn_edit_appointment" 
															value="<?php echo $appointment['book_laboratory_test_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Edit Appointment">	             
															<span class="svg-icon svg-icon-md">
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">	
																	    <rect x="0" y="0" width="24" height="24"></rect>	
																	        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
																	        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
																	</g>
																</svg>
															</span>
														</button>
														<?php
														}
													}
													?>
																		<?php
																	    }
																	    ?>
																	    <?php
																		if($appointment['book_medicine_id']!='')
																		{
																			?>
																				<!-- <a href="#" class="btn btn-sm btn-clean btn-icon mr-2 " data-id="<?php echo $appointment['book_medicine_id'];?>"> <i class="fa fa-eye" aria-hidden="true"></i></a> -->
																				<button formaction="<?php echo base_url(); ?>viewBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['book_medicine_id']; ?>,<?php echo "4";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		        <i class="fa fa-eye" aria-hidden="true"></i>

																		        </button>
																		        <?php
																		$date=date('Y-m-d');
																		if( $appointment['created_date'] > $date){
																			if($appointment['responsestatus']!="TXN_FAILURE" && $appointment['responsestatus']!="TXN_CANCELLED" && $appointment['responsestatus']!=""){
																		?>
																		<button formaction="<?php echo base_url(); ?>editBookPharmacyAppointment" name="btn_edit_appointment" 
															value="<?php echo $appointment['book_medicine_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Edit Appointment">	             
															<span class="svg-icon svg-icon-md">
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">	
																	    <rect x="0" y="0" width="24" height="24"></rect>	
																	        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
																	        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
																	</g>
																</svg>
															</span>
														</button>
														<?php
														}
													}
													?>
																		<?php
																	    }
																	    ?>
																	    <?php
																		if($appointment['book_ambulance_id']!='')
																		{
																			?>
																				<!-- <a href="#" class="btn btn-sm btn-clean btn-icon mr-2" data-id="<?php echo $appointment['book_ambulance_id'];?>"> <i class="fa fa-eye" aria-hidden="true"></i></a> -->
																				<button formaction="<?php echo base_url(); ?>viewBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['book_ambulance_id']; ?>,<?php echo "5";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		        <i class="fa fa-eye" aria-hidden="true"></i>

																		        </button>
																		         <?php
																		$date=date('Y-m-d');
																		if( $appointment['date'] > $date){
																			if($appointment['responsestatus']!="TXN_FAILURE" && $appointment['responsestatus']!="TXN_CANCELLED" && $appointment['responsestatus']!=""){
																		?>
																		<button formaction="<?php echo base_url(); ?>editBookAmbulanceAppointment" name="btn_edit_appointment" 
															value="<?php echo $appointment['book_ambulance_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Edit Appointment">	             
															<span class="svg-icon svg-icon-md">
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">	
																	    <rect x="0" y="0" width="24" height="24"></rect>	
																	        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
																	        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
																	</g>
																</svg>
															</span>
														</button>
														<?php
														}
													}
													?>

																		<?php
																	    }
																	    ?>

																	</td>
																	
																	
																</tr>
																<?php
															}
															?>
																
															</tbody>
														</table>
													</form>
													</div>
													</div>
											</div>
											<script type="text/javascript">
                         	
	$(document).ready( function () {
    //$('#myTable').DataTable();

    $('#appointmentListTable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : true
    })
} );

</script>


