<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Package</h5>
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
													<th>Sr No</th>
													<th>Package Name</th>
													<th>City</th>
													<th>Service</th>
													<th>Fees(&#x20b9)</th>
													<!-- <th>Available Visits</th> -->
													<th>No of Visits</th>
													<th>Validity (Days)</th>
													
													<!-- <th>Status</th> -->
													
													<th>Actions</th>
													
												</tr>
											</thead>
											<tbody>
												
												<?php 
												$i = 1;	

												foreach($manage_package as $package){ 


													// $date = $package['created_date'];
													// $date = strtotime($date);
													// $expired_date = strtotime("+".$package['validate_month']."day", $date);
													// $expired_date = date('Y-m-d', $expired_date);
													// $expired_date."<br>";
													// $today=date('Y-m-d')."<br>";


													 $date = $package['purchase_date'];
												$date = strtotime($date);
												$expired_date = strtotime("+".$package['validate_month']."day", $date);
												 $expired_date = date('Y-m-d', $expired_date);
												
												$left_available_visit=$package['no_visit'] - $package['available_visit'];
												$today=date('Y-m-d');

												//echo $expired_date."<br>";
												//echo $today=date('Y-m-d')."<br>";

											//	if($today < $expired_date){
													?>
												
												<tr>
													<td><?php echo $package['package_id'] ?></td>
													<td><?php echo $package['package_name'] ?></td>
													<td><?php echo $package['city'] ?></td>
													<td><?php echo $package['user_type_name']; ?></td>
													<td><?php echo $package['fees_name']; ?></td>
													<!-- <td><?php echo $left_available_visit; ?></td> -->
													<td><?php echo $package['no_visit']; ?></td>
													<td><?php echo $package['validate_month']; ?></td>
													<!-- <td><?php if($package['package_status'] == 0) { echo "Inactive"; } if($package['package_status'] == 1) { echo "Active"; } ?></td> -->
													<?php
													// if($today < $expired_date && $left_available_visit!=0)
													// {
														?>
													<td nowrap="nowrap">
													
														<button formaction="<?php echo base_url(); ?>userViewPackage" name="btn_view_package" value="<?php echo $package['package_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

															<i class="fa fa-eye" aria-hidden="true"></i>

														</button>
														 <?php
         
         
         date_default_timezone_set("Asia/Kolkata");
         $start = '08:00:00';
         $end   = '20:00:00';
         //$time=time();
         $time= date('H:i:s');
       
         $date=date('Y-m-d');
        // echo $holiday[0][hdate] . "==".$date;
         if(date('D') == 'Sun' || $holiday[0][hdate]==$date || ($time >=$start && $time >= $end)) {
         ?>
         <button formaction="<?php echo base_url(); ?>userAddPackage/addPackage" name="btn_add_package" value="<?php echo $package['package_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Add Package" disabled style="cursor: no-drop;">

															<i class="fas fa-check-square" title="Today is Holiday So don't book this Package today."></i>
														</button>
         <?php 
        
        }
        else
        {
            ?>
           <button formaction="<?php echo base_url(); ?>userAddPackage/addPackage" name="btn_add_package" value="<?php echo $package['package_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Add Package">

															<i class="fas fa-check-square" title="Book Package"></i>
														</button>  
            <?php
        }


         ?>

														
														
														
														<!-- 	<a href="<?php echo base_url(); ?>userAddPackage" > </a> -->
														<!-- </a> -->
														
													</td>
													<?php
												 // }
													?>
													
												</tr>
												<?php }
												//}
												?>
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
