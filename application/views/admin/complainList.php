<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Feedback</h5>
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
										<!-- <div class="card-title">
										

											<span style="color:grey;"> <?php echo $this->session->flashdata('message'); ?> </span>
										</div>
										<div class="card-toolbar">
											
											<a href="<?php echo base_url();?>addComplain" class="btn btn-primary font-weight-bolder">
											<span class="svg-icon svg-icon-md">
												
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<circle fill="#000000" cx="9" cy="15" r="6" />
														<path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
													</g>
												</svg>
												
											</span>Add Complain</a>
											
										</div> -->
									</div>
									<div class="card-body">
										<!--begin: Datatable-->
										<table class="table table-separate table-head-custom table-checkable" id="complain_datatable">
											<thead>
												<tr>
													<th width="10%">Option</th>
													<th width="10%">Service</th>
													<th width="35%">Description</th>
													<th width="15%">Date</th>
													<th width="20%">Email</th>
													<th width="10%">Mobile</th>
													
												</tr>
											</thead>
											<tbody>
												<form method="post">
												<?php 
												
												foreach($user_feedback as $feedback){ 
													
													?>
												<tr>
													<td><?php echo $feedback['name'] ?></td>
													<td><?php echo $feedback['service_name']; ?></td>
													<td><?php echo $feedback['problem']; ?></td>
													<td><?php echo date("d-m-Y H:i:s",strtotime($feedback['date'])); ?></td>
													<td><?php echo $feedback['email']; ?></td>
													<td><?php echo $feedback['mobile']; ?></td>
													
													
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
