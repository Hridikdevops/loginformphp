<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit();
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Retrieve user data from the database
    $conn = new mysqli("localhost", "your_username", "your_password", "user_authentication");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, username, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row["password"])) {
            // Login successful
            $_SESSION["user_id"] = $row["id"];
            header("Location: dashboard.php");
            exit();
        } else {
            // Invalid password
            $loginMessage = "Invalid password.";
        }
    } else {
        // User not found, automatically register
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $registerSql = "INSERT INTO users (username, password) VALUES ('$username', '$passwordHash')";
        
        if ($conn->query($registerSql) === TRUE) {
            // Registration and login successful
            $_SESSION["user_id"] = $conn->insert_id;
            $loginMessage = "Welcome, $username! You have been automatically registered and logged in.";
            header("Location: dashboard.php");
            exit();
        } else {
            // Registration failed
            $loginMessage = "Error: " . $registerSql . "<br>" . $conn->error;
        }
    }

    $conn->close();
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
    </style>
</head>
<body>

<div class="container">
    <?php
    // Display login message or error
    if (isset($loginMessage)) {
        echo "<p>$loginMessage</p>";
    }
    ?>

    <!-- Login and Registration Form -->
    <h2>User Login</h2>
    <form action="" method="post">
        <label for="loginUsername">Username:</label>
        <input type="text" id="loginUsername" name="username" required>

        <label for="loginPassword">Password:</label>
        <input type="password" id="loginPassword" name="password" required>

        <button type="submit" name="login">Login</button>
    </form>
</div>

</body>
</html>

