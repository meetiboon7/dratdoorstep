<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-2">
									<!--begin::Page Title-->
									<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Manage Role</h5>
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
						<form id="edit_permission_manage_form" class="form" action="<?php echo base_url(); ?>updateManagePermission" method="post" enctype="multipart/form-data">
								<div class="card-header">
									<!-- <h3 class="card-title">
										Add Manage User
									</h3> -->
								</div>
								<div class="card-body">

								<div class="row">
									<?php
                //  echo "<pre>";
                // print_r($manage_roles)."<br>";
                //  print_r($role_permission_master);
                //  echo "</pre>";
                //  echo $role_permission_master[0]['role_id'];
                  ?>

									<div class="form-group col-md-6">
										<label>Role *</label>
										<select class="form-control select2 role_valid" id="kt_select2_2" name="role_id" >
											<option value="none" selected disabled hidden> Select Role </option>

											<?php 
												foreach($manage_roles as $mr){
                        
                          $selected_roles = "";
                          if($mr['role_id'] == $role_permission_master[0]['role_id']){ $selected_roles = "selected"; }
													echo '<option value="'.$mr['role_id'].'" '. $selected_roles.'>'.$mr['role_name'].'</option>';
												}
											?>
										</select>
										<div id="role_valid_id" class="validation" style="display:none;color:red;">Please Enter Value</div>
										
									</div>
									
									
									
							    </div>

							    <div class="row">
            
              <div class="form-group col-md-12">
                <table border='1' class="table mb-0">
                  <thead>
                    <tr>
                      <th>Category</th>
                      <th>View &nbsp;&nbsp;<input type="checkbox" id="view" class="parent" data-group=".group1" /></th>
                      <th>Add &nbsp;&nbsp;<input type="checkbox" id="add" class="parent" data-group=".group2" /></th>
                       <th>Edit &nbsp;&nbsp;<input type="checkbox" id="edit" class="parent" data-group=".group3" /></th>
                      <th>Delete &nbsp;&nbsp;<input type="checkbox" id="delete" class="parent" data-group=".group4" /></th>
                    </tr>
                  </thead>
                  </tbody>
                  	<?php 
                   //  echo "<pre>";
                   // print_r($role_permission_master);
                   // print_r($menu_data);
                   // echo "</pre>";
							 foreach ($menu_data as $key => $value) {
                //echo "1"."<br>";
                 
         
           // echo $key
           // echo $role_permission_master[$key]['view_permission'];


//$os = array("Mac", "NT", "Irix", "Linux");
// if (in_array($role_permission_master[$key]['menu_id'],$value['id'])) {
//     echo "Got Irix";
// }

								?>
								 <tr>
                     
                      <td><input type="hidden" name='menu_id[<?php echo $value['id']; ?>]' value="<?php echo $value['id']; ?>"><?php echo strtoupper($value['menu']); ?></td>


                        <td>
                          <input type="checkbox" <?php if($role_permission_master[$key]['menu_id']==$value['id'] && $role_permission_master[$key]['view_permission']==1){ echo "checked='check'"; }?>  id="view_<?php echo $value['id']; ?>" class="group1" name='view[<?php echo $value['id']; ?>]' ></td>


                        <td><input type="checkbox" <?php if($role_permission_master[$key]['menu_id']==$value['id'] && $role_permission_master[$key]['add_permission']=='1'){ echo "checked='check'"; }?> id="add_<?php echo $value['id']; ?>" name='add[<?php echo $value['id']; ?>]' class="group2" ></td>

                         <td><input type="checkbox" <?php if($role_permission_master[$key]['menu_id']==$value['id'] && $role_permission_master[$key]['edit_permission']=='1'){ echo "checked='check'"; }?> id="edit_<?php echo $value['id']; ?>" name='edit[<?php echo $value['id']; ?>]' class="group3" ></td>


                          <td><input type="checkbox" <?php if($role_permission_master[$key]['menu_id']==$value['id'] && $role_permission_master[$key]['delete_permission']=='1'){ echo "checked='check'"; }?> id="delete_<?php echo $value['id']; ?>" name='delete[<?php echo $value['id']; ?>]' class="group4" ></td>

                     
                    </tr>
								<?php
									}
					?>
                     
                  </tbody>
                 
                </table>
              </div>
              </div>

							    


								<!-- <div class="row">
									
									
									<div class="form-group col-md-6">
										<label>Status</label>
										<select class="form-control select2"  name="status"  id="kt_select2_16">
											<option value="1">Active</option>
											<option value="0">Inactive</option>
										</select>
										
								</div>
								</div> -->	

								
								
							</div>
												
							<div class="card-footer">
								<button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Update</button>
								<a href="<?php echo base_url(); ?>adminManagePermission" class="btn btn-secondary">Cancel</a>
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
    $(function () {

        $("#btnSubmit").click(function () {
          
            // var emp_valid = $(".emp_valid");
              var role_valid = $(".role_valid");
              //var emp_valid = $(".emp_valid");
             // alert(emp_valid);
           

            if (role_valid.val() == null) {
                
                $('#role_valid_id').show();
            
                return false;
            }
            else
            {
               $('#role_valid_id').hide();
            }
           
            return true;

        });
    });
