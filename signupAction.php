<?php
session_start();
include("db_connect.php");

$fname = $_GET["fname"];
$lname = $_GET["lname"];
$username = $_GET["username"];
$email = $_GET["email"];
$pswd = $_GET["pswd"];
$question = $_GET["question"];
$answer = $_GET["answer"];

$user_type = "customer";
$status = "active";
$name = $fname . " " . $lname;
$hashed_password = password_hash($pswd, PASSWORD_DEFAULT);

// Check if user already exists
$check_query = "SELECT * FROM users WHERE Username = ? OR email = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Username or Email already exists. Please go back and try again.";
    exit();
}

// Insert user with updated schema
$query = "INSERT INTO users (Name, Username, email, password, question, answer, user_type, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssssss", $name, $username, $email, $hashed_password, $question, $answer, $user_type, $status);

if ($stmt->execute()) {
    $user_id = $conn->insert_id;

    // Create default accounts
    $account_types = ["Savings", "Checkings", "Loan"];
    foreach ($account_types as $type) {
        $acc_query = "INSERT INTO accounts (user_id, account_type, balance) VALUES (?, ?, 0.00)";
        $acc_stmt = $conn->prepare($acc_query);
        $acc_stmt->bind_param("is", $user_id, $type);
        $acc_stmt->execute();
    }

    header("Location: login.php");
    exit();
} else {
    echo "Registration failed: " . $stmt->error;
}
?>


