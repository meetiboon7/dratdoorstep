<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Wallet</h5>
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
										<!-- 	<h3 class="card-label">Address </h3> -->

											<span style="color:grey;"> <?php echo $this->session->flashdata('message'); ?> </span>
										</div>
										<div class="card-toolbar">
											<!--begin::Button-->
											<a href="#" class="btn btn-primary btn-add-model font-weight-bolder">
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
											</span>Add to Wallet</a>
											<!--end::Button-->
										</div>
									</div>
									<div class="card-body">
										<center>
										<img src="<?php echo base_url()?>uploads/image/wallet.jpeg"  width="75%" height="60%" />
									</center>
										<!--begin: Datatable-->
										<?php /*
										<table class="table table-separate table-head-custom table-checkable" id="wallettable">
										
											<thead>
												<tr>
													<th width="10%">Transaction Date</th>
													<th width="10%">Order Id</th>
													<th width="10%">Amount</th>
													<th width="10%">Status</th>
													
													
												</tr>
											</thead>
											<tbody>
												<form method="post">
												<?php 
												
												foreach($manage_wallet as $wallet){ 
													
													?>
												<tr>
													<td><?php echo $wallet['txndate'] ?></td>
													<td><?php echo $wallet['order_id'] ?></td>
													<td><?php echo $wallet['amt'] ?></td>
													<td><?php 
														if($wallet['responsestatus']=="TXN_SUCCESS")
														{
															?>
															
															<span class="label label-inline label-light-success font-weight-bold">Success</span>
															<?php
														}
														else
														{
															?>
															<span class="label label-inline label-light-danger font-weight-bold">Failure</span>
															<?php
														}

													 ?></td>
													
													
													
												</tr>
												<?php } ?>
											</tbody>
										</table>

									</form>
									<?php */?>
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

    $('#wallettable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : true
    })
} );

</script>
<script>
    $(document).ready(function(){
 
        // get Edit Product
       
 
        // get Delete Product
        $('.btn-add-model').on('click',function(){
            // get data from button edit
            //const id = $(this).data('id');

            // Set data to Form Edit
          //  $('.cityID').val(id);
            // Call Modal Edit
            $('#walletModal').modal('show');
        });
         
    });
</script>
<form action="<?php echo base_url(); ?>useraddWallet" method="post">
        <div class="modal fade" id="walletModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add to Wallet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             
               <div class="col-lg-12">
					<label>Amount *</label>
					<input type="text" class="form-control" name="amt" id="amt" value="" placeholder="Amount" onkeypress="return isNumberKey(event)"/>
					<div id="amt_valid" class="validation" style="display:none;color:red;">Please Enter Valeu between 1 to 10000</div>
					<!-- <div id="amt_valid_data" class="validation" style="display:none;color:red;">Minimum recharge of 50 Rs is necessary!</div> -->
				</div>
             
            </div>
            <div class="modal-footer">
              
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="btnSubmit">Pay</button>
            </div>
            </div>
        </div>
        </div>
        <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user')['user_id']; ?>"/>
<input type="hidden" name="REQUEST_TYPE" value="SEAMLESS"/>
<input type="hidden" name="ORDER_ID" value="<?php echo  "ORDS" . rand(10000,99999999)?>"/>
<input type="hidden" name="INDUSTRY_TYPE_ID" value="Retail109"/>
<input type="hidden" name="CHANNEL_ID" value="WEB"/>
</form>

<script type="text/javascript">
    $(function () {

        $("#btnSubmit").click(function () {
          
        	var amount= $("#amt").val() != '' ? parseFloat($("#amt").val()) : 0;
        	//alert(amount);

            if (amount == 0 || amount > 10000) {

            	
                
                $('#amt_valid').show();
        		
                return false;
            }
        	else
        	{
        		$('#amt_valid_data').hide();
        			
        			
        	}
            
           
			return true;

        });
    });
</script>
 <script type="text/javascript">
	function isNumberKey(evt) {
   var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
}
</script>