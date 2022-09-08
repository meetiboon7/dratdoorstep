<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Manage Role Master</h5>
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
								<div class="card card-custom nn_add-role">
									<div class="card-header flex-wrap py-5">
										<div class="card-title">
											<h3 class="card-label">Add Role</h3>
											<span style="color:grey;"> <?php echo $this->session->flashdata('message'); ?> </span>
										</div>
									</div>
									<form class="form" action="<?php echo base_url();?>addRole" method="post">
										<div class="card-body">
											<div class="form-group row">
												
												
												
												<div class="col-lg-4">
													<label>Role Name *</label>
													<input type="text" class="form-control" name="role_name" placeholder="Enter name" id="role_name"/>
													<div id="role_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
												</div>
												<div class="col-lg-4">
														<label>Status </label>
														<select class="form-control select2"  name="role_status"  id="kt_select2_3">
															<option value="1">Active</option>
															<option value="0">Inactive</option>
														</select>
												</div>
												<div class="col-lg-2">
													<br>
													<button type="submit" id="btnSubmit" class="btn btn-primary mr-2" style="margin: 5px 0 0 30px; ">Save</button>
												</div>
											</div>
										</div>
									</form>
								</div>
								<br>
									<div class="card card-custom nn_edit-role" style="display: none">
									<div class="card-header flex-wrap py-5">
										<div class="card-title">
											<h3 class="card-label">Edit Role</h3>
											<span style="color:grey;"> <?php echo $this->session->flashdata('message'); ?> </span>
										</div>
									</div>
									<form class="form" action="<?php echo base_url();?>updateRole" method="post">
										<div class="card-body">
											<div class="form-group row">
												
											
												<div class="col-lg-4">
													<label>Role Name *</label>
													<input type="text" class="form-control" id="role_name_upt" name="role_name" placeholder="Enter name"/>
													<div id="role_valid_upt" class="validation" style="display:none;color:red;">Please Enter Value</div>
												</div>
												
												<div class="col-lg-4">
													<label>status</label>
													<select class="form-control select2 sel_act-inact" id="kt_select2_6" name="role_status" >
														
														<option value="1" <?php if($view_managerole->role_status == 1 ) { echo "selected"; } ?>>Active</option>
														<option value="0" <?php if($view_managerole->role_status == 0 ) { echo "selected"; } ?>>Inactive</option>
													</select>
										
												</div>
												
												<div class="col-lg-2">
														<br>
													
														<button type="submit" name="btn_update_managerole" value="<?php echo $view_zone->zone_id; ?>" id="btnSubmitupt" class="btn btn-primary mr-2 btn_update_managerole" >Update</button>
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
											<h3 class="card-label">Role List</h3>
										</div>
									</div>
									<div class="card-body">
										<!--begin: Datatable-->
										<form method="post">
										<table class="table table-separate table-head-custom table-checkable dataTable no-footer" id="kt_datatable">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Role Name</th>
													<th>Status</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php
												foreach($all_roles as $role){ 
											?>
												<tr>
													<td><?php echo $role->role_id; ?></td>
													<td><?php echo $role->role_name; ?></td>
														<td><?php

														if($role->role_status=="1")
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
														<button name="btn_edit_managerole" type="button"  value="<?php echo $role->role_id; ?>"  class="btn btn-sm btn-clean btn-icon mr-2 editmanagerole" title="Edit Zone">	
															
															

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
														<!-- <button formaction="<?php echo base_url(); ?>deleteRole" name="btn_delete_managerole" value="<?php echo $role->role_id;  ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Delete Role">	             
															<i class="flaticon-delete"></i>
														</button> -->
														<a href="#" class="btn btn-sm btn-clean btn-icon mr-2 btn-delete" data-id="<?php echo $role->role_id;?>"> <i class="flaticon-delete"></i></a>
														
														<!-- </a> -->
													</td>
												</tr>
												<?php
											}
											?>
											</tbody>
										</table>
										<!--end: Datatable-->
										</form>
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
<form action="<?php echo base_url(); ?>deleteRole" method="post">
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             
               <h4>Are you sure want to delete this Role?</h4>
             
            </div>
            <div class="modal-footer">
                <input type="hidden"  name="btn_delete_managerole" class="roleID">
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
            $('.roleID').val(id);
            // Call Modal Edit
            $('#deleteModal').modal('show');
        });
         
    });
</script>
<script type="text/javascript">
    $(function () {

        $("#btnSubmit").click(function () {
          

            if ($("#role_name").val()=='') {
                
                $('#role_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#role_valid').hide();
            }

           
			return true;

        });
    });
</script>
<script type="text/javascript">
    $(function () {

        $("#btnSubmitupt").click(function () {
          
        
            if ($("#role_name_upt").val()=='') {
                
                $('#role_valid_upt').show();
        		
                return false;
            }
            else
            {
            	 $('#role_valid_upt').hide();
            }

           
			return true;

        });
    });
</script>
