<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Manage Voucher</h5>
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
										// echo "<pre>";
										// print_r($all_permission);
										// echo "</pre>";
										if($all_permission[12][add_permission] == 1) {
								
										?>
										<div class="card-toolbar">
											<!--begin::Button-->
											<a href="<?php echo base_url();?>addVoucher" class="btn btn-primary font-weight-bolder">
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
											</span>Add Voucher</a>
											<!--end::Button-->
										</div>
										<?php
											
										}
											?>
									</div>
									<div class="card-body">
			<form method="post" action="<?php echo base_url(); ?>voucherSearch">
         <div class="row">
              

         	<?php
         		$yearstart = date('Y-m-d', strtotime('01/01'));
				$yearEnd = date('Y-m-d', strtotime('12/31'));
         	?>

              <div class="col-lg-3">
                  <label>From Date *</label>
                 <input type="date" class="form-control" placeholder="DD/MM/YY" name="from_date" id="from_date" value="<?php echo $yearstart;?>" />
                 <span id="from_valid_id" style="display: none;color:red">Please Select From Date</span>
              </div>
              <div class="col-lg-3">
                  <label>To Date *</label>
                 <input type="date" class="form-control" placeholder="DD/MM/YY" name="to_date" id="to_date"  value="<?php echo $yearEnd;?>"/>
                 <span id="to_valid_id" style="display: none;color:red">Please Select To Date *</span>
              </div>
               
              <div class="col-lg-3" style="padding-top: 25px;">
                      <button type="submit" class="btn btn-primary mr-2" name="search" id="btnSubmit">Search</button>
                      <a href="<?php echo base_url(); ?>adminVoucher" class="btn btn-secondary">Reset</a>
                    </div>
             
             </div>
             
             <!-- <div class="row"> -->
                      
                   <!--  </div> -->
                 
                  
          </form>
          <br>
										<!--begin: Datatable-->
										<form  method="post">
										<table class="table table-separate table-head-custom table-checkable" id="voucherlist">
											<thead>
												<tr>
													<!-- <th>Sr No</th> -->
													<th>Title</th>
													<th>Code</th>
													<th>Amount</th>
													<th>From Date</th>
													<th>To Date</th>
													<th>Visibility</th>
													<!-- <th>Type</th> -->
													<?php
													if($all_permission[12][edit_permission] == 1 || $all_permission[12][delete_permission] == 1) {
								
													?>
													<th>Actions</th>
													<?php
												}
												?>
												</tr>
											</thead>
											<tbody>
												
												<?php 
												$i = 1;	
												foreach($voucher as $vouchers){ 
													
													?>
												<tr>
													<td><?php echo $vouchers['title'] ?></td>
													<td><?php echo $vouchers['code']; ?></td>
													<td><?php echo $vouchers['amount']; ?></td>
													<td><?php echo date("d-m-Y",strtotime($vouchers['from_date'])); ?></td>
													<td><?php echo date("d-m-Y",strtotime($vouchers['to_date'])); ?></td>
												    <td><?php 
												    if($vouchers['visi_and_invisi']=="1")
												    {
												        echo "Visible ";
												    }
												    else
												    {
												         echo "InVisible ";
												    }
												    
												    
												    
												    ?></td>
													<!-- <td><?php echo $vouchers['type']; ?></td> -->
													
													<td nowrap="nowrap">
													<?php
													if($all_permission[12][edit_permission] == 1) {
													?>
														<button formaction="<?php echo base_url(); ?>editVoucher" name="btn_edit_voucher" value="<?php echo $vouchers['voucher_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">	             
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
													if($all_permission[12][delete_permission] == 1) {
								
													?>
														<a href="#" class="btn btn-sm btn-clean btn-icon mr-2 btn-delete" data-id="<?php echo $vouchers['voucher_id'];  ?>"> <i class="flaticon-delete"></i></a>
														<?php
													}
														?>
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
<form action="<?php echo base_url(); ?>deleteVoucher" method="post">
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Voucher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             
               <h4>Are you sure want to delete this Voucher?</h4>
             
            </div>
            <div class="modal-footer">
                <input type="hidden"  name="btn_delete_voucher" class="voucherID">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-primary">Yes</button>
            </div>
            </div>
        </div>
        </div>
</form>
<script type="text/javascript">
document.getElementById('from_date').value ="<?php 
if(!$_POST['from_date']):?>"from_date"<?php  
  else:  echo $_POST['from_date']; endif;?>";
</script>
<script type="text/javascript">
document.getElementById('to_date').value ="<?php 
if(!$_POST['to_date']):?>"to_date"<?php  
  else:  echo $_POST['to_date']; endif;?>";
</script>

<script>
    $(document).ready(function(){
 
        // get Edit Product
       
 
        // get Delete Product
        $('.btn-delete').on('click',function(){
            // get data from button edit
            const id = $(this).data('id');

            // Set data to Form Edit
            $('.voucherID').val(id);
            // Call Modal Edit
            $('#deleteModal').modal('show');
        });
         
    });
</script>
<script type="text/javascript">
                            
    $(document).ready( function () {
    //$('#myTable').DataTable();

    $('#voucherlist').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : true
    })
} );

</script>