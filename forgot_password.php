<?php
include("db_connect.php");

if (!isset($_GET['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_GET['username'];
$stmt = $conn->prepare("SELECT user_id, question FROM users WHERE Username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: login.php");
    exit();
}

$row = $result->fetch_assoc();
$question = $row['question'];
$user_id = $row['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Security Question - Finance Master</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-light-grey">
<div class="w3-container w3-padding-64 w3-card-4 w3-white w3-margin">
  <h3>Security Question</h3>
  <p><?php echo htmlspecialchars($question); ?></p>

  <form action="verify_answer.php" method="post">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <input class="w3-input w3-border" type="text" name="answer" placeholder="Your Answer" required>
    <button class="w3-button w3-green w3-margin-top">Submit</button>
  </form>
</div>
</body>
</html>
