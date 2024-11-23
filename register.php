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

// Function to insert user into the database
function insertUser($conn, $username, $firstName, $lastName, $age, $gender, $phoneNumber, $password) {
    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO Users (Username, FirstName, LastName, Age, Gender, PhoneNumber, UserPassword) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    // Bind parameters with correct types
    $stmt->bind_param("ssssiss", $username, $firstName, $lastName, $age, $gender, $phoneNumber, $password);

    // Execute the query and return the result
    return $stmt->execute();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $phoneNumber = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $error_message = "Passwords do not match!";
    } else {
        // Call the function to insert data
        if (insertUser($conn, $username, $firstName, $lastName, $age, $gender, $phoneNumber, $password)) {
            // Redirect to success page after successful insert
            header("Location: RegisterSuccess.php");
            exit(); // Always call exit after header redirects to ensure the script terminates.
        } else {
            $error_message = "Error inserting user: " . $conn->error;
        }
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Fit4Life</title>

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

        /* Center form container */
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
        input[type="password"],
        input[type="email"],
        input[type="number"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        input[type="submit"],
        button {
            background-color: #fff;
            color: #0077cc;
            padding: 10px 20px;
            border: 2px solid #0077cc;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #0077cc;
            color: white;
        }

        #error-message {
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

<!-- Register Form Container -->
<div class="main-container">
    <main>
        <div id="register-form">
            <h2>Register</h2>
            <form action="register.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" required>

                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" required>

                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required min="16" max="100">

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="" disabled selected>Select your gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>

                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required pattern="(\(\d{3}\)\s?|\d{3}[-\s]?)?\d{3}[-\s]?\d{4}" placeholder="123-456-7890">

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required minlength="6">

                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required minlength="6">

                <input type="submit" value="Create Account">
            </form>

            <?php
            // Display error message if registration fails
            if (isset($error_message)) {
                echo "<p id='error-message'>$error_message</p>";
            }
            ?>

            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </div>
    </main>
</div>

</body>
</html>
