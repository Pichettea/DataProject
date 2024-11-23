<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account Created - Fit4Life</title>
    <style>
        /* Reset some default browser styles */
        body, h1, p {
            margin: 0;
            padding: 0;
        }

        /* Basic styling for the page */
        body {
            font-family: Arial, sans-serif;
            background-image: url('RegisterImage.jpg'); /* Background image */
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
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

        /* Success Message Styling */
        .success-container {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 50px;
            border-radius: 10px;
            text-align: center;
            width: 80%;
            max-width: 500px;
        }

        h1 {
            font-size: 30px;
            color: #27ae60;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #fff;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #27ae60;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        a:hover {
            background-color: #2ecc71;
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

<!-- Success Message Container -->
<div class="success-container">
    <h1>Account Created Successfully!</h1>
    <p>Congratulations! Your account has been created successfully. You can now log in and start enjoying the features of Fit4Life.</p>
    <a href="Login.php">Go to Login Page</a>
</div>

</body>
</html>
