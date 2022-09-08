<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Lab an Appointment</h5>
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
													
													<!-- <th>Appointment Type</th> -->
													<th>Patient Name</th>
													<th>Mobile Number</th>
													<th>Date</th>
													<th>Time</th>
													<th>Type</th>
													<th>Prescription</th>
													<th>Invoice</th>
													
													<!-- <th>Action</th> -->
												</tr>
											</thead>
											<tbody>
												<?php

												foreach($lab_appointment_book as $appointment){ 

													$newDate = date("d-m-Y", strtotime($originalDate));
													// echo "<pre>";
													// print_r($appointment);
													// echo "</pre>";


													
											?>
												<tr>
													<td><?php echo ucwords($appointment['name']); ?><br>Address : <?php echo $appointment['address']; ?></td>
													<td><?php echo $appointment['contact_no']; ?></td>
													<td><?php echo date("d-m-Y",strtotime($appointment['date'])); ?></td>
													<td><?php echo $appointment['time']; ?></td>
													<td><?php echo $appointment['lab_test_type_name']; ?></td>
													
													<td>
														<a href="<?php echo site_url('user/AppointmentList/download/'.$appointment['prescription']); ?>" download>Download</a>

													</td>
													
													<th> - </th>
													
														
														
													<!-- <td>West Zone</td> -->
													<!-- <td>Inactive</td> -->
												
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



