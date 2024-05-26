$(document).ready(function() {
    $('#login-tab').click(function() {
        $('#register-tab').removeClass('active');
        $('#login-tab').addClass('active');
        $('#register-form').removeClass('active');
        $('#login-form').addClass('active');
    });
    
    $('#register-tab').click(function() {
        $('#login-tab').removeClass('active');
        $('#register-tab').addClass('active');
        $('#login-form').removeClass('active');
        $('#register-form').addClass('active');
    });
});