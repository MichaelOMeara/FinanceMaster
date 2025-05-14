<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login - Finance Master</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="mystyle.css">
</head>
<body class="w3-light-grey">
<div class="w3-bar w3-light-grey w3-border-bottom">
  <a href="index.php" class="w3-bar-item w3-button">Home</a>
  <a href="register.php" class="w3-bar-item w3-button">Register</a>
  <a href="login.php" class="w3-bar-item w3-button w3-right">Login</a>
</div>

<div class="w3-container w3-padding-64 w3-card-4 w3-white w3-margin">
  <h2>Login</h2>
  <form action="loginaction.php" method="post" class="w3-container">
    <label>Username</label>
    <input class="w3-input" type="text" name="username" required>

    <label>Password</label>
    <input class="w3-input" type="password" name="password" required>

    <button class="w3-button w3-green w3-margin-top" type="submit">Login</button>
  </form>

  <!-- Forgot password button -->
  <div class="w3-margin-top">
    <form action="forgot_password.php" method="get">
      <label>Forgot your password?</label><br>
      <input class="w3-input w3-border w3-margin-top" type="text" name="username" placeholder="Enter your username" required>
      <button class="w3-button w3-blue w3-margin-top">Recover Password</button>
    </form>
  </div>
</div>

</body>
</html>
