<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE Username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if ($user['status'] !== 'active') {
            echo "<script>alert('Your account is currently locked. Please contact support.'); window.location.href='login.php';</script>";
            exit();
        }

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['user_type'] = $user['user_type'];

            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid password.'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('User not found.'); window.location.href='login.php';</script>";
    }
}

$conn->close();
?>
