
$(document).on('keydown keyup blur','#email, #login-email', function(){
	validateEmail(this);
});

$(document).on('blur focus','#email', function(){
	unique_signup_email(this);
});

$(document).on('keydown keyup blur','#password', function(){
	validatePassword(this);
});

// $(document).on('submit', '#pharmacy_login_form',function(e){
// 	var email = $('#login-email').val();
// 	var password = $('#password').val();
// 	if(validateEmail($('#login-email')) && validatePassword($('#password')) )
// 	{
		
// 	}else{
// 		e.preventDefault();	
// 	}
// });

$(document).on('keydown keyup blur', '.isRequired', function(){
	isRequired(this);	
});

// $(document).on('submit', '#pharmacy_signup_login_form',function(e){
		
// 	if(isRequired($('#last_name')) && isRequired($('#first_name'))  && validateEmail($('#email')) && unique_signup_email($('#email')) && validatePassword($('#password')) &&  validatePassword($('#confirm_password')) && isChecked($('#agree_terms')) && comparePassword($('#password'), $('#confirm_password')) )
// 	{
		
// 	}else{
// 		e.preventDefault();	
// 	}
	
// });

// $(document).on('submit', '#pharmacy_signup_pharmacy_form, #add_user_pharmacy_form, #edit_user_pharmacy_form',function(e){
// 	if(isRequired($('#pharmacy_name')) && isRequired($('#address')) && isRequired($('#city'))  && isRequired($('#pharmacy_contact')) && isRequired($('#pharmacy_fax')) &&  validateEmail($('#pharmacy_email')) && isRequired($('#pharmacy_license')) )
// 	{
		
// 	}else{
// 		e.preventDefault();	
// 	}
	
// });

// $(document).on('submit', '#pharmacySignUpCardDetails',function(e){
	
// 	if(isRequired($('#card_number')) && isRequired($('#expiry_date')) && isRequired($('#cvv_number')) && isRequired($('#card_holder_name')) )
// 	{
		
// 	}else{
// 		e.preventDefault();	
// 	}
// });

// $(document).on('keyup keydown blur','#card_number, #expiry_date, #cvv_number, #card_holder_name',function(){
// 	isRequired(this);
// });

// $(document).on('keyup keydown blur','#first_name, #last_name, #contact_no, #contact_number, #pharmacy_name, #address, #address_line_1, #city, #pharmacy_contact, #pharmacy_fax, #pharmacy_license',function(){
// 	isRequired(this);
// });

// $(document).on('click', '#agree_terms', function(){
// 	isChecked(this);
// });

$(document).on('keyup keydown blur','#password, #confirm_password',function(){
	comparePassword($('#password'), $('#confirm_password'));
});



/* Pharmacist identity section*/



/* Pharmacist identity section ends here*/



/*User Profile Form */

// $(document).on('submit', '#add_form',function(e){
// 	if(isRequired($('#add_name')) /*&& isRequired($('#address'))*/  )
// 	{
		
// 	}else{
// 		e.preventDefault();	
// 	}
	
// });


// $(document).on('submit', '#edit_form',function(e){
// 	if(isRequired($('#edit_name')) /*&& isRequired($('#address'))*/  )
// 	{
		
// 	}else{
// 		e.preventDefault();	
// 	}
	
// });
