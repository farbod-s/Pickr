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
			url: "index.php/auth/register",
			type: 'POST',
			dataType: 'JSON',
			data: form_data,
			success: function(result) {
				if (result) {
					//alert('Success');
                	window.location = "index.php";
	            }
	            else {
	                alert('Error'); // TODO
	            }
			},
			error: function() {
				//alert('Fatal Error');
				window.location = "index.php";
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
			url: "index.php/auth/login",
			type: 'POST',
			dataType: 'JSON',
			data: form_data,
			success: function(result) {
				if(result) {
					//alert('Success');
					window.location = "index.php";
				}
				else {
					alert('Error'); // TODO
				}
			},
			error: function() {
				//alert('Fatal Error');
				window.location = "index.php";
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
			url: "http://localhost/www/codeigniter/index.php/setting/update_setting", // BUG
			type: 'POST',
			dataType: 'JSON',
			data: form_data,
			success: function(result) {
				if(result) {
					alert('Success');
					//window.location = "index.php/setting";
				}
				else {
					alert('Error'); // TODO
				}
			},
			error: function() {
				alert('Fatal Error');
				//window.location = "index.php/setting";
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
			url: "http://localhost/www/codeigniter/index.php/auth/change_password", //BUG
			type: 'POST',
			dataType: 'JSON',
			data: form_data,
			success: function(result) {
				if(result) {
					alert('Success');
					//window.location = "index.php/setting";
				}
				else {
					alert('Error'); // TODO
				}
			},
			error: function() {
				alert('Fatal Error');
				//window.location = "index.php/setting";
			}
		});
		return false;
	});
});
