<!--begin::Content-->
		<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
			
			<!--begin::Entry-->
			<div class="d-flex flex-column-fluid">
				<!--begin::Container-->

				<div class="container">


					<?php
					
					if($this->uri->segment(2) == 'MyProfile'){

						
						


					$blank_image = base_url().'assets/media/users/blank.png';
					
					if(!empty($view_user_profile->profile_pic)){
						
						$profile_image = base_url().'uploads/user_profile/'.$view_user_profile->profile_pic;
					}else{
						
						$profile_image = $blank_image;
					}


					?>
					<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
								<!--begin::Profile Personal Information-->
								<div class="d-flex flex-row">
					<div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
										<!--begin::Profile Card-->
										<div class="card card-custom card-stretch">
											<!--begin::Body-->
											<div class="card-body pt-4">
												<!--begin::Toolbar-->
												<div class="d-flex justify-content-end">
													<div class="dropdown dropdown-inline">
														<!-- <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<i class="ki ki-bold-more-hor"></i>
														</a>
														 -->
													</div>
												</div>
												<!--end::Toolbar-->
												<!--begin::User-->
												<div class="d-flex align-items-center">
													<div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
														<div class="symbol-label" style="background-image:url('<?php echo base_url().'uploads/user_profile/'.$this->session->userdata('admin_user')['profile_pic'];?>')"></div>
														<i class="symbol-badge bg-success"></i>
													</div>
													<div>
														<a href="#" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">
															<?php //echo ucfirst($this->session->userdata('admin_user')['first_name'])." ".ucfirst($this->session->userdata('user')['last_name']);?>
																

																<?php echo ucfirst($view_user_profile->first_name)." ".ucfirst($view_user_profile->last_name); ?>
															</a>
														<!-- <div class="text-muted">Application Developer</div> -->
														<!-- <div class="mt-2">
															<a href="#" class="btn btn-sm btn-primary font-weight-bold mr-2 py-2 px-3 px-xxl-5 my-1">Chat</a>
															<a href="#" class="btn btn-sm btn-success font-weight-bold py-2 px-3 px-xxl-5 my-1">Follow</a>
														</div> -->
													</div>
												</div>
												<!--end::User-->
												<!--begin::Contact-->
												<div class="py-9">
													<div class="d-flex align-items-center justify-content-between mb-2">
														<span class="font-weight-bold mr-2">Email:</span>
														<a href="#" class="text-muted text-hover-primary"><?php echo ucfirst($this->session->userdata('admin_user')['email']);?></a>
													</div>
													<div class="d-flex align-items-center justify-content-between mb-2">
														<span class="font-weight-bold mr-2">Phone:</span>
														<span class="text-muted" style="margin-right: 35%;"><?php echo ucfirst($this->session->userdata('admin_user')['mobile']);?></span>
													</div>
													<!-- <div class="d-flex align-items-center justify-content-between">
														<span class="font-weight-bold mr-2">Location:</span>
														<span class="text-muted">Melbourne</span>
													</div> -->
												</div>
												<!--end::Contact-->
												<!--begin::Nav-->
												<div class="navi navi-bold navi-hover navi-active navi-link-rounded">
													
													<div class="navi-item mb-2">
														<a href="javascript:void(0);" class="navi-link py-4 active" id="profile_information_show">
															<span class="navi-icon mr-2">
																<span class="svg-icon">
																	<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<polygon points="0 0 24 0 24 24 0 24"></polygon>
																			<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
																			<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
																		</g>
																	</svg>
																	<!--end::Svg Icon-->
																</span>
															</span>
															<span class="navi-text font-size-lg">Personal Information</span>
														</a>
													</div>
													
													<div class="navi-item mb-2">
														<a href="javascript:void(0);" class="navi-link py-4" id="change_password_show">
															<span class="navi-icon mr-2">
																<span class="svg-icon">
																	<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Shield-user.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<rect x="0" y="0" width="24" height="24"></rect>
																			<path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"></path>
																			<path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3"></path>
																			<path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3"></path>
																		</g>
																	</svg>
																	<!--end::Svg Icon-->
																</span>
															</span>
															<span class="navi-text font-size-lg">Change Pin</span>
															
														</a>
													</div>
													
												</div>
												<!--end::Nav-->


											</div>
											<!--end::Body-->

										</div>
										<!--end::Profile Card-->


									</div>




									<div class="flex-row-fluid ml-lg-8" id="profile_data">
										
										<!--begin::Card-->
										<div class="card card-custom card-stretch">
											<!--begin::Header-->
											<div class="card-header py-3">
												<div class="card-title align-items-start flex-column">
													<h3 class="card-label font-weight-bolder text-dark">Personal Information</h3>
													<span class="text-muted font-weight-bold font-size-sm mt-1">Update your personal informaiton</span>
												</div>
												<!-- <div class="card-toolbar">
													<button type="reset" class="btn btn-success mr-2">Save Changes</button>
													<button type="reset" class="btn btn-secondary">Cancel</button>
												</div> -->
											</div>
											<!--end::Header-->
											<!--begin::Form-->
											
												<form class="form" id="edit_form" action="<?php echo base_url(); ?>updateMyProfile"  method="post" enctype="multipart/form-data">
												<!--begin::Body-->
												<div class="card-body">
													<div class="row">
														<label class="col-xl-3"></label>
														<!-- <div class="col-lg-9 col-xl-6">
															<h5 class="font-weight-bold mb-6">Customer Info</h5>
														</div> -->
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Profile Image</label>
														<div class="image-input image-input-empty image-input-outline" id="div_profile_image"  style="background-image: url('<?php echo $profile_image ?>');">
														<div class="image-input-wrapper"  ></div>
														<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
															<i class="fa fa-pen icon-sm text-muted"></i>
														  	<input type="file" name="img_profile" accept=".png, .jpg, .jpeg"/>
														  	<input type="hidden" name="profile_avatar_remove"/>
														</label>

														<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
															<i class="ki ki-bold-close icon-xs text-muted"></i>
														</span>

														<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
															<i class="ki ki-bold-close icon-xs text-muted"></i>
														</span>
													</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">First Name</label>
														<div class="col-lg-9 col-xl-6">
															<input class="form-control form-control-lg form-control-solid" type="text" name="first_name"  value="<?php echo $view_user_profile->first_name; ?>" />
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Last Name</label>
														<div class="col-lg-9 col-xl-6">
															<input class="form-control form-control-lg form-control-solid" type="text" name="last_name"  value="<?php echo $view_user_profile->last_name; ?>" />
														</div>
													</div>
													
													<div class="row">
														<label class="col-xl-3"></label>
														<div class="col-lg-9 col-xl-6">
															<h5 class="font-weight-bold mt-10 mb-6">Contact Info</h5>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Contact Phone</label>
														<div class="col-lg-9 col-xl-6">
															<div class="input-group input-group-lg input-group-solid">
																<div class="input-group-prepend">
																	<span class="input-group-text">
																		<i class="la la-phone"></i>
																	</span>
																</div>
																<input class="form-control form-control-lg form-control-solid" readonly type="text" name="mobile"  value="<?php echo $view_user_profile->mobile; ?>" />
															</div>
															
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
														<div class="col-lg-9 col-xl-6">
															<div class="input-group input-group-lg input-group-solid">
																<div class="input-group-prepend">
																	<span class="input-group-text">
																		<i class="la la-at"></i>
																	</span>
																</div>
																<input class="form-control form-control-lg form-control-solid" readonly type="email" name="email"  value="<?php echo $view_user_profile->email; ?>" />
															</div>
														</div>
													</div>
													<div class="form-group row">
														<div class="card-toolbar">
															<!-- <button type="submit" class="btn btn-success mr-2">Update Profile</button> -->
															<button type="submit" name="btn_update_user_myprofile" value="<?php echo $view_user_profile->user_id; ?>" class="btn btn-success mr-2 btn_update_profile" >Update Profile</button>
														</div>
													</div>
													
												</div>
												<!--end::Body-->
											</form>
											<!--end::Form-->
										</div>
									</div>

									<div class="flex-row-fluid ml-lg-8" id="change_password_card" style="display: none;">
										<!--begin::Card-->
										<div class="card card-custom">
											<!--begin::Header-->
											<div class="card-header py-3">
												<div class="card-title align-items-start flex-column">
													<h3 class="card-label font-weight-bolder text-dark">Change Pin</h3>
													<span class="text-muted font-weight-bold font-size-sm mt-1">Change your account Pin</span>
												</div>
												<!-- <div class="card-toolbar">
													<button type="submit" class="btn btn-success mr-2">Save Changes</button>
													
												</div> -->
											</div>
											<!--end::Header-->
											<!--begin::Form-->
											
												<form class="form" action="<?php echo base_url(); ?>resetPassword" method="POST" id="passwordForm">
												<div class="card-body">
													
											
													<?php if($this->session->flashdata('msg')): ?>
    													<p style="color:red;"><b><?php echo $this->session->flashdata('msg'); ?></b></p>
												<?php endif; ?>
													
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label text-alert">Current Pin</label>
														<div class="col-lg-9 col-xl-6">
															<input type="password" class="form-control form-control-lg form-control-solid mb-2" value="" placeholder="Current Pin" name="oldpass" id="oldpass" onkeypress="return isNumber(event)" maxlength="4"/>
															<!-- <a href="#" class="text-sm font-weight-bold">Forgot password ?</a> -->
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label text-alert">New Pin</label>
														<div class="col-lg-9 col-xl-6">
															<input type="password" class="form-control form-control-lg form-control-solid" value="" placeholder="New Pin" name="newpass" id="newpass" onkeypress="return isNumber(event)" maxlength="4"/>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label text-alert">Confirm Pin</label>
														<div class="col-lg-9 col-xl-6">
															<input type="password" class="form-control form-control-lg form-control-solid" value="" placeholder="Confirm Pin" name="passconf" id="passconf" onkeypress="return isNumber(event)" maxlength="4"/>
														</div>
													</div>
													<div class="form-group row">
													<div class="card-toolbar">
													<button type="submit" class="btn btn-success mr-2">Save Changes</button>
													
														</div>
														</div>
												</div>
											</form>
											<!--end::Form-->
										</div>
									</div>

									</div>
							</div>
						</div>

									


					<?php 
					}
					?>
					
					


					


					

					
				</div>
				<!--end::Container-->
			</div>
			<!--end::Entry-->
		</div>
	<!--end::Content-->
