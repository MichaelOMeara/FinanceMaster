<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    die("Unauthorized access.");
}

if (isset($_GET['id'])) {
    $message_id = intval($_GET['id']);
    $admin_id = $_SESSION['user_id'];

    // Ensure the admin owns this message
    $stmt = $conn->prepare("DELETE FROM messages WHERE message_id = ? AND receiver_id = ?");
    $stmt->bind_param("ii", $message_id, $admin_id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?msg_deleted=1");
    } else {
        echo "Failed to delete message.";
    }
    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
