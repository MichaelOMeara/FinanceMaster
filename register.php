<!DOCTYPE html>
<html>
<head>
  <title>Register - Finance Master</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="mystyle.css">
</head>
<body class="w3-light-grey">

<div class="w3-container w3-padding-64 w3-card-4 w3-white w3-margin">
  <h2>Register</h2>
  <form action="registeraction.php" method="post" class="w3-container">
    <label>Full Name</label>
    <input class="w3-input" type="text" name="Name" required>

    <label>Email</label>
    <input class="w3-input" type="email" name="email" required>

    <label>Password</label>
    <input class="w3-input" type="password" name="password" required>

    <button class="w3-button w3-blue w3-margin-top" type="submit">Register</button>
  </form>
</div>

</body>
</html>