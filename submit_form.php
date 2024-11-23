<?php
// Database connection settings
$servername = "localhost";
$username = "root";   // Update this with your MySQL username
$password = "Scgarnier2";  // Update this with your MySQL password
$dbname = "fit4life";   // Update this with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Capture form data
$username = $_POST['username'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

// Check if passwords match
if ($password !== $confirmPassword) {
    echo "Error: Passwords do not match!";
    exit; // Stop execution
}

// Password hashing for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Create SQL query using prepared statements
$sql = $conn->prepare("INSERT INTO Users (Username, FirstName, LastName, Age, Gender, PhoneNumber, UserPassword) VALUES (?, ?, ?, ?, ?, ?, ?)");

// Check if the prepared statement was successful
if (!$sql) {
    die("Failed to prepare the SQL statement: " . $conn->error);
}

// Bind parameters (correct the types: 'i' for integer and 's' for string)
$sql->bind_param("ssissss", $username, $firstname, $lastname, $age, $gender, $phone, $hashedPassword);

// Execute the query and check for errors
if ($sql->execute()) {
    // Redirect to Home.html after successful registration
    header("Location: Home.html");
    exit; // Ensure no further code is executed
} else {
    // Show detailed error if the query fails
    echo "Error: " . $sql->error;
}

// Close the connection
$conn->close();
?>


