<?php
include("db_connect.php");

$user_id = $_POST['user_id'];
$answer = $_POST['answer'];

$stmt = $conn->prepare("SELECT answer FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (strtolower(trim($row['answer'])) === strtolower(trim($answer))) {
    // Answer is correct
    header("Location: reset_password.php?user_id=" . $user_id);
    exit();
} else {
    // Incorrect answer
    header("Location: login.php");
    exit();
}
?>
