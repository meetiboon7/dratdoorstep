<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Book an Appointment</h5>
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

										<div class="card-title">
											<!-- <h3 class="card-label">Add Holiday</h3> -->
											<span style="color:grey;"> <?php echo $this->session->flashdata('message'); ?> </span>
										</div>
										<div class="form-group row">
											<div class="col-lg-1"></div>
											<div class="col-lg-2">
											<a href="<?php echo base_url()?>addDoctorAppointment" class="btn btn-success" style="background-color:#2c4062">
											   <i class="fa fa-user-md" aria-hidden="true"></i> Doctor
											   
											</a>
											</div>
											<div class="col-lg-2">
											<a href="<?php echo base_url()?>addNurseAppointment" class="btn btn-success" style="background-color:#2c4062">
											   <i class="fa fa-user-md" aria-hidden="true"></i> Nurse

											</a>
										</div>
										<div class="col-lg-2">
											<a href="<?php echo base_url()?>addLabAppointment" class="btn btn-success" style="background-color:#2c4062">
											   <i class="fa fa-flask" aria-hidden="true"></i>Lab Test

											</a>
										</div>
										<div class="col-lg-2">
											<a href="<?php echo base_url()?>addPharmacyAppointment" class="btn btn-success" style="background-color:#2c4062">
											   <i class="fa fa-plus-square" aria-hidden="true"></i> E-Pharmacy

											</a>
										</div>
										&nbsp;&nbsp;&nbsp;
										<div class="col-lg-2">
											<a href="<?php echo base_url()?>addAmbulanceAppointment" class="btn btn-success" style="background-color:#2c4062">
											   <i class="fa fa-ambulance" aria-hidden="true"></i> Ambulance

											</a>
									  	</div>
										<div class="col-lg-1"></div>
									</div>
											
								
								

								<!-- <div class="card-header">
									<h3 class="card-title">
										Appointment
									</h3>
								</div> -->
								
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



