<?php 
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

// Function to fetch activities for a specific week
function fetchActivitiesForWeek($conn, $user_id, $weekStartDate) {
    // Calculate the start and end dates of the week from the $weekStartDate
    $startDate = DateTime::createFromFormat('m/d/Y', $weekStartDate);
    $endDate = clone $startDate;
    $endDate->modify('+6 days');  // Add 6 days to get the end of the week

    // Format the dates back to mm/dd/yyyy for the query
    $startDateFormatted = $startDate->format('Y-m-d');
    $endDateFormatted = $endDate->format('Y-m-d');

    // Prepare the SQL query to fetch activities within the week
    $stmt = $conn->prepare("SELECT Activity_Name, Duration_Minutes, Activity_Date, Calories_Burned
                            FROM Activities
                            WHERE User_ID = ? AND Activity_Date BETWEEN ? AND ?");
    
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param("iss", $user_id, $startDateFormatted, $endDateFormatted); // 'i' for integer and 's' for string

    // Execute the query
    $stmt->execute();

    // Check for execution errors
    if ($stmt->error) {
        die('Execute error: ' . $stmt->error);
    }

    $result = $stmt->get_result();

    // Fetch the activities for that week
    $activities = [];
    while ($row = $result->fetch_assoc()) {
        $activities[] = [
            'name' => $row['Activity_Name'],
            'duration' => $row['Duration_Minutes'],
            'date' => $row['Activity_Date'],
            'calories' => $row['Calories_Burned']
        ];
    }

    // Return the activities for the week
    return $activities;
}

// Get the current date or date passed via GET (for navigation purposes)
$currentDate = isset($_GET['date']) ? $_GET['date'] : date('m/d/Y');

// Fetch activities for the week starting from the $currentDate
$activities = fetchActivitiesForWeek($conn, $user_id, $currentDate);

// Get the user's weight data

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the posted data
    $weight_date = $_POST['weight_date'];
    $weight = $_POST['weight'];

    // Prepare and execute the insert query
    $stmt = $conn->prepare("INSERT INTO Weight_Entries (User_ID, Weight_Date, Weight) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $weight_date, $weight);

    if ($stmt->execute()) {
        echo "Weight data added successfully!";
    } else {
        echo "Error adding weight data: " . $stmt->error;
    }
}

$weightData = [];
$stmt = $conn->prepare("SELECT Weight_Date, Weight FROM Weight_Entries WHERE User_ID = ? ORDER BY Weight_Date ASC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $weightData[] = [
        'date' => $row['Weight_Date'],
        'weight' => $row['Weight']
    ];
}




// Close the database connection
$conn->close();

