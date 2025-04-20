<?php
session_start();
include("db_connect.php");

// Only allow admin to delete users
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Get the user ID to delete
$user_id = intval($_GET['id']);

// Prevent admin from deleting themselves by accident
if ($user_id == $_SESSION['user_id']) {
    echo "You cannot delete your own admin account!";
    exit();
}

// Delete the user from the database
$query = "DELETE FROM users WHERE user_id = $user_id";

if (mysqli_query($conn, $query)) {
    header("Location: admin_dashboard.php");
    exit();
} else {
    echo "Error deleting user: " . mysqli_error($conn);
}
?>