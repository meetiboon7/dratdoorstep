<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Book Package List</h5>
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
									<div class="card-header flex-wrap py-5">
									 <div class="card-title">
										<span style="color:grey;"> <?php echo $this->session->flashdata('message'); ?> </span>
										</div>
										<div class="card-toolbar">
											
											<a href="<?php echo base_url();?>book_package" class="btn btn-primary font-weight-bolder">
											<span class="svg-icon svg-icon-md">						
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<circle fill="#000000" cx="9" cy="15" r="6" />
														<path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
													</g>
												</svg>	
											</span>Add Package</a>
										</div>
									</div>
									<div class="card-body">
										<!--begin: Datatable-->
                                    <form method="post">
										<table class="table table-separate table-head-custom table-checkable" id="complain_datatable">
											<thead>
												<tr>
													<th>User Name</th>
													<th>Address</th>
													<th>Start Date</th>
													<th>End Date</th>
													<th>Service Type</th>
													<th>Fees</th>	
                                                    <th>Generate Invoice</th>				
                                                </tr>
											</thead>
											<tbody>
                                               <?php 	
												 foreach($package_data as $package){ 	
												?>
												<tr>
                                                <td><?php echo $package['first_name']." ".$package['last_name'] ?></td>
                                                <td><?php echo $package['address_1']." ".$package['address_2'] ?></td>
                                                <td><?php echo $package['date'] ?></td>
                                                <td><?php echo $package['date_end'] ?></td>
                                                <td><?php echo $package['service_type'] ?></td>
                                                <td><?php echo $package['fees'] ?></td>
                                                <td><button  formaction="<?php echo base_url(); ?>package_invoice" name="invoice_id" value="<?php echo $package['package_book_id']; ?>"  class="btn btn-secondary" title="View Invoice">Receipt</button></td>
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

    $('#complain_datatable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : true
    })
} );

</script>
