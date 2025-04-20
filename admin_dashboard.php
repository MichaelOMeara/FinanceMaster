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
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr class="<?php echo ($row['status'] == 'locked') ? 'w3-pale-red' : ''; ?>">
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

</body>
</html>