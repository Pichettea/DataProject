<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fit4Life Workout Monitor</title>
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

        /* Right-side login/register button */
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

        /* Hero Section */
        .hero-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: black;
            padding-top: 80px; /* Space for the fixed navbar */
            text-align: center;
        }

        .hero-logo {
            margin-bottom: -10px; /* Reduced the margin to bring it closer */
        }

        .hero-logo img {
            max-height: 150px; /* Adjust logo size */
            width: auto;
        }

        .hero-section h1 {
            font-size: 48px;
            margin-top: 10px; /* Reduced the margin to bring it closer */
            margin-bottom: 5px; /* Keep text closer to the logo */
        }

        .hero-section p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        /* Main Content */
        main {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 50px; /* Space for the fixed navigation bar */
        }

        section {
            margin-bottom: 20px;
        }

        h2 {
            color: #0077cc;
            margin-bottom: 10px;
        }

        ul {
            list-style: none;
            padding-left: 20px;
        }

        ul li {
            margin-bottom: 10px;
        }

        blockquote {
            font-style: italic;
            color: #555;
            margin: 10px 0;
            padding-left: 20px;
            border-left: 4px solid #0077cc;
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
<!-- Navigation Bar -->
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

<!-- Hero Section (logo displayed on the page) -->
<div class="hero-section">
    <div class="hero-logo">
        <img src="logo.jpg" alt="Fit4Life Logo"> <!-- Display the logo -->
    </div>
    <h1>Welcome to Fit4Life</h1>
    <p>Your Fitness Journey Starts Here</p>
    <a href="Activities.php" class="login-button">Start Tracking</a>
</div>

<!-- Main Content -->
<main>
    <section class="welcome-section">
        <h2>Track Your Fitness Journey</h2>
        <p>Stay motivated by recording your progress and achieving your wellness milestones!</p>
    </section>
    <section class="features-section">
        <h2>Core Benefits</h2>
        <ul>
            <li>Comprehensive workout logging</li>
            <li>Analyze improvements over time</li>
            <li>Set realistic fitness targets</li>
        </ul>
    </section>
    <section class="about-section">
        <h2>Who Are We?</h2>
        <p>We empower individuals to maintain an active and healthy lifestyle through easy-to-use tracking tools. From novices to fitness enthusiasts, we cater to everyone’s unique needs.</p>
    </section>
    <section class="reviews-section">
        <h2>User Testimonials</h2>
        <blockquote>
            "An essential part of my fitness routine. It helped me get ready for my first marathon!" - Jane D.
        </blockquote>
        <blockquote>
            "Using this app has been a game-changer for my gym consistency. Love it!" - John S.
        </blockquote>
    </section>
</main>

<footer>
    <p>&copy; 2024 Fit4Life Workout Monitor. All rights reserved.</p>
</footer>
</body>
</html>
