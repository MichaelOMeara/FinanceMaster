<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if ($user['status'] === 'locked') {
            // Allow locked users to read messages only
            $_SESSION['locked_user_id'] = $user['user_id'];
            header("Location: locked_inbox.php");
            exit();
        }

        if ($user['status'] !== 'active') {
            echo "<script>alert('Your account is not active.'); window.location.href='login.php';</script>";
            exit();
        }

        $hashed = trim($user['password']);

        if (password_verify($password, $hashed)) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['status'] = $user['status'];

            // Redirect based on role
            if ($user['user_type'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            echo "<script>alert('Invalid password.'); window.location.href='login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('User not found.'); window.location.href='login.php';</script>";
        exit();
    }

    $stmt->close();
}
$conn->close();
?>
