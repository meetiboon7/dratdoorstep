<!DOCTYPE html>
<html lang="en"> 
	<!--begin::Head-->
	<head>
		<!-- Google Tag Manager -->
		<!-- <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&amp;l='+l:'';j.async=true;j.src= 'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','GTM-5FS8GGP');</script> -->
		<!-- End Google Tag Manager -->
		
		<meta charset="utf-8" />
		<title>DrAtDoorstep</title>
		<meta name="description" content="Updates and statistics" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<script type="text/javascript">
			var BASE_URL = "<?php echo base_url(); ?>";
		</script>

		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->

		<!--begin::Page Vendors Styles(used by this page)-->
		<link href="<?php echo base_url(); ?>assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
		<!--end::Page Vendors Styles-->
				<link href="<?php echo base_url(); ?>assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="<?php echo base_url(); ?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->

		<!--begin::Layout Themes(used by all pages)-->
		<link href="<?php echo base_url(); ?>assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/css/themes/layout/brand/light.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/css/themes/layout/aside/light.css" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		
		<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/media/favicon.ico" />
		<!-- Hotjar Tracking Code for keenthemes.com -->
		<script>(function(h,o,t,j,a,r){ h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)}; h._hjSettings={hjid:1070954,hjsv:6}; a=o.getElementsByTagName('head')[0]; r=o.createElement('script');r.async=1; r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv; a.appendChild(r); })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');</script>
	</head>
	<?php
    $this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
    $this->output->set_header('Cache-Control: no-cache, no-cache, must-revalidate');
    $this->output->set_header('Cache-Control: post-check=1, pre-check=1', false);
    $this->output->set_header('Pragma: no-cache');
    ?>
	<!--end::Head-->

	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<!-- Google Tag Manager (noscript) -->
		<noscript>
			<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FS8GGP" height="0" width="0" style="display:none;visibility:hidden"></iframe>
		</noscript>
		<!-- End Google Tag Manager (noscript) -->
		<!--begin::Main-->
		<!--begin::Header Mobile-->
		<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
			<!--begin::Logo-->
			<a href="#">
				<img alt="Logo" src="<?php echo base_url(); ?>assets/images/dad_logo.png" width="70" height="auto" />
			</a>
			<!--end::Logo-->
			<!--begin::Toolbar-->
			<div class="d-flex align-items-center">
				<!--begin::Aside Mobile Toggle-->
				<button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
					<span></span>
				</button>
				<!--end::Aside Mobile Toggle-->
				<!--begin::Header Menu Mobile Toggle-->
				<button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
					<span></span>
				</button>
				<!--end::Header Menu Mobile Toggle-->
				<!--begin::Topbar Mobile Toggle-->
				<button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
					<span class="svg-icon svg-icon-xl">
						<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/General/User.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
				</button>
				<!--end::Topbar Mobile Toggle-->
			</div>
			<!--end::Toolbar-->
		</div>
		<!--end::Header Mobile-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">
				<!--begin::Aside-->
				<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
					<!--begin::Brand-->
					<div class="brand flex-column-auto" id="kt_brand">
						<!--begin::Logo-->
						<a href="<?php echo base_url(); ?>user/dashboard" class="brand-logo">
							<img alt="Logo" src="<?php echo base_url(); ?>assets/images/dad_logo.png" width="70" height="auto" />
						</a>
						<!--end::Logo-->
						<!--begin::Toggle-->
						<button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
							<span class="svg-icon svg-icon svg-icon-xl">
								<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Navigation/Angle-double-left.svg-->
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24" />
										<path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
										<path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
									</g>
								</svg>
								<!--end::Svg Icon-->
							</span>
						</button>
						<!--end::Toolbar-->
					</div>
					<!--end::Brand-->
					<!--begin::Aside Menu-->
					<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
						<!--begin::Menu Container-->
						<div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
							<!--begin::Menu Nav-->
							<ul class="menu-nav">
								<li class="menu-item menu-item-active" aria-haspopup="true">
									<a href="<?php echo base_url()?>user/dashboard" class="menu-link">
										<span class="svg-icon menu-icon">
											<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Design/Layers.svg-->
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<polygon points="0 0 24 0 24 24 0 24" />
													<path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
													<path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
												</g>
											</svg>
											<!--end::Svg Icon-->
										</span>
										<span class="menu-text">Dashboard</span>
									</a>
								</li>
								
								<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
									
									
											
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="javascript:;" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-line">
														<span></span>
													</i>
													<span class="menu-text">Member</span>
													<i class="menu-arrow"></i>
												</a>
												<div class="menu-submenu">
													<i class="menu-arrow"></i>
													<ul class="menu-subnav">
														<li class="menu-item" aria-haspopup="true">
															<a href="<?php echo base_url().'userMember'?>" class="menu-link">
																<i class="menu-bullet menu-bullet-dot">
																	<span></span>
																</i>
																<span class="menu-text">List Member</span>
															</a>
														</li>
													</ul>
												</div>
											</li>
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="javascript:;" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-line">
														<span></span>
													</i>
													<span class="menu-text">Address</span>
													<i class="menu-arrow"></i>
												</a>
												<div class="menu-submenu">
													<i class="menu-arrow"></i>
													<ul class="menu-subnav">
														<li class="menu-item" aria-haspopup="true">
															<a href="<?php echo base_url().'userAddress'?>" class="menu-link">
																<i class="menu-bullet menu-bullet-dot">
																	<span></span>
																</i>
																<span class="menu-text">List Address</span>
															</a>
														</li>
													</ul>
												</div>
											</li>
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="javascript:;" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-line">
														<span></span>
													</i>
													<span class="menu-text">Feedback</span>
													<i class="menu-arrow"></i>
												</a>
												<div class="menu-submenu">
													<i class="menu-arrow"></i>
													<ul class="menu-subnav">
														<li class="menu-item" aria-haspopup="true">
															<a href="<?php echo base_url().'addComplain'?>" class="menu-link">
																<i class="menu-bullet menu-bullet-dot">
																	<span></span>
																</i>
																<span class="menu-text">Add Feedback</span>
															</a>
														</li>
													</ul>
												</div>
											</li>

											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="javascript:;" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-line">
														<span></span>
													</i>
													<span class="menu-text">Package</span>
													<i class="menu-arrow"></i>
												</a>
												<div class="menu-submenu">
													<i class="menu-arrow"></i>
													<ul class="menu-subnav">
														<li class="menu-item" aria-haspopup="true">
															<a href="<?php echo base_url().'userPackage'?>" class="menu-link">
																<i class="menu-bullet menu-bullet-dot">
																	<span></span>
																</i>
																<span class="menu-text">Package</span>
															</a>
														</li>
														<li class="menu-item" aria-haspopup="true">
															<a href="<?php echo base_url().'userMyPackage'?>" class="menu-link">
																<i class="menu-bullet menu-bullet-dot">
																	<span></span>
																</i>
																<span class="menu-text">My Package</span>
															</a>
														</li>
													</ul>
												</div>
											</li>
											
											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="javascript:;" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-line">
														<span></span>
													</i>
													<span class="menu-text">Appointment</span>
													<i class="menu-arrow"></i>
												</a>
												<div class="menu-submenu">
													<i class="menu-arrow"></i>
													<ul class="menu-subnav">
														<li class="menu-item" aria-haspopup="true">
															<a href="<?php echo base_url().'AppointmentList'?>" class="menu-link">
																<i class="menu-bullet menu-bullet-dot">
																	<span></span>
																</i>
																<span class="menu-text">Book an Appointment</span>
															</a>
														</li>

														<li class="menu-item" aria-haspopup="true">
															<a href="<?php echo base_url().'BookingHistory'?>" class="menu-link">
																<i class="menu-bullet menu-bullet-dot">
																	<span></span>
																</i>
																<span class="menu-text">Booking History</span>
															</a>
														</li>

														<!-- <li class="menu-item" aria-haspopup="true">
															<a href="<?php echo base_url().'DoctorAppointmentList'?>" class="menu-link">
																<i class="menu-bullet menu-bullet-dot">
																	<span></span>
																</i>
																<span class="menu-text">Doctor Appointment List</span>
															</a>
														</li>


														<li class="menu-item" aria-haspopup="true">
															<a href="<?php echo base_url().'NurseAppointmentList'?>" class="menu-link">
																<i class="menu-bullet menu-bullet-dot">
																	<span></span>
																</i>
																<span class="menu-text">Nurse Appointment List</span>
															</a>
														</li>


														<li class="menu-item" aria-haspopup="true">
															<a href="<?php echo base_url().'LabAppointmentList'?>" class="menu-link">
																<i class="menu-bullet menu-bullet-dot">
																	<span></span>
																</i>
																<span class="menu-text">Lab Appointment List</span>
															</a>
														</li>



														<li class="menu-item" aria-haspopup="true">
															<a href="<?php echo base_url().'PharmacyAppointmentList'?>" class="menu-link">
																<i class="menu-bullet menu-bullet-dot">
																	<span></span>
																</i>
																<span class="menu-text">Pharmacy Appointment List</span>
															</a>
														</li> -->



														<!-- <li class="menu-item" aria-haspopup="true">
															<a href="<?php echo base_url().'AmbulanceAppointmentList'?>" class="menu-link">
																<i class="menu-bullet menu-bullet-dot">
																	<span></span>
																</i>
																<span class="menu-text">Ambulance Appointment List</span>
															</a>
														</li> -->
														
													</ul>
												</div>
											</li>

											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="javascript:;" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-line">
														<span></span>
													</i>
													<span class="menu-text">Wallet</span>
													<i class="menu-arrow"></i>
												</a>
												<div class="menu-submenu">
													<i class="menu-arrow"></i>
													<ul class="menu-subnav">
														<li class="menu-item" aria-haspopup="true">
															<a href="<?php echo base_url().'userWallet'?>" class="menu-link">
																<i class="menu-bullet menu-bullet-dot">
																	<span></span>
																</i>
																<span class="menu-text">Add Wallet</span>
															</a>
														</li>
													</ul>
												</div>
											</li>

											<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
												<a href="javascript:;" class="menu-link menu-toggle">
													<i class="menu-bullet menu-bullet-line">
														<span></span>
													</i>
													<span class="menu-text">Voucher</span>
													<i class="menu-arrow"></i>
												</a>
												<div class="menu-submenu">
													<i class="menu-arrow"></i>
													<ul class="menu-subnav">
														<li class="menu-item" aria-haspopup="true">
															<a href="<?php echo base_url().'userVoucher'?>" class="menu-link">
																<i class="menu-bullet menu-bullet-dot">
																	<span></span>
																</i>
																<span class="menu-text">List Voucher</span>
															</a>
														</li>
													</ul>
												</div>
											</li>


											
											</li>

										
								</li>
							</ul>
							<!--end::Menu Nav-->
						</div>
						<!--end::Menu Container-->
					</div>
					<!--end::Aside Menu-->
				</div>
				<!--end::Aside-->
				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header header-fixed">
						<!-- <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
											<i class="fa fa-shopping-cart" aria-hidden="true"></i>
										</span> -->
						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-stretch justify-content-between">
							<!--begin::Header Menu Wrapper-->
							<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
								
							</div>
							<!--end::Header Menu Wrapper-->
							<!--begin::Topbar-->

							<div class="topbar">
								<!--begin::User-->

								<?php
								$this->db->select('*');
						        $this->db->from('cart');
						        $this->db->where('cart.user_id',$this->session->userdata('user')['user_id']);
						        $cart = $this->db->get()->result_array();
						        // echo count($cart);
						        // exit;
						        $cart_count=count($cart);

						        
								?>
								
									<div class="topbar-item">
									<div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle1">
										
										
										<span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
											<a href="<?php echo base_url().'userCart'?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i>	</a>
										</span>
										<?php 
										if($cart_count!=0)
										{
											?>
											<span class="label label-sm label-light-danger label-rounded font-weight-bolder" style="margin-bottom: 25px !important;"><?php echo $cart_count;?></span>
											<?php
										}
										?>
									</div>
								</div>
										
								
								
								<div class="topbar-item">
									<div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
										<span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
										<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"><?php echo ucfirst($this->session->userdata('user')['first_name'])." ".ucfirst($this->session->userdata('user')['last_name']);?></span>
										<span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
											<span class="symbol-label font-size-h5 font-weight-bold"><?php echo substr(strtoupper($this->session->userdata('user')['first_name']), 0,1)?></span>
										</span>
									</div>
								</div>
								<!--end::User-->
							</div>
							<!--end::Topbar-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5>
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
								<!--begin::Row-->
								<div class="row">
									<div class="col-lg-8 col-xxl-8">
										<!--begin::Mixed Widget 1-->
										<div class="card card-custom bg-gray-100 card-stretch gutter-b" style="height: calc(100% - 79px)">
											<!--begin::Header-->
											<div class="card-header border-0 bg-danger py-5">
												<h3 class="card-title font-weight-bolder text-white">Appointment Booking</h3>
												
											</div>
											<!--end::Header-->
											<!--begin::Body-->
											<div class="card-body p-0 position-relative overflow-hidden" >
												<!--begin::Chart-->
												<!-- <div id="kt_mixed_widget_1_chart" class="card-rounded-bottom bg-danger" style="height: 20px"></div> -->
												<!--end::Chart-->
												<!--begin::Stats-->

												<div class="card-spacer">
													<!--begin::Row-->
													<div class="row m-0">
														
														<div class="col bg-light-primary px-4 py-8 rounded-xl mr-7 mb-7" > 
															<a href="<?php echo base_url()?>addDoctorAppointment" class="text-primary font-weight-bold font-size-h6" >
															<center><img src="<?php echo base_url()?>uploads/image/doctor.svg" width="48px" height="48px" fill="#000"; /></center>
															<center>
															Doctor
															</center>
															</a>
														</div>
														
														<div class="col bg-light-primary px-4 py-8 rounded-xl mr-7 mb-7">
															<a href="<?php echo base_url()?>addNurseAppointment" class="text-primary font-weight-bold font-size-h6">
															<center><img src="<?php echo base_url()?>uploads/image/nurse.svg" width="48px" height="48px" fill="#000"; /></center>
															<center>
															Nurse
															</center>

														  </a>
														</div>
														<div class="col bg-light-primary px-4 py-8 rounded-xl mr-7 mb-7">
															<a href="<?php echo base_url()?>addLabAppointment" class="text-primary font-weight-bold font-size-h6">
															<center><img src="<?php echo base_url()?>uploads/image/lab.svg" width="48px" height="48px" fill="#000"; /></center>
															<center>
															Lab Test
															</center>
															</a>
														</div>
														<div class="col bg-light-primary px-6 py-8 rounded-xl mr-7 mb-7">
															<a href="<?php echo base_url()?>addPharmacyAppointment" class="text-primary font-weight-bold font-size-h6">
															<center><img src="<?php echo base_url()?>uploads/image/drug.svg" width="48px" height="48px" fill="#000"; /></center>
															<center>
															E-Pharmacy
															</center>
															</a>
														</div>
														<div class="col bg-light-primary px-6 py-8 rounded-xl mb-7" >
															<a href="<?php echo base_url()?>addAmbulanceAppointment" class="text-primary font-weight-bold font-size-h6">
															<center><img src="<?php echo base_url()?>uploads/image/ambulance.svg" width="48px" height="48px" fill="#000"; /></center>
															<center>
															Ambulance
															</center>
															</a>
														</div>

													</div>
													

													<!--end::Row-->
												</div>

												<!--end::Stats-->
											</div>
											<!--end::Body-->
										</div>
										<!--end::Mixed Widget 1-->
									</div>

									<div class="col-lg-4 col-xxl-4">
										<!--begin::Stats Widget 11-->
										<div class="card card-custom card-stretch card-stretch-half gutter-b" style="height: 75%;">
											<!--begin::Body-->
											<div class="card-header" style="background-color:#27395C !important;">
												<h3 class="card-title">
													<!-- <font color="#000000">My Wallet</font> -->
													<p style="color:white">My Wallet</p>
												</h3>
												</div>
											<div class="card-body" >
												<div class="flex-grow-1 p-12  flex-grow-1 bgi-no-repeat" >
															<h4 class="text-inverse-danger  font-weight-bolder" style="color:#27395C !important">HEALTH WALLET</h4>
															<p class="text-inverse-danger my-4" ><span style="font-size:30px;color:#27395C !important">₹ <?php

															 echo $user_balance['balance']; ?></span></p>
															<!-- <br>through product confidence.</p>
															<a href="#" class="btn btn-warning font-weight-bold py-2 px-6">Learn</a> -->
												</div>
													
											</div>
											<!--end::Body-->
										</div>
										<!--end::Stats Widget 11-->
										<!--begin::Stats Widget 12-->
										
										<!--end::Stats Widget 12-->
									</div>
								</div>
								<div class="row" style="margin-top: -5% !important;" >
									<div class="col-lg-12 col-xxl-12"  >
										<!--begin::Mixed Widget 1-->
										<div class="card card-custom  card-stretch gutter-b" >
											<!--begin::Header-->
											<!-- <div class="card-header border-0 bg-danger py-5">
												<h3 class="card-title font-weight-bolder text-white">My Package</h3>
												
											</div> -->
											<?php
										//	echo "<pre>";
											//print_r($all_holiday);
											?>
											<div class="card-header card-header-tabs-line">
												<div class="card-title">
													<h3 class="card-label">Today's Appointment</h3>
													
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
											<!--end::Header-->
											<!--begin::Body-->
											<div class="card-body tab_content" >
												<!--begin::Chart-->
												<!-- <div id="kt_mixed_widget_1_chart" class="card-rounded-bottom bg-danger" style="height: 20px"></div> -->
												<!--end::Chart-->
												<!--begin::Stats-->

												<div class="tab-content ">
													<!--begin::Table-->
													<div class="table-responsive">
														<form method="post">
														<table class="table table-head-custom table-head-bg table-borderless table-vertical-center" >
															<thead>
																<tr class="text-left text-uppercase">
																	<th style="min-width: 100px" ><span class="text-dark-75">Service</span></th>
																	<th style="min-width: 100px">
																		<span class="text-dark-75">Patient</span>
																	</th>
																	<th style="min-width: 100px"><span class="text-dark-75">Address</span></th>
																	<th style="min-width: 100px"><span class="text-dark-75">Date</span></th>
																	<th style="min-width: 100px"><span class="text-dark-75">Time</span></th>
																	<th style="min-width: 100px"><span class="text-dark-75">Action</span></th>
																	
																	
																</tr>
															</thead>
															<tbody>
																<?php

												foreach($appointment_book as $appointment){ 
													// echo "<pre>";
													// print_r($appointment);
													// echo "</pre>";
													?>
																<tr>
																	<td  class="mr-1">
																			
																			<div class="symbol symbol-50 symbol-light mr-4">
																				<span class="symbol-label">
																					<?php
																					if($appointment['appointment_book_id']!='')
																					{
																						?>
																						<img src="<?php echo base_url()?>uploads/image/doctor.svg" class="h-75 align-self-end" /> 
																						<?php
																					}
																					if($appointment['book_nurse_id']!='')
																					{
																						?>
																						<img src="<?php echo base_url()?>uploads/image/nurse.svg" class="h-75 align-self-end" />
																						<?php
																					}
																				if($appointment['book_laboratory_test_id']!='')
																					{
																						?>
																						<img src="<?php echo base_url()?>uploads/image/lab.svg" class="h-75 align-self-end" />
																						<?php
																					}
																					if($appointment['book_medicine_id']!='')
																					{
																						?>
																						<img src="<?php echo base_url()?>uploads/image/drug.svg" class="h-75 align-self-end" />
																						<?php
																					}
																					if($appointment['book_ambulance_id']!='')
																					{
																						?>
																						<img src="<?php echo base_url()?>uploads/image/ambulance.svg" class="h-75 align-self-end" />
																						<?php
																					}
																					?>
																					
																				</span>
																			</div>
																			
																		
																	</td>
																	<td class="mr-7">
																		<div class="d-flex">
																			
																			<div>
																				<a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"><?php echo $appointment['name']?></a>
																				<span class="text-muted font-weight-bold d-block"><?php echo $appointment['contact_no']?></span>
																			</div>
																		</div>
																	</td>
																	<td class="mr-7">
																		<span class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg"><?php echo $appointment['address_1']." ".$appointment['address_2']?></span>
																		
																	</td>
																	<td class="mr-7">
																		<span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo date("d-m-Y",strtotime($appointment['date'])); ?></span>
																		
																	</td>
																	<td class="mr-7">
																		<span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $appointment['time']?></span>
																		
																	</td>
																	<?php
																	// echo "<pre>";
																	// print_r($appointment);
																	if($appointment['appointment_book_id']!='')
																	{
																						?>
																	<td class="mr-7" nowrap="nowrap">
																		
																						
																			<button formaction="<?php echo base_url(); ?>viewBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['appointment_book_id']; ?>,<?php echo "1";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		<i class="fa fa-eye" aria-hidden="true"></i>

																		</button>
																	</td>
																	<?php
																}
																elseif($appointment['book_nurse_id']!='')
																	{
																						?>
																	<td  class="mr-7"nowrap="nowrap">
																		
																						
																			<button formaction="<?php echo base_url(); ?>viewBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['book_nurse_id']; ?>,<?php echo "2";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		<i class="fa fa-eye" aria-hidden="true"></i>

																		</button>
																	</td>
																	<?php
																}
																elseif($appointment['book_laboratory_test_id']!='')
																	{
																						?>
																	<td  class="mr-7" nowrap="nowrap">
																		
																						
																			<button formaction="<?php echo base_url(); ?>viewBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['book_laboratory_test_id']; ?>,<?php echo "3";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		<i class="fa fa-eye" aria-hidden="true"></i>

																		</button>
																	</td>
																	<?php
																}
																elseif($appointment['book_medicine_id']!='')
																	{
																						?>
																	<td class="mr-7" nowrap="nowrap">
																		
																						
																			<button formaction="<?php echo base_url(); ?>viewBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['book_medicine_id']; ?>,<?php echo "4";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		<i class="fa fa-eye" aria-hidden="true"></i>

																		</button>
																	</td>
																	<?php
																}
																elseif($appointment['book_ambulance_id']!='')
																	{
																						?>
																	<td class="mr-7" nowrap="nowrap">
																		
																						
																			<button formaction="<?php echo base_url(); ?>viewBookingHistory" name="btn_appointment_assign" value="<?php echo $appointment['book_ambulance_id']; ?>,<?php echo "5";?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

																		<i class="fa fa-eye" aria-hidden="true"></i>

																		</button>

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
													</form>
													</div>
													
													<!--end::Table-->
												</div>

												<!--end::Stats-->
											</div>

											<div class="display_user_today_appointment"></div>
											<!--end::Body-->
										</div>
										<!--end::Mixed Widget 1-->
									</div>

									
								</div>

								<div class="row">
									<div class="col-lg-6 col-xxl-6">
										<!--begin::Mixed Widget 1-->
										<div class="card card-custom bg-gray-100 card-stretch gutter-b" >
											<!--begin::Header-->
											<div class="card-header border-0 bg-danger py-5">
												<h3 class="card-title font-weight-bolder text-white">My Package</h3>
												
											</div>
											<!--end::Header-->
											<!--begin::Body-->
											<div class="card-body p-0 position-relative overflow-hidden" >
												<!--begin::Chart-->
												<!-- <div id="kt_mixed_widget_1_chart" class="card-rounded-bottom bg-danger" style="height: 20px"></div> -->
												<!--end::Chart-->
												<!--begin::Stats-->

												<div class="tab-content ">
													<!--begin::Table-->
													<div class="table-responsive">
														<table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
															<thead>
																<tr class="text-center text-uppercase">
																	<th style="min-width: 100px"  class="pl-7"><span class="text-dark-75">Name</span></th>
																	<th style="min-width: 100px"><span class="text-dark-75">Service</span></th>
																	<th style="min-width: 100px">
																		<span class="text-dark-75">Package</span>
																	</th>
																	<th style="min-width: 100px"><span class="text-dark-75">Valid till</span></th>
																	<th style="min-width: 100px"><span class="text-dark-75">Available visit</span></th>
																	
																	
																</tr>
															</thead>
															<tbody>
																<?php

												foreach($manage_package as $package){ 
													// echo "<pre>";
													// print_r($appointment);
													// echo "</pre>";
													$left_available_visit=$package['available_visit'];
													?>
																<tr class="text-center">
													<!-- <td class="mr-7"><a href="<?php echo base_url('userViewMyPackage/'.$package['book_package_id']); ?>"><?php echo $package['name']; ?></a></td> -->
													<td class="mr-7"><?php echo $package['name']; ?></a></td>
													<td class="mr-7"><?php echo $package['user_type_name']; ?></td>
													<td class="mr-7"><?php echo $package['package_name'] ?></td>
													<td class="mr-7"><?php echo date("d-m-Y",strtotime($package['expire_date'])); ?></td>
													<td class="mr-7"><?php echo $left_available_visit; ?></td>
													
													
													</tr>
																<?php
															}
															?>
																
															</tbody>
														</table>
													</div>
													
													<!--end::Table-->
												</div>

												<!--end::Stats-->
											</div>
											<!--end::Body-->
										</div>
										<!--end::Mixed Widget 1-->
									</div>

									<div class="col-lg-6 col-xxl-6">
										<!--begin::Stats Widget 11-->
										<div class="card card-custom bg-gray-100 card-stretch gutter-b" >
											<!--begin::Body-->
											
												<div class="card-header border-0 bg-danger py-5" style="background-color:#27395C !important;">
												<h3 class="card-title font-weight-bolder text-white">Package</h3>
												
											</div>
											<div class="card-body" >
												<div class="tab-content">
													<!--begin::Table-->
													<div class="table-responsive">
														<form method="post">
														<table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
															<thead>
																<tr class="text-left text-uppercase">
																	<!-- <th style="min-width: 100px" class="pl-7"><span class="text-dark-75">Service</span></th> -->
																	<th style="min-width: 20px" ><span class="text-dark-75"></span></th>
																	<th style="min-width: 100px" ><span class="text-dark-75">Service</span></th>
																	<th style="min-width: 100px"><span class="text-dark-75">Name</span></th>
																	
																	<th style="min-width: 100px"><span class="text-dark-75">Amount</span></th>
																	<th style="min-width: 100px"><span class="text-dark-75">Action</span></th>
																	
																</tr>
															</thead>
															<tbody>
																	<?php

												foreach($book_package as $b_package){ 
													// echo "<pre>";
													// print_r($appointment);
													// echo "</pre>";

													 $date = $b_package['purchase_date'];
													$date = strtotime($date);
													$expired_date = strtotime("+".$b_package['validate_month']."day", $date);
													 $expired_date = date('Y-m-d', $expired_date);
													
													$left_available_visit=$b_package['no_visit'] - $b_package['available_visit'];
													$today=date('Y-m-d');


												if($today < $expired_date){

													
													?>
																<tr>
																	<td >
																			
																			<!-- <div class="symbol symbol-50 symbol-light"> -->
																				<!-- <span class="symbol-label"> -->
																					<?php
																					if($b_package['service_id']==1)
																					{
																						?>
																						<img src="<?php echo base_url()?>uploads/image/doctor.svg" class="h-55 align-self-end" /> 
																						
																						<?php
																					}
																					if($b_package['service_id']==2)
																					{
																						?>
																						<img src="<?php echo base_url()?>uploads/image/nurse.svg" class="h-55 align-self-end" />
																						
																						<?php
																					}
																				if($b_package['service_id']==3)
																					{
																						?>
																						<img src="<?php echo base_url()?>uploads/image/lab.svg" class="h-55 align-self-end" />
																						
																						<?php
																					}
																					if($b_package['service_id']==4)
																					{
																						?>
																						<img src="<?php echo base_url()?>uploads/image/drug.svg" class="h-55 align-self-end" />
																						
																						<?php
																					}
																					if($b_package['service_id']==5)
																					{
																						?>
																						<img src="<?php echo base_url()?>uploads/image/ambulance.svg" class="h-55 align-self-end" />
																						
																						<?php
																					}
																					?>
																					
																				<!-- </span> -->
																			<!-- </div> -->
																			
																		
																	</td>
																	<td >
																			
																			<div class="symbol symbol-50 symbol-light mr-4">
																				<span class="symbol-label">
																					<?php
																					if($b_package['service_id']==1)
																					{
																						?>
																						 
																						<span><?php echo $b_package['user_type_name'];?></span>
																						<?php
																					}
																					if($b_package['service_id']==2)
																					{
																						?>
																						
																						<span><?php echo $b_package['user_type_name'];?></span>
																						<?php
																					}
																				if($b_package['service_id']==3)
																					{
																						?>
																						
																						<span><?php echo $b_package['user_type_name'];?></span>
																						<?php
																					}
																					if($b_package['service_id']==4)
																					{
																						?>
																						
																						<span><?php echo $b_package['user_type_name'];?></span>
																						<?php
																					}
																					if($b_package['service_id']==5)
																					{
																						$text=$b_package['user_type_name'];
																						function limit_text($text, $limit) {
																					    if (str_word_count($text, 0) > $limit) {
																					        $words = str_word_count($text, 2);
																					        $pos   = array_keys($words);
																					        $text  = substr($text, 0, $pos[$limit]) . '...';
																					    }
																					    return $text;
																					}



																						?>
																						
																						<span><?php echo limit_text($b_package['user_type_name'], 1);?></span>
																						<?php
																					}
																					?>
																					
																				</span>
																			</div>
																			
																		
																	</td>
																	<td><?php echo $b_package['package_name'] ?></td>
																	<td><?php echo $b_package['fees_name']; ?></td>
													
													
													
													<td nowrap="nowrap">
													
														<button formaction="<?php echo base_url(); ?>userViewPackage" name="btn_view_package" value="<?php echo $b_package['package_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="View Package">

															<i class="fa fa-eye" aria-hidden="true"></i>

														</button>

													</td>
																	
																</tr>
																<?php
															}
															
														}
															?>
																															
															</tbody>
														</table>
														</form>
													</div>
													<!--end::Table-->
												</div>
													
											</div>
											<!--end::Body-->
										</div>
										<!--end::Stats Widget 11-->
										<!--begin::Stats Widget 12-->
										
										<!--end::Stats Widget 12-->
									</div>
								</div>
								<!--end::Row-->
								<!--end::Dashboard-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					<!--end::Content-->
					<!--begin::Footer-->
					<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
						<!--begin::Container-->
						<div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<span class="text-muted font-weight-bold mr-2"><?php echo date('Y')?>©</span>
								<a href="#" target="_blank" class="text-dark-75 text-hover-primary">Dr at Doorsteps</a>
							</div>
							<!--end::Copyright-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Main-->
		<!-- begin::User Panel-->
		<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
			<!--begin::Header-->
			<div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
				<h3 class="font-weight-bold m-0">User Profile 
				<!-- <small class="text-muted font-size-sm ml-2">12 messages</small></h3> -->
				<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
					<i class="ki ki-close icon-xs text-muted"></i>
				</a>
			</div>
			<!--end::Header-->
			<!--begin::Content-->
			<div class="offcanvas-content pr-5 mr-n5">
				<!--begin::Header-->
				<div class="d-flex align-items-center mt-5">
					<div class="symbol symbol-100 mr-5">
						<div class="symbol-label" style="background-image:url('<?php echo base_url().'uploads/user_profile/'.$this->session->userdata('user')['profile_pic'];?>"></div>
						<i class="symbol-badge bg-success"></i>
					</div>
					<div class="d-flex flex-column">
						<a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?php echo $this->session->userdata('user')['email']; ?></a>
						<!-- <div class="text-muted mt-1">Application Developer</div> -->
						<div class="navi mt-2">
							<!-- <a href="#" class="navi-item">
								<span class="navi-link p-0 pb-2">
									<span class="navi-icon mr-1">
										<span class="svg-icon svg-icon-lg svg-icon-primary">
											
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000" />
													<circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5" />
												</g>
											</svg>
											
										</span>
									</span>
									<span class="navi-text text-muted text-hover-primary">jm@softplus.com</span>
								</span>
							</a> -->
							<?php
							$logOut; 
							if(isset($this->session->userdata('user')['id'])){
								$logOut = base_url(); 
							}else{
								$logOut = base_url();  
							}
							?>
							<a href="<?php echo $logOut; ?>" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">Sign Out</a>
							<!-- <a href="#" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">Sign Out</a> -->
						</div>
					</div>
				</div>
				<!--end::Header-->
				<!--begin::Separator-->
				<div class="separator separator-dashed mt-8 mb-5"></div>
				<!--end::Separator-->
				<!--begin::Nav-->
				<div class="navi navi-spacer-x-0 p-0">
					<!--begin::Item-->
					<a href="<?php echo base_url().'userProfile/MyProfile'?>" class="navi-item">
						<div class="navi-link">
							<div class="symbol symbol-40 bg-light mr-3">
								<div class="symbol-label">
									<span class="svg-icon svg-icon-md svg-icon-success">
										<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/General/Notification2.svg-->
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<path d="M13.2070325,4 C13.0721672,4.47683179 13,4.97998812 13,5.5 C13,8.53756612 15.4624339,11 18.5,11 C19.0200119,11 19.5231682,10.9278328 20,10.7929675 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 L13.2070325,4 Z" fill="#000000" />
												<circle fill="#000000" opacity="0.3" cx="18.5" cy="5.5" r="2.5" />
											</g>
										</svg>
										<!--end::Svg Icon-->
									</span>
								</div>
							</div>
							<div class="navi-text">
								<div class="font-weight-bold">My Profile</div>
								<!-- <div class="text-muted">Account settings and more 
								<span class="label label-light-danger label-inline font-weight-bold">update</span></div>-->
							</div> 
						</div>
					</a>
					<!--end:Item-->
					<!--begin::Item-->
					
					<!--end:Item-->
				</div>
				<!-- <div class="navi navi-spacer-x-0 p-0">
					<a href="<?php echo base_url(); ?>adminProfile/Reset" class="navi-item">
						<div class="navi-link">
							<div class="symbol symbol-40 bg-light mr-3">
								<div class="symbol-label">
									<span class="svg-icon svg-icon-md svg-icon-success">
									
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24" />
												<path d="M13.2070325,4 C13.0721672,4.47683179 13,4.97998812 13,5.5 C13,8.53756612 15.4624339,11 18.5,11 C19.0200119,11 19.5231682,10.9278328 20,10.7929675 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 L13.2070325,4 Z" fill="#000000" />
												<circle fill="#000000" opacity="0.3" cx="18.5" cy="5.5" r="2.5" />
											</g>
										</svg>
									
									</span>
								</div>
							</div>
							<div class="navi-text">
								<div class="font-weight-bold">Change Password</div>
								
							</div>
						</div>
					</a>
</div> -->
				<!--end::Nav-->
				<!--begin::Separator-->
				<div class="separator separator-dashed my-7"></div>
				<!--end::Separator-->
			</div>
			<!--end::Content-->
		</div>
		<!-- end::User Panel-->
		
		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop">
			<span class="svg-icon">
				<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Navigation/Up-2.svg-->
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
						<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
					</g>
				</svg>
				<!--end::Svg Icon-->
			</span>
		</div>
		<!--end::Scrolltop-->
		
		

		


		<script>var HOST_URL = "/metronic/theme/html/tools/preview";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="<?php echo base_url(); ?>assets/plugins/global/plugins.bundle.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/scripts.bundle.js"></script>
		<!--end::Global Theme Bundle-->

		<!--begin::Page Vendors(used by this page)-->
		<script src="<?php echo base_url(); ?>assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
		<!--end::Page Vendors-->

		<!--begin::Page Scripts(used by this page)-->
		<script src="<?php echo base_url(); ?>assets/js/pages/widgets.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/pages/crud/forms/widgets/select2.js"></script>
		<!--end::Page Scripts-->

	</body>
	<!--end::Body-->
</html>
<style type="text/css">
	
</style>
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
         //Find the href attribute value to identify the active tab + content
        //var idAttr = $(this).attr('id');
      // alert(activeTab);
        if(id != '') {
        	//alert("test");
          $.ajax({
           type: "POST",
            url: "<?php echo base_url('todayUserAppointment'); ?>",
            data: {id:id},
            dataType: "HTML",
            success: function(html) {
            	// $(".tab_content").show();
            	//alert(html);
			$('.display_user_today_appointment').html(html);

          		// $(activeTab).html(response);
            }
          });
        }

     
    });

});

</script>