</script>

<script type="text/javascript">




$(".parent").each(function(index){
  var group = $(this).data("group");
 // alert(group);
  var parent = $(this);
  

  
  
  parent.change(function(){  //"select all" change 
  
    if($(this).prop("checked") == true)
    {
        if(group=='.group2')
        {
	        $("#view").prop('checked', true); 
	        $(".group1").prop('checked', true);
        }
       else if(group=='.group3')
        {
	        $("#view").prop('checked', true); 
	        $(".group1").prop('checked', true);
        }
        else if(group=='.group4')
        {
	        $(".group1").prop('checked', true);
	        $(".group2").prop('checked', true);
	        $(".group3").prop('checked', true);
	        $("#view").prop('checked', true); 
	        $("#add").prop('checked', true);
	        $("#edit").prop('checked', true); 
        }

    }
    else if($(this).prop("checked") == false)
    {
        if(group=='.group2')
        {
          $(".group4").prop('checked', false);
          $(".group1").prop('checked', true);
          $("#view").prop('checked', true); 
          $("#delete").prop('checked', false); 
        }
       else if(group=='.group3')
        {
          $(".group4").prop('checked', false);
          $(".group1").prop('checked', true);
          $("#view").prop('checked', true); 
          $("#delete").prop('checked', false); 
        }
        else if(group=='.group4')
        {
        	$("#add").prop('checked', true); 
	        $("#view").prop('checked', true); 
	        $("#edit").prop('checked', true); 
        }
        else
        {
        	$(".group1").prop('checked', false);
	        $(".group2").prop('checked', false);
	        $(".group3").prop('checked', false);
	        $("#delete").prop('checked', false); 
	        $("#add").prop('checked', false);
	        $("#edit").prop('checked', false);
        }
          //alert("Checkbox is unchecked.");
    }
  
     $(group).prop('checked', parent.prop("checked"));
  });
  $(group).change(function(){ 
    parent.prop('checked', false);
    if ($(group+':checked').length == $(group).length ){
      parent.prop('checked', true);
    }
  });
});


  $(document).ready(function(e) {
    $('input[type="checkbox"]').click(function(){
      var checkId=$(this).attr('id');
      // alert(checkId);
      if(checkId){
        var splitVal=checkId.split('_');
          if(splitVal[0]=='edit'){
          $("#view_"+splitVal[1]).prop('checked', true); 
          $("#delete_"+splitVal[1]).prop('checked', false);
        }
        else if(splitVal[0]=='add'){
          $("#view_"+splitVal[1]).prop('checked', true); 
          $("#delete_"+splitVal[1]).prop('checked', false);
        }
        else if(splitVal[0]=='delete'){
          $("#view_"+splitVal[1]).prop('checked', true); 
           $("#add_"+splitVal[1]).prop('checked', true);
          $("#edit_"+splitVal[1]).prop('checked', true); 
          
        }else{
          $("#delete_"+splitVal[1]).prop('checked', false); 
           $("#add_"+splitVal[1]).prop('checked', false);
          $("#edit_"+splitVal[1]).prop('checked', false); 
        }
      }
      
      
           
        });

});


</script>



