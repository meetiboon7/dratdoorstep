<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Date and City Wise Appointment</h5>
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
										
									</div> -->
	           <form id="get_detail" class="form" action="<?php echo base_url(); ?>get_details_appointment"  method="post" >
									<div class="card-body">
										
										  <div class="row">
										  	 <div class="form-group col-md-3">
												<label>Select City *</label>
											<select class="form-control select2 city_valid"  name="city_id" required="" id="kt_select2_1">
											<option value="0" selected disabled hidden> Select City  </option>
             

											<?php 
											if($this->session->userdata('admin_user')['role_id']==-1)
											{
												foreach($city as $c){
                  
														echo '<option value="'.$c['city_id'].'">'.$c['city'].'</option>';


												}
											}
											elseif($this->session->userdata('admin_user')['city_permission']=='163')
											{
												echo '<option value="163">Vadodara</option>';
											}
											elseif($this->session->userdata('admin_user')['city_permission']=='139')
											{
												echo '<option value="139">Ahmedabad</option>';
											}
											elseif($this->session->userdata('admin_user')['city_permission']=='165')
											{
												echo '<option value="165">Surat</option>';
											}
											elseif($this->session->userdata('admin_user')['city_permission']=='139,163')
											{
											    
											    	echo '<option value="139">Ahmedabad</option>';
											    	echo '<option value="163">Vadodara</option>';
												// foreach($city as $c){
                  
												// 		echo '<option value="'.$c['city_id'].'">'.$c['city'].'</option>';


												// }
											}
											elseif($this->session->userdata('admin_user')['city_permission']=='139,165')
											{
											    
											    	echo '<option value="139">Ahmedabad</option>';
											    	echo '<option value="165">Surat</option>';
												
											}
												elseif($this->session->userdata('admin_user')['city_permission']=='163,165')
											{
											    
											    
											    	echo '<option value="163">Vadodara</option>';
											    	echo '<option value="165">Surat</option>';
												
											}
											elseif($this->session->userdata('admin_user')['city_permission']=='139,163,165')
											{
											    
											    
												foreach($city as $c){
                  
														echo '<option value="'.$c['city_id'].'">'.$c['city'].'</option>';


												}
											}
											?>
										</select>
										<div id="city_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
										  <div class="form-group col-md-3">
												<label>From Date *</label>
												<input type="date" class="form-control"   placeholder="Date of Birth" name="from_date" id="from_date" value="" />
												<div id="from_date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>

										<div class="form-group col-md-3">
												<label>To Date *</label>
												<input type="date" class="form-control"   placeholder="Date of Birth" name="to_date" id="to_date" value="" />
												<div id="to_date_valid" class="validation" style="display:none;color:red;">Please Enter Value</div>
										</div>
											<div class="form-group col-md-3" style="padding-top: 25px;">
											<button type="submit" class="btn btn-primary mr-2" name="search" id="btnSubmit">Search</button>
											<a href="<?php echo base_url(); ?>adminAllAppointment" class="btn btn-secondary">Reset</a>
										</div>
									 </div> 
								
										<!--begin: Datatable-->
										<table class="table table-separate table-head-custom table-checkable" id="complain_datatable">
											<thead>
												<tr>
													<th>Services</th>
													<th>Amount</th>
													<th>Patient</th>
													<th>Payment Type</th>
													<th>Appointment Date</th>
													<th>Generate Invoice</th>
							                        <th>Delete</th>
							                        <th>Edit</th>
												</tr>
											</thead>
											<tbody>
										
												<?php 
												
												foreach($all_appointment_details as $data){
												    
												    if($data[appointment_book_id]!=0)
												    {
												        $this->db->select('extra_invoice.*,additional_payment.amount');
                                                		$this->db->from('extra_invoice');
                                                		$this->db->join('additional_payment','additional_payment.appointment_id = extra_invoice.appointment_book_id','LEFT');
                                                		$this->db->where('additional_payment.appointment_id',$data[appointment_book_id]);
                                                		$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                                                		$total_amount= $this->db->get()->row_array();
												    }
												    elseif($data[book_nurse_id]!=0)
												    {
												        $this->db->select('extra_invoice.*,additional_payment.amount');
                                                		$this->db->from('extra_invoice');
                                                		$this->db->join('additional_payment','additional_payment.appointment_id = extra_invoice.book_nurse_id','LEFT');
                                                		$this->db->where('additional_payment.appointment_id',$data[book_nurse_id]);
                                                		$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                                                		$total_amount= $this->db->get()->row_array();
                                                	
												    }
												    elseif($data[book_laboratory_test_id]!=0)
												    {
												        $this->db->select('extra_invoice.*,additional_payment.amount');
                                                		$this->db->from('extra_invoice');
                                                		$this->db->join('additional_payment','additional_payment.appointment_id = extra_invoice.book_nurse_id','LEFT');
                                                		$this->db->where('additional_payment.appointment_id',$data[book_laboratory_test_id]);
                                                		$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                                                		$total_amount= $this->db->get()->row_array();
												    }
												    elseif($data[book_ambulance_id]!=0)
												    {
												        $this->db->select('extra_invoice.*,additional_payment.amount');
                                                		$this->db->from('extra_invoice');
                                                		$this->db->join('additional_payment','additional_payment.appointment_id = extra_invoice.book_nurse_id','LEFT');
                                                		$this->db->where('additional_payment.appointment_id',$data[book_ambulance_id]);
                                                		$this->db->order_by('extra_invoice.extra_invoice_id', 'DESC');
                                                		$total_amount= $this->db->get()->row_array();
												    }

													?>	
												<tr>
											
													<td><?php echo $data['list'];?></td>
													<td><?php echo $data['price']+$total_amount[amount];?></td>
													<td><?php echo $data['name'];?></td>
													<td><?php echo $data['type'];?></td>
													<td><?php echo $data['appmt_date'];?></td>
													<td><button  formaction="<?php echo base_url(); ?>invoice_recipt_appo" name="extra_invoice_id" value="<?php echo $data['extra_invoice_id']; ?>"  class="btn btn-secondary" title="View Invoice">Receipt</button></td>
													
													<td><button  formaction="<?php echo base_url(); ?>extra_invoice_delete" name="extra_invoice_id_del" value="<?php echo $data['extra_invoice_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Delete Record"><i class="flaticon-delete"></button></td>
	
	 <td><button  formaction="<?php echo base_url(); ?>extra_invoice_edit" name="extra_invoice_id_edit" value="<?php echo $data['extra_invoice_id']; ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Edit Record"><i class="flaticon-edit"></button></td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									
										<!--end: Datatable-->
									</div>
									 </form>  
								</div>
								<!--end::Card-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					<!--end::Content-->
<script type="text/javascript">
                         	
	$(document).ready( function () {
    

    $('#complain_datatable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : true
    })
} );

</script>
<script type="text/javascript">
    $(function () {

        $("#btnSubmit").click(function () {
           var city_valid = $(".city_valid");
          

            if (city_valid.val() == null) {
                
                $('#city_valid_id').show();
        		
                return false;
            }
            else
            {
            	 $('#city_valid_id').hide();
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
             
            

            
			return true;

        });
    });
</script>


<script type="text/javascript">
	
	document.getElementById('from_date').value ="<?php 
if(!$_POST['from_date']):?>"from_date"<?php  
  else:  echo $_POST['from_date']; endif;?>";

document.getElementById('to_date').value ="<?php 
if(!$_POST['to_date']):?>"to_date"<?php  
  else:  echo $_POST['to_date']; endif;?>";

</script>
