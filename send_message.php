<?php
session_start();
require 'db_connect.php';

// Ensure logged in AND is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    die("Unauthorized access");
}

// Ensure POST data is present
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['receiver_id']) && isset($_POST['content'])) {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = intval($_POST['receiver_id']);
    $content = trim($_POST['content']);

    // Optional: Validate receiver is a locked user
    $check = $conn->prepare("SELECT status FROM users WHERE user_id = ?");
    $check->bind_param("i", $receiver_id);
    $check->execute();
    $res = $check->get_result();
    $user = $res->fetch_assoc();

    if (!$user || $user['status'] !== 'locked') {
        die("Invalid user or user is not locked.");
    }

    // Send message
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $sender_id, $receiver_id, $content);
    
    if ($stmt->execute()) {
        echo "Message sent successfully. <a href='admin_dashboard.php'>Back to Dashboard</a>";
    } else {
        echo "Message sending failed: " . $stmt->error;
    }
} else {
    echo "Invalid request.";
}
?>
