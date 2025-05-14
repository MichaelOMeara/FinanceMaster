<?php
session_start();

include("db_connect.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
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

  <!-- Navigation Buttons -->
  <div class="w3-margin-top">
    <a href="account.php" class="w3-button w3-blue w3-margin-right">Accounts</a>
    <a href="deposit_withdraw.php" class="w3-button w3-green w3-margin-right">Deposit/Withdraw</a>
    <a href="transfer.php" class="w3-button w3-orange w3-margin-right">Transfer</a>
    <a href="transactions.php" class="w3-button w3-purple">Transactions</a>
  </div>

  <a class="w3-button w3-red w3-margin-top" href="logout.php">Logout</a>
</div>

</body>
</html>



