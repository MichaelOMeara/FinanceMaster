<?php
include("db_connect.php");

$user_id = $_POST['user_id'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

if ($new_password !== $confirm_password) {
    echo "Passwords do not match.";
    header("Location: reset_password.php");
    exit();
}

$hashed = password_hash($new_password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
$stmt->bind_param("si", $hashed, $user_id);

if ($stmt->execute()) {
    header("Location: login.php");
    exit();
} else {
    echo "Failed to update password.";
}
?>

