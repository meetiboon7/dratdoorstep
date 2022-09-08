<?php
// echo "<pre>";
// print_r($all_city);
// echo "</pre>";
// exit;

?>
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Holiday Master</h5>
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
								 <?php
                                if($all_permission[6][add_permission] == 1) {
                                ?>
								<div class="card card-custom nn_add-holiday">
									<div class="card-header flex-wrap py-5">
										<div class="card-title">
											<h3 class="card-label">Add Holiday</h3>
											<span style="color:grey;"> <?php echo $this->session->flashdata('message'); ?> </span>
										</div>
									</div>
									<form class="form" action="<?php echo base_url();?>addHoliday" method="post">
										<div class="card-body">
											<div class="form-group row">
												<div class="col-lg-3">
													<label>City *</label>
													<select class="form-control select2 city_valid js-example-placeholder-multiple" name="city_id[]" multiple id="city_id" required="" >
														<option value="" disabled> Select City </option>
														   
														<?php
														foreach ($all_city as  $city_data) {
															?>
															<option value="<?php echo $city_data->city_id?>"><?php echo $city_data->city?></option>;
															<?php
															# code...
														}
														?>
														
										</select>	
										<div id="city_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
												</div>
												<div class="col-lg-3">
													<label>Date *</label>
													<input class="form-control hdate" type="date" required="" value="" name="hdate" id="example-date-input"/>
													<div id="hday_date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
												</div>
												<div class="col-lg-3">
													<label>Name *</label>
													<input type="text" class="form-control" name="hday" required="" placeholder="Enter name" id="hday"/>
													<div id="hday_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
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
								<?php
                                            
                                        }
                                            ?>
                                            
                                    <?php
                                
                                
                                    if($all_permission[6][edit_permission] == 1) {
                                ?>
									<div class="card card-custom nn_edit-holiday" style="display: none">
									<div class="card-header flex-wrap py-5">
										<div class="card-title">
											<h3 class="card-label">Edit Holiday</h3>
											<span style="color:grey;"> <?php echo $this->session->flashdata('message'); ?> </span>
										</div>
									</div>
									<form class="form" action="<?php echo base_url();?>updateHoliday" method="post">
										<div class="card-body">
											<div class="form-group row">
												<div class="col-lg-3">
													<label>City</label>

										<select class="form-control sel_act-holiday-city select2 js-example-placeholder-multiple" id="city" name="city_id[]" multiple required="">
											<option disabled=""> Select City </option>
											<?php
													foreach($all_city as $c){

														$s_selected = "";
														$holiday = explode(',',$view_holiday->city_id);
														
														if(in_array($c->city_id, $holiday) ){ $s_selected = "selected"; }
														echo '<option value="'.$c->city_id.'" '.$s_selected.'>'.$c->city.'</option>';
													}
												?>
											</select>	
												</div>
												<div class="col-lg-3">
													<label>Date</label>
													<input class="form-control hdate" type="date" value="" required="" name="hdate" id="example-date-input"/>
													<div id="hday_date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
												</div>
												<div class="col-lg-3">
													<label>Name</label>
													<input type="text" class="form-control" required="" name="hday" placeholder="Enter name"/>
													<div id="hday_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
												</div>
												
												<div class="col-lg-3">
													<br>
												
													<button type="submit"  id="btnSubmit"  name="btn_update_holiday" value="<?php echo $view_holiday->hid; ?>" class="btn btn-primary mr-2 btn_update_holiday" >Update</button>
												</div>
											</div>
										</div>
									</form>
								</div>
								<br>
								<?php
                                            
                                        }
                                            ?>
								<!--begin::Card-->
								<!-- List Block -->
								<div class="card card-custom">
									<div class="card-header flex-wrap py-5">
										<div class="card-title">
											<h3 class="card-label">Holiday List</h3>

										</div>
									</div>
									<div class="card-body">
										<!--begin: Datatable-->
										<form method="post">
										<table class="table table-separate table-head-custom table-checkable dataTable no-footer" id="kt_datatable">
											<thead>
												<tr>
													<th>Sr No</th>
													<th>Date</th>
													<th>Holiday</th>
													<th>Cities</th>
													 <?php
                                                    if($all_permission[6][edit_permission] == 1 || $all_permission[6][delete_permission] == 1) {
                                
                                                    ?>
													<th>Actions</th>
													 <?php
                                                }
                                                ?>
												</tr>
											</thead>
											<tbody>
												<?php
												foreach($all_holiday as $holiday){ 


													
							?>
												<tr>
													<td><?php echo $holiday->hid; ?></td>
														<td><?php echo date("d-m-Y",strtotime($holiday->hdate)); ?></td>
														<td><?php echo $holiday->hday; ?></td>
														<td><?php
														$ids=explode(',',$holiday->city_id);

														 foreach ($ids as $id) {

                                                            if($id!='')
                                                            {
                                                                $result=$this->db->query('select city from city where city_id='.$id)->row();
                                                                if($result)
                                                                {
                                                                    echo $result->city.", ";
                                                                    
                                                                    //echo mb_substr($string, 0, -1);
                                                                }
                                                                else
                                                                {
                                                                    echo "-";
                                                                }
                                                            }
                                                            else
                                                            {
                                                            	echo "-";
                                                            }
                                                          }


														 ?></td>
													<!-- <td>West Zone</td> -->
													<!-- <td>Inactive</td> -->
													<?php
                                                    if($all_permission[6][edit_permission] == 1 || $all_permission[6][delete_permission] == 1) {
                                
                                                    ?>
													<td nowrap="nowrap">
													<?php
                                
                                
                                                        if($all_permission[6][edit_permission] == 1) {
                                                        ?>
														<button name="btn_edit_holiday" type="button"  value="<?php echo $holiday->hid; ?>"  class="btn btn-sm btn-clean btn-icon mr-2 editHoliday" title="Edit Holiday">	
															
															

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
														<?php
                                            
                                        }
                                            ?>
                                            <?php
                                
                                
                                                        if($all_permission[6][delete_permission] == 1) {
                                                        ?>
														<a href="#" class="btn btn-sm btn-clean btn-icon mr-2 btn-delete" data-id="<?php echo $holiday->hid;?>"> <i class="flaticon-delete"></i></a>
														<?php
                                            }
                                            ?>
														<!-- </a> -->
													</td>
													 <?php
                                            }
                                            ?>
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
<form action="<?php echo base_url(); ?>deleteHoliday" method="post">
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Holiday</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             
               <h4>Are you sure want to delete this Holiday?</h4>
             
            </div>
            <div class="modal-footer">
                <input type="hidden"  name="btn_delete_holiday" class="holidayID">
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
            $('.holidayID').val(id);
            // Call Modal Edit
            $('#deleteModal').modal('show');
        });
         
    });
</script>
<script type="text/javascript">
    $(function () {

        $("#btnSubmit").click(function () {

        	var city_valid = $(".city_valid");
        	//alert(city_valid);

        	 if (city_valid.val() == '') {
                
                $('#city_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#city_valid_id').hide();
            }
            
            if ($(".hdate").val()=='') {
                
                $('#hday_date_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#hday_date_valid').hide();
            }

            if ($("#hday").val()=='') {
                
                $('#hday_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#hday_valid').hide();
            }


            
			return true;

        });
    });
</script>

					