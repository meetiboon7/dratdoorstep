                    <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <!--begin::Subheader-->
                        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
                            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center flex-wrap mr-2">
                                    <!--begin::Page Title-->
                                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Manage City Mapping Master</h5>
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
                                <div class="card card-custom nn_add-cityMap">
                                    <div class="card-header flex-wrap py-5">
                                        <div class="card-title">
                                            <h3 class="card-label">City Mapping</h3>
                                        </div>
                                    </div>
                                    <form class="form" action="<?php echo base_url();?>addCityMapping" method="post">
                                        <div class="card-body">
                                            <div class="form-group row">

                                                <div class="col-lg-2">
                                                    <label>Employee *</label>
                                                    <select class="form-control select2 emp_name_validate" name="emp_id" required=""  id="kt_select2_1" >
                                                        
                                                        <option selected="true" value="" disabled="disabled">Select Employee</option>   
                                                        <?php
                                                        foreach ($all_employee as  $employee_data) {
                                                            ?>
                                                            <option value="<?php echo $employee_data->emp_id?>"><?php echo $employee_data->first_name." ".$employee_data->last_name?></option>
                                                            <?php
                                                            
                                                        }
                                                        ?>
                                                        
                                                    </select>   
                                                     <div id="emp_name_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
                                                </div>

                                                <div class="col-lg-2">
                                                    <label>City *</label>
                                                    <select class="form-control select2 city_name_validate" name="city_id"  id="kt_select21_2" required="" onChange="getZone(this.value)">
                                                    <option selected="true" value="" disabled="disabled">Select City</option>     
                                                       
                                                        <?php
                                                        foreach ($all_city as  $city_data) {
                                                            ?>
                                                            <option value="<?php echo $city_data->city_id?>"><?php echo $city_data->city?></option>
                                                            <?php
                                                            
                                                        }
                                                        ?>
                                                        
                                                </select>  
                                                  <div id="city_name_id" class="validation" style="display:none;color:red;">Please Enter Value</div> 
                                                </div>
                                                <div class="col-lg-3">
                                                    <label>Zone *</label>
                                                    <select class="form-control select2 zone_name_validate display_select_zone" name="zone_id[]"  id="kt_select2_17" multiple required="" >
                                                        <option disabled>Select Zone</option>
                                                    
                                                        <!-- <option selected="true" disabled="disabled">Select City</option>   --> 
                                                       
                                                        
                                        </select>
                                         <div id="zone_name_id" class="validation" style="display:none;color:red;">Please Enter Value</div>    
                                                </div>
                                                
                                                
                                                <div class="col-lg-2">
                                        <label>Status </label>
                                        <select class="form-control select2"  name="city_map_status"  id="kt_select2_10">
                                           
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        
                                    </div>
                                                <div class="col-lg-2">
                                                    <br>
                                                    <button type="submit" id="btnSubmit" class="btn btn-primary mr-2" style="margin: 5px 0 0 30px; ">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <br>
                                    <div class="card card-custom nn_edit-cityMap" style="display: none">
                                    <div class="card-header flex-wrap py-5">
                                        <div class="card-title">
                                            <h3 class="card-label">Edit City Mapping</h3>
                                        </div>
                                    </div>
                                    <form class="form" action="<?php echo base_url();?>updateCityMapping" method="post">
                                        <div class="card-body">
                                            <div class="form-group row">
                                                 <div class="col-lg-2">
                                                    <label>Employee *</label>
                                            <div class="span_id">
                                        <select class="form-control sel_act-emp select2" id="kt_select2_5" name="emp_id" >
                                            <option value="" disabled="">Select Employee</option>
                                            <?php
                                                    foreach($all_employee as $e){

                                                        $s_selected = "";
                                                        $employee = explode(',', $view_CityMapping->emp_id);
                                                        
                                                        if(in_array($e->emp_id, $employee) ){ $s_selected = "selected"; }
                                                        echo '<option value="'.$e->emp_id.'" '.$s_selected.'>'.$e->first_name.' '.$e->last_name.'</option>';
                                                    }
                                                ?>
                                            </select>   
                                            </div>
                                        
                                                </div>
                                                <div class="col-lg-2">
                                                    <label>City *</label>
                                            <div class="span_id">
                                        <select class="form-control sel_act-city select2" id="kt_select2_6" name="city_id" onChange="getZone(this.value)">
                                            <?php
                                                    foreach($all_city as $c){

                                                        $s_selected = "";
                                                        $city = explode(',', $view_CityMapping->city_id);
                                                        
                                                        if(in_array($c->city_id, $city) ){ $s_selected = "selected"; }
                                                        echo '<option value="'.$c->city_id.'" '.$s_selected.'>'.$c->city.'</option>';
                                                    }
                                                ?>
                                            </select>   
                                            </div>
                                        
                                                </div>
                                    <div class="col-lg-4">
                                                    <label>Zone</label>

                                        <select class="form-control sel_act-zone select2 display_zone display_select_zone"  id="kt_select2_7" name="zone_id[]" multiple required="">
                                            <option disabled="">Select Zone *</option>
                                            <!-- <?php
                                                    foreach($all_zone as $z){

                                                        $s_selected = "";
                                                        $zone = explode(',',$view_CityMapping->zone_id);
                                                       
                                                        if(in_array($z->zone_id,$zone) ){ $s_selected = "selected"; }
                                                        echo '<option value="'.$z->zone_id.'" '.$s_selected.'>'.$z->zone_name.'</option>';
                                                    }
                                                ?> -->
                                            </select>   
                                            
                                        </div>



                                               
                                                
                                    <div class="col-lg-2">
                                            <label>status</label>
                                            <select class="form-control select2 sel_act-inact" id="kt_select2_8" name="city_map_status" >
                                                
                                                <option value="1" <?php if($view_CityMapping->city_map_status == 1 ) { echo "selected"; } ?>>Active</option>
                                                <option value="0" <?php if($view_CityMapping->city_map_status == 0 ) { echo "selected"; } ?>>Inactive</option>
                                            </select>
                                        
                                        </div>
                                                
                                                <div class="col-lg-2">
                                                    <br>
                                                
                                                    <button type="submit" name="btn_update_CityMapping" value="<?php echo $view_CityMapping->city_map_id; ?>"  id="btnSubmit" class="btn btn-primary mr-2 btn_update_CityMapping" >Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div> 
                                <!--begin::Card--> 
                                <!-- List Block -->
                                <div class="card card-custom">
                                    <div class="card-header flex-wrap py-5">
                                        <div class="card-title">
                                            <h3 class="card-label">City Mapping List</h3>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!--begin: Datatable-->
                                        <form method="post">
                                        <table class="table table-separate table-head-custom table-checkable dataTable no-footer" id="kt_datatable">
                                            <thead>
                                                <tr>
                                                    <th>Sr No</th>
                                                    <th>Employee Name</th>
                                                    <th>City Name</th>
                                                    <th>Zone Name</th>
                                                    
                                                    <th>Status</th>
                                                    
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                foreach($all_city_mapping as $cityMapping){
                                                       // $ids=explode(',',$cityMapping->zone_id);

                                                
                                                  
                                                 

                                                    
                            ?>
                                                <tr>
                                                    <td><?php echo $cityMapping->city_map_id; ?></td>
                                                    <td><?php echo $cityMapping->first_name.' '.$cityMapping->last_name; ?></td>
                                                        <td><?php echo $cityMapping->city_name; ?></td>
                                                        <td><?php 
                                                        $ids=explode(',',$cityMapping->zone_id);
                                                        foreach ($ids as $id) {

                                                            if($id!='')
                                                            {
                                                                $result=$this->db->query('select zone_name from zone_master where zone_id='.$id)->row();
                                                                if($result)
                                                                {
                                                                    echo $result->zone_name.",";
                                                                    //echo mb_substr($string, 0, -1);
                                                                }
                                                                else
                                                                {
                                                                    echo "-";
                                                                }
                                                            }
                                                            else
                                                            {
                                                                echo "-";
                                                            }

                                                            
                                                            
                                                        }

                                                        ?>

                                                        </td>
                                                        
                                                        <td><?php

                                                        if($cityMapping->city_map_status=="1")
                                                        {

                                                         echo "Active"; 
                                                        }
                                                        else
                                                        {
                                                             echo "Inactive"; 
                                                        }


                                                         ?></td>
                                                        
                                                    <!-- <td>West Zone</td> -->
                                                    <!-- <td>Inactive</td> -->
                                                    <td nowrap="nowrap">
                                                        <button name="btn_edit_CityMapping" type="button"  value="<?php echo $cityMapping->city_map_id; ?>"  class="btn btn-sm btn-clean btn-icon mr-2 editCityMapping" title="Edit Manage City Mapping">   
                                                            
                                                            

                                                            <span class="svg-icon svg-icon-md">
                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">  
                                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                                            <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                                                                            <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1">
                                                                        </rect>
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                        </button>
                                                       <!--  <button formaction="<?php echo base_url(); ?>deleteCityMapping" name="btn_delete_CityMapping" value="<?php echo $cityMapping->city_map_id;  ?>"  class="btn btn-sm btn-clean btn-icon mr-2" title="Delete Manage City Mapping">                
                                                            <i class="flaticon-delete"></i>
                                                        </button> -->
                                                        <a href="#" class="btn btn-sm btn-clean btn-icon mr-2 btn-delete" data-id="<?php echo $cityMapping->city_map_id;?>"> <i class="flaticon-delete"></i></a>
                                                        
                                                        <!-- </a> -->
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                        <!--end: Datatable-->
                                        </form>
                                    </div>
                                </div>
                                <!--End List Block -->
                                <!--end::Card-->
                                <!--end::Dashboard-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Entry-->
                    </div>
                    <!--end::Content-->
<form action="<?php echo base_url(); ?>deleteCityMapping" method="post">
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete City Mapping</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             
               <h4>Are you sure want to delete this City Mapping?</h4>
             
            </div>
            <div class="modal-footer">
                <input type="hidden"  name="btn_delete_CityMapping" class="cityMapID">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-primary">Yes</button>
            </div>
            </div>
        </div>
        </div>
    </form>
<script>
    $(document).ready(function(){
 
        // get Edit Product
       
 
        // get Delete Product
        $('.btn-delete').on('click',function(){
            // get data from button edit
            const id = $(this).data('id');

            // Set data to Form Edit
            $('.cityMapID').val(id);
            // Call Modal Edit
            $('#deleteModal').modal('show');
        });
         
    });
</script>
<script type="text/javascript">
    $(function () {

        $("#btnSubmit").click(function () {
            var emp_name_validate = $(".emp_name_validate");
              var city_name_validate = $(".city_name_validate");
              var zone_name_validate = $(".zone_name_validate");
              //alert(zone_name_validate);
              
            
            
           
            if (emp_name_validate.val() == null) {
                
                $('#emp_name_id').show();
                
                return false;
            }
            else
            {
                 $('#emp_name_id').hide();
            }

            if (city_name_validate.val() == null) {
                
                $('#city_name_id').show();
                
                return false;
            }
            else
            {
                 $('#city_name_id').hide();
            }

             if (zone_name_validate.val() == null) {
                
                $('#zone_name_id').show();
                
                return false;
            }
            else
            {
                 $('#zone_name_id').hide();
            }

            
            return true;

        });
    });
</script>
<script type="text/javascript">
 

    function getZone(city_id){
       // alert(city_id);
        //alert(BASE_URL);
        
        if(city_id){

            jQuery.ajax({
                type:'POST',
               // url: <?php echo base_url()?>+'admin/cityMapping/zole_list_display', 
                url: BASE_URL+'admin/cityMapping/zole_list_display',
                data:'city_id='+city_id,
                success:function(html){
                //  alert(html);
                        //  console.log(html);
                    jQuery('.display_select_zone').html(html);
                     
                }
            }); 
        }else{
           
          
        }
    }

    
</script>
                    