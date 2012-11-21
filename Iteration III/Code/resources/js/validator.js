$(document).ready(function() {

    // Validation sign up form
    $("#register-form").validate({
        rules: {
            username: {required: true, minlength: 4, maxlength: 20},
            email: {required: true, email: true},
            password: {required: true, minlength: 6},
            confirm_password: {required: true, equalTo: "#password"},
        },
        messages: {
            username: {
                required: "Enter your Username",
                minlength: "Username must be minimum 4 characters",
                maxlength: "Username must be maximum 20 characters"},
            email: {
                required: "Enter your Email address",
                email: "Enter valid Email address"},
            password: {
                required: "Enter your Password",
                minlength: "Password must be minimum 6 characters"},
            confirm_password: {
                required: "Enter Confirm Password",
                equalTo: "Password and Confirm Password must match"},
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight: function(element, errorClass, validClass)
        {
            $(element).parents('.control-group').removeClass('success');
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass)
        {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });

    // Validation Change Password form    
    $("#change-pass-form").validate({
        rules: {
            old_pass: {required: true, minlength: 6},
            new_pass: {required: true, minlength: 6},
            confirm_new_pass: {required: true, equalTo: "#new_pass"},
        },
        messages: {
            old_pass: {
                required: "Enter your Old Password",
                minlength: "Old Password must be minimum 6 characters"},
            new_pass: {
                required: "Enter your new Password",
                minlength: "New Password must be minimum 6 characters"},
            confirm_new_pass: {
                required: "Enter Confirm Password",
                equalTo: "New Password and Confirm Password must match"},
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight: function(element, errorClass, validClass)
        {
            $(element).parents('.control-group').removeClass('success');
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass)
        {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });
});