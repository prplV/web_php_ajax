<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration</title>
    <link rel="stylesheet" href="./public/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./public/script.js"></script>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <div id="login-tab" class="form-tab active">Login</div>
                <div id="register-tab" class="form-tab">Register</div>
            </div>
            <div class="form-body">
                <form id="login-form" class="form-content active">
                    <label for="login-username">Username</label>
                    <input type="text" id="login-username" name="username" required>
                    
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" name="password" required>
                    
                    <button type="submit">Login</button>
                </form>
                
                <form id="register-form" class="form-content">
                    <label for="register-username">Username</label>
                    <input type="text" id="register-username" name="username" required>
                    
                    <label for="register-email">Email</label>
                    <input type="email" id="register-email" name="email" required>
                    
                    <label for="register-password">Password</label>
                    <input type="password" id="register-password" name="password" required>
                    
                    <label for="register-confirm-password">Confirm Password</label>
                    <input type="password" id="register-confirm-password" name="confirm_password" required>
                    
                    <button type="submit">Register</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
