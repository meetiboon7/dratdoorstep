 <?php
 		?>	
 			<option value="none" selected disabled hidden> Select Zone </option>
      <?php foreach ($select_zone as  $zone_data) {
           ?>

              <option value="<?php echo $zone_data->zone_id?>"><?php echo $zone_data->zone_name?></option>
                                                            <?php
                                                            
        }
?>