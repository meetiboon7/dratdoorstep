<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Manage Voucher</h5>
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
						<form id="add_voucher_form" class="form" action="<?php echo base_url(); ?>insertVoucher" method="post" enctype="multipart/form-data">
								<!-- <div class="card-header">
									<h3 class="card-title">
										Add Fees Info
									</h3>
								</div> -->
								<div class="card-body">

								<div class="row">
									
									<div class="form-group col-md-6">
											<label>Title *</label>
											<input type="text" class="form-control" placeholder="Title" name="title" id="title"/>
											<div id="title_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>

										<div class="form-group col-md-6">
											<label>Promo Code *</label>
											<input type="text" class="form-control" placeholder="Promo Code" name="code" id="code"/>
											<div id="code_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									
									    
								
									 

									
									
									
							    </div>

							  	<div class="row">

							  		<div class="form-group col-md-6">
								        <label class="col-form-label"><b>Select Service</b></label><br>
								        <div id="inline_content">
								            <div class="radio-inline">
								            	<div class="col-md-3">
								                <label class="radio radio-success">
								                    <input type="radio" name="serivce_radio" class="form-control" value="Services" /><span></span>
								                    Services
								                </label>
								             	</div>
								             	<div class="col-md-3">
								                <label class="radio radio-success">
								                    <input type="radio" name="serivce_radio"  class="form-control" value="Package" /><span></span>
								                    Package
								                </label>
								            </div>
								            <div class="col-md-3">
								                <label class="radio radio-success">
								                    <input type="radio" name="serivce_radio"  class="form-control" value="All" /><span></span>
								                    All 
								                </label>
								            </div>
								               
								            </div>
								             </div>
								            <div id="radio_service_valid" class="validation" style="display:none;color:red;">Please Select Value</div>
								            
								        
								    </div>
									
									


									
									<div class="form-group col-md-4" id="service_dropdown" style="display: none";>

										<label>Services*</label>
										<select class="form-control select2 service_valid" id="kt_select2_17" name="service_id" data-placeholder="Select Service" style="width:573">
										
											<?php 
												foreach($service_type as $st){
													echo '<option value="'.$st['user_type_id'].'">'.$st['user_type_name'].'</option>';
												}
											?>
										</select>
										 <div id="service_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>


									
									
									<div class="form-group col-md-4" id="package_dropdown" style="display: none"; >
										<label>Packages*</label>
										<select class="form-control select2 package_valid" id="kt_select2_13" name="package_id"  data-placeholder="Select Package" style="width:573">
											
											<?php 
												foreach($packages as $p){
													echo '<option value="'.$p['package_id'].'">'.$p['package_name'].'</option>';
												}
											?>
										</select>
										<div id="package_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
								
								</div>
								
							    
									
								
								<div class="row">
									
									<div class="form-group col-md-6">
											<label>From date *</label>
											<input type="date" class="form-control" placeholder="From Date" name="from_date" id="from_date"  min="<?php echo date('Y-m-d'); ?>"/>
											<div id="from_date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
									
									<div class="form-group col-md-6">
											<label>To date *</label>
											<input type="date" class="form-control" placeholder="To Date" name="to_date" id="to_date"  min="<?php echo date('Y-m-d'); ?>"/>
											<div id="to_date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>
							    </div>
							    

							   
							    
									
									
									
									
							    

							    <div class="row">
									<div class="form-group col-md-12">
										<label>Description *</label>
										<textarea class="form-control" name="desc" id="editor1" ></textarea>
										<div id="description_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
									</div>

									
									

								</div>
								<div class="row">
									
									<div class="form-group col-md-6">
											<label>Amount *</label>
											<input type="text" class="form-control" placeholder="Amount" name="amount" id="amount"  onkeypress="return isNumberKey(event)"/>
											<div id="amount_valid" class="validation"  style="display:none;color:red;">Please Enter Value</div>
									</div>
									
									<div class="form-group col-md-6">
										<label>Type *</label>
										<select class="form-control select2 type_validate"  name="type"  id="kt_select2_16">
										<option value="none" selected disabled hidden> Select Type </option>
											<option value="All User">All User</option>
											<option value="New User">New User</option>
										</select>
										<div id="type_valid_id" class="validation"  style="display:none;color:red;">Please Enter Value</div>
										
								</div>
							    </div>

							     
							   
							    
								
									
							    

								

								 <div class="row">

								 	
							    	
									<div class="form-group col-md-6">
										<label>City *</label>
										<select class="form-control select2 city_valid js-example-placeholder-multiple"   name="city_id[]" id="city_validate" multiple="">
											
											<?php 
												foreach($city as $c){
													echo '<option value="'.$c['city_id'].'">'.$c['city'].'</option>';
												}
											?>
										</select>
										<div id="city_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
								</div>
								
								 <div class="form-group col-md-6">
										  <label>visibility</label>
											<div class="col-3">
											   <span class="switch switch-outline switch-icon switch-success">
											    <label>
											     <input type="checkbox" checked="checked" name="visi_and_invisi"/>
											     <span></span>
											    </label>
											   </span>
											</div>
								 	</div>

									
									
									
								
							   
									
									
								</div>	

								
								
							</div>
												
							<div class="card-footer">
								<button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Save</button>
								<a href="<?php echo base_url(); ?>adminVoucher" class="btn btn-secondary">Cancel</a>
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
	$("#inline_content input[name=serivce_radio]").click(function(){

		//alert($('input:radio[name=serivce_radio]:checked').val());
    
    if($('input:radio[name=serivce_radio]:checked').val() == "Services"){

    	$("#package_dropdown").hide();
    	$("#service_dropdown").show();
    	
    	$('.select2-search__field').css({'width': 450});
    	$('.select2-selection__rendered').css({'width': 450});
    	

       
    }
    else if($('input:radio[name=serivce_radio]:checked').val() == "Package")
    {
    	//alert("fs");
    	$("#service_dropdown").hide();
    	$("#package_dropdown").show();
    	$('.select2-search__field').css({'width': 450});
    	$('.select2-selection__rendered').css({'width': 450});
    }
     else
    {
    	$("#service_dropdown").hide();
    	$("#package_dropdown").hide();
    }
});
</script>

