<?php
session_start();
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satellite Telemetry Dashboard</title>
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #0a192f;
            background-image: url('3d-rendering-dark-earth-space.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            color: white;
            text-align: center;
        }

        /* Navigation Bar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 50px;
            background: #112240;
        }

        .navbar h1 {
            font-size: 24px;
            color: #64ffda;
        }

        .navbar ul {
            list-style: none;
            display: flex;
        }

        .navbar ul li {
            margin: 0 20px;
        }

        .navbar ul li a, .navbar ul li form button {
            color: white;
            text-decoration: none;
            font-size: 18px;
            background: none;
            border: none;
            cursor: pointer;
            font-family: Arial, sans-serif;
        }

        .navbar ul li a:hover, .navbar ul li form button:hover {
            color: #64ffda;
        }

        /* Hero Section */
        .hero {
            height: 90vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 20px;
            max-width: 600px;
            margin-bottom: 30px;
        }

        /* Call to Action Button */
        .btn {
            display: inline-block;
            padding: 12px 30px;
            font-size: 20px;
            color: white;
            background: #64ffda;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn:hover {
            background: #52d3b8;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <h1>Satellite Telemetry Data Visualization Tool</h1>
        <ul>
            <li><a href="index.php">Home</a></li>
<?php if (!$isLoggedIn): ?>
            <li><a href="signup.html">Signup</a></li>
            <li><a href="login.html">Login</a></li>
<?php else: ?>
            <li>Welcome, <?php echo htmlspecialchars($username); ?></li>
            <li>
                <form method="POST" action="logout.php" style="display:inline;">
                    <button type="submit">Logout</button>
                </form>
            </li>
<?php endif; ?>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Monitor Your Satellite in Real Time</h1>
        <p>Track telemetry data, battery status, temperature, and location updates with ease.</p>
        <a href="dash.html" class="btn">Go to Dashboard</a>
    </section>

</body>
</html>
