<?php
if (!isset($_GET['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_GET['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Reset Password - Finance Master</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-light-grey">
<div class="w3-container w3-padding-64 w3-card-4 w3-white w3-margin">
  <h3>Reset Your Password</h3>
  <form action="update_password.php" method="post" onsubmit="return validatePasswords()">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

    <label>New Password</label>
    <input class="w3-input" type="password" name="new_password" required>

    <label>Confirm Password</label>
    <input class="w3-input" type="password" name="confirm_password" required onkeyup="checkPasswordMatch()">
    <input type="submit" value="Submit" />
          
    <button class="w3-button w3-blue w3-margin-top">Submit</button>
  </form>
  
  <script>
        function checkPasswordMatch() {
          let password = document.getElementById(\"pswd\").value;
          let confirmPassword = document.getElementById(\"pswd2\").value;
          let message = document.getElementById(\"message\");
          message.textContent = password === confirmPassword && password !== \"\" 
              ? \"Passwords match!\" 
              : \"Passwords do not match!\";
        }

        function validatePasswords() {
          let password = document.getElementById(\"pswd\").value;
          let confirmPassword = document.getElementById(\"pswd2\").value;
          if (password === \"\") {
            alert(\"Password field is empty.\");
            return false;
          }
          if (password !== confirmPassword) {
            alert(\"Passwords didn't match.\");
            return false;
          }
          return true;
        }
      </script>
</div>
</body>
</html>
