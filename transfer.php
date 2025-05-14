<?php
session_start();
require 'db_connect.php';
include 'header.php';

// TEMP: Replace with $_SESSION['user_id'] when login is active
$user_id = $_SESSION['user_id']; 

// Fetch user accounts
$stmt = $pdo->prepare("SELECT * FROM accounts WHERE user_id = ? AND status = 'active'");
$stmt->execute([$user_id]);
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errorMessage = isset($_GET['error']) ? $_GET['error'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Finance Master - Transfer Money</title>
  <style>
    body { font-family: Arial; margin: 20px; }
    .form-card {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      max-width: 500px;
      margin: auto;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    input, select, button {
      width: 100%;
      margin: 10px 0;
      padding: 10px;
    }
  </style>
  <script>
    // If PHP passes an error, show it
    <?php if (!empty($errorMessage)): ?>
      alert("<?= htmlspecialchars($errorMessage) ?>");
    <?php endif; ?>
  </script>
</head>
<body>


<h2>Transfer Funds Between Accounts</h2>

<div class="form-card">
  <form action="transferAction.php" method="POST">
    <label>From Account:</label>
    <select name="from_account" required>
      <?php foreach ($accounts as $acc): ?>
        <option value="<?= $acc['account_id'] ?>"><?= ucfirst($acc['account_type']) ?> (Balance: $<?= number_format($acc['balance'], 2) ?>)</option>
      <?php endforeach; ?>
    </select>

    <label>To Account:</label>
    <select name="to_account" required>
      <?php foreach ($accounts as $acc): ?>
        <option value="<?= $acc['account_id'] ?>"><?= ucfirst($acc['account_type']) ?> (Balance: $<?= number_format($acc['balance'], 2) ?>)</option>
      <?php endforeach; ?>
    </select>

    <label>Amount:</label>
    <input type="number" step="0.01" name="amount" min="0.01" required>

    <button type="submit">Transfer</button>
  </form>
</div>

</body>
</html>
