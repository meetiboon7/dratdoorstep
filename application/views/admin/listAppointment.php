
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
																		<th style="min-width: 100px"><span class="text-dark-75">Receipt</span></th>
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
																					
																					if($appointment['id']!='')
                                        											{
                                        												?>
                                        												<img src="<?php echo base_url()?>uploads/image/Group 1576.svg" class="h-75 align-self-end" />
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
																			 <?php 
                                                                             if($appointment['id']!='')
                                        											{
                                        												?>
                                        												<span class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"><?php echo $appointment['package_name']?></span>
                                        												<?php
                                        											}
                                                                             ?>
																		
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
																	if($service_id!=4)
																	{
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
																		<button formaction="<?php echo base_url(); ?>invoice_recipt" name="appointment_book_id" value="<?php echo $appointment['appointment_book_id']; ?>"  class="btn btn-secondary" title="View Invoice">

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
																		<button formaction="<?php echo base_url(); ?>invoice_recipt" name="book_nurse_id" value="<?php echo $appointment['book_nurse_id']; ?>"  class="btn btn-secondary" title="View Invoice">

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
																		<button formaction="<?php echo base_url(); ?>invoice_recipt" name="book_laboratory_test_id" value="<?php echo $appointment['book_laboratory_test_id']; ?>"  class="btn btn-secondary" title="View invoice_recipt">

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
																							if($appointment['responsestatus']!='TXN_FAILURE')
																							{
																						?>

																						 <button formaction="<?php echo base_url(); ?>cancle_appoinment" name="appointment_book_id" value="<?php echo $appointment['appointment_book_id']; ?>"  class="btn btn-danger" title="Cancel Appointment">

																						Cancel

																						</button>
																						<?php
																						    }
																						 	else
																						   {
																						   		echo "Not allowed";
																						   }
																						}
																						
																						if($appointment['book_nurse_id']!='')
																						{
																							if($appointment['responsestatus']!='TXN_FAILURE')
																							{
																						?>

																						 <button formaction="<?php echo base_url(); ?>cancle_appoinment" name="book_nurse_id" value="<?php echo $appointment['book_nurse_id']; ?>"  class="btn btn-danger" title="Cancel Appointment">

																						Cancel

																						</button>
																						<?php
																							}
																						 	else
																						   {
																						   		echo "Not allowed";
																						   }
																						}
																						
																						if($appointment['book_laboratory_test_id']!='')
																						{
																							if($appointment['responsestatus']!='TXN_FAILURE')
																							{
																						?>

																						 <button formaction="<?php echo base_url(); ?>cancle_appoinment" name="book_laboratory_test_id" value="<?php echo $appointment['book_laboratory_test_id']; ?>"  class="btn btn-danger" title="Cancel Appointment">

																						 Cancel

																						 </button>
																						<?php
																						   }
																						 	else
																						   {
																						   		echo "Not allowed";
																						   }
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
                                										if($appointment['id']!='')
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

																	</td>

																	<?php
																}
																?>
																	<td nowrap="nowrap">
																		<?php
																		$this->db->select('*');
																		$this->db->from('assign_appointment');
																		$this->db->where('assign_appointment.appointment_id',$appointment['appointment_book_id']);
																		$assing_appointment_id= $this->db->get()->row_array();
																		if($appointment['appointment_book_id']!='' && $appointment['responsestatus']!="TXN_FAILURE" && $appointment['responsestatus']!="TXN_CANCELLED" && $appointment['responsestatus']!="")
																		{

																			//echo "113";
																		//echo $this->session->userdata('admin_user')['emp_id'];
																			if($this->session->userdata('admin_user')['role_id']==-1 || $this->session->userdata('admin_user')['role_id']==7 || $this->session->userdata('admin_user')['role_id']==8){
																			if($assing_appointment_id['appointment_id']==$appointment['appointment_book_id']){
																							
																						
																			?>
																				<a  href="#" class="btn btn-sm btn-clean btn-icon mr-2 btn-assign" data-id="<?php echo $appointment['appointment_book_id'];?>,<?php echo "1";?>" title="Assign">

																		<span class="svg-icon svg-icon-primary svg-icon-2x">
																				<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-12-28-020759/theme/html/demo1/dist/../src/media/svg/icons/Communication/Share.svg-->
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			        <rect x="0" y="0" width="24" height="24"/>
																			        <path d="M10.9,2 C11.4522847,2 11.9,2.44771525 11.9,3 C11.9,3.55228475 11.4522847,4 10.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,16 C20,15.4477153 20.4477153,15 21,15 C21.5522847,15 22,15.4477153 22,16 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L10.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																			        <path d="M24.0690576,13.8973499 C24.0690576,13.1346331 24.2324969,10.1246259 21.8580869,7.73659596 C20.2600137,6.12944276 17.8683518,5.85068794 15.0081639,5.72356847 L15.0081639,1.83791555 C15.0081639,1.42370199 14.6723775,1.08791555 14.2581639,1.08791555 C14.0718537,1.08791555 13.892213,1.15726043 13.7542266,1.28244533 L7.24606818,7.18681951 C6.93929045,7.46513642 6.9162184,7.93944934 7.1945353,8.24622707 C7.20914339,8.26232899 7.22444472,8.27778811 7.24039592,8.29256062 L13.7485543,14.3198102 C14.0524605,14.6012598 14.5269852,14.5830551 14.8084348,14.2791489 C14.9368329,14.140506 15.0081639,13.9585047 15.0081639,13.7695393 L15.0081639,9.90761477 C16.8241562,9.95755456 18.1177196,10.0730665 19.2929978,10.4469645 C20.9778605,10.9829796 22.2816185,12.4994368 23.2042718,14.996336 L23.2043032,14.9963244 C23.313119,15.2908036 23.5938372,15.4863432 23.9077781,15.4863432 L24.0735976,15.4863432 C24.0735976,15.0278051 24.0690576,14.3014082 24.0690576,13.8973499 Z" fill="#000000" fill-rule="nonzero" transform="translate(15.536799, 8.287129) scale(-1, 1) translate(-15.536799, -8.287129) "/>
																			    </g>
																		</svg>
																		<!--end::Svg Icon-->
																	</span></a>
																	<?php
																}
																else
																{
																	?>
																	<a href="#" class="btn btn-sm btn-clean btn-icon mr-2 btn-assign" data-id="<?php echo $appointment['appointment_book_id'];?>,<?php echo "1";?>" title="Assign">

																		<span class="svg-icon svg-icon-primary svg-icon-2x">
																			
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			        <rect x="0" y="0" width="24" height="24"/>
																			        <path d="M10.9,2 C11.4522847,2 11.9,2.44771525 11.9,3 C11.9,3.55228475 11.4522847,4 10.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,16 C20,15.4477153 20.4477153,15 21,15 C21.5522847,15 22,15.4477153 22,16 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L10.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																			        <path d="M24.0690576,13.8973499 C24.0690576,13.1346331 24.2324969,10.1246259 21.8580869,7.73659596 C20.2600137,6.12944276 17.8683518,5.85068794 15.0081639,5.72356847 L15.0081639,1.83791555 C15.0081639,1.42370199 14.6723775,1.08791555 14.2581639,1.08791555 C14.0718537,1.08791555 13.892213,1.15726043 13.7542266,1.28244533 L7.24606818,7.18681951 C6.93929045,7.46513642 6.9162184,7.93944934 7.1945353,8.24622707 C7.20914339,8.26232899 7.22444472,8.27778811 7.24039592,8.29256062 L13.7485543,14.3198102 C14.0524605,14.6012598 14.5269852,14.5830551 14.8084348,14.2791489 C14.9368329,14.140506 15.0081639,13.9585047 15.0081639,13.7695393 L15.0081639,9.90761477 C16.8241562,9.95755456 18.1177196,10.0730665 19.2929978,10.4469645 C20.9778605,10.9829796 22.2816185,12.4994368 23.2042718,14.996336 L23.2043032,14.9963244 C23.313119,15.2908036 23.5938372,15.4863432 23.9077781,15.4863432 L24.0735976,15.4863432 C24.0735976,15.0278051 24.0690576,14.3014082 24.0690576,13.8973499 Z" fill="#000000" fill-rule="nonzero" transform="translate(15.536799, 8.287129) scale(-1, 1) translate(-15.536799, -8.287129) "/>
																			    </g>
																		</svg>
																		<!--end::Svg Icon-->
																	</span></a>
																	<?php
																}
															}
																?>
																	<button formaction="<?php echo base_url(); ?>viewAdminBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['appointment_book_id']; ?>,<?php echo "1";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		<i class="fa fa-eye" aria-hidden="true"></i>

																		</button>
																		<?php
																		if($appointment['responsestatus']!="TXN_FAILURE" && $appointment['responsestatus']!="TXN_CANCELLED" && $appointment['responsestatus']!=""){
																			?>
																		<button formaction="<?php echo base_url(); ?>adminEditDoctorAppointment" name="btn_edit_appointment" 
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
																		$this->db->select('*');
																		$this->db->from('assign_appointment');
																		$this->db->where('assign_appointment.appointment_id',$appointment['book_nurse_id']);
																		$assing_appointment_id= $this->db->get()->row_array();
																		if($appointment['book_nurse_id']!='' && $appointment['responsestatus']!="TXN_FAILURE" && $appointment['responsestatus']!="TXN_CANCELLED" && $appointment['responsestatus']!="")
																		{
																			
																			if($this->session->userdata('admin_user')['role_id']==-1 || $this->session->userdata('admin_user')['role_id']==7 || $this->session->userdata('admin_user')['role_id']==8){
																				
																			if($assing_appointment_id['appointment_id']==$appointment['book_nurse_id']){
																						
																						
																			
																			?>
																				<a href="#"  class="btn btn-sm btn-clean btn-icon mr-2 btn-assign" data-id="<?php echo $appointment['book_nurse_id'];?>,<?php echo "2";?>" title="Assign">

																		<span class="svg-icon svg-icon-primary svg-icon-2x">
																				
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			        <rect x="0" y="0" width="24" height="24"/>
																			        <path d="M10.9,2 C11.4522847,2 11.9,2.44771525 11.9,3 C11.9,3.55228475 11.4522847,4 10.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,16 C20,15.4477153 20.4477153,15 21,15 C21.5522847,15 22,15.4477153 22,16 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L10.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																			        <path d="M24.0690576,13.8973499 C24.0690576,13.1346331 24.2324969,10.1246259 21.8580869,7.73659596 C20.2600137,6.12944276 17.8683518,5.85068794 15.0081639,5.72356847 L15.0081639,1.83791555 C15.0081639,1.42370199 14.6723775,1.08791555 14.2581639,1.08791555 C14.0718537,1.08791555 13.892213,1.15726043 13.7542266,1.28244533 L7.24606818,7.18681951 C6.93929045,7.46513642 6.9162184,7.93944934 7.1945353,8.24622707 C7.20914339,8.26232899 7.22444472,8.27778811 7.24039592,8.29256062 L13.7485543,14.3198102 C14.0524605,14.6012598 14.5269852,14.5830551 14.8084348,14.2791489 C14.9368329,14.140506 15.0081639,13.9585047 15.0081639,13.7695393 L15.0081639,9.90761477 C16.8241562,9.95755456 18.1177196,10.0730665 19.2929978,10.4469645 C20.9778605,10.9829796 22.2816185,12.4994368 23.2042718,14.996336 L23.2043032,14.9963244 C23.313119,15.2908036 23.5938372,15.4863432 23.9077781,15.4863432 L24.0735976,15.4863432 C24.0735976,15.0278051 24.0690576,14.3014082 24.0690576,13.8973499 Z" fill="#000000" fill-rule="nonzero" transform="translate(15.536799, 8.287129) scale(-1, 1) translate(-15.536799, -8.287129) "/>
																			    </g>
																		</svg>
																		<!--end::Svg Icon-->
																		</span></a>
																		<?php
																	}
																	else
																	{

																		
																		?>
																		<a href="#" class="btn btn-sm btn-clean btn-icon mr-2 btn-assign" data-id="<?php echo $appointment['book_nurse_id'];?>,<?php echo "2";?>" title="Assign">

																		<span class="svg-icon svg-icon-primary svg-icon-2x">
																				
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			        <rect x="0" y="0" width="24" height="24"/>
																			        <path d="M10.9,2 C11.4522847,2 11.9,2.44771525 11.9,3 C11.9,3.55228475 11.4522847,4 10.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,16 C20,15.4477153 20.4477153,15 21,15 C21.5522847,15 22,15.4477153 22,16 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L10.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																			        <path d="M24.0690576,13.8973499 C24.0690576,13.1346331 24.2324969,10.1246259 21.8580869,7.73659596 C20.2600137,6.12944276 17.8683518,5.85068794 15.0081639,5.72356847 L15.0081639,1.83791555 C15.0081639,1.42370199 14.6723775,1.08791555 14.2581639,1.08791555 C14.0718537,1.08791555 13.892213,1.15726043 13.7542266,1.28244533 L7.24606818,7.18681951 C6.93929045,7.46513642 6.9162184,7.93944934 7.1945353,8.24622707 C7.20914339,8.26232899 7.22444472,8.27778811 7.24039592,8.29256062 L13.7485543,14.3198102 C14.0524605,14.6012598 14.5269852,14.5830551 14.8084348,14.2791489 C14.9368329,14.140506 15.0081639,13.9585047 15.0081639,13.7695393 L15.0081639,9.90761477 C16.8241562,9.95755456 18.1177196,10.0730665 19.2929978,10.4469645 C20.9778605,10.9829796 22.2816185,12.4994368 23.2042718,14.996336 L23.2043032,14.9963244 C23.313119,15.2908036 23.5938372,15.4863432 23.9077781,15.4863432 L24.0735976,15.4863432 C24.0735976,15.0278051 24.0690576,14.3014082 24.0690576,13.8973499 Z" fill="#000000" fill-rule="nonzero" transform="translate(15.536799, 8.287129) scale(-1, 1) translate(-15.536799, -8.287129) "/>
																			    </g>
																		</svg>
																		<!--end::Svg Icon-->
																		</span></a>
																		<?php
																	}
																}
																	?>
																		<button formaction="<?php echo base_url(); ?>viewAdminBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['book_nurse_id']; ?>,<?php echo "2";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		<i class="fa fa-eye" aria-hidden="true"></i>

																		</button>
																		<?php
																		if($appointment['responsestatus']!="TXN_FAILURE" && $appointment['responsestatus']!="TXN_CANCELLED" && $appointment['responsestatus']!=""){
																			?>
																		<button formaction="<?php echo base_url(); ?>adminEditNurseAppointment" name="btn_edit_appointment" 
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
																	    $this->db->select('*');
																		$this->db->from('assign_appointment');
																		$this->db->where('assign_appointment.appointment_id',$appointment['book_laboratory_test_id']);
																		$assing_appointment_id= $this->db->get()->row_array();
																	    ?>

																	    <?php
																		if($appointment['book_laboratory_test_id']!='' && $appointment['responsestatus']!="TXN_FAILURE" && $appointment['responsestatus']!="TXN_CANCELLED" && $appointment['responsestatus']!="")
																		{
																			if($this->session->userdata('admin_user')['role_id']==-1 || $this->session->userdata('admin_user')['role_id']==7 || $this->session->userdata('admin_user')['role_id']==8){
																if($assing_appointment_id['appointment_id']==$appointment['book_laboratory_test_id']){
																							
																						
																			?>
																				<a href="#"  class="btn btn-sm btn-clean btn-icon mr-2 btn-assign" data-id="<?php echo $appointment['book_laboratory_test_id'];?>,<?php echo "3";?>" title="Assign">

																		<span class="svg-icon svg-icon-primary svg-icon-2x">
																				<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-12-28-020759/theme/html/demo1/dist/../src/media/svg/icons/Communication/Share.svg-->
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			        <rect x="0" y="0" width="24" height="24"/>
																			        <path d="M10.9,2 C11.4522847,2 11.9,2.44771525 11.9,3 C11.9,3.55228475 11.4522847,4 10.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,16 C20,15.4477153 20.4477153,15 21,15 C21.5522847,15 22,15.4477153 22,16 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L10.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																			        <path d="M24.0690576,13.8973499 C24.0690576,13.1346331 24.2324969,10.1246259 21.8580869,7.73659596 C20.2600137,6.12944276 17.8683518,5.85068794 15.0081639,5.72356847 L15.0081639,1.83791555 C15.0081639,1.42370199 14.6723775,1.08791555 14.2581639,1.08791555 C14.0718537,1.08791555 13.892213,1.15726043 13.7542266,1.28244533 L7.24606818,7.18681951 C6.93929045,7.46513642 6.9162184,7.93944934 7.1945353,8.24622707 C7.20914339,8.26232899 7.22444472,8.27778811 7.24039592,8.29256062 L13.7485543,14.3198102 C14.0524605,14.6012598 14.5269852,14.5830551 14.8084348,14.2791489 C14.9368329,14.140506 15.0081639,13.9585047 15.0081639,13.7695393 L15.0081639,9.90761477 C16.8241562,9.95755456 18.1177196,10.0730665 19.2929978,10.4469645 C20.9778605,10.9829796 22.2816185,12.4994368 23.2042718,14.996336 L23.2043032,14.9963244 C23.313119,15.2908036 23.5938372,15.4863432 23.9077781,15.4863432 L24.0735976,15.4863432 C24.0735976,15.0278051 24.0690576,14.3014082 24.0690576,13.8973499 Z" fill="#000000" fill-rule="nonzero" transform="translate(15.536799, 8.287129) scale(-1, 1) translate(-15.536799, -8.287129) "/>
																			    </g>
																		</svg>
																		<!--end::Svg Icon-->
																	</span></a>
																	<?php
																}
																else
																{
																	?>
																	<a href="#" class="btn btn-sm btn-clean btn-icon mr-2 btn-assign" data-id="<?php echo $appointment['book_laboratory_test_id'];?>,<?php echo "3";?>" title="Assign">

																		<span class="svg-icon svg-icon-primary svg-icon-2x">
																				<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-12-28-020759/theme/html/demo1/dist/../src/media/svg/icons/Communication/Share.svg-->
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			        <rect x="0" y="0" width="24" height="24"/>
																			        <path d="M10.9,2 C11.4522847,2 11.9,2.44771525 11.9,3 C11.9,3.55228475 11.4522847,4 10.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,16 C20,15.4477153 20.4477153,15 21,15 C21.5522847,15 22,15.4477153 22,16 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L10.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																			        <path d="M24.0690576,13.8973499 C24.0690576,13.1346331 24.2324969,10.1246259 21.8580869,7.73659596 C20.2600137,6.12944276 17.8683518,5.85068794 15.0081639,5.72356847 L15.0081639,1.83791555 C15.0081639,1.42370199 14.6723775,1.08791555 14.2581639,1.08791555 C14.0718537,1.08791555 13.892213,1.15726043 13.7542266,1.28244533 L7.24606818,7.18681951 C6.93929045,7.46513642 6.9162184,7.93944934 7.1945353,8.24622707 C7.20914339,8.26232899 7.22444472,8.27778811 7.24039592,8.29256062 L13.7485543,14.3198102 C14.0524605,14.6012598 14.5269852,14.5830551 14.8084348,14.2791489 C14.9368329,14.140506 15.0081639,13.9585047 15.0081639,13.7695393 L15.0081639,9.90761477 C16.8241562,9.95755456 18.1177196,10.0730665 19.2929978,10.4469645 C20.9778605,10.9829796 22.2816185,12.4994368 23.2042718,14.996336 L23.2043032,14.9963244 C23.313119,15.2908036 23.5938372,15.4863432 23.9077781,15.4863432 L24.0735976,15.4863432 C24.0735976,15.0278051 24.0690576,14.3014082 24.0690576,13.8973499 Z" fill="#000000" fill-rule="nonzero" transform="translate(15.536799, 8.287129) scale(-1, 1) translate(-15.536799, -8.287129) "/>
																			    </g>
																		</svg>
																		<!--end::Svg Icon-->
																	</span></a>
																	<?php
																}
															}
																?>
																	<button formaction="<?php echo base_url(); ?>viewAdminBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['book_laboratory_test_id']; ?>,<?php echo "3";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		<i class="fa fa-eye" aria-hidden="true"></i>

																		</button>
																		<?php
																		if($appointment['responsestatus']!="TXN_FAILURE" && $appointment['responsestatus']!="TXN_CANCELLED" && $appointment['responsestatus']!=""){
																			?>
																		<button formaction="<?php echo base_url(); ?>adminEditLabAppointment" name="btn_edit_appointment" 
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
																	     $this->db->select('*');
																		$this->db->from('assign_appointment');
																		$this->db->where('assign_appointment.appointment_id',$appointment['book_medicine_id']);
																		$assing_appointment_id= $this->db->get()->row_array();
																		
																		if($appointment['book_medicine_id']!='')
																		{
																			if($this->session->userdata('admin_user')['role_id']==-1 || $this->session->userdata('admin_user')['role_id']==7 || $this->session->userdata('admin_user')['role_id']==8){
																			if($assing_appointment_id['appointment_id']==$appointment['book_medicine_id']){
																			?>
																				<!-- <a href="#" style="pointer-events: none;
                    cursor:not-allowed;background-color: #EEEEEE;" class="btn btn-sm btn-clean btn-icon mr-2 btn-assign" data-id="<?php echo $appointment['book_medicine_id'];?>,<?php echo "4";?>" title="Assign">

																		<span class="svg-icon svg-icon-primary svg-icon-2x">
																				
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			        <rect x="0" y="0" width="24" height="24"/>
																			        <path d="M10.9,2 C11.4522847,2 11.9,2.44771525 11.9,3 C11.9,3.55228475 11.4522847,4 10.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,16 C20,15.4477153 20.4477153,15 21,15 C21.5522847,15 22,15.4477153 22,16 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L10.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																			        <path d="M24.0690576,13.8973499 C24.0690576,13.1346331 24.2324969,10.1246259 21.8580869,7.73659596 C20.2600137,6.12944276 17.8683518,5.85068794 15.0081639,5.72356847 L15.0081639,1.83791555 C15.0081639,1.42370199 14.6723775,1.08791555 14.2581639,1.08791555 C14.0718537,1.08791555 13.892213,1.15726043 13.7542266,1.28244533 L7.24606818,7.18681951 C6.93929045,7.46513642 6.9162184,7.93944934 7.1945353,8.24622707 C7.20914339,8.26232899 7.22444472,8.27778811 7.24039592,8.29256062 L13.7485543,14.3198102 C14.0524605,14.6012598 14.5269852,14.5830551 14.8084348,14.2791489 C14.9368329,14.140506 15.0081639,13.9585047 15.0081639,13.7695393 L15.0081639,9.90761477 C16.8241562,9.95755456 18.1177196,10.0730665 19.2929978,10.4469645 C20.9778605,10.9829796 22.2816185,12.4994368 23.2042718,14.996336 L23.2043032,14.9963244 C23.313119,15.2908036 23.5938372,15.4863432 23.9077781,15.4863432 L24.0735976,15.4863432 C24.0735976,15.0278051 24.0690576,14.3014082 24.0690576,13.8973499 Z" fill="#000000" fill-rule="nonzero" transform="translate(15.536799, 8.287129) scale(-1, 1) translate(-15.536799, -8.287129) "/>
																			    </g>
																		</svg>
																		
																	</span></a> -->
																	<?php
																}
																else
																{
																	?>
																	<!-- <a href="#"  class="btn btn-sm btn-clean btn-icon mr-2 btn-assign" data-id="<?php echo $appointment['book_medicine_id'];?>,<?php echo "4";?>" title="Assign">

																		<span class="svg-icon svg-icon-primary svg-icon-2x">
																				
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			        <rect x="0" y="0" width="24" height="24"/>
																			        <path d="M10.9,2 C11.4522847,2 11.9,2.44771525 11.9,3 C11.9,3.55228475 11.4522847,4 10.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,16 C20,15.4477153 20.4477153,15 21,15 C21.5522847,15 22,15.4477153 22,16 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L10.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																			        <path d="M24.0690576,13.8973499 C24.0690576,13.1346331 24.2324969,10.1246259 21.8580869,7.73659596 C20.2600137,6.12944276 17.8683518,5.85068794 15.0081639,5.72356847 L15.0081639,1.83791555 C15.0081639,1.42370199 14.6723775,1.08791555 14.2581639,1.08791555 C14.0718537,1.08791555 13.892213,1.15726043 13.7542266,1.28244533 L7.24606818,7.18681951 C6.93929045,7.46513642 6.9162184,7.93944934 7.1945353,8.24622707 C7.20914339,8.26232899 7.22444472,8.27778811 7.24039592,8.29256062 L13.7485543,14.3198102 C14.0524605,14.6012598 14.5269852,14.5830551 14.8084348,14.2791489 C14.9368329,14.140506 15.0081639,13.9585047 15.0081639,13.7695393 L15.0081639,9.90761477 C16.8241562,9.95755456 18.1177196,10.0730665 19.2929978,10.4469645 C20.9778605,10.9829796 22.2816185,12.4994368 23.2042718,14.996336 L23.2043032,14.9963244 C23.313119,15.2908036 23.5938372,15.4863432 23.9077781,15.4863432 L24.0735976,15.4863432 C24.0735976,15.0278051 24.0690576,14.3014082 24.0690576,13.8973499 Z" fill="#000000" fill-rule="nonzero" transform="translate(15.536799, 8.287129) scale(-1, 1) translate(-15.536799, -8.287129) "/>
																			    </g>
																		</svg>
																		
																	</span></a> -->
																	<?php
																}
															}
																?>
																	<button formaction="<?php echo base_url(); ?>viewAdminBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['book_medicine_id']; ?>,<?php echo "4";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		<i class="fa fa-eye" aria-hidden="true"></i>

																		</button>
																		<?php
																		if($appointment['responsestatus']!="TXN_FAILURE" && $appointment['responsestatus']!="TXN_CANCELLED" && $appointment['responsestatus']!=""){
																			?>
																		<button formaction="<?php echo base_url(); ?>adminEditPharmacyAppointment" name="btn_edit_appointment" 
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
																		if($appointment['book_ambulance_id']!='' && $appointment['responsestatus']!="TXN_FAILURE" && $appointment['responsestatus']!="TXN_CANCELLED" && $appointment['responsestatus']!="")
																		{
																			?>
																				<a href="#" class="btn btn-sm btn-clean btn-icon mr-2 btn-assign" data-id="<?php echo $appointment['book_ambulance_id'];?>,<?php echo "5";?>" title="Assign">

																		<span class="svg-icon svg-icon-primary svg-icon-2x">
																				<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-12-28-020759/theme/html/demo1/dist/../src/media/svg/icons/Communication/Share.svg-->
																			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																			    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			        <rect x="0" y="0" width="24" height="24"/>
																			        <path d="M10.9,2 C11.4522847,2 11.9,2.44771525 11.9,3 C11.9,3.55228475 11.4522847,4 10.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,16 C20,15.4477153 20.4477153,15 21,15 C21.5522847,15 22,15.4477153 22,16 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L10.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																			        <path d="M24.0690576,13.8973499 C24.0690576,13.1346331 24.2324969,10.1246259 21.8580869,7.73659596 C20.2600137,6.12944276 17.8683518,5.85068794 15.0081639,5.72356847 L15.0081639,1.83791555 C15.0081639,1.42370199 14.6723775,1.08791555 14.2581639,1.08791555 C14.0718537,1.08791555 13.892213,1.15726043 13.7542266,1.28244533 L7.24606818,7.18681951 C6.93929045,7.46513642 6.9162184,7.93944934 7.1945353,8.24622707 C7.20914339,8.26232899 7.22444472,8.27778811 7.24039592,8.29256062 L13.7485543,14.3198102 C14.0524605,14.6012598 14.5269852,14.5830551 14.8084348,14.2791489 C14.9368329,14.140506 15.0081639,13.9585047 15.0081639,13.7695393 L15.0081639,9.90761477 C16.8241562,9.95755456 18.1177196,10.0730665 19.2929978,10.4469645 C20.9778605,10.9829796 22.2816185,12.4994368 23.2042718,14.996336 L23.2043032,14.9963244 C23.313119,15.2908036 23.5938372,15.4863432 23.9077781,15.4863432 L24.0735976,15.4863432 C24.0735976,15.0278051 24.0690576,14.3014082 24.0690576,13.8973499 Z" fill="#000000" fill-rule="nonzero" transform="translate(15.536799, 8.287129) scale(-1, 1) translate(-15.536799, -8.287129) "/>
																			    </g>
																		</svg>
																		<!--end::Svg Icon-->
																	</span></a>
																	<button formaction="<?php echo base_url(); ?>viewAdminBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['book_ambulance_id']; ?>,<?php echo "5";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		<i class="fa fa-eye" aria-hidden="true"></i>

																		</button>
																		<?php
																		if($appointment['responsestatus']!="TXN_FAILURE" && $appointment['responsestatus']!=""){
																			?>
																		<button formaction="<?php echo base_url(); ?>adminEditAmbulanceAppointment" name="btn_edit_appointment" 
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
						if($appointment['id']!='' && $appointment['responsestatus']!="TXN_FAILURE" && $appointment['responsestatus']!="TXN_CANCELLED" && $appointment['responsestatus']!="")
						{   
             ?>
                   <button formaction="<?php echo base_url(); ?>viewAdminBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['id']; ?>,<?php echo "6";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

							<i class="fa fa-eye" aria-hidden="true"></i>

						</button>
                 <a href="#" class="btn btn-sm btn-clean btn-icon mr-2 btn-assign" data-id="<?php echo $appointment['id'];?>,<?php echo "6";?>" title="Assign">

																<span class="svg-icon svg-icon-primary svg-icon-2x">
																	<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-12-28-020759/theme/html/demo1/dist/../src/media/svg/icons/Communication/Share.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<rect x="0" y="0" width="24" height="24"/>
																			<path d="M10.9,2 C11.4522847,2 11.9,2.44771525 11.9,3 C11.9,3.55228475 11.4522847,4 10.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,16 C20,15.4477153 20.4477153,15 21,15 C21.5522847,15 22,15.4477153 22,16 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L10.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																			<path d="M24.0690576,13.8973499 C24.0690576,13.1346331 24.2324969,10.1246259 21.8580869,7.73659596 C20.2600137,6.12944276 17.8683518,5.85068794 15.0081639,5.72356847 L15.0081639,1.83791555 C15.0081639,1.42370199 14.6723775,1.08791555 14.2581639,1.08791555 C14.0718537,1.08791555 13.892213,1.15726043 13.7542266,1.28244533 L7.24606818,7.18681951 C6.93929045,7.46513642 6.9162184,7.93944934 7.1945353,8.24622707 C7.20914339,8.26232899 7.22444472,8.27778811 7.24039592,8.29256062 L13.7485543,14.3198102 C14.0524605,14.6012598 14.5269852,14.5830551 14.8084348,14.2791489 C14.9368329,14.140506 15.0081639,13.9585047 15.0081639,13.7695393 L15.0081639,9.90761477 C16.8241562,9.95755456 18.1177196,10.0730665 19.2929978,10.4469645 C20.9778605,10.9829796 22.2816185,12.4994368 23.2042718,14.996336 L23.2043032,14.9963244 C23.313119,15.2908036 23.5938372,15.4863432 23.9077781,15.4863432 L24.0735976,15.4863432 C24.0735976,15.0278051 24.0690576,14.3014082 24.0690576,13.8973499 Z" fill="#000000" fill-rule="nonzero" transform="translate(15.536799, 8.287129) scale(-1, 1) translate(-15.536799, -8.287129) "/>
																		</g>
																	</svg>
																	<!--end::Svg Icon-->
																</span></a>
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
    $(document).ready(function(){
 
        // get Edit Product
       
 // alert("100");
        // get Delete Product
        $('.btn-assign').on('click',function(){
            // get data from button edit
            const id = $(this).data('id');
            //alert("200");
            // Set data to Form Edit
            //  const doctor= $('.doctorappointment').val(1);
            // const nurse=  $('.nurseappointment').val(2);
            //  const lab= $('.labappointment').val(3);
            // const pharmacy=  $('.pharmacyappointment').val(4);
            //  const ambulance= $('.ambulanceappointment').val(5);
            $('.appointmentID').val(id);
            // Call Modal Edit
            $('#assignModel').modal('show');
        });
         
    });
</script>
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
<script type="text/javascript">
	$("#inline_content input[name=assign_radio]").click(function(){

		//alert($('input:radio[name=serivce_radio]:checked').val());
    
    if($('input:radio[name=assign_radio]:checked').val() == "Team"){

    	$("#employee_dropdown").hide();
    	$("#team_dropdown").show();
    	
    	$('.select2-search__field').css({'width': 420});
    	$('.select2-selection__rendered').css({'width': 420});
    	

       
    }
    else if($('input:radio[name=assign_radio]:checked').val() == "Employee")
    {
    	//alert("fs");
    	$("#team_dropdown").hide();
    	$("#employee_dropdown").show();
    	$('.select2-search__field').css({'width': 400});
    	$('.select2-selection__rendered').css({'width': 420});
    }
     
});
</script>


<form action="<?php echo base_url(); ?>assingAppointment" method="post">
        <div class="modal fade" id="assignModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assign</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             <div class="row">
               <div class="col-lg-12">
					<div id="inline_content">
						<div class="radio-inline">
						    <div class="col-md-6">
								                <label class="radio radio-success">
								                    <input type="radio" name="assign_radio" class="form-control" value="Team" /><span></span>
								                    Team
								                </label>
								             	</div>
								             	<div class="col-md-6">
								                <label class="radio radio-success">
								                    <input type="radio" name="assign_radio"  class="form-control" value="Employee" /><span></span>
								                    Employee
								                </label>
								            </div>
								            
								               
								            </div>
								             </div>
								            <div id="radio_assign_valid" class="validation" style="display:none;color:red;">Please Select Value</div>
								            
								        
								   
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-lg-12" id="team_dropdown" style="display: none";>

										<b><label>Team *</label></b>
										<select class="form-control select2 team_valid" id="kt_select2_10" name="team_id"  data-placeholder="Select Team" style="width:420">
										<option value="none" selected disabled hidden> Select Team </option>
											<?php 
												foreach($manage_team_assign as $mta){
													echo '<option value="'.$mta['team_id'].'">'.$mta['team_name'].'</option>';
												}
											?>
										</select>
										 <div id="team_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>


									
									
									<div class="col-lg-12" id="employee_dropdown" style="display: none"; >
										<b><label>Employee *</label></b>

										<select class="form-control select2 employee_valid" id="kt_select2_11" name="employee_id"  data-placeholder="Select Employee" style="width:420">
											<option value="none" selected disabled hidden> Select Employee </option>
											
											<?php 
												foreach($manage_employee_assign as $mea){
													echo '<option value="'.$mea['emp_id'].'">('.$mea['user_type_name'].") ".$mea['first_name']." ".$mea['last_name']." (".$mea['mobile_no'].')</option>';
												}
											?>
										</select>
										<div id="employee_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
			</div>

             
            </div>
            <div class="modal-footer">
              	 <input type="hidden"  name="btn_appointment_assign" class="appointmentID">
              	  <!-- <input type="hidden"  name="doctor_appointment_assign" class="doctorappointment">
              	  <input type="hidden"  name="nurse_appointment_assign" class="nurseappointment">
              	  <input type="hidden"  name="lab_appointment_assign" class="labappointment">
              	  <input type="hidden"  name="pharmacy_appointment_assign" class="pharmacyappointment">
              	  <input type="hidden"  name="ambulance_appointment_assign" class="ambulanceappointment"> -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="btnSubmit">Assign</button>
            </div>
            </div>
        </div>
        </div>
      
</form>
<script src="<?php echo base_url(); ?>assets/js/pages/crud/forms/widgets/select2.js"></script>