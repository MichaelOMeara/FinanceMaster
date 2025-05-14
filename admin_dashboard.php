<?php
session_start();
include("db_connect.php");

// Verify if logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all customer users
$query = "SELECT * FROM users WHERE user_type = 'customer'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="mystyles.css"> <!-- Use your consistent W3.CSS -->
    </head>
    <body class="w3-container">

        <!-- Admin Welcome Banner -->
        <div class="w3-panel w3-blue w3-padding-16 w3-center">
            <h2>Welcome, Admin!</h2>
            <a href="logout.php" class="w3-button w3-red w3-margin-top">Logout</a>
        </div>

        <!-- Admin Dashboard Table -->
        <div class="w3-card-4 w3-margin">
            <div class="w3-container w3-teal">
                <h3>Customer Accounts</h3>
            </div>

            <table class="w3-table-all w3-hoverable">
                <thead>
                    <tr class="w3-light-grey">
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="<?php echo ($row['status'] == 'locked') ? 'w3-pale-red' : ''; ?>">
                            <td><?php echo $row['user_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['Username']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <?php if ($row['status'] == 'active') { ?>
                                    <a href="lock_user.php?id=<?php echo $row['user_id']; ?>" class="w3-button w3-red w3-small">Lock</a>
                                <?php } else { ?>
                                    <a href="unlock_user.php?id=<?php echo $row['user_id']; ?>" class="w3-button w3-green w3-small">Unlock</a>
                                <?php } ?>
                                <a href="delete_user.php?id=<?php echo $row['user_id']; ?>" class="w3-button w3-black w3-small w3-margin-left" onclick="return confirm('Are you sure you want to permanently delete this user?');">Delete</a>
                            </td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- Messaging Section -->
        <div class="w3-card-4 w3-margin-top">
            <div class="w3-container w3-teal">
                <h3>Send Message to Locked User</h3>
            </div>
            <form class="w3-container" method="post" action="send_message.php" style="padding: 16px;">
                <label for="receiver_id" class="w3-text-teal"><b>Select Locked User:</b></label>
                <select class="w3-select w3-border" name="receiver_id" required>
                    <option value="" disabled selected>Choose a locked user</option>
                    <?php
                    // Fetch locked users only
                    $locked_users = mysqli_query($conn, "SELECT user_id, Username FROM users WHERE status = 'locked'");
                    while ($locked = mysqli_fetch_assoc($locked_users)) {
                        echo "<option value='{$locked['user_id']}'>[ID {$locked['user_id']}] {$locked['Username']}</option>";
                    }
                    ?>
                </select>

                <label for="content" class="w3-text-teal w3-margin-top"><b>Message:</b></label>
                <textarea name="content" class="w3-input w3-border" required></textarea>

                <button type="submit" class="w3-button w3-teal w3-margin-top">Send Message</button>
            </form>
        </div>
        <?php
// Only show replies if logged in as admin
        $admin_id = $_SESSION['user_id'];
        $reply_query = $conn->prepare("SELECT m.*, u.Username FROM messages m JOIN users u ON m.sender_id = u.user_id WHERE m.receiver_id = ? ORDER BY m.date DESC");
        $reply_query->bind_param("i", $admin_id);
        $reply_query->execute();
        $replies = $reply_query->get_result();
        ?>

        <div class="w3-card-4 w3-margin-top">
            <div class="w3-container w3-teal">
                <h3>Messages from Users (Replies)</h3>
            </div>
            <div class="w3-container">
                <?php if ($replies->num_rows > 0): ?>
                    <?php while ($msg = $replies->fetch_assoc()): ?>
                        <div class="w3-panel w3-border w3-light-grey w3-margin-top">
                            <p><strong>From:</strong> <?php echo htmlspecialchars($msg['Username']); ?> (User ID: <?php echo $msg['sender_id']; ?>)</p>
                            <p><strong>Message:</strong><br><?php echo nl2br(htmlspecialchars($msg['content'])); ?></p>
                            <p><small>Received on: <?php echo $msg['date']; ?></small></p>
                            <a href="delete_message.php?id=<?php echo $msg['message_id']; ?>" class="w3-button w3-small w3-red w3-margin-top" onclick="return confirm('Delete this message?');">Delete</a>

                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="w3-text-grey">No replies received yet.</p>
                <?php endif; ?>
            </div>
        </div>



    </body>
</html>