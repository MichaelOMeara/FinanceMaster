<?php
session_start();
include 'header.php';
require 'db_connect.php';

$user_id = $_SESSION['user_id']; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from_account_id = $_POST['from_account'];
    $to_account_id = $_POST['to_account'];
    $amount = floatval($_POST['amount']);

    if ($from_account_id == $to_account_id) {
        header("Location: transfer.php?error=Cannot transfer to the same account.");
        exit;
    }

    if ($amount <= 0) {
        header("Location: transfer.php?error=Invalid transfer amount.");
        exit;
    }

    // Fetch both accounts
    $stmt = $pdo->prepare("SELECT * FROM accounts WHERE account_id IN (?, ?) AND user_id = ?");
    $stmt->execute([$from_account_id, $to_account_id, $user_id]);
    $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($accounts) != 2) {
        header("Location: transfer.php?error=Accounts not found or unauthorized.");
        exit;
    }

    // Identify which is which
    $from_account = null;
    $to_account = null;
    foreach ($accounts as $acc) {
        if ($acc['account_id'] == $from_account_id) $from_account = $acc;
        if ($acc['account_id'] == $to_account_id) $to_account = $acc;
    }

    if ($from_account['balance'] < $amount) {
        header("Location: transfer.php?error=Insufficient funds in the selected account.");
        exit;
    }

    // Begin transaction
    $pdo->beginTransaction();

    try {
        // Update balances
        $update_from = $pdo->prepare("UPDATE accounts SET balance = ? WHERE account_id = ?");
        $update_from->execute([$from_account['balance'] - $amount, $from_account_id]);

        $update_to = $pdo->prepare("UPDATE accounts SET balance = ? WHERE account_id = ?");
        $update_to->execute([$to_account['balance'] + $amount, $to_account_id]);

        // Record the transaction
        $record = $pdo->prepare("INSERT INTO transactions (account_id, type, amount, from_account, to_account) VALUES (?, 'transfer', ?, ?, ?)");
        $record->execute([$to_account_id, $amount, $from_account_id, $to_account_id]);

        $pdo->commit();
        header("Location: transactions.php");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        header("Location: transfer.php?error=Transfer failed: " . urlencode($e->getMessage()));
        exit;
    }
}

?>
