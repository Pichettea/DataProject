<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get user details from session
$username = $_SESSION['username'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$age = $_SESSION['age'];
$gender = $_SESSION['gender'];
$phone = $_SESSION['phone'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Fit4Life</title>
    <style>
        /* Reset styles */
        body, h1, h2, p, form, button {
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
            flex-direction: column;
            height: 100vh;
            margin: 0;
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

        /* Profile container */
        .profile-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
            margin-top: 80px; /* Add space below the navigation bar */
        }

        h2 {
            color: #0077cc;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .profile-info {
            text-align: left;
            margin-bottom: 20px;
        }

        .profile-info p {
            font-size: 16px;
            color: #333;
            margin-bottom: 12px;
        }

        .profile-info strong {
            font-weight: bold;
            color: #0077cc;
        }

        button {
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
            margin-top: 20px;
        }

        button:hover {
            background-color: #005fa3;
        }

        /* Links styling */
        a {
            color: #0077cc;
            text-decoration: none;
            font-size: 14px;
        }

        a:hover {
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

<!-- Profile Container -->
<div class="profile-container">
    <h2>User Profile</h2>
    <div class="profile-info">
        <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
        <p><strong>First Name:</strong> <?php echo htmlspecialchars($firstname); ?></p>
        <p><strong>Last Name:</strong> <?php echo htmlspecialchars($lastname); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($age); ?></p>
        <p><strong>Gender:</strong> <?php echo htmlspecialchars($gender); ?></p>
        <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($phone); ?></p>
    </div>
    <form action="change_password.php" method="POST">
        <button type="submit">Change Password</button>
    </form>
    <p><a href="logout.php">Logout</a></p>
</div>

</body>
</html>



