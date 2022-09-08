 <?php
 		?>	
 			<option value="none" selected disabled hidden> Select Address </option>
      <?php foreach ($select_address as  $address) {
           ?>

              <option value="<?php echo $address->address_id;?>"><?php echo $address->address_1." ".$address->address_2;?></option>
                                                            <?php
                                                            
        }
?>