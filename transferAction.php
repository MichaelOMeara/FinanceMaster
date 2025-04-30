<?php
session_start();
echo"Logged in user_id " .$_SESSION['user_id'];
require 'db_connect.php';

$user_id = $_SESSION['user_id']; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from_account_id = $_POST['from_account'];
    $to_account_id = $_POST['to_account'];
    $amount = floatval($_POST['amount']);

    if ($from_account_id == $to_account_id) {
        die("Cannot transfer to the same account.");
    }

    if ($amount <= 0) {
        die("Invalid transfer amount.");
    }

    // Fetch both accounts
    $stmt = $pdo->prepare("SELECT * FROM accounts WHERE account_id IN (?, ?) AND user_id = ?");
    $stmt->execute([$from_account_id, $to_account_id, $user_id]);
    $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($accounts) != 2) {
        die("Accounts not found or not owned by user.");
    }

    // Identify which is which
    $from_account = null;
    $to_account = null;
    foreach ($accounts as $acc) {
        if ($acc['account_id'] == $from_account_id) $from_account = $acc;
        if ($acc['account_id'] == $to_account_id) $to_account = $acc;
    }

    if ($from_account['balance'] < $amount) {
        die("Insufficient funds.");
    }

    // Begin transaction
    $pdo->beginTransaction();

    try {
        // Update balances
        $new_from_balance = $from_account['balance'] - $amount;
        $new_to_balance = $to_account['balance'] + $amount;

        $update_from = $pdo->prepare("UPDATE accounts SET balance = ? WHERE account_id = ?");
        $update_from->execute([$new_from_balance, $from_account_id]);

        $update_to = $pdo->prepare("UPDATE accounts SET balance = ? WHERE account_id = ?");
        $update_to->execute([$new_to_balance, $to_account_id]);

        // Record transfer
        $record = $pdo->prepare("INSERT INTO transactions (account_id, type, amount, from_account, to_account) VALUES (?, 'transfer', ?, ?, ?)");
        $record->execute([$to_account_id, $amount, $from_account_id, $to_account_id]);

        $pdo->commit();
        header("Location: transactions.php");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Transfer failed: " . $e->getMessage());
    }
}
?>
