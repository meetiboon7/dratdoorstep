// alert(BASE_URL);
//var BASE_URL = "https://deviboon.dratdoorstep.com/";
var profile_image = new KTImageInput('div_profile_image');


  

function isNumber(evt) {

    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

$('.editHoliday').click(function(e) {
e.preventDefault();
		var holiday_id = $(this).val();

				$.ajax({  
				type: 'POST',
				url:   BASE_URL+'admin/Holidays/editHoliday', 			
				data: {btn_edit_holiday:holiday_id},
				success: function(response) {
					
					var data_array = $.parseJSON(response);
					

					console.log(data_array);
					$('.card.card-custom.nn_edit-holiday').show();
					$('.card.card-custom.nn_add-holiday').hide();
	               
					$(".sel_act-holiday-city option:selected").removeAttr("selected");
					for(c of data_array['city_id'])
					{

						$('.sel_act-holiday-city [value="'+ c +'"]').attr('selected', 'true');
					}
	    			


	                $(".card.card-custom.nn_edit-holiday .form-group input[name='hdate']").val(data_array['hdate']);
	                $(".card.card-custom.nn_edit-holiday .form-group input[name='hday']").val(data_array['hday']);
	               $(".card.card-custom.nn_edit-holiday button[name='btn_update_holiday']").val(data_array['hid']);
	                $('.select2').select2();


				}

			});
		
		
		
	});


$('.editZone').click(function() {
		var zone_id = $(this).val();
		console.log(zone_id);
		$.ajax({  
			type: 'POST',
			url: BASE_URL + 'admin/Zone/editZone', 			
			data: {btn_edit_zone:zone_id},
			success: function(response) {
				var data_array = $.parseJSON(response);	

				console.log(data_array);			
				$('.card.card-custom.nn_edit-zone').show();

					$('.card.card-custom.nn_add-zone').hide();
               
			
			 	//$('.span_id select option[value="' + data_array['city_id'] + '"]').prop('selected', "true");
			 	
			 		$(".zone-city option:selected").removeAttr("selected");
					for(c of data_array['city_id'])
					{

						$('.zone-city [value="'+ c +'"]').attr('selected', 'true');
					}

                  $(".card.card-custom.nn_edit-zone .form-group input[name='zone_name']").val(data_array['zone_name']);
                if(data_array['zone_status'] == 1){
                	var data_val = 1;
                 	$(".card.card-custom.nn_edit-zone .form-group .sel_act-inact > [value=" + data_val + "]").attr("selected", "true");
                }
                if(data_array['zone_status'] == 0){
                	var data_val = 0;
                 	$(".card.card-custom.nn_edit-zone .form-group .sel_act-inact > [value=" + data_val + "]").attr("selected", "true");
                }
                $(".card.card-custom.nn_edit-zone button[name='btn_update_zone']").val(data_array['zone_id']);
                $('.select2').select2();
			}

		});
	});


$('.editCity').click(function() {
		var city_id = $(this).val();
		$.ajax({  
			type: 'POST',
			url: BASE_URL + 'admin/City/editCity', 			
			data: {btn_edit_city:city_id},
			success: function(response) {
				var data_array = $.parseJSON(response);	

				console.log(data_array);			
				$('.card.card-custom.nn_edit-city').show();

					$('.card.card-custom.nn_add-city').hide();
               
                  $(".card.card-custom.nn_edit-city .form-group input[name='city']").val(data_array['city']);
                  $(".card.card-custom.nn_edit-city .form-group input[name='city_code']").val(data_array['city_code']);
                if(data_array['city_status'] == 1){
                	var data_val = 1;
                 	$(".card.card-custom.nn_edit-city .form-group .sel_act-inact > [value=" + data_val + "]").attr("selected", "true");
                }
                if(data_array['city_status'] == 0){
                	var data_val = 0;
                 	$(".card.card-custom.nn_edit-city .form-group .sel_act-inact > [value=" + data_val + "]").attr("selected", "true");
                }
                $(".card.card-custom.nn_edit-city button[name='btn_update_city']").val(data_array['city_id']);
                $('.select2').select2();
			}

		});
	});


$('.editDoctorType').click(function() {
		var doctor_type_id = $(this).val();
		$.ajax({  
			type: 'POST',
			url: BASE_URL + 'admin/DoctorType/editDoctorType', 			
			data: {btn_edit_doctor_type:doctor_type_id},
			success: function(response) {
				var data_array = $.parseJSON(response);	

				console.log(data_array);			
				$('.card.card-custom.nn_edit-doctor-type').show();

					$('.card.card-custom.nn_add-doctor-type').hide();
               
                  $(".card.card-custom.nn_edit-doctor-type .form-group input[name='doctor_type_name']").val(data_array['doctor_type_name']);
                if(data_array['d_status'] == 1){
                	var data_val = 1;
                 	$(".card.card-custom.nn_edit-doctor-type .form-group .sel_act-inact > [value=" + data_val + "]").attr("selected", "true");
                }
                if(data_array['d_status'] == 0){
                	var data_val = 0;
                 	$(".card.card-custom.nn_edit-doctor-type .form-group .sel_act-inact > [value=" + data_val + "]").attr("selected", "true");
                }
                $(".card.card-custom.nn_edit-doctor-type button[name='btn_update_doctor_type']").val(data_array['d_type_id']);
                $('.select2').select2();
			}

		});
	});




$('.editmanagerole').click(function() {
		var role_id = $(this).val();

		$.ajax({  
			type: 'POST',
			url: BASE_URL + 'admin/Roles/editmanagerole', 			
			data: {btn_edit_managerole:role_id},
			success: function(response) {
				var data_array = $.parseJSON(response);	

				//console.log(data_array);			
				
              $('.card.card-custom.nn_edit-role').show();

					$('.card.card-custom.nn_add-role').hide();
                 
                 $(".card.card-custom.nn_edit-role .form-group input[name='role_name']").val(data_array['role_name']);
                if(data_array['role_status'] == 1){
                	var data_val = 1;
                 	$(".card.card-custom.nn_edit-role .form-group .sel_act-inact > [value=" + data_val + "]").attr("selected", "true");
                }
                if(data_array['city_status'] == 0){
                	var data_val = 0;
                 	$(".card.card-custom.nn_edit-role .form-group .sel_act-inact > [value=" + data_val + "]").attr("selected", "true");
                }
                $(".card.card-custom.nn_edit-role button[name='btn_update_managerole']").val(data_array['role_id']);
                $('.select2').select2();
			}

		});
	});


$('.editCityMapping').click(function(){
		var city_map_id = $(this).val();
	//	var city_id = $("#city_data_id").val();
		//alert(city_id);
		//,city_id:city_id
		$.ajax({  
			type: 'POST',
			url: BASE_URL + 'admin/CityMapping/editCityMapping', 			
			data: {btn_edit_CityMapping:city_map_id},
			success: function(response) {
				var data_array = $.parseJSON(response);	

				console.log(data_array);			
				$('.card.card-custom.nn_edit-cityMap').show();

					$('.card.card-custom.nn_add-cityMap').hide();

					$(".sel_act-emp option:selected").removeAttr("selected");
					for(e of  data_array['emp_id'])
					{
						$('.sel_act-emp [value='+data_array['emp_id']+']').attr('selected', 'true');
					}

					$(".sel_act-city option:selected").removeAttr("selected");
					for(c of data_array['city_id'])
					{
						$('.sel_act-city [value='+data_array['city_id']+']').attr('selected', 'true');
					}


					$(".sel_act-zone option:selected").removeAttr("selected");
					for(z of data_array['zone_id'])
					{
						$('.sel_act-zone [value="'+z+'"]').attr('selected', 'true');

					}

					


					// $('.sel_act-zone :selected').each(function(i, sel){ 
    	// 					alert( $(sel).val() ); 

					// });
     //           		$(".citymapping-zone option:selected").removeAttr("selected");
					// for(z of data_array['zone_id'])
					// {

					// 	$('.citymapping-zone [value="'+ data_array['zone_id'] +'"]').attr('selected', 'true');
					// }

					    //You need a id for set values
    // $.each($(".citymapping-zone"), function(){
    //         $(this).select2(data_array['zone_id'],data_array);
    // });












                // $(".card.card-custom.nn_edit-cityMap .form-group input[name='role_name']").val(data_array['role_name']);
                if(data_array['city_map_status'] == 1){
                	var data_val = 1;
                 	$(".card.card-custom.nn_edit-cityMap .form-group .sel_act-inact > [value=" + data_val + "]").attr("selected", "true");
                }
                if(data_array['city_map_status'] == 0){
                	var data_val = 0;
                 	$(".card.card-custom.nn_edit-cityMap .form-group .sel_act-inact > [value=" + data_val + "]").attr("selected", "true");
                }
                $(".card.card-custom.nn_edit-cityMap button[name='btn_update_CityMapping']").val(data_array['city_map_id']);
                $('.select2').select2();
			}

		});
	});