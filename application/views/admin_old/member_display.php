 <?php
 		?>	
 			<option value="none" selected disabled hidden> Select Member </option>
      <?php foreach ($select_member as  $member_data) {
           ?>

              <option value="<?php echo $member_data->member_id?>"><?php echo $member_data->name." - ".$member_data->contact_no?></option>
                                                            <?php
                                                            
        }
?>