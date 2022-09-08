<div class="card-body tab_content">
												<div class="tab-content ">
<div class="table-responsive">
													<form method="post">
														<table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
															<thead>
																<tr class="text-left text-uppercase">
																	<th style="min-width: 100px"  class="pl-7"><span class="text-dark-75">Service</span></th>
																	<th style="min-width: 100px">
																		<span class="text-dark-75">Patient</span>
																	</th>
																	<th style="min-width: 100px"><span class="text-dark-75">Address</span></th>
																	<th style="min-width: 100px"><span class="text-dark-75">Date</span></th>
																	<th style="min-width: 100px"><span class="text-dark-75">Time</span></th>
																	<th style="min-width: 100px"><span class="text-dark-75">Action</span></th>
																	
																</tr>
															</thead>
															<tbody>
																<?php

												foreach($appointment_book_test as $appointment){ 
													
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
																				<br>
																				<?php
																				if($appointment['book_laboratory_test_id']!='')
																					{
																						?>
																						
																						<span class="text-muted font-weight-bolder text-hover-primary mb-1 font-size-lg"><?php echo $appointment['lab_test_type_name']?></span>
																						<?php
																					}
																				?>
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
																		if($appointment['appointment_book_id']!='')
																					{
																						?>
																	<td nowrap="nowrap">
																		
																						
																			<button formaction="<?php echo base_url(); ?>viewAdminBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['appointment_book_id']; ?>,<?php echo "1";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		<i class="fa fa-eye" aria-hidden="true"></i>

																		</button>
																	</td>
																	<?php
																}
																elseif($appointment['book_nurse_id']!='')
																{
																	?>
																	<td nowrap="nowrap">
																		
																						
																			<button formaction="<?php echo base_url(); ?>viewAdminBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['book_nurse_id']; ?>,<?php echo "2";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		<i class="fa fa-eye" aria-hidden="true"></i>

																		</button>
																	</td>
																	<?php
																}
																elseif($appointment['book_laboratory_test_id']!='')
																{
																	?>
																	<td nowrap="nowrap">
																		
																						
																			<button formaction="<?php echo base_url(); ?>viewAdminBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['book_laboratory_test_id']; ?>,<?php echo "3";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		<i class="fa fa-eye" aria-hidden="true"></i>

																		</button>
																	</td>
																	<?php
																}
																elseif($appointment['book_medicine_id']!='')
																{
																	?>
																	<td nowrap="nowrap">
																		
																						
																			<button formaction="<?php echo base_url(); ?>viewAdminBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['book_medicine_id']; ?>,<?php echo "4";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		<i class="fa fa-eye" aria-hidden="true"></i>

																		</button>
																	</td>
																	<?php
																}
																elseif ($appointment['book_ambulance_id']!='') {
																	?>
																	<td nowrap="nowrap">
																		
																						
																			<button formaction="<?php echo base_url(); ?>viewAdminBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['book_ambulance_id']; ?>,<?php echo "5";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		<i class="fa fa-eye" aria-hidden="true"></i>

																		</button>
																	</td>
																	<?php
																	# code...
																}
																?>
																	
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