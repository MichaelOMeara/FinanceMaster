<?php
session_start();
require 'db_connect.php';
include 'header.php';

$user_id = $_SESSION['user_id'];

// Fetch user's account IDs
$stmt = $pdo->prepare("SELECT account_id FROM accounts WHERE user_id = ?");
$stmt->execute([$user_id]);
$account_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (empty($account_ids)) {
    die("No accounts found.");
}

// Fetch all transactions linked to these accounts
$in_clause = implode(',', array_fill(0, count($account_ids), '?'));

$query = $pdo->prepare("
    SELECT * FROM transactions
    WHERE account_id IN ($in_clause)
    ORDER BY date DESC
");
$query->execute($account_ids);
$transactions = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Finance Master - Transactions</title>
  <style>
    body { font-family: Arial; margin: 20px; background: #f1f1f1;}
    .card { background: white; padding: 20px; margin: 15px 0; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);}
    .transfer { background: #e0f7fa; }
    .deposit { background: #e8f5e9; }
    .withdrawal { background: #ffebee; }
  </style>
</head>
<body>

<h2>Your Transactions</h2>

<?php foreach ($transactions as $tx): ?>
  <div class="card <?= $tx['type'] ?>">
    <p><strong>Type:</strong> <?= ucfirst($tx['type']) ?></p>
    <p><strong>Amount:</strong> $<?= number_format($tx['amount'], 2) ?></p>
    <p><strong>Date:</strong> <?= $tx['date'] ?></p>

    <?php if ($tx['type'] == 'transfer'): ?>
      <p><strong>From Account ID:</strong> <?= $tx['from_account'] ?></p>
      <p><strong>To Account ID:</strong> <?= $tx['to_account'] ?></p>
    <?php else: ?>
      <p><strong>Account ID:</strong> <?= $tx['account_id'] ?></p>
    <?php endif; ?>
  </div>
<?php endforeach; ?>

</body>
</html>






