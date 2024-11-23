<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fit4Life Workout Monitor - Activities</title>
  <style>
        /* General Reset */
        body, h1, h2, p, ul, li {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            color: #333;
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

        .login-button {
            background-color: #0077cc;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .login-button:hover {
            background-color: #005fa3;
        }

        /* Main Content */
        main {
            padding: 20px;
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 80px; /* Space for the fixed navigation bar */
        }

        h2 {
            color: #0077cc;
            margin-bottom: 20px;
            text-align: center;
        }

        .activities-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .activity-card {
            text-align: center;
            background-color: #fff;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .activity-card:hover {
            transform: scale(1.05);
        }

        .activity-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 2px solid #0077cc;
        }

        .activity-card h3 {
            margin-top: 10px;
            font-size: 18px;
            color: #333;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
            background: #0077cc;
            color: #fff;
        }
    </style>
</head>
<body>
<!-- New Navigation Bar -->
<div class="nav-bar">
  <div class="nav-links">
    <a href="Home.php">Home</a>
    <a href="Activities.php" class="current">Activities</a>
    <a href="Profile.php">Profile</a>
    <a href="Community.php">Community</a>
    <a href="Views.php">Views</a>
  </div>
  <div class="company-name">Fit4Life</div>
  <a href="Login.php" class="login-button">Login/Register</a>
</div>

<!-- Main Content -->
<main>
  <h2>Choose Your Activity</h2>
  <div class="activities-container">
    <div class="activity-card">
      <a href="Running.php">
        <img src="running.jpg" alt="Activity 1">
        <h3>Running</h3>
      </a>
    </div>
    <div class="activity-card">
      <a href="Yoga.php">
        <img src="Yoga.jpg" alt="Activity 2">
        <h3>Yoga</h3>
      </a>
    </div>
    <div class="activity-card">
      <a href="Cycling.php">
        <img src="Cycling.jpg" alt="Activity 3">
        <h3>Cycling</h3>
      </a>
    </div>
    <div class="activity-card">
      <a href="Swimming.php">
        <img src="swimming.jpg" alt="Activity 4">
        <h3>Swimming</h3>
      </a>
    </div>
  </div>
</main>

<footer>
  <p>&copy; 2024 Fit4Life Workout Monitor. All rights reserved.</p>
</footer>
</body>
</html>