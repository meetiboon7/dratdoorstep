<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Manage Team</h5>
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
					<div class="card-body p-0">
						<form id="add_fees_form" class="form" action="<?php echo base_url(); ?>insertManageTeam" method="post" enctype="multipart/form-data">
								<div class="card-header">
									<h3 class="card-title">
										Add Team Info
									</h3>
								</div>
								<div class="card-body">

								<div class="row">
									<div class="form-group col-md-4">
										<label>City *</label>
										<select class="form-control select2 city_valid" id="kt_select2_17" name="city_id" >
											<option value="none" selected disabled hidden> Select City </option>

											<?php 
												foreach($city as $c){
													echo '<option value="'.$c['city_id'].'">'.$c['city'].'</option>';
												}
											?>
										</select>
										<div id="city_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
									<div class="form-group col-md-4">
										<label>Zone *</label>
										<select class="form-control select2 zone_valid" id="kt_select2_14" name="zone_id" >
											<option value="none" selected disabled hidden> Select Zone </option>
											<?php 
												foreach($zone_master as $z){
													echo '<option value="'.$z['zone_id'].'">'.$z['zone_name'].'</option>';
												}
											?>
										</select>
										<div id="zone_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>

									<div class="form-group col-md-4">
											<label>Team Name *</label>
											<input type="text" class="form-control isRequired" placeholder="Team Name" name="team_name" id="team_name"/>
											 <div id="team_name_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									
									
									
							    </div>

							    

								

								 <div class="row">

								 	
									<div class="form-group col-md-8">
								    	<label>Employee</label>
								    	<select id="kt_dual_listbox_1" class="dual-listbox emp_valid" multiple name="emp_id[]">
												 <option value="none" selected disabled hidden> Select Employee </option>
											<?php 
												foreach($employee_master as $em){
													echo '<option value="'.$em['emp_id'].'">'.$em['first_name']." ".$em['last_name'].'</option>';
												}
											?>
										</select>
										 <div id="emp_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									

									
									
								
							   
									
									
								</div>

								<div class="row">
									
									
									<div class="form-group col-md-4">
										<label>Status</label>
										<select class="form-control select2"  name="team_status"  id="kt_select2_16">
											<option value="1">Active</option>
											<option value="0">Inactive</option>
										</select>
										
								</div>
								</div>	

								
								
							</div>
												
							<div class="card-footer">
								<button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Save</button>
								<a href="<?php echo base_url(); ?>adminManageTeam" class="btn btn-secondary">Cancel</a>
							</div>
						</form>
					</div>
				</div>
				<!-- End of Pharmacy Details -->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Entry-->
	</div>
<!--end::Content-->
<script type="text/javascript">
	// Class definition
                    var KTDualListbox = function() {
                        // Private functions
                        var demo1 = function () {
 // Dual Listbox
 var listBox = $('#kt_dual_listbox_1');

 var $this = listBox;

 // get options
 var options = [];
 $this.children('option').each(function () {
  var value = $(this).val();
  var label = $(this).text();
  options.push({
   text: label,
   value: value
  });
 });

 // init dual listbox
 var dualListBox = new DualListbox($this.get(0), {
  addEvent: function (value) {
   console.log(value);
  },
  removeEvent: function (value) {
   console.log(value);
  },
  availableTitle: 'Available options',
  selectedTitle: 'Selected options',
  addButtonText: 'Add',
  removeButtonText: 'Remove',
  addAllButtonText: 'Add All',
  removeAllButtonText: 'Remove All',
 // options: options,
 });
};

                        return {
                            // public functions
                            init: function() {
                                demo1();
                            },
                        };
                    }();

                    jQuery(document).ready(function() {
                        KTDualListbox.init();
                    });
</script>
<script type="text/javascript">
    $(function () {

        $("#btnSubmit").click(function () {
          
             var city_valid = $(".city_valid");
              var zone_valid = $(".zone_valid");
              //var emp_valid = $(".emp_valid");
             // alert(emp_valid);
            if (city_valid.val() == null) {
                
                $('#city_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#city_valid_id').hide();
            }

            if (zone_valid.val() == null) {
                
                $('#zone_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#zone_valid_id').hide();
            }
           
            

            if ($("#team_name").val()=='') {
                
                $('#team_name_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#team_name_valid').hide();
            }

            // if (emp_valid.val() == null) {
                
            //     $('#emp_valid_id').show();
        		
            //     return false;
            // }
            // else
            // {
            // 	 $('#emp_valid_id').hide();
            // }
            
			return true;

        });
    });
</script>



