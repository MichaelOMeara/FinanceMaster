<?php
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard - Finance Master</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="mystyle.css">
</head>
<body class="w3-light-grey">
<div class="w3-bar w3-light-grey w3-border-bottom">
  <a href="index.php" class="w3-bar-item w3-button">Home</a>
  <a href="dashboard.php" class="w3-bar-item w3-button">Dashboard</a>
  <a href="logout.php" class="w3-bar-item w3-button w3-right w3-red">Logout</a>
</div>

<div class="w3-container w3-padding-64 w3-card-4 w3-white w3-margin">
  <h2>Welcome to Finance Master</h2>
  <p>Hello, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</p>
  <p>User Type: <strong><?php echo htmlspecialchars($_SESSION['user_type']); ?></strong></p>
  <p>Status: <strong><?php echo htmlspecialchars($_SESSION['status']); ?></strong></p>

  <a class="w3-button w3-red w3-margin-top" href="logout.php">Logout</a>
</div>

</body>
</html>