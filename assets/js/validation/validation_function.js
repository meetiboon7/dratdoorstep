function comparePassword(password, c_password){
	$(c_password).removeClass('is-invalid');
	$(c_password).removeClass('is-valid');
	$(c_password).next('.validation').removeClass('valid-feedback');
	$(c_password).next('.validation').removeClass('invalid-feedback');
		if(($(password).val().trim() === $(c_password).val()) && $(password).val() !="")
		{
			if(validatePassword(password) && validatePassword(c_password)){
				display_feedback(c_password, 'is-valid', 'valid-feedback', 'Password macthed');
				return true;
			}
			else{
				display_feedback(c_password, 'is-invalid', 'invalid-feedback', 'Password should contain atleast 4 Digit');
				return false;
			}
		}else{
			display_feedback(c_password, 'is-invalid', 'invalid-feedback', 'Password mismatch');
			return false;
		}
}

function isChecked(element)
{
	$(element).removeClass('is-invalid');
	$(element).removeClass('is-valid');
	if($(element).is(":checked")){
		
		return true;
    }else{
    	display_feedback(element, 'is-invalid', 'invalid-feedback', 'This is required');
    	return false;
    }
}

function isRequired(element)
{

	$(element).removeClass('is-invalid');
	$(element).removeClass('is-valid');

	if($(element).val().trim() === "")
	{
		display_feedback(element, 'is-invalid', 'invalid-feedback', 'This is required');
		return false;	
	}else{
		//$(e).addClass('is-valid');
		return true;
	}
}

function validateEmail(email){
	$(email).removeClass('is-invalid');
	$(email).removeClass('is-valid');
	if($(email).val() !== "")
	{

		if(!validateEmailFormat($(email).val())){
			display_feedback(email, 'is-invalid', 'invalid-feedback', 'Email is not valid');
			return false;	
		}else{
			/*$(email).removeClass('is-invalid');
			$(email).removeClass('is-valid');
			if(!unique_signup_email(email))
			{
				display_feedback(email, 'is-invalid', 'invalid-feedback', 'Email cannot be empty');
				return false;
			}else{*/
				$(email).addClass('is-valid');
				return true;
			//}
		}
	}
	else{
		display_feedback(email, 'is-invalid', 'invalid-feedback', 'Email cannot be empty');
		return false;
	}
}

function unique_signup_email(email)
{
	
	var email_id = $(email).val();
	
	// var BASE_URL = "http://localhost/DADS_Web/";
	//var BASE_URL = "https://deviboon.dratdoorstep.com/";

	//var BASE_URL = "http://localhost/DADS_Web/";
	var is_available = false;
	$.ajax({  
			type: 'POST',
			url: BASE_URL + 'checkSignupEmailId', 
			data: {email_id:email_id},
			async: false,
			success: function(data) {
				//console.log(data);
				if(data.trim() === "true")
				{
					$(email).addClass('is-valid');
					is_available = true;
				}
				else{
					display_feedback(email, 'is-invalid', 'invalid-feedback', 'Email is not available');
					is_available = false;	

				}
			}
		});	
	
	return is_available;
}



function validatePassword(e)
{

	$(e).removeClass('is-invalid');
	$(e).removeClass('is-valid');
	if($(e).val().trim() != "")
	{
		
		if($(e).val().length <4){
			
			display_feedback(e, 'is-invalid', 'invalid-feedback', 'Pin should contain atleast 4 Digit');
			return false;
		}else{
			
			$(e).addClass('is-valid');
			return true;
		}
	}
	else{
		display_feedback(e, 'is-invalid', 'invalid-feedback', 'Password cannot be empty');
		return false;	
	}
}

function display_feedback(e,add_class_name, feedback_class_name = "", feedback_message = "")
{		
	$(e).addClass(add_class_name);	
	$(e).next('.validation').addClass(feedback_class_name);
	$(e).next('.validation').html(feedback_message);
}

function validateEmailFormat(emailField){
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{1,4})$/;
	
	if (reg.test(emailField) == false) 
	{
		return false;
	}
	return true;
}