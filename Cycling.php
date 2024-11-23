<?php
// Start the session to check if the user is logged in
session_start();

// Check if the user is signed in (if the session 'User_ID' is not set)
if (!isset($_SESSION['User_ID'])) {
    // Set a session variable or pass a message through the URL to indicate the need for login
    $_SESSION['error_message'] = "You need to be signed in to access this page.";

    // Redirect to the login page
    header("Location: login.php");  // Assuming 'login.php' is your login page
    exit(); // Make sure to call exit after header to stop further script execution
}

$user_id = $_SESSION['User_ID']; // Get the logged-in user's ID from the session

// Database connection
$servername = "localhost";
$username = "root"; // your database username
$password = "Scgarnier2"; // your database password
$dbname = "fit4life"; // your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function insertActivities($conn, $user_id, $activity_name, $duration_minutes, $calories_burned, $activity_date) {
    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO Activities (User_ID, Activity_Name, Duration_Minutes, Calories_Burned, Activity_Date) 
                            VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);  // If preparing fails
    }
    
    $stmt->bind_param("isdis", $user_id, $activity_name, $duration_minutes, $calories_burned, $activity_date);
    
    if (!$stmt->execute()) {
        die("Error executing query: " . $stmt->error);  // If executing fails
    }
    return true;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $duration_minutes = $_POST['duration_minutes'];
    $calories_burned = $_POST['calories_burned'];
    $activity_date = $_POST['activity_date'];

    // Validate inputs
    if (empty($duration_minutes) || empty($calories_burned) || empty($activity_date)) {
        $error_message = "All fields are required.";
    } elseif ($duration_minutes <= 0) {
        $error_message = "Duration must be more than 0 minutes.";
    } elseif ($calories_burned < 0) {
        $error_message = "Calories burned must be 0 or greater.";
    } else {
        // Prepare the SQL statement using prepared statements
        $activity_name = 'Cycling'; // Fixed activity name
    
        if (insertActivities($conn, $user_id, $activity_name, $duration_minutes, $calories_burned, $activity_date)) {
            header("Location: Profile.php");
            exit(); // Always call exit after header redirects to ensure the script terminates.
        } else {
            echo "Error inserting Activity: " . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Activity - Workout Monitor</title>
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

        .error-message {
            color: red;
            text-align: center;
            font-size: 16px;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        input[type="number"], input[type="date"] {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 300px;
        }

        input[type="submit"] {
            background-color: #0077cc;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #005fa3;
        }
    </style>
</head>
<body>

<!-- New Navigation Bar (without login button) -->
<div class="nav-bar">
    <div class="nav-links">
        <a href="Home.php">Home</a>
        <a href="Activities.php" class="current">Activities</a>
        <a href="Profile.php">Profile</a>
        <a href="Community.php">Community</a>
        <a href="Views.php">Views</a>
    </div>
    <div class="company-name">Fit4Life</div>
</div>

<!-- Main Content Container -->
<div class="main-container">
    <main>
        <h2>Log Your Activity</h2>
        <form action="Cycling.php" method="POST">
            <label for="duration_minutes">Duration (minutes):</label>
            <input type="number" id="duration_minutes" name="duration_minutes" min="1" required>

            <label for="calories_burned">Calories Burned:</label>
            <input type="number" id="calories_burned" name="calories_burned" min="0" required>

            <label for="activity_date">Date of Activity:</label>
            <input type="date" id="activity_date" name="activity_date" required>

            <input type="submit" value="Log Activity">
        </form>

        <!-- Display error message if any -->
        <?php if (isset($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </main>
</div>

</body>
</html>