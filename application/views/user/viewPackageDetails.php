<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">View Package</h5>
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
 <div class="card-header">
  <div class="card-title">
            <span class="card-icon">
            	<?php
            	
            	if($manage_package['service_id']==1)
            	{
            		?>
            		<i class="fa fa-user-md" aria-hidden="true"></i>
            		<?php
            	}
            	if($manage_package['service_id']==2)
            	{
            		?>
            		<i class="fa fa-user-md" aria-hidden="true"></i>
            		<?php
            	}
            	if($manage_package['service_id']==3)
            	{
            		?>
            		<i class="fa fa-flask" aria-hidden="true"></i>
            		<?php
            	}
            	if($manage_package['service_id']==4)
            	{
            		?>
            		 <i class="fa fa-plus-square" aria-hidden="true"></i>
            		<?php
            	}
            	if($manage_package['service_id']==5)
            	{
            		?>
            		 <i class="fa fa-ambulance" aria-hidden="true"></i>
            		<?php
            	}
            	?>
               
            </span>
   <h3 class="card-label">
    <?php echo $manage_package['package_name'];?>
    <small>
    	 <?php echo $manage_package['user_type_name'];?>
    </small>
   </h3>
  </div>
        <!-- <div class="card-toolbar">
            <a href="#" class="btn btn-sm btn-success font-weight-bold">
                <i class="flaticon2-cube"></i> Reports
            </a>
        </div> -->
 </div>
 <form method="post">
 <div class="card-body">
  <?php echo $manage_package['description'];?>
 
  	
  		<label>&nbsp;&#x20b9 <b>Price: </b><?php  echo $manage_package['fees_name']; ?></label><br>
  		<label><i class="fa fa-user-md" aria-hidden="true"></i> <b>Visits: </b><?php  echo $manage_package['no_visit']; ?></label><br>
  		<label><i class="fa fa-map-marker" aria-hidden="true"></i> <b>City: </b><?php  echo $manage_package['city']; ?></label><br>
        <label><i class="fa fa-calendar" aria-hidden="true"></i> <b>Days: </b><?php  echo $manage_package['validate_month']; ?></label>
  	
  </div>

    <div class="card-footer d-flex justify-content-between">
    	 <!-- <a href="<?php echo base_url(); ?>userAddPackage" class="btn btn-light-primary font-weight-bold">Book Package</a> -->
         <?php
         
         
         date_default_timezone_set("Asia/Kolkata");
         $start = '08:00:00';
         $end   = '20:00:00';
         //$time=time();
         $time= date('H:i:s');
       
         $date=date('Y-m-d');
        // echo $holiday[0][hdate] . "==".$date;
         if(date('D') == 'Sun' || $holiday[0][hdate]==$date || ($time >=$start && $time >= $end)) {
         ?>
         Today is Holiday So don't book this Package today.
         <?php 
        
        }
        else
        {
            ?>
             <button formaction="<?php echo base_url(); ?>userAddPackage/viewPackage" class="btn btn-light-primary font-weight-bold" name="btn_view_package"value="<?php echo $manage_package['package_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" >  Book Package
                 </button>  
            <?php
        }


         ?>
    	
        <a href="<?php echo base_url(); ?>userPackage" class="btn btn-light-primary font-weight-bold">Back to List Page</a>
       
 </div>
</form>

								<!--end::Card-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					<!--end::Content-->

