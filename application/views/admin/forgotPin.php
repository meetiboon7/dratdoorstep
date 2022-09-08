<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		
		<meta charset="utf-8" />
		<title>Sign Up | Dr at Doorstep</title>
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<script type="text/javascript">
			var BASE_URL = "<?php echo base_url(); ?>";

		</script>
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->

		<!--begin::Page Custom Styles(used by this page)-->
		<link href="<?php echo base_url()?>assets/css/pages/login/classic/login-1.css" rel="stylesheet" type="text/css" />
		<!--end::Page Custom Styles-->

		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="<?php echo base_url()?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->

		<!--begin::Layout Themes(used by all pages)-->
		<link href="<?php echo base_url()?>assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>assets/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url()?>assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/validation/validation_function.js"></script>
		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="<?php echo base_url()?>assets/media/logos/favicon.ico" />
		
		<!-- Hotjar Tracking Code for keenthemes.com -->
		<script>(function(h,o,t,j,a,r){ h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)}; h._hjSettings={hjid:1070954,hjsv:6}; a=o.getElementsByTagName('head')[0]; r=o.createElement('script');r.async=1; r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv; a.appendChild(r); })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');</script>
	</head>
	<!--end::Head-->

	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<!-- Google Tag Manager (noscript) -->
		<noscript>
			<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FS8GGP" height="0" width="0" style="display:none;visibility:hidden"></iframe>
		</noscript>
		  
		<!-- End Google Tag Manager (noscript) -->
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Login-->
			<div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
				<!--begin::Aside-->
				<div class="login-aside d-flex flex-row-auto bgi-size-cover bgi-no-repeat p-10 p-lg-10" style="background-image: url(<?php echo base_url()?>assets/media/bg/drardoorstep.jpeg);">
					<!--begin: Aside Container-->
					<div class="d-flex flex-row-fluid flex-column justify-content-between">
						<!--begin: Aside header-->
						<!-- <a href="#" class="flex-column-auto mt-5 pb-lg-0 pb-10">
							<img src="assets/images/dad_logo.png" class="max-h-70px" alt="" />
						</a> -->
						<!--end: Aside header-->
						<!--begin: Aside content-->
						<!-- <div class="flex-column-fluid d-flex flex-column justify-content-center">
							<h3 class="font-size-h1 mb-5 text-white">Welcome to Dr at Doorsteps!</h3>
							<p class="font-weight-lighter text-white opacity-80">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
						</div> -->
						<!--end: Aside content-->
						<!--begin: Aside footer for desktop-->
						<!-- <div class="d-none flex-column-auto d-lg-flex justify-content-between mt-10">
							<div class="opacity-70 font-weight-bold text-white">© 2020 Dr at Doorstep </div>
							<div class="d-flex">
								<a href="#" class="text-white">Privacy</a>
								<a href="#" class="text-white ml-10">Legal</a>
								<a href="#" class="text-white ml-10">Contact</a>
							</div>
						</div> -->
						<!--end: Aside footer for desktop-->
					</div>
					<!--end: Aside Container-->
				</div>
				
				<div class="d-flex flex-column flex-row-fluid position-relative p-7 overflow-hidden">
					
					<div class="d-flex flex-column-fluid flex-center mt-30 mt-lg-0">
						<!--begin::Signin-->
						<div class="login-form login-signin">
							<div class="text-center mb-10 mb-lg-12">
								<!-- <img src="assets/images/dad_logo.png" style="width:140px; height: auto;" alt="" /> -->
								<h3 class="font-size-h1">Forgot Pin</h3>
								 <div class="alert-text"><?php echo $this->session->flashdata('message'); ?></div>
								<!-- <p class="text-muted font-weight-bold">Enter your username and password</p> -->
							</div>
							
						<form class="form" method="post" action="<?php echo base_url()?>ForgotPasswordAdmin"  id="kt_login_forgot1">
								
								<div class="form-group">
									<input class="form-control" type="email" placeholder="Email" name="email" id="email" value="" required />
									<!-- <div class="validation"></div> -->
									<?php if ($error): ?>
    									<div id="infoMessage"  class="text-danger"><?php echo form_error('email_address'); ?></div>
								<?php endif ?>
								</div>
								<div class="form-group d-flex flex-wrap flex-center">
									<button type="submit" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Submit</button>
									<a type="button" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-4" href="<?php echo base_url()?>admin">Cancel</a>
								</div>
						</form>
							
							

							<!--end::Form-->
						</div>
						<!--end::Signin-->
						
						

						<!--end::Forgot-->
					</div>

					<!--end::Content body-->
					<!--begin::Content footer for mobile-->
					<div class="d-flex d-lg-none flex-column-auto flex-column flex-sm-row justify-content-between align-items-center mt-5 p-5">
						<div class="text-dark-50 font-weight-bold order-2 order-sm-1 my-2">© 2020 Dr at Doorsteps</div>
						<div class="d-flex order-1 order-sm-2 my-2">
							<a href="#" class="text-dark-75 text-hover-primary">Privacy</a>
							<a href="#" class="text-dark-75 text-hover-primary ml-4">Legal</a>
							<a href="#" class="text-dark-75 text-hover-primary ml-4">Contact</a>
						</div>
					</div>
					<!--end::Content footer for mobile-->
				</div>
				<!--end::Content-->
			</div>
			<!--end::Login-->
		</div>
		<!--end::Main-->
		<script>var HOST_URL = "/metronic/theme/html/tools/preview";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->

		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="<?php echo base_url()?>assets/plugins/global/plugins.bundle.js"></script>
		<script src="<?php echo base_url()?>assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="<?php echo base_url()?>assets/js/scripts.bundle.js"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Scripts(used by this page)-->
		<!-- <script src="<?php echo base_url()?>assets/js/pages/custom/login/login-general.js"></script -->
			<script src="<?php echo base_url()?>assets/js/login.js"></script>
			<!-- <script src="<?php echo base_url()?>assets/js/validation/login.js"></script> -->
			<!-- <script src="<?php echo base_url(); ?>assets/js/login.js"></script> -->
		<script src="<?php echo base_url(); ?>assets/js/pages/crud/forms/widgets/select2.js"></script>



		<!--end::Page Scripts-->
	</body>
	<!--end::Body-->
</html>
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