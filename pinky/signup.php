<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$servername = "127.0.0.1";
$username = "root";  // Use your MySQL username
$password = "";      // Use your MySQL password
$dbname = "satellite_dashboard";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data (name, email, username, and password)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debug: print received POST data
    echo "<pre>Received POST data: ";
    print_r($_POST);
    echo "</pre>";

    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert a new user into the database
    $sql = "INSERT INTO users (name, email, username, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssss", $name, $email, $username, $hashedPassword);

    if ($stmt->execute()) {
        // Redirect to the login page or return success response
        header("Location: login.html");
        exit();
    } else {
        // Handle duplicate username error gracefully
        if ($conn->errno === 1062) {
            echo "Error: Username already exists. Please choose a different username.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

$conn->close();
?>
