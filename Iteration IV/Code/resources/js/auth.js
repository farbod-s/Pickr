$(document).ready(function() {
	// Sign Up
	$('#register-btn').click(function() {
		var form_data = {
			username: $('#username').val(),
			email: $('#email').val(),
			password: $('#password').val(),
			confirm_password: $('#confirm_password').val()
		};
        if(!$('#register-form').valid())
            return false;
		$.ajax({
			url: PICKR['baseUrl'] + "auth/register",
			type: 'POST',
			dataType: 'JSON',
			data: form_data,
			success: function(result) {
				if (result) {
					//alert('Success, Signed up');
                	window.location = PICKR['baseUrl'];
	            }
	            else {
	                alert('Error, Can not register');
	            }
			},
			error: function() {
				alert('Ajax Error');
				//window.location = PICKR['baseUrl'];
			}
		});
		return false;
	});

	// Sign In
	$('#login-btn').click(function() {
		var form_data = {
			name: $('#name').val(),
			pass: $('#pass').val(),
			user_remember_me: $('input[name=remember_me]:checked').val()
		};
		if(!$('#login-form').valid())
			return false;
		$.ajax({
			url: PICKR['baseUrl'] + "auth/login",
			type: 'POST',
			dataType: 'JSON',
			data: form_data,
			success: function(result) {
				if(result) {
					//alert('Success, Signed in');
					window.location = PICKR['baseUrl'];
				}
				else {
					alert('Error, Can not login');
				}
			},
			error: function() {
				alert('Ajax Error');
				//window.location = PICKR['baseUrl'];
			}
		});
		return false;
	});

	// Save Profile
	$('#save-profile-btn').click(function() {
		var form_data = {
			firstname: $('#firstname').val(),
			lastname: $('#lastname').val(),
			gender: $('input[name=gender]:checked').val(),
			country: $('#country').val(),
			website: $('#website').val(),
			description: $('#description').val(),
			pic_address: $('#profile-image').attr('src')
		};
		if(!$('#update-profile-form').valid())
			return false;
		$.ajax({
			url: PICKR['baseUrl'] + "setting/update_setting",
			type: 'POST',
			dataType: 'JSON',
			data: form_data,
			success: function(result) {
				if(result) {
					//alert('Success, Profile saved');
					window.location = PICKR['baseUrl'] + "setting";
				}
				else {
					alert('Error, Can not save profile');
				}
			},
			error: function() {
				alert('Ajax Error');
				//window.location = PICKR['baseUrl'] + "setting";
			}
		});
		return false;
	});

	// Change Password
	$('#change-pass-btn').click(function() {
		var form_data = {
			old_pass: $('#old_pass').val(),
			new_pass: $('#new_pass').val(),
			confirm_new_pass: $('#confirm_new_pass').val()
		};
		if(!$('#change-pass-form').valid())
			return false;
		$.ajax({
			url: PICKR['baseUrl'] + "auth/change_password",
			type: 'POST',
			dataType: 'JSON',
			data: form_data,
			success: function(result) {
				if(result) {
					//alert('Success, Password changed');
					window.location = PICKR['baseUrl'] + "setting";
				}
				else {
					alert('Error, Can not change password');
				}
			},
			error: function() {
				alert('Ajax Error');
				//window.location = PICKR['baseUrl'] + "setting";
			}
		});
		return false;
	});
});
