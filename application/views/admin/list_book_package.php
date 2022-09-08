<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">My Book Package</h5>
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
									<!-- <div class="card-header flex-wrap py-5">
										<div class="card-title">
											

											<span style="color:grey;"> <?php echo $this->session->flashdata('message'); ?> </span>
										</div>
										
										
										
									</div> -->

									<div class="card-body">
										<!--begin: Datatable-->
										<form method="post">
										<table class="table table-separate table-head-custom table-checkable" id="listpackage_datatable">
											<thead>
												<tr>
													<th>Patient Name</th>
													<th>Package Name</th>
													<th>Purchase Date</th>
													<th>Amount</th>
													<th>Generate Invoice</th>
													
													
												</tr>
											</thead>
											<tbody>
												
												<?php 
												$i = 1;	
												foreach($manage_package as $package){ 

													?>
												<tr>

													<td><?php echo $package['name'].$package['member_id']; ?></td>
													<td><?php echo $package['package_name']; ?></td>
													<td><?php echo date("d-m-Y",strtotime($package['purchase_date'])); ?></td>
													<td><?php echo $package['total']; ?></td>
													<td>
													    <!--Reciept Start-->
													     <button  formaction="<?php echo base_url(); ?>adminPackageRecipt" name="book_package_id" 
													      value="<?php echo $package['id']; ?>"  class="btn btn-secondary" title="View Invoice">Receipt
													      </button>
													      <!--Reciept End -->
													      
													      <!--View Package-->
													      <button formaction="<?php echo base_url(); ?>view_package" name="btn_view_mypackage" value="<?php echo $package['id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

														    <i class="fa fa-eye" aria-hidden="true"></i>

														  </button>
														  <!--View Package End-->
														  
														  <!--Assing Edit Package-->
														  <?php
														   if($package['id']!='' && $package['responsestatus']!="TXN_FAILURE" && $package['responsestatus']!="TXN_CANCELLED" && $package['responsestatus']!="")
														   {	   	
														?>
														<a href="#" class="btn btn-sm btn-clean btn-icon mr-2 btn-assign" data-id="<?php echo $package['id'];?>,<?php echo "1";?>" title="Assign" >

																			<span class="svg-icon svg-icon-primary svg-icon-2x">
																				<!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-12-28-020759/theme/html/demo1/dist/../src/media/svg/icons/Communication/Share.svg-->
																				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																						<rect x="0" y="0" width="24" height="24"/>
																						<path d="M10.9,2 C11.4522847,2 11.9,2.44771525 11.9,3 C11.9,3.55228475 11.4522847,4 10.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,16 C20,15.4477153 20.4477153,15 21,15 C21.5522847,15 22,15.4477153 22,16 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L10.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
																						<path d="M24.0690576,13.8973499 C24.0690576,13.1346331 24.2324969,10.1246259 21.8580869,7.73659596 C20.2600137,6.12944276 17.8683518,5.85068794 15.0081639,5.72356847 L15.0081639,1.83791555 C15.0081639,1.42370199 14.6723775,1.08791555 14.2581639,1.08791555 C14.0718537,1.08791555 13.892213,1.15726043 13.7542266,1.28244533 L7.24606818,7.18681951 C6.93929045,7.46513642 6.9162184,7.93944934 7.1945353,8.24622707 C7.20914339,8.26232899 7.22444472,8.27778811 7.24039592,8.29256062 L13.7485543,14.3198102 C14.0524605,14.6012598 14.5269852,14.5830551 14.8084348,14.2791489 C14.9368329,14.140506 15.0081639,13.9585047 15.0081639,13.7695393 L15.0081639,9.90761477 C16.8241562,9.95755456 18.1177196,10.0730665 19.2929978,10.4469645 C20.9778605,10.9829796 22.2816185,12.4994368 23.2042718,14.996336 L23.2043032,14.9963244 C23.313119,15.2908036 23.5938372,15.4863432 23.9077781,15.4863432 L24.0735976,15.4863432 C24.0735976,15.0278051 24.0690576,14.3014082 24.0690576,13.8973499 Z" fill="#000000" fill-rule="nonzero" transform="translate(15.536799, 8.287129) scale(-1, 1) translate(-15.536799, -8.287129) "/>
																					</g>
																				</svg>
																				<!--end::Svg Icon-->
																			</span></a>
												<!--					<button  formaction="<?php echo base_url(); ?>edit_book_package" name="btn_edit_package" -->
												<!--				value="<?php echo $package['book_package_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Edit Appointment" >	             -->
												<!--				<span class="svg-icon svg-icon-md">-->
												<!--					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">-->
												<!--						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">	-->
												<!--							<rect x="0" y="0" width="24" height="24"></rect>	-->
												<!--							<path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>-->
												<!--							<rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>-->
												<!--						</g>-->
												<!--					</svg>-->
												<!--				</span>-->
												<!--</button>-->
														<?php
														   }
														?>
														
														<!--End Assign Package-->
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


<script>
	$(document).ready(function(){
		$('.btn-assign').on('click',function(){
            // get data from button edit
            const id = $(this).data('id');
            // Set data to Form Edit
            $('.appointmentID').val(id);
            // Call Modal Edit
            $('#assignModel').modal('show');
          });

	});
</script>
<script type="text/javascript">
                         	
	$(document).ready( function () {
    //$('#myTable').DataTable();

    $('#listpackage_datatable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : true
    })
} );

