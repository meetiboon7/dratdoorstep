<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">View MY Package</h5>
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
					<div class="row">
					
						<div class="col-xl-6">
                			<div class="card card-custom">
                				<div class="card-body p-0">
						
								<form class="form"  id="add_view_package_form" action="<?php echo base_url(); ?>updatePackageBook" method="post" enctype="multipart/form-data">
								<!-- <div class="card-header">
									<h3 class="card-title">
										Add Doctor Appointment
									</h3>
								</div> -->

								<div class="card-body">
    							     <div class="row">
    							    	<div class="form-group col-md-6">
    											<label><b>Date *</b></label>
    											<input type="date" class="form-control" placeholder="DD/MM/YY" name="date" id="date" min="<?php echo date('Y-m-d'); ?>"/>
    											<div id="date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
    									</div>
    									<div class="form-group col-md-6">
    											<label><b>Time *</b></label>
    											<input type="time" class="form-control" placeholder="HH:MM" name="time" id="time"/>
    											<div id="time_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
    									</div>
    							    </div>
	
                                    <input type="hidden" name="book_package_id" id="book_package_id" value="<?php echo $manage_package[0]['book_package_id'];?>">
                               		<input type="hidden" name="package_id" id="package_id" value="<?php echo $manage_package[0]['package_id'];?>">
                               		<input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $manage_package[0]['service_id'];?>">
                                    <input type="hidden" name="amount" id="amount" value="<?php echo $manage_package[0]['total'];?>">
                                    <input type="hidden" name="package_name" id="package_name" value="<?php echo $manage_package[0]['package_name'];?>">
                                    <!-- <input type="hidden" name="cart_id" id="cart_id" value="<?php echo $manage_package['cart_id'];?>"> -->
                                    <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $manage_package[0]['patient_id'];?>">
                                    <input type="hidden" name="available_visit" id="available_visit" value="<?php echo $manage_package[0]['available_visit'];?>">
						     	</div>
												
							<div class="card-footer">
								<!-- <button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Booking Now</button> -->
							<!-- 	<button type="button" class="btn btn-primary mr-2" id="btnSubmit">Book Now</button> -->
								<?php
								// $date = date('Y-m-d H:i:s');
								// $date = strtotime($date);
								// //echo $manage_package['purchase_date'];
								// $purchase_date=$manage_package['purchase_date'];
								// $purchase_date = strtotime($purchase_date);
								
								//$purchase_date=$manage_package['purchase_date'];
								//echo $purchase_date;
								//$date = strtotime($purchase_date);

								//$expired_date = strtotime("+".$manage_package['validate_month']."day", $date);
								// $expired_date = strtotime("+".$manage_package['no_days']."day", $date);
								//  $expired_date =date('Y-m-d', $expired_date);
								//   $purchase_date =date('Y-m-d', $date);
								  $today=date('Y-m-d');
								 //echo "Expire ".$expired_date."<br>";
								// echo "Purchase ".$purchase_date."<br>";
								//echo "Today ".$today;
							//	$today=date('Y-m-d');
								if($manage_package[0]['available_visit']==0)
								{
								?>
								<font color="red"><b><label>"Sorry,No More Visit Available for this Package."</label></b></font>
								
								<?php
								}
								else if($today > $manage_package[0]['expire_date'])
								{
									?>
									<font color="red"><b><label>"This Package is no Longer available to book an appointment."</label></b></font>
									<?php
								}
								else
								{
									?>
									<button type="button" class="btn btn-primary mr-2" id="btnSubmit">Book Now</button>
									<?php
								}
									?>
								
								<!-- <a href="<?php echo base_url()?>userCart"  class="btn btn-primary mr-2">Book Now</a> -->
								
								<!-- <a href="<?php echo base_url(); ?>AppointmentList" class="btn btn-secondary">Cancel</a> -->
							</div>
						</form>
												
						
					</div>
				</div>
			</div>
			
			<div class="col-xl-6">
				<div class="card card-custom">
									<div class="card-header flex-wrap py-5">
										<div class="card-title">
											<h3 class="card-label">Package Book Details</h3>
											<span style="color:grey;"> <?php echo $this->session->flashdata('message'); ?> </span>
										</div>
									</div>
				<div class="card-body">
										
				   <form method="post">
				   						<?php
				   							//$manage_package['package_id'];
				   						?>
										<table class="table table-separate table-head-custom table-checkable" id="view_package_datatable">
											<thead>
												<tr>
													<th>Date</th>
													<th>Time</th>
													
													
												</tr>
											</thead>
											<tbody>
												
												<?php 
												$i = 1;	
												foreach($book_package as $package){ 
												?>
												<tr>

													<td><?php echo $package['date'] ?></td>
													<td><?php echo $package['time']; ?></td>
													
												</tr>
												<?php } ?>
											</tbody>
										</table>
										<!--  <input id="reloadValue" type="hidden" name="reloadValue" value="" /> -->

									</form>
									
									</div>
								</div>
						</div>
			
			
					</div>
				
				
			
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>

				</div>
                        <div class="d-flex flex-column-fluid">
							
						<div class="container">
						    <div class="row">
						        <div class="col-xl-6">
				<div class="card card-custom">
                    <div class="card-header">
                       <div class="card-title">
                            <span class="card-icon">
                            	<?php
                            	
                            	if($manage_package[0]['service_id']==1)
                            	{
                            		?>
                            		<i class="fa fa-user-md" aria-hidden="true"></i>
                            		<?php
                            	}
                            	if($manage_package[0]['service_id']==2)
                            	{
                            		?>
                            		<i class="fa fa-user-md" aria-hidden="true"></i>
                            		<?php
                            	}
                            	if($manage_package[0]['service_id']==3)
                            	{
                            		?>
                            		<i class="fa fa-flask" aria-hidden="true"></i>
                            		<?php
                            	}
                            	if($manage_package[0]['service_id']==4)
                            	{
                            		?>
                            		 <i class="fa fa-plus-square" aria-hidden="true"></i>
                            		<?php
                            	}
                            	if($manage_package[0]['service_id']==5)
                            	{
                            		?>
                            		 <i class="fa fa-ambulance" aria-hidden="true"></i>
                            		<?php
                            	}
                            	?>
                               
                            </span>
                           <h3 class="card-label">
                            <?php echo $manage_package[0]['package_name'];?>
                            <small>
                            	 <?php echo $manage_package[0]['user_type_name'];?>
                            </small>
                           </h3>
                       </div>
                            <!-- <div class="card-toolbar">
                                <a href="#" class="btn btn-sm btn-success font-weight-bold">
                                    <i class="flaticon2-cube"></i> Reports
                                </a>
                            </div> -->
                    </div>
                    <!--  <form method="post"> -->
                     <div class="card-body">
                            <?php 
                    		 echo $manage_package[0]['description'];?>
                      		<label>&nbsp;&#x20b9 <b>Price: </b><?php  echo $manage_package[0]['total']; ?></label><br>
                      		<label><i class="fa fa-user-md" aria-hidden="true"></i> <b>Visits: </b><?php  echo $manage_package[0]['no_visit']; ?></label><br>
                      		<?php $left_available_visit=$manage_package[0]['available_visit']; ?>
                      		<label><i class="fa fa-user-md" aria-hidden="true"></i> <b>Avaailable Visits: </b><?php  echo $left_available_visit; ?></label><br>
                      		<label><i class="fa fa-map-marker" aria-hidden="true"></i> <b>City: </b><?php  echo $manage_package[0]['city']; ?></label><br>
                            <label><i class="fa fa-calendar" aria-hidden="true"></i> <b>Days: </b><?php  echo $manage_package[0]['no_days']; ?></label><br>
                            <label><i class="fa fa-calendar" aria-hidden="true"></i> <b>Expired Date: </b><?php  echo date("d-m-Y",strtotime($manage_package[0]['expire_date'])); ?></label>
                      	
                      </div>
                    <!-- </form> -->

								<!--end::Card-->
			    </div>
		    </div>
						    </div>
							
					    </div>
					</div>
	
					<!--end::Content-->


