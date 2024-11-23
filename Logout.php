<?php
// Start session and handle logout functionality
session_start();

// Destroy the session to log out the user
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - Fitness Tracker</title>
    <style>
        /* Reset styles */
        body, h1, div, ul, li {
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

        /* Left-side links container */
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

        /* Centered company name (Fit4Life) */
        .company-name {
            font-weight: bold;
            color: white;
            font-size: 24px;
            text-align: center;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        /* Main Content styling */
        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 80px; /* Space for the navigation bar */
        }

        main {
            text-align: center;
            background-color: #0077cc;
            color: white;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 80%; /* Adjust width to make it smaller */
            max-width: 600px; /* Keep it from expanding too wide */
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        #logout-message {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .sign-in-btn {
            background-color: white;
            color: #0077cc;
            border: 2px solid #0077cc;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 16px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
        }

        .sign-in-btn:hover {
            background-color: #005fa3;
            color: white;
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
        <div id="logout-message">
            <h1>Thanks for using Fit4Life, Have a nice day!</h1>
            <a href="Login.php" class="sign-in-btn">Sign Back In</a>
        </div>
    </main>
</div>

</body>
</html>

