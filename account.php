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

$accountData = [
    'checking' => null,
    'savings' => null,
    'loan' => null
];

foreach ($accounts as $account) {
    $type = strtolower(trim($account['account_type']));
    if (isset($accountData[$type])) {
        $accountData[$type] = $account;
    }
}


?>

                   echo"<pre>";
                   print_r($accounts[loan]);
                   echo"</pre>;

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Finance Master - My Accounts</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }
        .account-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin: 15px auto;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .account-title { font-size: 1.5em; margin-bottom: 10px; }
        .balance { font-size: 1.2em; color: green; }
        .status { font-weight: bold; color: #555; }
    </style>
</head>
<body>

    <h1>Welcome to Finance Master</h1>
    <h2>Your Accounts</h2>

    <?php foreach (['savings', 'checking', 'loan'] as $type): ?>
        <?php $account = $accountData[$type]; ?>
        
        <div class="account-card">
            <div class="account-title"><?= ucfirst($type) ?> Account</div>
            <?php if ($account): ?>
                <p><strong>Account ID:</strong> <?= $account['account_id'] ?></p>
                <p class="balance"><strong>Balance:</strong> $<?= number_format($account['balance'], 2) ?></p>
                <p class="status"><strong>Status:</strong> <?= ucfirst($account['status']) ?></p>
                
                
            <?php else: ?>
                <p>No <?= $type ?> account found.</p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

</body>
</html>
