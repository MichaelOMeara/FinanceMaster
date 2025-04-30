

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Finance Master</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    .navbar {
      background-color: #003366;
      color: white;
      display: flex;
      padding: 10px 20px;
      align-items: center;
      justify-content: space-between;
    }
    .navbar a {
      color: white;
      text-decoration: none;
      margin: 0 12px;
      font-weight: bold;
    }
    .navbar a:hover {
      text-decoration: underline;
    }
    .nav-links {
      display: flex;
      gap: 15px;
    }
    .brand {
      font-size: 1.3em;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="navbar">
  <div class="brand">Finance Master</div>
  <div class="nav-links">
    <a href="account.php">Dashboard</a>
    <a href="deposit_withdraw.php">Deposit/Withdraw</a>
    <a href="transfer.php">Transfer</a>
    <a href="transactions.php">Transactions</a>
    <a href="logout.php">Logout</a>
  </div>
</div>


