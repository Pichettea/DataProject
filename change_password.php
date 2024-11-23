<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

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

// Get the current user's username from the session
$current_user = $_SESSION['username'];

// Initialize error messages
$error_message = '';
$success_message = '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure the POST values are set before accessing them
    if (isset($_POST['old_password'], $_POST['new_password'], $_POST['confirm_password'])) {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate that new password and confirm password match
        if ($new_password != $confirm_password) {
            $error_message = "New password and confirm password do not match.";
        } else {
            // Escape the user inputs to prevent SQL injection
            $old_password = $conn->real_escape_string($old_password);
            $new_password = $conn->real_escape_string($new_password);
            $confirm_password = $conn->real_escape_string($confirm_password);

            // Query to fetch the current password for the user
            $sql = "SELECT UserPassword FROM users WHERE Username = '$current_user' LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Fetch the current password from the database
                $user = $result->fetch_assoc();

                // Check if the entered old password matches the stored password
                if ($user['UserPassword'] == $old_password) {
                    // Update the password in the database
                    $sql_update = "UPDATE users SET UserPassword = '$new_password' WHERE Username = '$current_user'";

                    if ($conn->query($sql_update) === TRUE) {
                        // Success: Redirect to Personal_Info.php after password change
                        header("Location: Personal_Info.php");
                        exit();  // Ensure the script stops after the redirect
                    } else {
                        $error_message = "Error updating password: " . $conn->error;
                    }
                } else {
                    $error_message = "Old password is incorrect.";
                }
            } else {
                $error_message = "User not found.";
            }
        }
    } else {
        $error_message = "Please fill in all fields.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - Fit4Life</title>
    <style>
        /* Reset styles */
        body, h1, h2, p, form, input, button {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* General body styling */
        html, body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
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
            position: absolute;  /* Position the company name absolutely */
            left: 50%;  /* Move it to the middle */
            transform: translateX(-50%);  /* Adjust for exact centering */
        }

        /* Form container */
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
            margin-top: 80px; /* Add space below the navigation bar */
        }

        h2 {
            color: #0077cc;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .form-container label {
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
            display: block;
            text-align: left;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .form-container button {
            background-color: #0077cc;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            max-width: 200px;
        }

        .form-container button:hover {
            background-color: #005fa3;
        }

        /* Error and success messages */
        .message {
            margin-top: 10px;
            font-size: 16px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
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

<!-- Form Container -->
<div class="form-container">
    <h2>Change Password</h2>
    <form action="change_password.php" method="POST">
        <label for="old_password">Old Password:</label>
        <input type="password" id="old_password" name="old_password" required>

        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>

        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit">Change Password</button>
    </form>

    <!-- Display error or success messages -->
    <?php if ($error_message): ?>
        <p class="message error"><?php echo $error_message; ?></p>
    <?php elseif ($success_message): ?>
        <p class="message success"><?php echo $success_message; ?></p>
    <?php endif; ?>

</div>

</body>
</html>

