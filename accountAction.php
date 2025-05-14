<?php
session_start();
include("db_connect.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Prepare SQL query to fetch all active accounts for this user
$query = "SELECT account_id, account_type, balance, status FROM accounts WHERE user_id = ? AND status = 'active'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$accounts = [];
while ($row = $result->fetch_assoc()) {
    $accounts[] = $row;
}

// Output the account information as JSON for AJAX use or process in HTML below
header('Content-Type: application/json');
echo json_encode($accounts);
exit();
?>
