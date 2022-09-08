<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">My Book Package</h5>
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
								<div class="card card-custom">
									<!-- <div class="card-header flex-wrap py-5">
										<div class="card-title">
											

											<span style="color:grey;"> <?php echo $this->session->flashdata('message'); ?> </span>
										</div>
										
										
										
									</div> -->

									<div class="card-body">
										<!--begin: Datatable-->
										<form method="post">
										<table class="table table-separate table-head-custom table-checkable" id="package_datatable">
											<thead>
												<tr>
													<th>Package Name</th>
													<th>Service</th>
													<th>Booked For</th>
													<th>Expired On</th>
													<th>Available Visits</th>
													<th>Total Visit</th>
													
													
													<!-- <th>Status</th> -->
													
													<th>Actions</th>
													
												</tr>
											</thead>
											<tbody>
												
												<?php 
												$i = 1;	
												foreach($manage_package as $package){ 

												//$date = strtotime("+".$package['validate_month']."day", $package['created_date']);
												//echo $date;
												//echo date('Y-m-d', $date);
													// echo "<pre>";
													// print_r($package);
												// $date = $package['purchase_date'];
												// $date = strtotime($date);
												// $expired_date = strtotime("+".$package['validate_month']."day", $date);
												
												$left_available_visit=$package['available_visit'];
												//echo $package['no_visit'];
												//echo $package['available_visit'];
												//echo $left_available_visit;	
													?>
												<tr>

													<td><?php echo $package['package_name'] ?></td>
													<td><?php echo $package['user_type_name']; ?></td>
													<td><?php echo $package['name']; ?></td>
													<td><?php echo date("d-m-Y",strtotime($package['expire_date'])); ?></td>
													<td><?php echo $left_available_visit; ?></td>
													<td><?php echo $package['no_visit']; ?></td>

													
													
													<td nowrap="nowrap">
														<?php
														?>
														<button formaction="<?php echo base_url(); ?>userViewMyPackage" name="btn_view_mypackage" value="<?php echo $package['book_package_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

															<i class="fa fa-eye" aria-hidden="true"></i>

														</button>
														   <input type="hidden" name="cart_id" id="cart_id" value="<?php echo $package['cart_id'];?>">

														<!-- <button formaction="<?php echo base_url(); ?>userAddPackage/addPackage" name="btn_add_package" value="<?php echo $package['package_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Add Package">

															<i class="fas fa-check-square" title="Book Package"></i>
														</button> -->
														
														
														<!-- 	<a href="<?php echo base_url(); ?>userAddPackage" > </a> -->
														<!-- </a> -->
														
													</td>
													
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</form>
										<!--end: Datatable-->
									</div>
								</div>
								<!--end::Card-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					<!--end::Content-->


<script type="text/javascript">
                         	
	$(document).ready( function () {
    //$('#myTable').DataTable();

    $('#package_datatable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : true
    })
} );

</script>
