<?php

session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trim whitespace from inputs
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); // <-- TRIM password input
    // Debug (optional)
    // var_dump($password);

    $stmt = $conn->prepare("SELECT * FROM users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if ($user['status'] !== 'active') {
            echo "<script>alert('Your account is currently locked. Please contact support.'); window.location.href='login.php';</script>";
            exit();
        }

        // Trim the hashed password too (just to be safe, though usually not needed)
        $hashed = trim($user['password']);

        if (password_verify($password, $hashed)) {
            // Success
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['status'] = $user['status'];

            // Redirect based on user type
            if ($user['user_type'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            echo "<script>alert('Invalid password.'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('User not found.'); window.location.href='login.php';</script>";
    }

    $stmt->close();
}
$conn->close();
?>
