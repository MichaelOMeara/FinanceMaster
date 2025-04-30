<?php
session_start();
echo"Logged in user_id " .$_SESSION['user_id'];
require 'db_connect.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; 


$query = $pdo->prepare("SELECT * FROM accounts WHERE user_id = ?");
$query->execute([$user_id]);
$accounts = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Finance Master - Deposit/Withdraw</title>
  <style>
    body { font-family: Arial; margin: 20px; background: #f8f9fa; }
    .form-card {
      background: white;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      max-width: 500px;
    }
    input, select, button {
      padding: 10px;
      margin: 10px 0;
      width: 100%;
    }
  </style>
</head>
<body>

  <h2>Deposit / Withdraw Funds</h2>

  <?php foreach ($accounts as $account): ?>
    <div class="form-card">
      <h3><?= ucfirst($account['account_type']) ?> Account</h3>
      <p>Balance: $<?= number_format($account['balance'], 2) ?></p>

      <!-- Deposit/Withdraw Form -->
      <form action="deposit_withdrawAction.php" method="POST">
        <input type="hidden" name="account_id" value="<?= $account['account_id'] ?>">

        <label>Transaction Type:</label>
        <select name="action" required>
          <option value="deposit">Deposit</option>
          <option value="withdraw">Withdraw</option>
        </select>

        <label>Amount:</label>
        <input type="number" step="0.01" name="amount" min="0.01" required>

        <button type="submit">Submit</button>
      </form>
    </div>
  <?php endforeach; ?>

</body>
</html>
