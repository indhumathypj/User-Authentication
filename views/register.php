<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .wrapper {
            width: 360px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .invalid-feedback {
            display: block;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: #ffffff;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        p {
            margin-top: 15px;
            text-align: center;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        #passwordStrength {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>

        <?php if (isset($message)): ?>
            <p style="color: green;"><?php echo htmlspecialchars($message); ?></p>
        <?php elseif (isset($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>" autocomplete="off" required>
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($email); ?>" autocomplete="off" required>
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" autocomplete="new-password" required>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                <div id="passwordStrength"></div>
            </div>
            <div class="form-group">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('password').addEventListener('input', function () {
            var password = this.value;
            var strengthBar = document.getElementById('passwordStrength');
            var strength = getPasswordStrength(password);

            strengthBar.innerHTML = 'Password strength: ' + strength.text;
            strengthBar.style.color = strength.color;
        });

        function getPasswordStrength(password) {
            var strength = {
                text: 'Weak',
                color: 'red'
            };

            if (password.length >= 8 &&
                /[a-z]/.test(password) &&
                /[A-Z]/.test(password) &&
                /[0-9]/.test(password) &&
                /[^a-zA-Z0-9]/.test(password)) {
                strength.text = 'Strong';
                strength.color = 'green';
            } else if (password.length >= 6) {
                strength.text = 'Medium';
                strength.color = 'orange';
            }

            return strength;
        }
    </script>
</body>
</html>
