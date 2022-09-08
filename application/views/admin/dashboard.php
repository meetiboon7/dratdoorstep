
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5>
									<!--end::Page Title-->
								</div>
								<!--end::Info-->
							</div>
						</div>
						<!--end::Subheader-->
						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
						<div class="card card-custom">
											<!--begin::Header-->
											<div class="card-header border-0">
												<h3 class="card-title align-items-start flex-column">
													<span class="card-label font-weight-bolder text-dark">Book an Appointment</span>
													<span class="text-muted mt-3 font-weight-bold font-size-sm">You can book an Appointment on behalf of Patient</span>
												</h3>
												<div class="card-toolbar">
													<?php
													if($this->session->userdata('admin_user')['user_type_id'] == 1)	
													{
													?>	
													<a href="<?php echo base_url()?>adminAddDoctorAppointment" class="btn btn-success font-weight-bolder font-size-sm mr-3" style="background-color:#ffffff;color:#000000"><img src="<?php echo base_url()?>uploads/image/doctor.svg" width="24px" height="24px" fill="#000"; />  Doctor</a>
													<?php
													}
													elseif($this->session->userdata('admin_user')['user_type_id'] == 2)
													{
														?>
														
														<a href="<?php echo base_url()?>adminAddNurseAppointment" class="btn btn-success font-weight-bolder font-size-sm mr-3" style="background-color:#ffffff;color:#000000"><img src="<?php echo base_url()?>uploads/image/nurse.svg" width="24px" height="24px" fill="#000"; />  Nurse</a>
														<?php


													}
													elseif($this->session->userdata('admin_user')['user_type_id'] == 3)
													{
														?>
														<a href="<?php echo base_url()?>adminAddLabAppointment" class="btn btn-success font-weight-bolder font-size-sm mr-3" style="background-color:#ffffff;color:#000000"><img src="<?php echo base_url()?>uploads/image/lab.svg" width="24px" height="24px" fill="#000"; />   &nbsp;Lab Test</a>
														<?php
													}
													elseif($this->session->userdata('admin_user')['user_type_id'] == 4)
													{
														?>
														<a href="<?php echo base_url()?>adminAddPharmacyAppointment" class="btn btn-success font-weight-bolder font-size-sm mr-3" style="background-color:#ffffff;color:#000000"><img src="<?php echo base_url()?>uploads/image/drug.svg" width="24px" height="24px" fill="#000"; />  E-Pharmacy</a>
														<?php

													}
													elseif($this->session->userdata('admin_user')['user_type_id'] == 5)
													{	
														?>
															<a href="<?php echo base_url()?>adminAddAmbulanceAppointment" class="btn btn-success font-weight-bolder font-size-sm mr-3" style="background-color:#ffffff;color:#000000"><img src="<?php echo base_url()?>uploads/image/ambulance.svg" width="24px" height="24px" fill="#000"; /> &nbsp; Ambulance</a>
														<?php
													}
													elseif($this->session->userdata('admin_user')['user_type_id'] == 999 || $this->session->userdata('admin_user')['user_type_id'] == 6 || $this->session->userdata('admin_user')['user_type_id'] == 7 || $this->session->userdata('admin_user')['user_type_id'] == 8)
													{
														?>
														<a href="<?php echo base_url()?>adminAddDoctorAppointment" class="btn btn-success font-weight-bolder font-size-sm mr-3" style="background-color:#ffffff;color:#000000"><img src="<?php echo base_url()?>uploads/image/doctor.svg" width="24px" height="24px" fill="#000"; />  Doctor</a>
														<a href="<?php echo base_url()?>adminAddNurseAppointment" class="btn btn-success font-weight-bolder font-size-sm mr-3" style="background-color:#ffffff;color:#000000"><img src="<?php echo base_url()?>uploads/image/nurse.svg" width="24px" height="24px" fill="#000"; />  Nurse</a>
														<a href="<?php echo base_url()?>adminAddLabAppointment" class="btn btn-success font-weight-bolder font-size-sm mr-3" style="background-color:#ffffff;color:#000000"><img src="<?php echo base_url()?>uploads/image/lab.svg" width="24px" height="24px" fill="#000"; />   &nbsp;Lab Test</a>
														<a href="<?php echo base_url()?>adminAddPharmacyAppointment" class="btn btn-success font-weight-bolder font-size-sm mr-3" style="background-color:#ffffff;color:#000000"><img src="<?php echo base_url()?>uploads/image/drug.svg" width="24px" height="24px" fill="#000"; />  E-Pharmacy</a>
														<a href="<?php echo base_url()?>adminAddAmbulanceAppointment" class="btn btn-success font-weight-bolder font-size-sm mr-3" style="background-color:#ffffff;color:#000000"><img src="<?php echo base_url()?>uploads/image/ambulance.svg" width="24px" height="24px" fill="#000"; /> &nbsp; Ambulance</a>

														<?php
													}
													?>
													<a href="<?php echo base_url()?>adminPackageBook" class="btn btn-success font-weight-bolder font-size-sm mr-3" style="background-color:#ffffff;color:#000000"><img src="<?php echo base_url()?>uploads/image/Group 1576.svg" width="24px" height="24px" fill="#000"; /> &nbsp; Package</a>
													&nbsp;&nbsp;&nbsp;
													
													<a href="<?php echo base_url()?>adminAppointmentList" class="btn btn-success font-weight-bolder font-size-sm mr-3" style="background-color:#ffffff;color:#000000;float:left;" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
													  <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
													  <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
													</svg> &nbsp; View Appointment List</a>
													
												</div>
											</div>
											<!--end::Header-->
											<!--begin::Body-->
											
											<!--end::Body-->
										</div>
										<br><br>
										<div class="row">
					
						<div class="col-xl-12">
									<div class="card card-custom">

											<div class="card-header card-header-tabs-line">
												<div class="card-title">
													<h3 class="card-label">Today's Appointment</h3>
													<?php
													$date=date('Y-m-d');
													if($all_holiday[0]['hdate']==$date)
													{
														echo "<font color='red'> ( Today is ".$all_holiday[0]['hday']." )</font>";
													}
													?>
												</div>
												<div class="card-toolbar">
													<ul class="nav nav-tabs nav-bold nav-tabs-line tabs">
														<?php
														if($this->session->userdata('admin_user')['user_type_id'] == 1)	
														{
														?>	
														<li class="nav-item" >
															<a class="nav-link active" name="id" href="#kt_tab_pane_2_3" id='1'  data-toggle="tab">
																<span class="nav-icon">
																	<img src="<?php echo base_url()?>uploads/image/doctor.svg" width="18px" height="18px" fill="#000"; />
																</span>
																<span class="nav-text">Doctor</span>
															</a>
														</li>
														<?php
														}
														elseif ($this->session->userdata('admin_user')['user_type_id']==2) {
															?>
															<li class="nav-item" >
																<a class="nav-link" id="2" name="id" href="#kt_tab_pane_2_3"  data-toggle="tab">
																	<span class="nav-icon">
																		<img src="<?php echo base_url()?>uploads/image/nurse.svg" width="24px" height="24px" fill="#000"; />
																	</span>
																	<span class="nav-text">Nurse</span>
																</a>
															</li>
															<?php
															# code...
														}
														elseif($this->session->userdata('admin_user')['user_type_id']==3)
														{
															?>
																<li class="nav-item">
															<a class="nav-link" id="3" name="id" data-toggle="tab" href="#kt_tab_pane_2_3">
																<span class="nav-icon">
																	<img src="<?php echo base_url()?>uploads/image/lab.svg" width="24px" height="24px" fill="#000"; />
																</span>
																<span class="nav-text">Lab Test</span>
															</a>
														</li>
															<?php

														}
														elseif($this->session->userdata('admin_user')['user_type_id']==4)
														{
															?>
															<li class="nav-item">
															<a class="nav-link" id="4" name="id" data-toggle="tab" href="#kt_tab_pane_2_3">
																<span class="nav-icon">
																	<img src="<?php echo base_url()?>uploads/image/drug.svg" width="24px" height="24px" fill="#000"; /> 
																</span>
																<span class="nav-text">E-Pharmacy</span>
															</a>
														</li>
															<?php
														}
														elseif($this->session->userdata('admin_user')['user_type_id']==5){
															?>
															<li class="nav-item">
															<a class="nav-link" id="5" name="id" data-toggle="tab" href="#kt_tab_pane_2_3">
																<span class="nav-icon">
																	<img src="<?php echo base_url()?>uploads/image/ambulance.svg" width="24px" height="24px" fill="#000"; />
																</span>
																<span class="nav-text">Ambulance</span>
															</a>
														</li>
															<?php

														}
														elseif($this->session->userdata('admin_user')['user_type_id']==999 || $this->session->userdata('admin_user')['user_type_id']==6 || $this->session->userdata('admin_user')['user_type_id'] == 7 || $this->session->userdata('admin_user')['user_type_id'] == 8)
														{
															?>
															<li class="nav-item" >
															<a class="nav-link active" name="id" href="#kt_tab_pane_2_3" id='1'  data-toggle="tab">
																<span class="nav-icon">
																	<img src="<?php echo base_url()?>uploads/image/doctor.svg" width="18px" height="18px" fill="#000"; />
																</span>
																<span class="nav-text">Doctor</span>
															</a>
														</li>
														<li class="nav-item" >
																<a class="nav-link" id="2" name="id" href="#kt_tab_pane_2_3"  data-toggle="tab">
																	<span class="nav-icon">
																		<img src="<?php echo base_url()?>uploads/image/nurse.svg" width="24px" height="24px" fill="#000"; />
																	</span>
																	<span class="nav-text">Nurse</span>
																</a>
															</li>
															<li class="nav-item">
															<a class="nav-link" id="3" name="id" data-toggle="tab" href="#kt_tab_pane_2_3">
																<span class="nav-icon">
																	<img src="<?php echo base_url()?>uploads/image/lab.svg" width="24px" height="24px" fill="#000"; />
																</span>
																<span class="nav-text">Lab Test</span>
															</a>
														</li>
														<li class="nav-item">
															<a class="nav-link" id="4" name="id" data-toggle="tab" href="#kt_tab_pane_2_3">
																<span class="nav-icon">
																	<img src="<?php echo base_url()?>uploads/image/drug.svg" width="24px" height="24px" fill="#000"; /> 
																</span>
																<span class="nav-text">E-Pharmacy</span>
															</a>
														</li>
														<li class="nav-item">
															<a class="nav-link" id="5" name="id" data-toggle="tab" href="#kt_tab_pane_2_3">
																<span class="nav-icon">
																	<img src="<?php echo base_url()?>uploads/image/ambulance.svg" width="24px" height="24px" fill="#000"; />
																</span>
																<span class="nav-text">Ambulance</span>
															</a>
														</li>
															<?php
														}
														?>

													<!-- 	
														<li class="nav-item">
															<a class="nav-link" id="3" name="id" data-toggle="tab" href="#kt_tab_pane_2_3">
																<span class="nav-icon">
																	<img src="<?php echo base_url()?>uploads/image/lab.svg" width="24px" height="24px" fill="#000"; />
																</span>
																<span class="nav-text">Lab Test</span>
															</a>
														</li>
														<li class="nav-item">
															<a class="nav-link" id="4" name="id" data-toggle="tab" href="#kt_tab_pane_2_3">
																<span class="nav-icon">
																	<img src="<?php echo base_url()?>uploads/image/drug.svg" width="24px" height="24px" fill="#000"; /> 
																</span>
																<span class="nav-text">E-Pharmacy</span>
															</a>
														</li>
														<li class="nav-item">
															<a class="nav-link" id="5" name="id" data-toggle="tab" href="#kt_tab_pane_2_3">
																<span class="nav-icon">
																	<img src="<?php echo base_url()?>uploads/image/ambulance.svg" width="24px" height="24px" fill="#000"; />
																</span>
																<span class="nav-text">Ambulance</span>
															</a>
														</li> -->
														
													</ul>
												</div>
											</div>
											<div class="card-body tab_content">
												<div class="tab-content ">
													<!--begin::Table-->
													<form method="post">
													<div class="table-responsive">
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

												foreach($appointment_book as $appointment){ 
													// echo "<pre>";
													// print_r($appointment);
													// echo "</pre>";
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
																			
																			<div>
																				<a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"><?php echo $appointment['name']?></a>
																				<span class="text-muted font-weight-bold d-block"><?php echo $appointment['contact_no']?></span>
																			</div>
																		</div>
																	</td>
																	<td>
																		<span class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"><?php echo $appointment['address_1']." ".$appointment['address_2']?></span>
																		
																	</td>
																	<td>
																		<span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo date("d-m-Y",strtotime($appointment['date'])); ?></span>
																		
																	</td>
																	<td>
																		<span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $appointment['time']?></span>
																		
																	</td>
																	<?php
																	// echo "<pre>";
																	// print_r($appointment);
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
																elseif($appointment['book_ambulance_id']!='')
																	{
																						?>
																	<td nowrap="nowrap">
																		
																						
																			<button formaction="<?php echo base_url(); ?>viewAdminBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['book_ambulance_id']; ?>,<?php echo "5";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		<i class="fa fa-eye" aria-hidden="true"></i>

																		</button>
																	</td>
																	<?php
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
													
													<!--end::Table-->
												</div>
											</div>
											<div class="display_today_appointment"></div>
										</div>
							</div>

							
						</div>
						<br><br>
						<div class="row">
							<div class="col-xl-12">
										<div class="card card-custom">
									<div class="card-header flex-wrap py-5">
										<div class="card-title">
											<h3 class="card-label">Package List</h3>
										</div>
									</div>
									<div class="card-body">
																			
										<div class="tab-content">
													<!--begin::Table-->
													<div class="table-responsive">
														<table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
															<thead>
																<tr class="text-left text-uppercase">
																	<th style="min-width: 100px"  class="pl-7"><span class="text-dark-75">Service</span></th>
																	<th style="min-width: 100px">
																		<span class="text-dark-75">Patient</span>
																	</th>
																	
																	<th style="min-width: 100px"><span class="text-dark-75">Date</span></th>
																	<th style="min-width: 100px"><span class="text-dark-75">Time</span></th>
																	
																</tr>
															</thead>
															<tbody>
																<?php

												foreach($package_appointment_book as $appointment_book){ 
													// echo "<pre>";
													// print_r($appointment);
													// echo "</pre>";
													?>
																<tr>
																	<td >
																		
																			<div class="symbol symbol-50 symbol-light mr-4">
																				<span class="symbol-label">
																					
																					<img src="<?php echo base_url()?>uploads/image/Group 1576.svg" class="h-75 align-self-end" />  
																				</span>
																			</div>
																			
																		
																	</td>
																	<td class="pl-0 py-8">
																		<div class="d-flex">
																			
																			<div>
																				<a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"><?php echo $appointment_book['name']?></a>
																				<span class="text-muted font-weight-bold d-block"><?php echo $appointment_book['contact_no']?></span>
																			</div>
																		</div>
																	</td>
																	
																	<td>
																		<span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo date("d-m-Y",strtotime($appointment_book['date'])); ?></span>
																		
																	</td>
																	<td>
																		<span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $appointment_book['time']?></span>
																		
																	</td>
																	
																</tr>
																<?php
															}
															?>
																
															</tbody>
														</table>
													</div>
													<!--end::Table-->
												</div>
									</div>
									
								</div>
							</div>
						</div>

</div>
</div>
						<!--end::Entry-->
						
					</div>
					<!--end::Content-->
<script type="text/javascript">

$(document).ready(function() {
//https://codepen.io/cssjockey/pen/jGzuK
    //When page loads...
    $(".tab_content").hide(); //Hide all content
    $("ul.tabs li:first").addClass("active").show(); //Activate first tab
    $(".tab_content:first").show(); //Show first tab content

    //On Click Event
    $("ul.tabs li").click(function() {
//alert("test");
        $("ul.tabs li").removeClass("active"); //Remove any "active" class
        $(this).addClass("active"); //Add "active" class to selected tab
      $(".tab_content").hide(); //Hide all tab content

       var activeTab = $(this).find("a").attr("href");
        var id = $(this).find("a").attr("id");
        //alert(id);
         //Find the href attribute value to identify the active tab + content
        //var idAttr = $(this).attr('id');
      // alert(activeTab);
        if(id != '') {
        	//alert("test");
          $.ajax({
           type: "POST",
            url: "<?php echo base_url('todayAppointment'); ?>",
            data: {id:id},
            dataType: "HTML",
            success: function(html) {
            	// $(".tab_content").show();
            	//alert(html);
			$('.display_today_appointment').html(html);

          		// $(activeTab).html(response);
            }
          });
        }

     
    });

});

</script>