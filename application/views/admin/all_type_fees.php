<?php

if($type['type']==2)
{
	?>
	
		<label>Type Sub Type</label>
		<!-- <select class="select2_group form-control" name="sub"> -->
			<select class="form-control select2" id="kt_select2_4" name="submenu_type_id" >
				<option value="1">Injection</option>	
				<option value="2">Nursing charging</option>
				<option value="3">Procedure</option>
				<!-- <option value="4">Customize</option> -->
			
		</select>
  	
	<?php
}
elseif($type['type']==3)
{
	?>
	
		<label>Type Sub Type</label>
	<!-- <select class="select2_group form-control" name="sub"> -->
		<select class="form-control select2" id="kt_select2_2" name="submenu_type_id" >
			<option value="1">XRAY(Portable)</option>	
			<option value="2">ECG</option>
			<option value="3">Blood Test</option>
			<option value="4">Other Test</option>
		
	</select>

	<?php
}
elseif($type['type']==5)
{
	?>
	
		<label>Type Sub Type</label>
	<!-- <select class="select2_group form-control" name="sub"> -->
		<select class="form-control select2" id="kt_select2_50" name="submenu_type_id" >
			<option value="1">One Way</option>	
			<option value="2">Round Trip</option>
			<option value="3">Multi Location</option>
			
		
	</select>

	<?php
}
else
{
	?>

	<?php
}

?>
<script src="<?php echo base_url(); ?>assets/js/pages/crud/forms/widgets/select2.js"></script>