<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Manage Fees</h5>
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
											<!-- <h3 class="card-label">Fees </h3> -->

											<span style="color:grey;"> <?php echo $this->session->flashdata('message'); ?> </span>
										</div>
										<?php
								
								
									if($all_permission[5][add_permission] == 1) {
								?>
										<div class="card-toolbar">
											<!--begin::Button-->
											<a href="<?php echo base_url();?>addManageFees" class="btn btn-primary font-weight-bolder">
											<span class="svg-icon svg-icon-md">
												<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<circle fill="#000000" cx="9" cy="15" r="6" />
														<path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
													</g>
												</svg>
												<!--end::Svg Icon-->
											</span>Add Fees</a>
											<!--end::Button-->
										</div>
										<?php
											
										}
											?>
									</div>
									<div class="card-body">
										<!--begin: Datatable-->
										<form  method="post">
										<table class="table table-separate table-head-custom table-checkable" id="feeslist">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Fees(&#x20b9)</th>
													<th>Fees Type</th>
													<th>City</th>
													<th width="13%">Service</th>
													<th>From Time : To Time</th>
													<th>Status</th>
													<?php
													if($all_permission[5][edit_permission] == 1 || $all_permission[5][delete_permission] == 1) {
								
													?>
													<th>Actions</th>
													<?php
												}
												?>
												</tr>
											</thead>
											<tbody>
												<form method="post">
												<?php 
												$i = 1;	
												foreach($manage_fees as $fees){ 
													
													?>
												<tr>
													<td><?php echo $fees['fees_id'] ?></td>
													<td><?php echo $fees['fees_name'] ?></td>
													<td><?php echo $fees['fees_type_name']; ?></td>
													<td><?php echo $fees['city']; ?></td>
													<td><?php echo $fees['user_type_name']; ?></td>
													<td><?php echo $fees['from_time']." : ".$fees['to_time']; ?></td>
													<td><?php if($fees['fees_status'] == 0) { echo "Inactive"; } if($fees['fees_status'] == 1) { echo "Active"; } ?></td>
													<td nowrap="nowrap">
													<?php
													if($all_permission[5][edit_permission] == 1) {
													?>
														<button formaction="<?php echo base_url(); ?>editManageFees" name="btn_edit_manage_fees"value="<?php echo $fees['fees_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">	             
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
													if($all_permission[5][delete_permission] == 1) {
								
													?>


														<a href="#" class="btn btn-sm btn-clean btn-icon mr-2 btn-delete" data-id="<?php echo $fees['fees_id'];  ?>"> <i class="flaticon-delete"></i></a>
														<!-- </a> -->
														<?php
													}
														?>
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
<form action="<?php echo base_url(); ?>deleteManageFees" method="post">
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Fees</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             
               <h4>Are you sure want to delete this Fees?</h4>
             
            </div>
            <div class="modal-footer">
                <input type="hidden"  name="btn_delete_manage_fees" class="feesID">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-primary">Yes</button>
            </div>
            </div>
        </div>
        </div>
</form>
<script>
    $(document).ready(function(){
 
        // get Edit Product
       
 
        // get Delete Product
        $('.btn-delete').on('click',function(){
            // get data from button edit
            const id = $(this).data('id');

            // Set data to Form Edit
            $('.feesID').val(id);
            // Call Modal Edit
            $('#deleteModal').modal('show');
        });
         
    });
</script>
<script type="text/javascript">
                         	
	$(document).ready( function () {
    //$('#myTable').DataTable();

    $('#feeslist').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : true
    })
} );

</script>