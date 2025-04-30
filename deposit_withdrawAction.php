<?php
session_start();
require 'db_connect.php';

// TEMP: Replace with $_SESSION['user_id'] when login is active
$user_id = $_SESSION['user_id']; 

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account_id = $_POST['account_id'];
    $action = $_POST['action'];
    $amount = floatval($_POST['amount']);

    if ($amount <= 0) {
        die("Invalid amount.");
    }

    // Get the account info for the user
    $stmt = $pdo->prepare("SELECT * FROM accounts WHERE account_id = ? AND user_id = ? AND status = 'active'");
    $stmt->execute([$account_id, $user_id]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$account) {
        die("Account not found or inactive.");
    }

    // Calculate new balance
    $new_balance = $account['balance'];

    if ($action === 'deposit') {
        $new_balance += $amount;
    } elseif ($action === 'withdraw') {
        if ($amount > $account['balance']) {
            die("Insufficient funds.");
        }
        $new_balance -= $amount;
    } else {
        die("Invalid transaction type.");
    }

    // Update the balance in the database
    $update = $pdo->prepare("UPDATE accounts SET balance = ? WHERE account_id = ?");
    $update->execute([$new_balance, $account_id]);

    // Redirect back to the form page
    header("Location: deposit_withdraw.php");
    exit;
}
?>

