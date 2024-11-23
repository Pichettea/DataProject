<?php

$servername = "localhost"; // or your server's host name
$username = "root"; // your database username
$password = "Scgarnier2"; // your database password
$dbname = "fit4life"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the login form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Escape special characters to prevent SQL injection
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Query to find the user with the given username
    $sql = "SELECT * FROM users WHERE Username = '$username' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists, check password
        $user = $result->fetch_assoc();

        // Compare the input password with the stored password
        // Assuming the password is stored as plain text
        // If you are hashing the password, you will need to use password_verify()
        if ($user['UserPassword'] == $password) {
            // Successful login
            // Start session
            session_start();

            // Set session variables (add user details to the session)
            $_SESSION['username'] = $user['Username'];
            $_SESSION['User_ID'] = $user['UserID']; // Assuming you have a UserID column
            $_SESSION['firstname'] = $user['FirstName'];
            $_SESSION['lastname'] = $user['LastName'];
            $_SESSION['age'] = $user['Age'];
            $_SESSION['gender'] = $user['Gender'];
            $_SESSION['phone'] = $user['PhoneNumber'];

            // Redirect to the profile page
            header("Location: Profile.php");
            exit();
        } else {
            // Incorrect password
            $error_message = "Incorrect password.";
        }
    } else {
        // No such user
        $error_message = "No user found with that username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Fit4Life</title>
    <style>
        /* Reset styles */
        body, h1, div, ul, li, form, input, label {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* General body styling */
        html, body {
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        /* Navigation Bar */
        .nav-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 15px 30px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            width: 100%;
            box-sizing: border-box;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .nav-links a:hover {
            background-color: #575757;
        }

        .company-name {
            font-weight: bold;
            color: white;
            font-size: 24px;
            text-align: center;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        /* Center login form */
        .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
            width: 100%;
            height: 100vh;
        }

        main {
            background-color: #0077cc;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            color: white;
            margin-bottom: 20px;
            font-size: 24px;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 8px;
            color: white;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #fff;
            color: #0077cc;
            padding: 10px 20px;
            border: 2px solid #0077cc;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #0077cc;
            color: white;
        }

        #login-error {
            color: red;
            margin-top: 10px;
        }

        p {
            margin-top: 15px;
            color: white;
        }

        a {
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<div class="nav-bar">
    <div class="nav-links">
        <a href="Home.php">Home</a>
        <a href="Activities.php">Activities</a>
        <a href="Profile.php">Profile</a>
        <a href="Community.php">Community</a>
        <a href="Views.php">Views</a>
    </div>
    <div class="company-name">
        Fit4Life
    </div>
</div>

<!-- Main Content Container -->
<div class="main-container">
    <main>
        <div id="login-form">
            <h2>Login</h2>
            <form action="login.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <input type="submit" value="Login">
            </form>
            
            <?php
            // Display error message if login fails
            if (isset($error_message)) {
                echo "<p id='login-error'>$error_message</p>";
            }
            ?>

            <p>Don't have an account? <a href="register.php">Create one here</a>.</p>
        </div>
    </main>
</div>

</body>
</html>

