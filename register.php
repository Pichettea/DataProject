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
        echo "Passwords do not match!";
    } else {
        // Call the function to insert data
        if (insertUser($conn, $username, $firstName, $lastName, $age, $gender, $phoneNumber, $password)) {
            // Redirect to success page after successful insert
            header("Location: RegisterSuccess.php");
            exit(); // Always call exit after header redirects to ensure the script terminates.
        } else {
            echo "Error inserting user: " . $conn->error;
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
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - Fit4Life</title>

    <style>
        /* Reset some default browser styles */
        body, h1, form {
            margin: 0;
            padding: 0;
        }

        /* Disable horizontal scrolling and full height layout */
        html, body {
            height: 100%;
            font-family: Arial, sans-serif;
            background-image: url('RegisterImage.jpg'); /* Background image */
            background-size: cover;  /* Ensure the image covers the entire page */
            background-position: center center; /* Center the image */
            background-repeat: no-repeat; /* Prevent the image from repeating */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start; /* Ensures proper positioning */
            overflow-x: hidden; /* Prevent horizontal scrolling */
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
            transform: translateX(-50%);  /* Ensures centering */
        }

        /* Form container */
        .form-container {
            background-color: white;
            padding: 25px;  /* Reduced padding for a slightly smaller box */
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 350px; /* Shrunk the width of the form */
            margin-top: 90px; /* Space for fixed navbar */
            display: flex;
            flex-direction: column;
            align-items: center;
            box-sizing: border-box; /* Ensure padding doesn't exceed max-width */
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            width: 100%;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
            width: 100%;
        }

        /* Input and select styling */
        input[type="text"], input[type="email"], input[type="number"], input[type="tel"], input[type="password"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2ecc71;
        }

        /* Error message styling */
        #errorMessage {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<div class="nav-bar">
    <div class="nav-links">
        <a href="Home.php">Home</a>
        <a href="Activities.php">Activities</a>
        <a href="Profile.html">Profile</a>
        <a href="History.html">History</a>
        <a href="Community.html">Community</a>
    </div>
    <div class="company-name">
        Fit4Life
    </div>
</div>

<!-- Register Form Container -->
<div class="form-container">
    <h1>Register to Fit4Life</h1>

    <!-- Form to gather user data -->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="input-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="input-group">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required>
        </div>

        <div class="input-group">
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required>
        </div>

        <div class="input-group">
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required min="16" max="100">
        </div>

        <div class="input-group">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="" disabled selected>Select your gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="input-group">
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required pattern="(\(\d{3}\)\s?|\d{3}[-\s]?)?\d{3}[-\s]?\d{4}" placeholder="123-456-7890">
        </div>

        <div class="input-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required minlength="6">
        </div>

        <div class="input-group">
            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required minlength="6">
        </div>

        <button type="submit">Create Account</button>
    </form>

    <p id="errorMessage"></p>
</div>

<script>
    // Form Validation for Age and UserID generation (Basic Validation)
    document.getElementById('registerForm').onsubmit = function(event) {
        let age = parseInt(document.getElementById('age').value);
        let errorMessage = document.getElementById('errorMessage');

        // Check if the age is under 16
        if (age < 16) {
            event.preventDefault(); // Prevent form submission
            errorMessage.textContent = "You must be 16 years or older to create an account.";
            return false;
        }

        // Generate a simple UserID
        let username = document.getElementById('username').value;
        let userID = "user" + username.substring(0, 4) + Date.now();  // Simple UserID: first 4 chars of username + timestamp
        alert("Your UserID is: " + userID); // Show the generated UserID (for demo purposes)

        // In a real application, this ID would be generated on the server side

        return true; // Allow form submission
    };
</script>

</body>
</html>
