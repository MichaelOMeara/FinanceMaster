<?php
session_start();
include("db_connect.php");

// Only admins can lock users
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$user_id = intval($_GET['id']);

// Lock the user account
$query = "UPDATE users SET status = 'locked' WHERE user_id = $user_id";
mysqli_query($conn, $query);

header("Location: admin_dashboard.php");
exit();
?>