// Calculate the next and previous weeks' start dates
$nextWeekStart = date('m/d/Y', strtotime($currentDate . ' +7 days'));
$prevWeekStart = date('m/d/Y', strtotime($currentDate . ' -7 days'));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fit4Life Calendar</title>
    <style>
        /* Original CSS Layout */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        /* Navigation bar */
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

        /* Centering the company name in the nav bar */
        .company-name {
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            flex-grow: 1;
            position: absolute; /* This ensures it's centered */
            left: 50%;  /* Centers horizontally */
            transform: translateX(-50%); /* Offsets the element to ensure it's truly centered */
        }
        .right-links {
            display: flex;
            gap: 20px;
            margin-left: auto; /* Pushes the links to the right */
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

        /* Calendar Layout */
        .calendar-container {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 20px;
            padding: 100px 20px 20px 20px; /* Space for fixed nav bar */
        }

        .day {
            background-color: #fff;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            height: 300px;
            overflow-y: auto;
        }

        .day h3 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .activities {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .activities li {
            background-color: #4CAF50;
            color: white;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 14px;
            text-align: center;
        }

        .activities li:hover {
            background-color: #45a049;
        }
        .calories-container {
            margin-top: 10px;
            background-color: #f2f2f2; /* Light gray background */
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Optional shadow for better separation */
        }

        /* Style for the text inside the calories container */
        .calories-text {
            color: #333; /* Dark gray text */
            font-size: 12px;
        }

        /* Weight Input Section */
        .weight-input-container {
            text-align: center;
            margin: 20px;
        }

        .weight-input {
            padding: 10px;
            margin: 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .weight-input-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .weight-input-button:hover {
            background-color: #45a049;
        }

        /* Graph Container */
        .graph-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        /* Adjusting graph size */
        #weightGraph {
            max-width: 600px;
            max-height: 300px;
        }
        footer {
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
            background: #0077cc;
            color: #fff;
        }
    </style>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <div class="right-links">
        <a href="Logout.php" class="personal-info">Logout</a>
        <a href="Personal_Info.php" class="personal-info">Personal Information</a>
    </div>
</div>

<!-- Calendar Navigation -->
<div style="text-align: center; margin-top: 80px;">
    <a href="?date=<?php echo $prevWeekStart; ?>" style="font-size: 18px; padding: 10px; background-color: #4CAF50; color: white; border-radius: 5px;">Previous Week</a>
    <span style="font-size: 24px; margin: 0 20px;">Week of <?php echo date('M d, Y', strtotime($currentDate)); ?></span>
    <a href="?date=<?php echo $nextWeekStart; ?>" style="font-size: 18px; padding: 10px; background-color: #4CAF50; color: white; border-radius: 5px;">Next Week</a>
</div>

<!-- Calendar Container -->
<div class="calendar-container">
    <?php for ($i = 0; $i < 7; $i++): ?>
        <?php 
            // Calculate the current day (current date plus $i days)
            $currentDay = date('Y-m-d', strtotime("$currentDate +$i days"));
            $dayName = date('l', strtotime($currentDay));
        ?>
        <div class="day">
            <h3><?php echo $dayName; ?> (<?php echo date('M d', strtotime($currentDay)); ?>)</h3>
            <ul class="activities" id="<?php echo strtolower($dayName); ?>">
    <?php 
    // Initialize a flag to check if we found any activity for the day
    $foundActivity = false;

    // Loop through the activities and check if any activity matches the current day
    foreach ($activities as $activity) {
        // If activity date matches the current day, display it
        if ($activity['date'] == $currentDay) {
            // Display activity name and duration
            echo "<li>" . htmlspecialchars($activity['name']) . " - " . htmlspecialchars($activity['duration']) . " minutes";
            // Add a new rectangle for calories burned
            echo "<div class='calories-container'>
                    <span class='calories-text'>Calories Burned: " . htmlspecialchars($activity['calories']) . " kcal</span>
                  </div></li>";
            $foundActivity = true;
        }
    }

    // If no activity is found for the day, show a message
    if (!$foundActivity) {
        echo "<li>No activities for this day.</li>";
    }
    ?>
</ul>
            
        </div>
    <?php endfor; ?>
</div>


<!-- Weight Input Section -->
<div class="weight-input-container">
    <form action="Profile.php" method="POST">
        <input type="date" name="weight_date" class="weight-input" required>
        <input type="number" step="0.1" name="weight" class="weight-input" placeholder="Enter your weight" required>
        <button type="submit" class="weight-input-button">Add Weight</button>
    </form>
</div>

<!-- Graph Section -->
<div class="graph-container">
    <canvas id="weightGraph"></canvas>
</div>

<script>
    // Prepare data for the weight graph
    const weightData = <?php echo json_encode($weightData); ?>;
    const labels = weightData.map(entry => entry.date);
    const weights = weightData.map(entry => entry.weight);

    // Create the chart
    const ctx = document.getElementById('weightGraph').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Weight Progress',
                data: weights,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                tension: 0.1
            }]
        }
    });
</script>

<footer>
  <p>&copy; 2024 Fit4Life Workout Monitor. All rights reserved.</p>
</footer>
</body>
</html>