<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Member List</h5>
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
									
									<div class="card-body">
										<!--begin: Datatable-->
									<form method="post">
										<table class="table table-separate table-head-custom table-checkable" id="complain_datatable">
											<thead>
												<tr>
													<th width="10%">Mobile</th>
													<th width="10%">Name</th>
													<th width="35%">Edit</th>
													
													
												</tr>
											</thead>
											<tbody>
											
												<?php 
												
												foreach($member as $m){ 


                          						$user_id=$m['user_id'];
												

												$this->db->select('mobile');
											   	$this->db->from('user');
											   	$this->db->where('user.user_id',$user_id);
											   //	$this->db->order_by('member.member_id', 'DESC');
												$user_no = $this->db->get()->row_array();
												
													
													?>
												<tr>
													<td><?php echo $user_no['mobile'] ?></td>
													<td><?php echo $m['name']; ?></td>
													<td><button formaction="<?php echo base_url(); ?>adminEditMember" name="btn_edit_member"value="<?php echo $m['member_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">	             
															<span class="svg-icon svg-icon-md">
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">	
																	    <rect x="0" y="0" width="24" height="24"></rect>	
																	        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
																	        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
																	</g>
																</svg>
															</span>
														</button></td>
													
													
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
