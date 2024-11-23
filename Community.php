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

$user_id = $_SESSION['User_ID']; // Get the logged-in user's ID from the session

// Function to insert a community post
function insertCommunityPost($conn, $user_id, $title, $content, $category) {
    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO community_posts (User_ID, Title, Content, Category) 
                            VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);  // If preparing fails
    }
    
    $stmt->bind_param("isss", $user_id, $title, $content, $category);
    
    if (!$stmt->execute()) {
        die("Error executing query: " . $stmt->error);  // If executing fails
    }
    return true;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize user inputs
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Validate inputs (basic validation)
    if (empty($title) || empty($content) || empty($category)) {
        echo "All fields are required.";
    } else {
        // Insert the post into the database
        if (insertCommunityPost($conn, $user_id, $title, $content, $category)) {
            // Redirect to community page after successful post submission
            header("Location: Community.php");
            exit(); // Always call exit after header redirects to ensure the script terminates.
        } else {
            echo "Error inserting post.";
        }
    }
}

// Fetch all posts from the community_posts table
$sql = "SELECT p.Post_ID, p.Title, p.Content, p.Category, p.Created_At, u.Username 
        FROM community_posts p 
        JOIN Users u ON p.User_ID = u.UserID 
        ORDER BY p.Created_At DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Post</title>
    <style>
        /* Include the styles from your original navbar */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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

        .nav-links a {
            color: white;
            text-decoration: none;
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

        .Logout-button {
            background-color: #0077cc;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .Logout-button:hover {
            background-color: #005fa3;
        }

        /* Main Content */
        main {
            padding: 20px;
            max-width: 800px;
            margin: 80px auto 20px; /* Adjusted for navbar */
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .post-btn {
            background-color: #0077cc;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .post-btn:hover {
            background-color: #005fa3;
        }

        .post {
            border-bottom: 1px solid #ddd;
            margin-bottom: 15px;
            padding-bottom: 15px;
        }

        .post h3 {
            color: #0077cc;
        }

        .post p {
            margin-top: 5px;
        }

        .category-label {
            font-size: 14px;
            font-weight: bold;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background: #0077cc;
            color: white;
            margin-top: 20px;
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
        <a href="Community.php" class="current">Community</a>
        <a href="Views.php">Views</a>
    </div>
    <div class="company-name">Fit4Life</div>
    <a href="Logout.php" class="Logout-button">Logout</a>
</div>

<!-- Main Content -->
<main>
    <h2>Share Your Experience & Tips</h2>
    <!-- Search Bar -->
    <div class="search-bar">
        <input type="text" id="search" placeholder="Search for topics...">
    </div>

    <!-- Post Form -->
    <form action="Community.php" method="POST">
        <div class="form-group">
            <label for="title">Post Title</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="content">Post Content</label>
            <textarea id="content" name="content" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="category">Select Category</label>
            <select name="category" id="category">
                <option value="tips">Tips</option>
                <option value="educational">Educational</option>
                <option value="food">Food</option>
                <option value="fun">For Fun</option>
                <option value="any">Any</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="post-btn">Post</button>
        </div>
    </form>

    <!-- Posts Section -->
    <div id="posts-container">
        <?php
        // Display fetched posts
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='post'>
                        <h3>" . htmlspecialchars($row['Title']) . "</h3>
                        <p><strong>Category:</strong> " . htmlspecialchars($row['Category']) . "</p>
                        <p><strong>Posted by:</strong> " . htmlspecialchars($row['Username']) . " | <strong>Posted on:</strong> " . htmlspecialchars($row['Created_At']) . "</p>
                        <p>" . nl2br(htmlspecialchars($row['Content'])) . "</p>
                      </div>";
            }
        } else {
            echo "<p>No posts found.</p>";
        }
        ?>
    </div>
</main>

<!-- Footer -->
<footer>
    <p>&copy; 2024 Fit4Life Workout Monitor. All rights reserved.</p>
</footer>

<!-- JavaScript for filtering posts based on search -->
<script>
    document.getElementById("search").addEventListener("input", function() {
        var searchQuery = this.value.toLowerCase();
        var posts = document.querySelectorAll(".post");
        posts.forEach(function(post) {
            var title = post.querySelector("h3").textContent.toLowerCase();
            var content = post.querySelector("p").textContent.toLowerCase();
            if (title.includes(searchQuery) || content.includes(searchQuery)) {
                post.style.display = "block";
            } else {
                post.style.display = "none";
            }
        });
    });
</script>
</body>
</html>


