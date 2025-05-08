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
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'] ?? '';
    $emailInput = $_POST['email'] ?? '';
    $newPassword = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($token)) {
        die("Invalid token.");
    }

    if ($newPassword !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // Check if token is valid and not expired and email matches
    $stmt = $conn->prepare("SELECT email, expires_at FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Invalid or expired token.");
    }

    $row = $result->fetch_assoc();
    $expiresAt = $row['expires_at'];
    $email = $row['email'];

    if (strtotime($expiresAt) < time()) {
        die("Token has expired.");
    }

    if ($email !== $emailInput) {
        die("Email does not match the token.");
    }

    // Hash new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update user's password
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashedPassword, $email);
    if ($stmt->execute()) {
        // Delete token
        $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        echo "Password has been reset successfully. You can now <a href='login.html'>login</a>.";
    } else {
        echo "Failed to reset password. Please try again.";
    }
}

$conn->close();
?>
