<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Doctor an Appointment</h5>
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
						
								<!-- <div class="card-header">
									<h3 class="card-title">
										Book Details
									</h3>
								</div> -->
								<div class="card-body">

									
								
								

								<!-- <div class="card-header">
									<h3 class="card-title">
										Appointment
									</h3>
								</div> -->
								<form method="post">
										<table class="table table-separate table-head-custom table-checkable dataTable no-footer" id="kt_datatable">
											<thead>
												<tr>
													<!-- <th>Sr No</th> -->
													<!-- <th>Date</th>
													<th>Time</th>
													<th>Appointment Type</th> -->
													<th>Patient Name</th>
													<th>Mobile Number</th>
													<th>Date</th>
													<th>Time</th>
													<th>Appointment Type</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php

												foreach($appointment_book as $appointment){ 

													//$newDate = date("d-m-Y", strtotime($originalDate));


													
											?>
												<tr>
													<td><?php echo $appointment['name']; ?></td>
													<td><?php echo $appointment['contact_no']; ?></td>
													<td><?php echo date("d-m-Y",strtotime($appointment['date'])); ?></td>
													<td><?php echo $appointment['time']; ?></td>
													<td><?php echo $appointment['doctor_type_name']; ?></td>
													
													
													
													
														
														
													<!-- <td>West Zone</td> -->
													<!-- <td>Inactive</td> -->
													<td nowrap="nowrap">
														<button name="btn_edit_managerole" type="button"  value="<?php echo $role->role_id; ?>"  class="btn btn-sm btn-clean btn-icon mr-2 editmanagerole" title="Edit Zone">	
															
															

															<span class="svg-icon svg-icon-md">
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">	
																	    <rect x="0" y="0" width="24" height="24"></rect>
																	        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
																	        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1">
																	    </rect>
																	</g>
																</svg>
															</span>
														</button>
														<!-- <button formaction="<?php echo base_url(); ?>deleteRole" name="btn_delete_managerole" value="<?php echo $role->role_id;  ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Delete Role">	             
															<i class="flaticon-delete"></i>
														</button> -->
														<a href="#" class="btn btn-sm btn-clean btn-icon mr-2 btn-delete" data-id="<?php echo $role->role_id;?>"> <i class="flaticon-delete"></i></a>
														
														<!-- </a> -->
													</td>
												</tr>
												<?php
											}
											?>
											</tbody>
										</table>
										<!--end: Datatable-->
										</form>
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



