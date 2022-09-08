<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">E-Pharmacy Appointment</h5>
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
									<form method="post">
										<table class="table table-separate table-head-custom table-checkable dataTable no-footer" id="kt_datatable">
											<thead>
												<tr>
													<!-- <th>Sr No</th> -->
													<th>Patient Name</th>
													<th>Mobile Number</th>
													<th>LandLine</th>
													<th>Address</th>
													<th>Prescription</th>
													
												</tr>
											</thead>
											<tbody>
												<?php

												foreach($pharmacy_appointment_book as $appointment){ 
												?>
												<tr>
													
													
													<td><?php echo $appointment['name']; ?></td>
													<td><?php echo $appointment['mobile']; ?></td>
													<td><?php echo $appointment['landline']; ?></td>
													<td><?php echo $appointment['address']; ?></td>
													<td>
														<?php 
														if($appointment['prescription']=='')
														{
															echo " - ";

														}
														else
														{
															?>
															<a href="<?php echo site_url('user/AppointmentList/downloadPharmacyDocument/'.$appointment['prescription']); ?>" download>Download</a>
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



