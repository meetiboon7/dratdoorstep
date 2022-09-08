<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Booking History</h5>
									<!--end::Page Title-->
								</div>
								<!--end::Info-->
							</div>
						</div>
		<!--begin::Entry-->
		<div class="d-flex flex-column-fluid">
			<!--begin::Container-->

			<div class="container">

				<!-- Pharmacy Details -->
				<div class="card card-custom">
					<div class="card card-custom">
											<div class="card-header card-header-tabs-line">
												<div class="card-title">
													<h3 class="card-label">Appointment History</h3>
												</div>
												<div class="card-toolbar">
													<ul class="nav nav-tabs nav-bold nav-tabs-line tabs">
														<li class="nav-item" >
															<a class="nav-link active" name="id" href="#kt_tab_pane_2_3" id='1'  data-toggle="tab">
																<span class="nav-icon">
																	<img src="<?php echo base_url()?>uploads/image/doctor.svg" width="18px" height="18px" fill="#000"; />
																</span>
																<span class="nav-text">Doctor</span>
															</a>
														</li>
														<li class="nav-item" >
															<a class="nav-link" id="2" name="id" href="#kt_tab_pane_2_3"  data-toggle="tab">
																<span class="nav-icon">
																	<img src="<?php echo base_url()?>uploads/image/nurse.svg" width="24px" height="24px" fill="#000"; />
																</span>
																<span class="nav-text">Nurse</span>
															</a>
														</li>
														<li class="nav-item">
															<a class="nav-link" id="3" name="id" data-toggle="tab" href="#kt_tab_pane_2_3">
																<span class="nav-icon">
																	<img src="<?php echo base_url()?>uploads/image/lab.svg" width="24px" height="24px" fill="#000"; />
																</span>
																<span class="nav-text">Lab Test</span>
															</a>
														</li>
														<li class="nav-item">
															<a class="nav-link" id="4" name="id" data-toggle="tab" href="#kt_tab_pane_2_3">
																<span class="nav-icon">
																	<img src="<?php echo base_url()?>uploads/image/drug.svg" width="24px" height="24px" fill="#000"; /> 
																</span>
																<span class="nav-text">E-Pharmacy</span>
															</a>
														</li>
														<li class="nav-item">
															<a class="nav-link" id="5" name="id" data-toggle="tab" href="#kt_tab_pane_2_3">
																<span class="nav-icon">
																	<img src="<?php echo base_url()?>uploads/image/ambulance.svg" width="24px" height="24px" fill="#000"; />
																</span>
																<span class="nav-text">Ambulance</span>
															</a>
														</li>
														
													</ul>
												</div>
											</div>
											<div class="card-body tab_content">
												<div class="tab-content ">
													<!--begin::Table-->
													<div class="table-responsive">
														<form method="post">
														<table class="table table-head-custom table-head-bg table-borderless table-vertical-center" id="kt_datatable">
															<thead>
																<tr class="text-left text-uppercase">
																	<th style="min-width: 100px"  class="pl-7"><span class="text-dark-75">Service</span></th>
																	<th style="min-width: 100px">
																		<span class="text-dark-75">Patient</span>
																	</th>
																	<th style="min-width: 100px"><span class="text-dark-75">Address</span></th>
																	<th style="min-width: 100px"><span class="text-dark-75">Date</span></th>
																	<th style="min-width: 100px"><span class="text-dark-75">Time</span></th>
																	<!-- <th style="min-width: 100px"><span class="text-dark-75">Report</span></th> -->
																	<th style="min-width: 100px"><span class="text-dark-75">Receipt</span></th>
																	<th style="min-width: 100px"><span class="text-dark-75">Cancel Appointment</span></th>
																	<th style="min-width: 100px"><span class="text-dark-75">Status</span></th>
																	<th style="min-width: 100px"><span class="text-dark-75">Action</span></th>
																	
																</tr>
															</thead>
															<tbody>
																<?php

												foreach($appointment_book as $appointment){ 
													// echo "<pre>";
													// print_r($appointment);
													// echo "</pre>";
													//echo $appointment['appointment_book_id']
													?>
																<tr>
																	<td >
																			
																			<div class="symbol symbol-50 symbol-light mr-4">
																				<span class="symbol-label">
																					<?php
																					if($appointment['appointment_book_id']!='')
																					{
																						?>
																						<img src="<?php echo base_url()?>uploads/image/doctor.svg" class="h-75 align-self-end" /> 
																						<?php
																					}
																					
																					?>
																					
																				</span>
																			</div>
																			
																		
																	</td>
																	<td class="pl-0 py-8">
																		<div class="d-flex">
																			
																			<div>
																				<a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"><?php echo $appointment['name']?></a>
																				<span class="text-muted font-weight-bold d-block"><?php echo $appointment['contact_no']?></span>
																			</div>
																		</div>
																	</td>
																	<td>
																		<span class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"><?php echo $appointment['address_1']." ".$appointment['address_2']?></span>
																		
																	</td>
																	<td>
																		<span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo date("d-m-Y",strtotime($appointment['date'])); ?></span>
																		
																	</td>
																	<td>
																		<span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $appointment['time']?></span>
																		
																	</td>
																	<!-- <td>
																		<form method="post" action="view_report.php">
																			<input type="hidden" name="case" value="<?php echo $case;?>" / >
																			<input type="submit" value="Report"/>
																	    </form>
																   </td> -->
																	<td>
																		<?php
																		if($appointment['responsestatus']=='TXN_SUCCESS'){
																						?>
																		<button formaction="<?php echo base_url(); ?>invoice" name="appointment_book_id" value="<?php echo $appointment['appointment_book_id']; ?>"  class="btn btn-secondary" title="View Receipt">

																		Receipt

																		</button>
																		<?php
																		}
																		else{
																			echo "<font color='Red'>No Data Available</font>";
																		}
																	?>
																	</td>
																	<td>

																		
																		<?php

																				
																				date_default_timezone_set('Asia/Kolkata');
																				        $script_tz = date_default_timezone_get();
																				        $cur       = date('Y-m-d');
																				 // $cancel = strtotime($cancel);
																				 //   $new = strtotime($cur);
																				 //   echo $new;
																				   $cancel = $appointment['date']; 
																				   $new = date("Y-m-d",strtotime($cur)); 
																				    // echo $cancel."<br>";
																				    // echo $new;
																				   // exit;
																				if($new < $cancel)
																				{

																					if($appointment['confirm']==1)
																					{
																						if($appointment['responsestatus']=='TXN_SUCCESS'){
																						?>
																						 <button formaction="<?php echo base_url(); ?>cancle" name="appointment_book_id" value="<?php echo $appointment['appointment_book_id']; ?>"  class="btn btn-danger" title="Cancel Appointment">

																						Cancel

																						</button>
																						<?php 
																								}
																								else
																								{
																									?>
																									Not Allowed
																									<?php

																								}
																								?>
																						<?php
																					}
																					else
																					{
																						?>
																						 Not allowed
																					<?php }
																					
																				 ?>

																				
																				<?php 
																				}
																				else
																				{ 
																					?>
																				         Not allowed
																				<?php 
																			    } 
																			    ?>

																	</td>
																	<td>
																	 <?php 
																	 	//echo $appointment['confirm'];
																	 	//echo $appointment['cancel'];

																	 //cancle time respose status allso update work left
																					if($appointment['responsestatus']=="TXN_SUCCESS")
																					{
																						?>
																						
																						<span class="label label-inline label-light-success font-weight-bold">Success</span>
																						<?php
																					}
																					else if ($appointment['responsestatus']=="TXN_CANCELLED") 
																					{
																						?>
																						<span class="label label-inline label-light-danger font-weight-bold">Cancelled</span>
																					<?php
																				    }
																				    else if ($appointment['responsestatus']=="TXN_PENDING") 
																					{
																						?>
																						<span class="label label-inline" style="background:orange;">Pending</span>
																					<?php
																				    }
																					else
																					{
																						?>
																						<span class="label label-inline label-light-danger font-weight-bold">Failure</span>
																						<?php
																					}

																				 ?>
																				</td>
																	<td nowrap="nowrap">
																		
																		<button formaction="<?php echo base_url(); ?>viewBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['appointment_book_id']; ?>,<?php echo "1";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		<i class="fa fa-eye" aria-hidden="true"></i>

																		</button>
																		<?php
																		$date=date('Y-m-d');
																		if( $appointment['date'] > $date){
																			if($appointment['responsestatus']!="TXN_FAILURE" && $appointment['responsestatus']!="TXN_CANCELLED" && $appointment['responsestatus']!=""){
																		?>
																		<button formaction="<?php echo base_url(); ?>editBookDoctorAppointment" name="btn_edit_appointment" 
															value="<?php echo $appointment['appointment_book_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Edit Appointment">	             
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
													}
													?>
														
																	</td>
																	
																	
																</tr>
																<?php
															}
															?>
																
															</tbody>
														</table>
													</form>
													</div>
													
													<!--end::Table-->
												</div>
											</div>
											<div class="display_list_appointment"></div>
										</div>
				</div>
				<!-- End of Pharmacy Details -->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Entry-->
	</div>
<!--end::Content-->
<script>
    $(document).ready(function(){
 
        // get Edit Product
       
 
        // get Delete Product
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

$(document).ready(function() {
//https://codepen.io/cssjockey/pen/jGzuK
    //When page loads...
    $(".tab_content").hide(); //Hide all content
    $("ul.tabs li:first").addClass("active").show(); //Activate first tab
    $(".tab_content:first").show(); //Show first tab content

    //On Click Event
    $("ul.tabs li").click(function() {
//alert("test");
        $("ul.tabs li").removeClass("active"); //Remove any "active" class
        $(this).addClass("active"); //Add "active" class to selected tab
      $(".tab_content").hide(); //Hide all tab content

       var activeTab = $(this).find("a").attr("href");
        var id = $(this).find("a").attr("id");
        //alert(id);
        //alert(id);
         //Find the href attribute value to identify the active tab + content
        //var idAttr = $(this).attr('id');
      // alert(activeTab);
        if(id != '') {
        	//alert("test");
          $.ajax({
           type: "POST",
            url: "<?php echo base_url('allBookingHistory'); ?>",
            data: {id:id},
            dataType: "HTML",
            success: function(html) {
            	// $(".tab_content").show();
            	//alert(html);
			$('.display_list_appointment').html(html);

          		// $(activeTab).html(response);
            }
          });
        }

     
    });

});

</script>

<script type="text/javascript">
                         	
	$(document).ready( function () {
    //$('#myTable').DataTable();

    $('#kt_datatable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : true
    })
} );

</script>

