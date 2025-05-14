<?php
session_start();
include 'header.php';
include("db_connect.php");

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

<div class="w3-container w3-padding-64 w3-card-4 w3-white w3-margin">
  <h2>Welcome to Finance Master</h2>
  
  <p>Hello, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</p>
  <p>User Type: <strong><?php echo htmlspecialchars($_SESSION['user_type']); ?></strong></p>
  <p>Status: <strong><?php echo htmlspecialchars($_SESSION['status']); ?></strong></p>

  <a class="w3-button w3-red w3-margin-top" href="logout.php">Logout</a>
</div>

</body>
</html>