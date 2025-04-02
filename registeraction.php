<?php
// Start session
session_start();

// Include database connection
include("db_connect.php"); 

// Get form values
$name = $_POST['Name'];
$username = $_POST['Username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Set default user_type and status
$user_type = 'customer'; // default value
$status = 'active';      // default status

// Check if username or email already exists
$check_query = "SELECT * FROM users WHERE Username = ? OR email = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Username or Email already exists. Please go back and try again.";
    exit();
}

// Insert into users table
$query = "INSERT INTO users (Name, Username, email, password, user_type, status) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssss", $name, $username, $email, $hashed_password, $user_type, $status);

if ($stmt->execute()) {
    // Registration successful, redirect to login
    header("Location: login.php");
    exit();
} else {
    echo "Registration failed: " . $stmt->error;
}
?>