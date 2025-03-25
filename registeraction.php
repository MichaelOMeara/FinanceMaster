<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['Name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hash
    $user_type = 'customer';
    $status = 'active';

    // Check if user exists
    $checkQuery = "SELECT * FROM users WHERE Name = '$name' OR email = '$email'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('Username or email already exists.'); window.location.href='register.php';</script>";
    } else {
        $insertQuery = "INSERT INTO users (Name, email, password, user_type, status)
                        VALUES ('$name', '$email', '$password', '$user_type', '$status')";
        
        if ($conn->query($insertQuery) === TRUE) {
            echo "<script>alert('Registration successful! You can now log in.'); window.location.href='login.php';</script>";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