</script>
<form action="<?php echo base_url(); ?>assingPackageAppointment" method="post">
	<div class="modal fade" id="assignModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Assign</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							<div id="inline_content">
								<div class="radio-inline">
									<div class="col-md-6">
										<label class="radio radio-success">
											<input type="radio" name="assign_radio" class="form-control" value="Team" /><span></span>
											Team
										</label>
									</div>
									<div class="col-md-6">
										<label class="radio radio-success">
											<input type="radio" name="assign_radio"  class="form-control" value="Employee" /><span></span>
											Employee
										</label>
									</div>
								</div>
							</div>
							<div id="radio_assign_valid" class="validation" style="display:none;color:red;">Please Select Value</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-lg-12" id="team_dropdown" style="display: none";>
							<b><label>Team *</label></b>
							<select class="form-control select2 team_valid" id="kt_select2_17" name="team_id"  data-placeholder="Select Team" style="width:420">
								<option value="none" selected disabled hidden> Select Team </option>
								<?php 
								foreach($manage_team_assign as $mta){
									echo '<option value="'.$mta['team_id'].'">'.$mta['team_name'].'</option>';
								}
								?>
							</select>
							<div id="team_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
						</div>
						<div class="col-lg-12" id="employee_dropdown" style="display: none"; >
							<b><label>Employee *</label></b>

							<select class="form-control select2 employee_valid" id="kt_select2_13" name="employee_id"  data-placeholder="Select Employee" style="width:420">
								<option value="none" selected disabled hidden> Select Employee </option>

								<?php 

								echo "<pre>";
								print_r($manage_employee_assign);

								foreach($manage_employee_assign as $mea){
									echo '<option value="'.$mea['emp_id'].'">('.$mea['user_type_name'].") ".$mea['first_name']." ".$mea['last_name']." (".$mea['mobile_no'].')</option>';
								}

							//exit;
								?>
							</select>
							<div id="employee_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>

						</div>
					</div>


				</div>
				<div class="modal-footer">
					<input type="hidden"  name="btn_appointment_assign" class="appointmentID">
              	  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              	  <button type="submit" class="btn btn-primary" id="btnSubmit">Assign</button>
              	</div>
              </div>
            </div>
          </div>

        </form>
 <script type="text/javascript">
        	$("#inline_content input[name=assign_radio]").click(function(){

		//alert($('input:radio[name=serivce_radio]:checked').val());

		if($('input:radio[name=assign_radio]:checked').val() == "Team"){

			$("#employee_dropdown").hide();
			$("#team_dropdown").show();

			$('.select2-search__field').css({'width': 420});
			$('.select2-selection__rendered').css({'width': 420});
    	 // $('#kt_select2_17').empty();
    	 $('#kt_select2_17').selectmenu('refresh');




    	}
    	else if($('input:radio[name=assign_radio]:checked').val() == "Employee")
    	{
    	//alert("fs");
    	$("#team_dropdown").hide();
    	$("#employee_dropdown").show();
    	$('.select2-search__field').css({'width': 400});
    	$('.select2-selection__rendered').css({'width': 420});
    	//  $('#kt_select2_13').empty();
    	$('#kt_select2_13').selectmenu('refresh');

    }

  });
</script>
<script type="text/javascript">

	$(document).ready(function() {

    $(".tab_content").hide(); 
    $("ul.tabs li:first").addClass("active").show(); 
    $(".tab_content:first").show();

  
    $("ul.tabs li").click(function() {
        $("ul.tabs li").removeClass("active");
        $(this).addClass("active");
      $(".tab_content").hide();

      var activeTab = $(this).find("a").attr("href");
      var id = $(this).find("a").attr("id");
    
      if(id != '') {
        	$.ajax({
        		type: "POST",
        		url: "<?php echo base_url('allAppointment'); ?>",
        		data: {id:id},
        		dataType: "HTML",
        		success: function(html) {
            	$('.display_list_appointment').html(html);
          	}
          });
        }


      });

  });

</script>
