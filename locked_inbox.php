<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['locked_user_id'])) {
    echo "Access denied.";
    exit();
}

$user_id = $_SESSION['locked_user_id'];

// Handle reply submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_id']) && isset($_POST['reply_content'])) {
    $admin_id = intval($_POST['admin_id']);
    $reply = trim($_POST['reply_content']);

    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $admin_id, $reply);
    if ($stmt->execute()) {
        echo "<p style='color: green;'>Reply sent successfully.</p>";
    } else {
        echo "<p style='color: red;'>Failed to send reply.</p>";
    }
}

// Fetch messages sent *to* the locked user
$stmt = $conn->prepare("SELECT * FROM messages WHERE receiver_id = ? ORDER BY date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Locked Account - Admin Messages</title>
    <link rel="stylesheet" href="mystyles.css">
</head>
<body class="w3-container">
    <div class="w3-panel w3-red w3-padding-16 w3-center">
        <h3>Your Account is Locked</h3>
        <p>Please review the message(s) from support below and reply if needed.</p>
    </div>

    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="w3-card-4 w3-margin w3-padding">
            <h4>Message from Admin</h4>
            <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
            <p><small>Sent on: <?php echo $row['date']; ?></small></p>

            <!-- Reply Form -->
            <form method="post" class="w3-container w3-margin-top">
                <input type="hidden" name="admin_id" value="<?php echo $row['sender_id']; ?>">
                <label for="reply_content">Your Reply:</label>
                <textarea name="reply_content" class="w3-input w3-border" required></textarea>
                <button type="submit" class="w3-button w3-teal w3-margin-top">Send Reply</button>
            </form>
        </div>
    <?php } ?>

    <div class="w3-center w3-margin-top">
        <a href="logout.php" class="w3-button w3-black">Logout</a>
    </div>
</body>
</html>
