<?php 
session_start();

// Check if the user is signed in
if (!isset($_SESSION['User_ID'])) {
    $_SESSION['error_message'] = "You need to be signed in to access this page.";
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root"; 
$password = "Scgarnier2"; 
$dbname = "fit4life"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fit4Life Views</title>
    <style>
        /* Basic styling */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    display: flex;
}

h1 {
    text-align: center;
    color: #333;
    margin-top: 100px;
    font-size: 2em;
}

/* Title styling */
h2 {
    color: #333;
    font-size: 1.6em;
    margin-bottom: 10px;
    text-align: center; /* Centers the title above the table */
    width: 100%; /* Ensure the title spans the full width of the container */
}

/* Table styling */
table {
    width: 100%; /* Set to 100% to ensure it takes full available width */
    margin-top: 10px;
    margin-left: auto; /* Automatically centers the table */
    margin-right: auto; /* Automatically centers the table */
    border-collapse: collapse;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    table-layout: fixed; /* Ensure the table adjusts to the available width */
}

th, td {
    padding: 4px 8px; /* Reduced padding */
    text-align: left;
    border: 1px solid #ddd;
    font-size: 0.85em; /* Smaller font size */
}

th {
    background-color: #4CAF50;
    color: white;
    text-transform: uppercase;
}

td {
    background-color: #f9f9f9;
}

tr:nth-child(even) td {
    background-color: #f1f1f1;
}

tr:hover {
    background-color: #f5f5f5;
}

.container {
    width: 80%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

p {
    color: #555;
    font-size: 1.1em;
    text-align: center;
    margin-top: 10px;
}

footer {
    text-align: center;
    padding: 10px 0;
    background: #0077cc;
    color: #fff;
    width: 100%;  /* Ensures footer spans the full width */
    position: relative;  /* Ensures it stays at the bottom */
    bottom: 0;
}
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    display: flex;
    flex-direction: column;  /* Allow the footer to stay at the bottom */
    min-height: 100vh;  /* Ensure the body takes at least the full height of the screen */
}

/* Top Navigation Bar styling */
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
    color: white;
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    flex-grow: 1;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
}

.right-links {
    display: flex;
    gap: 20px;
    margin-left: auto;
}

.personal-info {
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    font-weight: bold;
}

.personal-info:hover {
    background-color: #575757;
}

/* Left Sidebar Navigation */
.left-sidebar {
    position: fixed;
    top: 70px; /* To leave space for the top navbar */
    left: 0;
    width: 250px;
    background-color: #333;
    color: white;
    padding-top: 20px;
    height: 100%;
    overflow-y: auto;
    box-sizing: border-box;
}

.left-sidebar a {
    display: block;
    padding: 10px 20px;
    text-decoration: none;
    color: white;
    font-size: 16px;
    margin-bottom: 10px;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.left-sidebar a:hover {
    background-color: #575757;
}

.table-wrapper {
    overflow-x: auto; /* Allow horizontal scroll when content overflows */
    -webkit-overflow-scrolling: touch;
    margin-left: 20px; /* Space for better visual alignment */
    margin-right: auto;
    max-width: 90%; /* Limit width for the scrollable area */
    border: 1px solid #ddd; /* Add a border around the table wrapper */
    padding: 5px;
    max-height: 500px; /* Limit the height for the table to show scroll */
}
.table-wrapper table {
    width: 100%; /* Ensure the table takes full width inside the scrollable wrapper */
}

/* Optional: Move the main content a bit to the left */
.main-content {
    margin-left: 300px; /* Adjust left margin to move content left */
    padding: 20px;
    flex-grow: 1;
}

/* Specific styling for AllUserData table */
#AllUserData {
    width: 100%; /* Ensure the table takes the full available width */
    min-width: 1200px; /* Set a minimum width to prevent squishing */
    table-layout: auto; /* Let the table adjust column width based on content */
}
    </style>
</head>
<body>

<!-- Top Navigation Bar -->
<div class="nav-bar">
    <div class="nav-links">
        <a href="Home.php">Home</a>
        <a href="Activities.php">Activities</a>
        <a href="Profile.php">Profile</a>
        <a href="Community.php">Community</a>
        <a href="Views.php">Views</a>
    </div>
    <div class="company-name">Fit4Life</div>
    <div class="right-links">
        <a href="Logout.php" class="personal-info">Logout</a>
        <a href="Personal_Info.php" class="personal-info">Personal Information</a>
    </div>
</div>

<!-- Left Sidebar Navigation -->
<div class="left-sidebar">
    <?php
    $views = [
        'UserActivityMetrics',
        'UsersAboveAverageCalories',
        'UserActivityFrequency',
        'UserActivitiesHealthMetrics',
        'UsersWithActivitiesAndMetrics',
        'UsersWithPosts',
        'UserActivitySummary',
        'LatestWeightEntry',
        'MostActiveUsers',
        'AllUserData'
    ];

    foreach ($views as $view) {
        echo "<a href='#$view'>$view</a>";
    }
    ?>
</div>

<!-- Main Content Area -->
<div class="main-content">
    <h1>User Data from Views</h1>

    <?php
    foreach ($views as $view) {
        echo "<div class='table-container'>"; // Start of table container
        echo "<h2 id='$view'>Data from View: $view</h2>";
    
        $query = "SELECT * FROM $view";
        $result = $conn->query($query);
    
        if ($result->num_rows > 0) {
            echo "<div class='table-wrapper'>"; // Table wrapper for scrolling
            echo "<table id='$view'>"; // Table for each view
            echo "<tr>";
    
            $field_info = $result->fetch_fields();
            foreach ($field_info as $column) {
                echo "<th>" . $column->name . "</th>";
            }
            echo "</tr>";
    
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . $value . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            echo "</div><br>"; // Close the table wrapper
        } else {
            echo "<p>No data found for $view.</p><br>";
        }
        echo "</div>"; // End of table container
    }
    ?>
</div>

<footer>
  <p>&copy; 2024 Fit4Life Workout Monitor. All rights reserved.</p>
</footer>

</body>
</html>