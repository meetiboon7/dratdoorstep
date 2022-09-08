				<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">City Master</h5>
									<!--end::Page Title-->
								</div>
								<!--end::Info-->
							</div>
						</div>
						<!--end::Subheader-->
						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
								<!--begin::Dashboard-->
								<div class="card card-custom nn_add-city">
									<div class="card-header flex-wrap py-5">
										<div class="card-title">
											<h3 class="card-label">Add City </h3>
											<span style="color:grey;"> <?php echo $this->session->flashdata('message'); ?> </span>
										</div>
									</div>
									<form class="form" action="<?php echo base_url();?>addCity" method="post">
										<div class="card-body">
											<div class="form-group row">
												<div class="col-lg-3">
													
													
													<label>City *</label>
													<input type="text" class="form-control" required  name="city" placeholder="Enter City Name" id="city"/>
													<div id="city_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
												</div>
												<div class="col-lg-3">
														<label>Status </label>
										<select class="form-control select2"  name="city_status"  id="kt_select2_3">
											<option value="1">Active</option>
											<option value="0">Inactive</option>
										</select>
										
									</div>
												<div class="col-lg-3">
													<br>
													<button type="submit" id="btnSubmit" class="btn btn-primary mr-2" style="margin: 5px 0 0 30px; ">Save</button>
												</div>
											</div>
												</div>
												
												
										
									</form>
								</div>
								<br>
									<div class="card card-custom nn_edit-city" style="display: none">
									<div class="card-header flex-wrap py-5">
										<div class="card-title">
											<h3 class="card-label">Edit City</h3>
											<span style="color:grey;"> <?php echo $this->session->flashdata('message'); ?> </span>
										</div>
									</div>
									<form class="form" action="<?php echo base_url();?>updateCity" method="post">
										<div class="card-body">
											<div class="form-group row">
												<div class="col-lg-3">
													<label>City *</label>
													<input type="text" class="form-control" name="city" value="" placeholder="Enter City Name" id="city_upt"/>
													<div id="city_upt_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
												</div>
												
												
												<div class="col-lg-3">
											<label>status</label>
											<select class="form-control select2 sel_act-inact" id="kt_select2_4" name="city_status" >
												
												<option value="1" <?php if($view_city->city_status == 1 ) { echo "selected"; } ?>>Active</option>
												<option value="0" <?php if($view_city->city_status == 0 ) { echo "selected"; } ?>>Inactive</option>
											</select>
										
										</div>
												
												<div class="col-lg-3">
													<br>
												
													<button type="submit" name="btn_update_city" value="<?php echo $view_city->city_id; ?>" id="btnSubmitupt" class="btn btn-primary mr-2 btn_update_city" >Update</button>
												</div>
											</div>
										</div>
									</form>
								</div> 
								<!--begin::Card--> 
								<!-- List Block -->
								<div class="card card-custom">
									<div class="card-header flex-wrap py-5">
										<div class="card-title">
											<h3 class="card-label">City List</h3>
										</div>
									</div>
									<div class="card-body">
										<!--begin: Datatable-->
										
										<!-- <table class="table table-separate table-head-custom table-checkable" id="kt_datatable"> -->
											<!-- <form method="post"> -->
											<table class="table table-separate table-head-custom table-foot-custom table-checkable" id="kt_datatable1" style="margin-top: 13px !important">
										
											<thead>
												<tr>
													<th>Sr No</th>
													<th>City Name</th>
													<th>Status</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php
												foreach($all_city as $city){ 


													
							?>
												<tr>
													<td><?php echo $city->city_id; ?></td>
														<td><?php echo $city->city; ?></td>
														
														<td><?php

														if($city->city_status=="1")
														{

														 echo "Active"; 
														}
														else
														{
															 echo "Inactive"; 
														}


														 ?></td>
														
													<!-- <td>West Zone</td> -->
													<!-- <td>Inactive</td> -->
													<td nowrap="nowrap">
														<button name="btn_edit_city" type="button"  value="<?php echo $city->city_id; ?>"  class="btn btn-sm btn-clean btn-icon mr-2 editCity" title="Edit City">	
															
															

															<span class="svg-icon svg-icon-md">
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">	
																	    <rect x="0" y="0" width="24" height="24"></rect>
																	        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
																	        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1">
																	    </rect>
																	</g>
																</svg>
															</span>
														</button>
														<!-- <button formaction="<?php echo base_url(); ?>deleteCity" name="btn_delete_city" 
															value="<?php echo $city->city_id;?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Delete City"> -->
															<!-- <button formaction="<?php echo base_url(); ?>deleteCity" name="btn_delete_city" value="<?php echo $city->city_id;  ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Delete City">	             
															<i class="flaticon-delete"></i>
														</button> -->
														<!-- <a href="#" data-href="<?php echo $city->city_id;  ?>" data-toggle="modal" data-target="#confirm-delete">Delete record #23</a> -->
														<a href="#" class="btn btn-sm btn-clean btn-icon mr-2 btn-delete" data-id="<?php echo $city->city_id;?>"> <i class="flaticon-delete"></i></a>



														
														<!-- </a> -->
													</td>
												</tr>
												<?php
											}
											?>
											</tbody>
										</table>
									<!-- </form> -->
										<!--end: Datatable-->
										
									</div>
								</div>
								<!--End List Block -->
								<!--end::Card-->
								<!--end::Dashboard-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					<!--end::Content-->

					<!-- <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                ...
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div> -->
  <form action="<?php echo base_url(); ?>deleteCity" method="post">
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete City</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             
               <h4>Are you sure want to delete this City?</h4>
             
            </div>
            <div class="modal-footer">
                <input type="hidden"  name="btn_delete_city" class="cityID">
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
            $('.cityID').val(id);
            // Call Modal Edit
            $('#deleteModal').modal('show');
        });
         
    });
</script>
<script type="text/javascript">
    $(function () {

        $("#btnSubmit").click(function () {
          

            if ($("#city").val()=='') {
                
                $('#city_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#city_valid').hide();
            }

           
			return true;

        });
    });
</script>
<script type="text/javascript">
    $(function () {

        $("#btnSubmitupt").click(function () {
          
        
            if ($("#city_upt").val()=='') {
                
                $('#city_upt_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#city_upt_valid').hide();
            }

           
			return true;

        });
    });
</script>