<!-- 	<script type="text/javascript">
		$(document).ready(function() {
  $(".number_check").keyup(function() {

  		var myLength = $(".number_check").val().length;

	  	if( myLength >= 4 ) {

	  var currentYear = (new Date).getFullYear();
	  var value = parseInt($(this).val(), 10);
	  var start = parseInt(1960, 10);	
  
  		if (start <= value && currentYear >= value) {
   
  		} 
  else {
   				$(this).val('');
	}

}

        
        
	  	
  });

})
	</script> -->
	<!-- <style type="text/css">
		 .box{
        color: #fff;
        padding: 20px;
        display: none;
        margin-top: 20px;
    }
	</style> -->
<!-- 	<script type="text/javascript">
    $(function () {
        $("#checked_box").click(function () {
        
            if ($(this).is(":checked")) {
            	 $("#checkbox_click").hide();
              
            } else {
               
                  $("#checkbox_click").show();
            }
        });
    });
</script> -->
<script type="text/javascript">
	$(document).ready(function() {

        $("#profile_information_show").click(function() {
        	var count=0
            $("#profile_data").toggle();
            $("#change_password_card").hide();

        });
    });
</script>
<script type="text/javascript">
	$(document).ready(function() {

        $("#change_password_show").click(function() {
            $("#change_password_card").toggle();
            $("#profile_data").hide();
        });
    });
</script>
<script type="text/javascript">
	function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>



