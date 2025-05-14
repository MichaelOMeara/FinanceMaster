<?php
session_start();
include 'header.php';
require 'db_connect.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; 

$stmt = $pdo->prepare("SELECT * FROM accounts WHERE user_id = ? AND status = 'active'");
$stmt->execute([$user_id]);
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errorMessage = isset($_GET['error']) ? $_GET['error'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Deposit/Withdraw - Finance Master</title>
  <style>
    body { font-family: Arial; margin: 20px; }
    .form-card {
      background: #f9f9f9;
      padding: 20px;
      border-radius: 8px;
      max-width: 500px;
      margin: auto;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    input, select, button {
      width: 100%;
      margin: 10px 0;
      padding: 10px;
    }
  </style>
  <script>
    // Show popup if an error exists
    <?php if (!empty($errorMessage)): ?>
      alert("<?= htmlspecialchars($errorMessage) ?>");
    <?php endif; ?>
  </script>
</head>
<body>


<h2>Deposit or Withdraw Funds</h2>

<div class="form-card">
  <form action="deposit_withdrawAction.php" method="POST">
    <label>Account:</label>
    <select name="account_id" required>
      <?php foreach ($accounts as $acc): ?>
        <option value="<?= $acc['account_id'] ?>"><?= ucfirst($acc['account_type']) ?> - Balance: $<?= number_format($acc['balance'], 2) ?></option>
      <?php endforeach; ?>
    </select>

    <label>Action:</label>
    <select name="action" required>
      <option value="deposit">Deposit</option>
      <option value="withdraw">Withdraw</option>
    </select>

    <label>Amount:</label>
    <input type="number" name="amount" step="0.01" min="0.01" required>

    <button type="submit">Submit</button>
  </form>
</div>

</body>
</html>

