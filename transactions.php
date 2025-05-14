<?php
session_start();
require 'db_connect.php';
include 'header.php';

// TEMP: Replace with $_SESSION['user_id'] when login is active
$user_id = $_SESSION['user_id']; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account_id = $_POST['account_id'];
    $action = $_POST['action'];
    $amount = floatval($_POST['amount']);

    if ($amount <= 0) {
        header("Location: deposit_withdraw.php?error=Amount must be greater than zero.");
        exit;
    }

    // Get account
    $stmt = $pdo->prepare("SELECT * FROM accounts WHERE account_id = ? AND user_id = ? AND status = 'active'");
    $stmt->execute([$account_id, $user_id]);
    $account = $stmt->fetch();

    if (!$account) {
        header("Location: deposit_withdraw.php?error=Account not found or unauthorized.");
        exit;
    }

    if ($action === 'withdraw' && $account['balance'] < $amount) {
        header("Location: deposit_withdraw.php?error=Insufficient funds for withdrawal.");
        exit;
    }

    // Begin transaction
    $pdo->beginTransaction();

    try {
        $newBalance = ($action === 'deposit')
            ? $account['balance'] + $amount
            : $account['balance'] - $amount;

        // Update balance
        $update = $pdo->prepare("UPDATE accounts SET balance = ? WHERE account_id = ?");
        $update->execute([$newBalance, $account_id]);

        // Record transaction
        $log = $pdo->prepare("INSERT INTO transactions (account_id, type, amount, from_account, to_account) VALUES (?, ?, ?, NULL, NULL)");
        $log->execute([$account_id, $action, $amount]);

        $pdo->commit();

        header("Location: transactions.php");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        header("Location: deposit_withdraw.php?error=Transaction failed. Please try again.". urlencode($e->getMessage()));
        exit;
    }
}

