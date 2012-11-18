$(document).ready(function() {
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

	$('#login-btn').click(function() {
		var form_data = {
			name: $('#name').val(),
			pass: $('#pass').val(),
			user_remember_me: $('#user_remember_me').val()
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
});
