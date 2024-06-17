<?php
    require_once "session.php";
    startSession();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="./public/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./public/script.js"></script>
    <script>
        $('document').ready(function() {
            $('#login-btn').click(function () {
                if ($('#login-username').val() == "" || $('#login-password').val() == "" ) {
                    alert("Fill all inputs");
                } else {
                    $.ajax({
                        method: 'post',
                        url: 'login.php',
                        contentType: "application/json; charset=utf-8",
                        data: JSON.stringify({
                            username: $('#login-username').val(),
                            password: $('#login-password').val(),
                        }),
                        success: function (resp) {
                            console.log(resp);
                            if (resp.status == 'error') {
                                alert('No user was found with those username and password');
                            } else {
                                if ($('#login-username').val() == "admin"){
                                    window.location.replace('admin.php');
                                } else {
                                    window.location.replace('main.php');
                                }
                            }
                        },
                    });
                }
            });
            $('#reg-btn').click(function () {
                if ($('#register-username').val() == "" || $('#register-password').val() == "" || $('#register-confirm-password').val() == "" ) {
                    alert("Fill all inputs");
                } else if ($('#register-password').val() != $('#register-confirm-password').val()) {
                    alert("Confirm password input value is invalid");
                } 
                else {
                    $.ajax({
                        method: 'post',
                        url: 'logup.php',
                        contentType: "application/json; charset=utf-8",
                        data: JSON.stringify({
                            username: $('#register-username').val(),
                            password: $('#register-password').val(),
                        }),
                        success: function (resp) {
                            console.log(resp);
                            if (resp.status == 'error') {
                                alert('Current user already exists');
                            } else {
                                alert(`User ${$('#register-username').val()} was registered`);
                                $('#register-username').val("");
                                $('#register-password').val("");
                                $('#register-confirm-password').val("");
                                $('#login-tab').click();
                            }
                        },
                    });
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <div id="login-tab" class="form-tab active">Login</div>
                <div id="register-tab" class="form-tab">Register</div>
            </div>
            <div class="form-body">
                <div id="login-form" class="form-content active">
                    <label for="login-username">Username</label>
                    <input type="text" id="login-username" name="username" required>
                    
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" name="password" required>
                    
                    <button id="login-btn">Login</button>
                </div>
                
                <div id="register-form" class="form-content">
                    <label for="register-username">Username</label>
                    <input type="text" id="register-username" name="username" required>
                    
                    <label for="register-password">Password</label>
                    <input type="password" id="register-password" name="password" required>
                    
                    <label for="register-confirm-password">Confirm Password</label>
                    <input type="password" id="register-confirm-password" name="confirm_password" required>
                    
                    <button id="reg-btn">Register</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
