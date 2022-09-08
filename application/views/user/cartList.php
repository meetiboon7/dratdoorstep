<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Cart List</h5>
									<!--end::Page Title-->
								</div>
								<!--end::Info-->
							</div>
						</div>
						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
								<!--begin::Page Layout-->
								<div class="d-flex flex-row">
	<!--begin::Layout-->
									<div class="flex-row-fluid ml-lg-8">
										<!--begin::Section-->
										<div class="card card-custom gutter-b">
											<!--begin::Header-->
											<!-- <div class="card-header flex-wrap border-0 pt-6 pb-0">
												<h3 class="card-title align-items-start flex-column">
													<span class="card-label font-weight-bolder font-size-h3 text-dark">My Shopping Cart</span>
												</h3>
												<div class="card-toolbar">
													<div class="dropdown dropdown-inline">
														<a href="#" class="btn btn-primary font-weight-bolder font-size-sm">Continue Shopping</a>
													</div>
												</div>
											</div> -->
											<!--end::Header-->
											
											<div class="card-body">
												<!--begin::Shopping Cart-->

												<?php
														// echo "<pre>";
														// print_r($cart_data_list);
														if(count($cart_data_list)>0){
															?>
												<div class="table-responsive">
													<form method="POST" action="<?php echo base_url(); ?>responsePayment">
													<table class="table" >
														<!--begin::Cart Header-->

														<thead>
															<tr>
																<th >Service / Package</th>
																<th >Date</th>
																<th >Patient</th>
																<th colspan="2" style="text-align: right;">Amt</th>
																<th colspan="2"  style="text-align: left;">Action</th>
																<!-- <th ></th> -->
															</tr>
														</thead>
														
														<tbody>
															<?php
															// echo "<pre>";
															// print_r($cart_data_list);
															// echo "</pre>";
													//	echo count($cart_data_list);

												foreach($cart_data_list as $cart){

													// echo "<pre>";
													// print_r($cart);
													// echo "</pre>";

												?>

															<!--begin::Cart Content-->

															<tr>
																<input type="hidden" name="service_type_id" id="service_type_id_test" value="<?php echo $cart['user_type_id']; ?>">

																<input type="hidden" name="cart_id[]" id="cart_id" value="<?php echo $cart['cart_id']; ?>">

																<input type="hidden" name="amounts[]" id="amounts" value="<?php echo $cart['amount']; ?>">

																


																<input type="hidden" name="package_id" id="package_id" value="<?php echo $cart['package_id']; ?>">
																<?php
																if($cart['package_id']==0)
																{
																	?>
																	<td>

																		<?php 
																		if($cart['lab_test_type_name']==''){
																			echo $cart['user_type_name'];
																		}
																		else{
																			echo $cart['user_type_name']." ( ".$cart['lab_test_type_name']." )";
																		}

																		 ?></td>
																	<?php
																}
																else
																{
																	?>
																	<td><?php echo $cart['package_name']; ?></td>
																	<?php
																}
																?>
																	<td><?php echo date("d-m-Y",strtotime($cart['date']))." ".$cart['time']; ?></td>
																<td><?php echo ucwords($cart['name']); ?></td>
																<td colspan="2" style="text-align: right;">₹ <?php echo $cart['amount']; ?></td>

																<td nowrap="nowrap" style="text-align: left;">
																	
																	<button type="button" class="btn btn-sm btn-clean btn-icon mr-2 btn-delete deleteCart" id="<?php echo $cart['cart_id'];?>"> <i class="flaticon-delete"></i></button>
																	<!-- <a href="#" class="btn btn-sm btn-clean btn-icon mr-2 btn-delete" data-id="<?php echo $am['address_id'];  ?>"></a> -->

																	<?php
																	if($cart['user_type_id']==1)
																	{
																		?>
																		<button formaction="<?php echo base_url(); ?>editDoctorCart" name="btn_edit_cart" 
															value="<?php echo $cart['cart_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Edit cart">	             
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
																	else if($cart['user_type_id']==2)
																	{
																		?>
																		<button formaction="<?php echo base_url(); ?>editNurseCart" name="btn_edit_cart" 
															value="<?php echo $cart['cart_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Edit cart">	             
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
																	else if($cart['user_type_id']==3)
																	{
																		?>
																		<button formaction="<?php echo base_url(); ?>editLabCart" name="btn_edit_cart" 
															value="<?php echo $cart['cart_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Edit cart">	             
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
																	else if($cart['user_type_id']==5)
																	{
																		?>
																		<button formaction="<?php echo base_url(); ?>editAmbulanceCart" name="btn_edit_cart" 
															value="<?php echo $cart['cart_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Edit cart">	             
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
																	?>
																	
																</td>


															</tr>
															<?php
															 $item_total += $cart["amount"];
															  $user_id = $cart["user_id"];
															
															}
															
														
															//echo  $item_total;
															
														
															?>
															<!--end::Cart Content-->
															<!--begin::Cart Footer-->
															<?php 
															//echo $user_id;
															if($user_id!='')
															{
															?>
															
															<tr>
																<td colspan="0"></td>
																<?php
																
																if ($this->session->userdata('user')['balance'] == 0) {
                        
												                       ?>
												                       <td><label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
																		<input type="checkbox" name="wallet_deduction" id="wallet_deduction" class="checkbox_check" value="0.00"> 
																		<span></span>&nbsp;&nbsp; Use Wallet Balance :</label><br><br><br><br>
																		<label><b>*Other Charges extra</b></label></td>
												                        <!--  <td class="font-size-h4" style="text-align: right;">Wallet Balance :</td> -->
																		
																		   
												                       <?php
												                      //  exit;
												                    }
												                    else if($this->session->userdata('user')['balance'] > 50)
												                    {

												                    	?>
												                    	<td  colspan="2"><label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
																		<input type="checkbox" name="wallet_deduction" id="wallet_deduction" class="checkbox_check"  value="50.00"> 
																		<span></span>&nbsp;&nbsp;<!-- <b><div id="show"></div></b> --> Use Wallet Balance :</label><br><br><br><br>
																		<label><b>*Other Charges extra</b></label></td>
																		
												                              <!--  <td class="font-size-h4" style="text-align: right;"></td> -->
																		
																		   
												                   <?php }
												                    else
												                    {
												                    	?>
												                    	<td><label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
																		<input type="checkbox" name="wallet_deduction" class="checkbox_check" id="wallet_deduction" value="<?php echo $this->session->userdata('user')['balance']?>"> 
																		<span></span>&nbsp;&nbsp;<!-- <b><div id="show"></div></b> -->Use Wallet Balance :</label><br><br><br><br>
																		<label><b>*Other Charges extra</b></label></td>
																		
												                           <!--  <td class="font-size-h4" style="text-align: right;">Wallet Balance :</td> -->
																		
																		   
												                            <?php
												                    }	
												                    	
                    
																?>
																
																
															<td class="font-size-h4" width="20%">
																<label style="width: 100%;font-size: 1.05rem !important;">Total</label>
																<label style="width: 100%;font-size: 1.05rem !important;">Discount</label>
																<label style="width: 100%;font-size: 1.05rem !important;">Wallet</label>
																<label style="width: 100%;font-size: 1.05rem !important;">Grand Total</label>

															</td>
															<td class="font-size-h4" style="color:black;text-align: right;">
																<input type="hidden" readonly="" style=" background-color: transparent;border: 0px solid;" class="form-control font-size-h4" id="total_price_hidden" name="total_price" value="<?php echo number_format((float)$item_total, 2, '.', '');?>">

																<input type="text" style=" background-color: transparent;border: 0px solid;margin-top: -7px;margin-left:10px; text-align: right;" id="main_total"  disabled="disabled" value="₹ <?php echo number_format((float)$item_total, 2, '.', '');?>"> 

																<input type="text"  style=" background-color: transparent;border: 0px solid;margin-top: -7px;margin-left:10px; text-align: right;" class="form-control font-size-h4" id="voucher_discount" name="voucher_discount" value="">

																<input type="text"  style=" background-color: transparent;border: 0px solid; margin-top: -7px;margin-left:10px; text-align: right;"  readonly="" class="form-control font-size-h4" disabled="disabled" class="form-control font-size-h4" id="wallet_show" name="wallet_show" value="">

																<input type="text" readonly="" style=" background-color: transparent;border: 0px solid;margin-top: -17px;margin-left:10px; text-align: right;" class="form-control font-size-h4" id="grand_total" name="grand_total" value="">
																<input type="hidden"  class="form-control font-size-h4" id="voucher_id" name="voucher_id" value="">

															</td>
															<!-- <td class="font-size-h4" width="20%">
																<label>Total</label>
																<lable id='discount_lable' style="display: none;">Discount</lable><br>								<lable id='show' style="display: none;">Wallet</lable><br>
																<label id="grand_total_lable" style="display: none;">Grand Total</label><br>
															</td>	 -->															
																
																<!-- <input type="hidden" readonly="" style=" background-color: transparent;border: 0px solid;" class="form-control font-size-h4" id="total_price_hidden" name="total_price" value="<?php echo number_format((float)$item_total, 2, '.', '');?>"> -->
																<!-- <td class="font-weight-bolder font-size-h4" >R.s</td> -->
																<!-- <td class="font-size-h4" style="color:black;text-align: right;"> -->
																	<!-- <input type="text" style=" background-color: transparent;border: 0px solid;margin-top: -7px;margin-left:10px;"> ₹ <?php echo number_format((float)$item_total, 2, '.', '');?><br> -->
																	
																	 <!-- <input type="text" disabled="disabled" style=" background-color: transparent;border: 0px solid;margin-top: -7px;margin-left:10px;" class="form-control font-size-h4" id="voucher_discount" name="voucher_discount" value=""> -->
																	  <!-- <input type="text"  style=" background-color: transparent;border: 0px solid; margin-top: -7px;margin-left:10px;"  readonly="" class="form-control font-size-h4" disabled="disabled" class="form-control font-size-h4" id="wallet_show" name="wallet_show" value=""> -->
																	 <!-- <input type="text" readonly="" style=" background-color: transparent;border: 0px solid;margin-top: -17px;margin-left:10px;" class="form-control font-size-h4" id="grand_total" name="grand_total" value=""> -->
																	
																	 
																	 
																	  
																<!-- </td> -->
																
																
																


																
																<!-- <div id='ResponseDiv'>
       																	 This is a div to hold the response.
																</div> -->
																
															</tr>
															
															<?php
														}

														?>
														
															<!-- <tr>
																<td colspan="4" class="border-0 text-muted text-right pt-0">Notice</td>
															</tr> -->
															<tr>
																<td colspan="2" class="border-0 pt-10">
																	
																		<div class="form-group row">
																			<div class="col-md-3 d-flex align-items-center">
																				<label class="font-weight-bolder" for="promo_code">Apply Voucher</label>
																			</div>

																			<div class="col-md-9">

																				<div class="input-group w-100">
																					<input type="text" class="form-control" placeholder="Voucher Code" name="coupon_code" id="coupon_code" />
																					<div class="input-group-append">
																						<button id="apply" class="btn btn-secondary" type="button">Apply</button>
																					</div>
																				</div>
																				<b><span id="message" style="color:green;"></span></b>
																			</div>
																		</div>
																	
																</td>

																<?php
																if($item_total!=0)
																{
																	?>
																	<td colspan="3" class="border-0 text-right pt-10">
																	<!-- <a href="#" class="btn btn-success font-weight-bolder px-8">Proceed to Checkout</a> -->
																	<button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Process to Pay</button>
																    </td>
																	<?php
																}
																?>
																
															</tr>
															<!--end::Cart Footer-->
														</tbody>
														
													</table>
													<input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user')['user_id']; ?>"/>
<input type="hidden" name="REQUEST_TYPE" value="SEAMLESS"/>
<input type="hidden" name="ORDER_ID" value="<?php echo  "ORDS" . rand(10000,99999999)?>"/>
<input type="hidden" name="INDUSTRY_TYPE_ID" value="Retail"/>
<input type="hidden" name="CHANNEL_ID" value="WEB"/>
													</form>
												</div>
												<?php
														
														}
														else
														{
															?>
															<center><h1><label style="color:red">Your Cart is empty</label></h1></center>
															<?php
															
														}
														?>
												<!--end::Shopping Cart-->
											</div>
											
										</div>
										<!--end::Section-->
										
									</div>
									
									<!--end::Layout-->
<!--end::Content-->
</div>
</div>
</div>
</div>
<script type="text/javascript">
	$(".deleteCart").click(function() 
{
		
		   //var cart_id = $(this).attr('value');
		   var cart_id = $(this).attr('id');
		  // alert(cart_id);
		  // $clicked_btn = $(this);
		   //alert(href);
		   jQuery.ajax({
			url: "<?php echo base_url('removeCartRecord'); ?>",
			type: "POST",
			dataType: 'json',
			data: {cart_id:cart_id},
			success: function(res) 
			{
				window.location.href = '<?php echo base_url('userCart'); ?>';
				//alert(res);
				//$(this).closest('tr').remove();
				// $clicked_btn.parent().remove();
				// if(res==1)
				// {
				// 	alert('Data saved successfully');	
				// }
				// else
				// {
				// 	alert('Data not saved');	
				// }
				
			},
			error:function()
			{
				//alert('data not saved');	
			}
		});
		
	});

$('#wallet_deduction').on('click', function() {

	//var checkboxClick=$(this).addClass('checkBoxCheck');
	
	//alert(wallet_deduction);
	var total_price_hidden=$('#main_total').val();
	//alert(total_price_hidden);
	var grand_total=$("#grand_total").val();
	//alert(grand_total);
	var voucher_discount=$("#voucher_discount").val();
	// alert(total_price_hidden);
	// alert(voucher_discount);
	//var wallet_deduction


	if(total_price_hidden!='' && grand_total=='')
	{
		// .html()
		//alert("1");


var wallet_deduction= $('#wallet_deduction').val();
			var str =grand_total;
			//alert(str);
			var ret = str.split(" ");
			var str1 = ret[0];
			var str2 = ret[1];

			var dis=voucher_discount;
			var retvou = dis.split(" ");
			var voustr1 = retvou[0];
			var voustr2 = retvou[1];

			var main=total_price_hidden;
			var rettot = main.split(" ");
			var totstr1 = rettot[0];
			var totstr2 = rettot[1];

			//alert(voustr2);
			 var grand_total_display=totstr2 - wallet_deduction;
			 //alert(grand_total_display);
		$('#show').show();
		//$('#wallet_show').val(this.checked ? wallet_deduction : '').css({ 'color': 'black','text-align':'right'});
		$('#wallet_show').val(this.checked ? '₹ ' + wallet_deduction : '').css({ 'color': 'black','text-align':'right'});
		if ($('input.checkbox_check').is(':checked')) 
		{
			//alert("1");
			$("#grand_total").val(this.checked ? '₹ ' + grand_total_display.toFixed(2): '');
		}
		else if($(".checkbox_check").prop('checked', false))
		{
			//alert("2");
			$("#grand_total").val();
		}
		
	}
	else if(total_price_hidden!='' && grand_total!='')
	{
		
		var str =grand_total;
		var ret = str.split(" ");
		var str1 = ret[0];
		var str2 = ret[1];

		var dis=voucher_discount;
		var retvou = dis.split(" ");
		var voustr1 = retvou[0];
		var voustr2 = retvou[1];

		var main=total_price_hidden;
		var rettot = main.split(" ");
		var totstr1 = rettot[0];
		var totstr2 = rettot[1];

		var grand_total_display=totstr2 - voustr2;
	 
		$('#show').show();
		
		//$('#grand_total').val(grand_total_display);
		$("#grand_total").val('₹ ' + grand_total_display.toFixed(2));
		
		if ($('input.checkbox_check').is(':checked')) 
		{
			//alert("3");
			
			var wallet_deduction= $('#wallet_deduction').val();
			//alert("3");
			//var grand_total_display=totstr2 - voustr2 - wallet_deduction ;

			//alert(grand_total_display);
			$('#wallet_show').val(this.checked ? '₹ ' + wallet_deduction : '').css({ 'color': 'black','text-align':'right'});
			//$("#grand_total").val(this.checked ? '₹ ' + grand_total_display.toFixed(2): '');
			var total_price_hidden_main=$('#main_total').val();
			var totbal = total_price_hidden_main.split(" ");
			var tstr1 = totbal[0];
			var tstr2 = totbal[1];

			var dis=voucher_discount;
			var retvou = dis.split(" ");
			var voustr1 = retvou[0];
			var voustr2 = retvou[1];

			var grand_total_display1=tstr2 - voustr2 - wallet_deduction;
			var grand_total_display2=tstr2 - wallet_deduction;
			//alert(grand_total_display1);
		//	$("#grand_total").val('₹ ' + grand_total_display1.toFixed(2));
			$("#grand_total").val(this.checked ? '₹ ' + grand_total_display1.toFixed(2) : grand_total_display2.toFixed(2));

		}
		else if($(".checkbox_check").prop('checked', false))
		{
			//alert("4");
			var wallet_deduction= $('#wallet_deduction').val();
			$('#wallet_show').val(this.checked ? '₹ ' + wallet_deduction : '').css({ 'color': 'black','text-align':'right'});
			
			//alert("5");
			var total_price_hidden_main=$('#main_total').val();
			var totbal = total_price_hidden_main.split(" ");
			var tstr1 = totbal[0];
			var tstr2 = totbal[1];

			var dis=voucher_discount;
			var retvou = dis.split(" ");
			var voustr1 = retvou[0];
			var voustr2 = retvou[1];

			var grand_total_display1=tstr2 - voustr2 - wallet_deduction;
			
			//alert(grand_total_display1);
		//	$("#grand_total").val('₹ ' + grand_total_display1.toFixed(2));
			//alert(this.checked);
			if(this.checked==true)
			{
				//alert("5");
				$("#grand_total").val(this.checked ? '₹ ' + grand_total_display1.toFixed(2) : '');
			}
			else if(this.checked==false)
			{
				var grand_total_display2=tstr2 - voustr2;
				
				//alert("6");
				//alert(grand_total_display2);
				if(this.checked==true)
				{
					
					$("#grand_total").val(this.checked ? '₹ ' + grand_total_display2 : '');
				}
				else
				{
					
					var grand_total_display3=tstr2 - voustr2;
					if(this.checked==true)
					{
						//alert("YY");
						$("#grand_total").val('₹ ' + grand_total_display3);
					}
					else(this.checked==false)
					{
						//alert("NN");
							// if(this.checked)
							// {
							// 	alert("fsdf");
							// 	$("#grand_total").val('₹ ' + grand_total_display3);
							// }
							// else
							// {
							// 	alert("FDsfgggdsg");
							// 	$("#grand_total").val(grand_total_display3);
							// }
							//alert(grand_total_display3);
							var grand_total_display4=tstr2 - voustr2;
							//alert(grand_total_display4);
							//res + Number.isNaN('')
							if(grand_total_display4 + Number.isNaN('NaN'))
							{
								//alert("dfd");
								$("#grand_total").val(this.checked ? '₹ ' + grand_total_display3 : '₹ ' + grand_total_display4);
							}
							else
							{
								//alert("dfddfdsf");
								$("#grand_total").val(this.checked ? '₹ ' + grand_total_display3 : '');
							}
							
						

						
					}
					
				}
				
				//$("#grand_total").val(this.checked ? '₹ ' + grand_total_display2.toFixed(2) : '');
			}
			else{
				alert("Fdsf");
			}
			
			
		}
		/*else
		{
			alert("6");
			//alert("4");
			$("#grand_total").val('');
		}*/


	}
	
	
	 //var gra

 //    $('#show').html(this.checked ? this.value : '');
});
</script>

<script>
	$("#apply").click(function(){
		//var total_price=$('#total_price').val();
		//alert(total_price);
		//alert($('#coupon_code').val());
		if($('#coupon_code').val()!=''){
			//alert("test");
			$.ajax({
						
						url: "<?php echo base_url('updateVoucherCode'); ?>",
						type: "POST",
						//dataType: 'json',
						data:{
							coupon_code: $('#coupon_code').val()
						},
						success: function(dataResult){
							 var dataResult = JSON.parse(dataResult);
							  //26-7
							 var vouch_id=dataResult.voucher_id
							 var voucher_id= $('#voucher_id').val(vouch_id);
							 //26-7
							// alert(dataResult);
							 //var all_service=dataResult.all_service;
							//			alert(all_service);
							if(dataResult.statusCode==200){


								
								//var MyDateString;

								//MyDate.setDate(MyDate.getDate() + 20);

	//MyDateString =  MyDate.getFullYear() + '-' + ('0' + (MyDate.getMonth()+1)).slice(-2) + '-' + ('0'  + MyDate.getDate()).slice(-2);


								             

								
								var MyDate = new Date();
								//var today_date = d.getFullYear() + "-0" + (d.getMonth()+1).slice(-2) + "-0" + d.getDate();
								var today_date =MyDate.getFullYear() + '-' + ('0' + (MyDate.getMonth()+1)).slice(-2) + '-' + ('0'  + MyDate.getDate()).slice(-2);

								
								var start_date    = dataResult.from_date;
								var end_date    = dataResult.to_date;
								
								// alert(start_date);
								// alert(end_date);
								if(today_date >= start_date && today_date <= end_date)
								{  
										var all_service=dataResult.all_service;
									
										
										var package_id= $('#package_id').val();

										
										var service_id= $('#service_type_id').val();
										var arr = $('input[name=service_type_id').map(function() {
  												return this.value;
										}).get();

										// var myarraydata=[];
										// 	var arraydata = $("input[name^='service_type_id']");
										// for(i=0;i<arraydata.length;i++)
										// {

										// 	var service_type_id1 =  arraydata[i].value;
										// 	myarraydata.push(service_type_id1); 
										 
										// }

										 
											
										var service_id=arr;
										//alert(service_id);

										var arr1 = $('input[name=package_id]').map(function() {
  												return this.value;
										}).get();
											
										var package_id=arr1;
										//alert(service_id);

										


										if(dataResult.service_id != '' )
										{
											var service_type_id=dataResult.service_id.split(",");
											
											
											
											$.each(service_type_id,function(i){
												
													var service_t_id=service_type_id[i];
													
													
													if($.inArray(service_t_id,service_id) >= 0)
													{
														var wallet_ded=$('#wallet_show').val();
														var walldeduct=wallet_ded;
														var retwallded = walldeduct.split(" ");
														var wallstr1 = retwallded[0];
														var wallstr2 = retwallded[1];
														//alert(wallet_ded);
														var after_apply=$('#total_price_hidden').val()-dataResult.value-wallstr2;

														//alert(after_apply);
														var discount=$('#total_price').val(after_apply);
														//var grand_total=$('#grand_total').val(after_apply);
														//₹ 
														var voucher_code=dataResult.value;
														//var voucher_discount=$('#voucher_discount').val(voucher_code);
														var voucher_discount=$("#voucher_discount").val('₹ ' + voucher_code);
														
														if(after_apply + Number.isNaN('NaN'))
														{
															//alert("a1");
															//alert("dfd");
															//$("#grand_total").val(this.checked ? '₹ ' + grand_total_display3 : '₹ ' + grand_total_display4);
															var grand_total=$("#grand_total").val('₹ ' + after_apply.toFixed(2));
														}
														else
														{
															//alert("test");
																var after_apply=$('#total_price_hidden').val()-dataResult.value;
															var grand_total=$("#grand_total").val('₹ ' + after_apply.toFixed(2));
														}
														
														//alert(wallet_ded);

														


														

														$('#voucher_discount').css({ 'color': 'black','text-align':'right'});

														$('#grand_total').css({ 'color': 'black','text-align':'right'});


														$('#discount_lable').show();
														//$('#show').show();
														$('#grand_total_lable').show();
														$('#rupee_icon_dis').show();
														$('#rupee_icon_grand').show();
														//$('#wallet_show').show();
														$('#message').html("Promocode applied successfully !");
														$('#message').css({ 'color': 'green'});
														 return false;
													}
													else
													{
														//alert("4");
														$('#message').html("This Promocode not available for this service !");
														$('#message').css({ 'color': 'red'});
													}
													//alert(service_t_id);

												
	   											
											});
										}
										else if(dataResult.package_id != '' )
										{
										

											var package_check_id=dataResult.package_id.split(',');
											//var package_t_id;
											$.each(package_check_id,function(i){
												
	   												var package_t_id=package_check_id[i];
	   												if($.inArray(package_t_id,package_id) >= 0)
													{
														//alert("2");
														var after_apply=$('#total_price_hidden').val()-dataResult.value;
														
															//$('#total_price').hide();
														var discount=$('#total_price').val(after_apply);
														//var grand_total=$('#grand_total').val(after_apply);
														//₹ 
														var grand_total=$("#grand_total").val('₹ ' + after_apply.toFixed(2));


														var voucher_code=dataResult.value;
														//var voucher_discount=$('#voucher_discount').val(voucher_code);
														var voucher_discount=$("#voucher_discount").val('₹ ' + voucher_code);


														

														$('#voucher_discount').css({ 'color': 'black','text-align':'right'});

														$('#grand_total').css({ 'color': 'black','text-align':'right'});

														$('#discount_lable').show();
														$('#grand_total_lable').show();
														$('#rupee_icon_dis').show();
														$('#rupee_icon_grand').show();
														$('#message').html("Promocode applied successfully !");
														$('#message').css({ 'color': 'green'});

													}
													else
													{
														$('#message').html("This Promocode not available for this service !");
														$('#message').css({ 'color': 'red'});
													}
	   											
											});
										}
										else if(all_service == -1)
										{
											var after_apply=$('#total_price_hidden').val()-dataResult.value;
											
												//$('#total_price').hide();
											var discount=$('#total_price').val(after_apply);
											//var grand_total=$('#grand_total').val(after_apply);
											//₹ 
											var grand_total=$("#grand_total").val('₹ ' + after_apply.toFixed(2));


											var voucher_code=dataResult.value;
											//var voucher_discount=$('#voucher_discount').val(voucher_code);
											var voucher_discount=$("#voucher_discount").val('₹ ' + voucher_code);


											

											$('#voucher_discount').css({ 'color': 'black','text-align':'right'});

											$('#grand_total').css({ 'color': 'black','text-align':'right'});

											$('#discount_lable').show();
											$('#grand_total_lable').show();
											$('#rupee_icon_dis').show();
											$('#rupee_icon_grand').show();
											$('#message').html("Promocode applied successfully !");
											$('#message').css({ 'color': 'green'});
										}
										else
										{
											$('#message').html("This Promocode not available for this service !");
											$('#message').css({ 'color': 'red'});
										}
										
										

								 	  	
								}
								else if(today_date <= end_date){
									$('#message').html("Invalid promocode !");
									$('#message').css({ 'color': 'red'});
								}
								else
								{

									$('#message').html("Expired this promocode !");
									$('#message').css({ 'color': 'red'});
										
								}


								
								
							}
							else if(dataResult.statusCode==201){
								$('#message').html("Invalid promocode !");
								$('#message').css({ 'color': 'red'});
							}
						}
			});
		}
		else{

			$('#message').html("Promocode can not be blank .Enter a Valid Promocode !");
			$('#message').css({ 'color': 'red'});
		}
	});
	$("#edit").click(function(){
		$('#coupon_code').val("");
		$('#apply').show();
		$('#edit').hide();
		location.reload();
	});
</script>