<script type="text/javascript">
    $(function () {

        $("#btnSubmit").click(function () {


        	if ($("#title").val()=='') {
                
                $('#title_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#title_valid').hide();
            }

            if ($("#code").val()=='') {
                
                $('#code_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#code_valid').hide();
            }


            // var atLeastOneChecked = false;

             if ($('input[name="serivce_radio"]:checked').length == 0) {
               			
               			$('#radio_service_valid').show();
               			 return false;
            }
            else
            {
               		$('#radio_service_valid').hide();
            }



            


             if($('input:radio[name=serivce_radio]:checked').val() == "Services"){

            	var service_options = $('#kt_select2_17 > option:selected');
		        if(service_options.length == 0){
				
				    $('#service_valid_id').show();
				    //$('.select2-selection__rendered').css({'width': 573});
					 return false;
				}
				else
				{
				   	 $('#service_valid_id').hide();
				   	// $('.select2-search__field').css({'width': 573});
				}
						       //    return true;
             }

             if($('input:radio[name=serivce_radio]:checked').val() == "Package"){

            	var package_options = $('#kt_select2_13 > option:selected');
		        if(package_options.length == 0){
				
				    $('#package_valid_id').show();
				    //$('.select2-selection__rendered').css({'width': 573});
					 return false;
				}
				else
				{
				   	 $('#package_valid_id').hide();
				   	//  $('.select2-selection__rendered').css({'width': 573});
				}
						          // return true;
             }
       

       		 if ($("#from_date").val()=='') {
                
                $('#from_date_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#from_date_valid').hide();
            }

             if ($("#to_date").val()=='') {
                
                $('#to_date_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#to_date_valid').hide();
            }
             //var desc = CKEDITOR.instances.description.getData();
            var ckValue = CKEDITOR.instances["editor1"].getData();
           // alert(ckValue);
            if (ckValue=='') {
                
                $('#description_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#description_valid').hide();
            }
            var type = $(".type_validate");
            
          //  var city_valid = $(".city_valid");
            
           if ($("#amount").val()=='') {
                
                $('#amount_valid').show();
        		
                return false;
            }
            else
            {
            	 $('#amount_valid').hide();
            }
            if (type.val() == null) {
                
                $('#type_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#type_valid_id').hide();
            }

             //alert(city_valid);
             var options = $('#city_validate > option:selected');
	         if(options.length == 0){
	               $('#city_valid_id').show();
	        		
	                return false;
	         }
			else
            {
            	 $('#city_valid_id').hide();
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
