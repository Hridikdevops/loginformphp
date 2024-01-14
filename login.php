<?php
require "DataBase.php";

$db = new DataBase();

// Check if the user is trying to log in
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($db->dbConnect()) {
        if ($db->logIn("users", $username, $password)) {
            echo "Login Success";
        } else {
            echo "Username or Password wrong. <a href='#' onclick='showSignUpForm()'>Sign Up</a>";
        }
    } else {
        echo "Error: Database connection";
    }
}

// Check if the user is trying to sign up
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($db->dbConnect()) {
        if ($db->signUp("users", $fullname, $email, $username, $password)) {
            echo "Sign Up Success. You can now log in.";
        } else {
            echo "Sign Up Failed. Please try again.";
        }
    } else {
        echo "Error: Database connection";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Authentication</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        input {
            padding: 8px;
            width: 250px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 250px;
            font-size: 16px;
        }

        p {
            color: #4caf50;
            margin-top: 10px;
        }

        .error-message {
            color: #ff0000;
            margin-top: 10px;
        }

        #signup-form {
            display: none;
        }
    </style>
    <script>
        function showSignUpForm() {
            document.getElementById("login-form").style.display = "none";
            document.getElementById("signup-form").style.display = "block";
        }
    </script>
</head>
<body>

<div class="container" id="login-form">
    <?php
    // Display login message or error
    if (isset($loginMessage)) {
        echo "<p>$loginMessage</p>";
    }
    ?>

    <!-- Login Form -->
    <h2>User Login</h2>
    <form action="" method="post">
        <label for="loginUsername">Username:</label>
        <input type="text" id="loginUsername" name="username" required>

        <label for="loginPassword">Password:</label>
        <input type="password" id="loginPassword" name="password" required>

        <button type="submit" name="login">Login</button>
    </form>

    <p>If you don't have an account, <a href="#" onclick="showSignUpForm()">Sign Up</a></p>
</div>

<div class="container" id="signup-form">
    <!-- Signup Form -->
    <h2>User Sign Up</h2>
    <form action="" method="post">
        <label for="signupFullname">Full Name:</label>
        <input type="text" id="signupFullname" name="fullname" required>

        <label for="signupEmail">Email:</label>
        <input type="email" id="signupEmail" name="email" required>

        <label for="signupUsername">Username:</label>
        <input type="text" id="signupUsername" name="username" required>

        <label for="signupPassword">Password:</label>
        <input type="password" id="signupPassword" name="password" required>

        <button type="submit" name="signup">Sign Up</button>
    </form>
</div>

</body>
</html>
