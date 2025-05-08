<?php
session_start();
// Database connection details
$servername = "localhost";
$username = "root";  // Use your MySQL username
$password = "";      // Use your MySQL password
$dbname = "satellite_dashboard";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Clear previous error message
unset($_SESSION['login_error']);

// Get POST data (username and password)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredUsername = $_POST['username'];
    $enteredPassword = $_POST['password'];

    // SQL query to find the user by username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $enteredUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if username exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the entered password against the stored password (hashed)
        if (password_verify($enteredPassword, $user['password'])) {
            // Login successful
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            // Invalid password
            $_SESSION['login_error'] = "Incorrect password";
            header("Location: login.html");
            exit();
        }
    } else {
        // Invalid username
        $_SESSION['login_error'] = "Invalid username or password";
        header("Location: login.html");
        exit();
    }
}

$conn->close();
?>
