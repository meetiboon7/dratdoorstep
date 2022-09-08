<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Voucher</h5>
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
											
										</div>
									</div>
									<div class="card-body">
										<!--begin: Datatable-->
										<table class="table table-separate table-head-custom table-checkable" id="wallettable">
										
											<thead>
												<tr>
													<th width="10%">Voucher Code</th>
													<th width="10%">Amount</th>
													<th width="10%">Service</th>
													<th width="10%">Package</th>
													<th width="10%">All</th>
													<th width="10%">From Date</th>
													<th width="10%">To Date</th>
													
													
												</tr>
											</thead>
											<tbody>
												<form method="post">
												<?php 
												
												foreach($voucher_list as $voucher){ 
													
													?>
												<tr>
													<td><?php echo $voucher['code']; ?></td>
													<td><?php echo $voucher['amount']; ?></td>
													<td><?php echo $voucher['user_type_name']; ?></td>
													<td><?php echo $voucher['package_name']; ?></td>
													<td><?php if($voucher['all_service']==0){echo "-";}else{echo "Both";} ?></td>

													<td><?php echo date("d-m-Y",strtotime($voucher['from_date'])) ?></td>
													<td><?php echo $voucher['to_date'] ?></td>
													
													
													
													
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
<input type="hidden" name="INDUSTRY_TYPE_ID" value="Retail"/>
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