<script type="text/javascript">

// Ajax post
$(document).ready(function() 
{
$("#btnSubmit").click(function() 
{

//alert(member);
var book_package_id=$('#book_package_id').val();
var package_id=$('#package_id').val();
var user_type_id=$('#user_type_id').val();
var patient_id=$('#patient_id').val();
var available_visit=$('#available_visit').val();

	var date = $('#date').val();
	var time = $('#time').val();
	

	if(date!="" && time!="")
	{
			jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url('updatePackageBook'); ?>",
			dataType: 'html',
			data: {package_id:package_id,user_type_id: user_type_id, patient_id: patient_id,date:date,time:time,available_visit:available_visit,book_package_id:book_package_id},
			success: function(res) 
			{
				window.location.href = '<?php echo base_url('userViewMyPackage'); ?>';
			},
			error:function()
			{
				//alert('data not saved');	
			}
		});
	}
	else
	{
		if ($("#date").val()=='') {
                
                $('#date_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#date_valid').hide();
            }
            if ($("#time").val()=='') {
                
                $('#time_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#time_valid').hide();
            }
           
			return true;
	}

});
});
</script>


<!-- <script type="text/javascript">

    $(function () {

        $("#btnSubmit").click(function () {
          

            if ($("#date").val()=='') {
                
                $('#date_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#date_valid').hide();
            }
            if ($("#time").val()=='') {
                
                $('#time_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#time_valid').hide();
            }
           
			return true;

        });
    });
</script>

 -->