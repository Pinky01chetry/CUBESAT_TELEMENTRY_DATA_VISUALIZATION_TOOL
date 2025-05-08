<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "satellite_dashboard";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed']));
}

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
        // Handle password reset
        $email = $_POST['email'];
        $newPassword = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        if ($newPassword !== $confirmPassword) {
            echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
            exit();
        }

        // Hash new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update user's password
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashedPassword, $email);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Password reset successful']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to reset password. Please try again.']);
        }
    } else if (isset($_POST['email'])) {
        // Handle email confirmation
        $email = $_POST['email'];

        // Check if email exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            echo json_encode(['status' => 'error', 'message' => 'No user found with that email address.']);
            exit();
        } else {
            echo json_encode(['status' => 'success', 'message' => 'OK']);
        }
    }
}

$conn->close();
?>
