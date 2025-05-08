<?php
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - Satellite Dashboard</title>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Arial', sans-serif;
    }

    body {
      height: 100vh;
      background: linear-gradient(135deg, #0a192f, #112240);
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-container {
      background: #112240;
      padding: 40px 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px #64ffda;
      width: 370px;
      text-align: center;
      animation: fadeIn 1s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: scale(0.8);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    .login-container h1 {
      color: #64ffda;
      margin-bottom: 30px;
      font-size: 28px;
    }

    .login-container input[type='text'],
    .login-container input[type='password'] {
      width: 100%;
      padding: 12px 15px;
      margin: 10px 0;
      background: #0a192f;
      border: 2px solid #64ffda;
      border-radius: 5px;
      color: white;
      font-size: 16px;
      outline: none;
      transition: 0.3s;
    }

    .login-container input[type='text']:focus,
    .login-container input[type='password']:focus {
      border-color: #52d3b8;
      box-shadow: 0 0 8px #52d3b8;
    }

    .login-container button {
      width: 100%;
      padding: 12px;
      background: #64ffda;
      border: none;
      margin-top: 20px;
      border-radius: 5px;
      color: #0a192f;
      font-size: 18px;
      cursor: pointer;
      transition: 0.3s;
    }

    .login-container button:hover {
      background: #52d3b8;
    }

    .login-container p {
      margin-top: 20px;
      color: #a9b3c1;
      font-size: 14px;
    }

    .login-container p a {
      color: #64ffda;
      text-decoration: none;
    }

    .login-container p a:hover {
      text-decoration: underline;
    }

    .error {
      color: red;
      font-size: 14px;
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <h1>Satellite Login</h1>
    <form id="loginForm" method="POST" action="login.php">
      <input type="text" id="username" name="username" placeholder="Username" required /><br />
      <input type="password" id="password" name="password" placeholder="Password" required /><br />
      <button type="submit">Login</button>
      <p>
        Don't have an account? <a href="signup.html">Sign up here</a>
      </p>
      <div id="error-message" class="error">
        <?php if ($error) { echo htmlspecialchars($error); } ?>
      </div>
    </form>
  </div>
</body>
</html>
