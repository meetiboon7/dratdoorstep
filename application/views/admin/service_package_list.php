<?php
 		?>	
 			<option value="none" selected disabled hidden> Select Package Service </option>
    
      <?php foreach ($select_package_service as $package) {
           ?>

              <option value="<?php echo $package->package_id?>"><?php echo $package->package_name." - ".($package->fees_name)." ".(₹)?></option>
                                                            <?php
                                                            
        }
?>