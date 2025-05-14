<!DOCTYPE html>
<html>
<head>
  <title>Register - Finance Master</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="mystyle.css">
</head>
<body>
  <div class="container w-75 mt-3">     
    <div class="w3-container w3-padding-64 w3-card-4 w3-white w3-margin">
      <form name="signup" action="signupAction.php" method="get" onsubmit="return validatePasswords()"> 
        <h2>Sign Up Form</h2>

        <div class="item">
          <label>First Name</label>
          <input class="w3-input" type="text" name="fname" required />
        </div>

        <div class="item">
          <label>Last Name</label>
          <input class="w3-input" type="text" name="lname" required />
        </div>

        <div class="item">
          <label>Username</label>
          <input class="w3-input" type="text" name="username" required />
        </div>    

        <div class="item">
          <label>Email</label>
          <input class="w3-input" type="email" name="email" required />
        </div>

        <div class="item">
          <label>Password</label>
          <input class="w3-input" type="password" id="pswd" name="pswd" required />
        </div>

        <div class="item">
          <label>Retype Password</label>
          <input class="w3-input" type="password" id="pswd2" name="pswd2" required onkeyup="checkPasswordMatch()" />
          <span id="message" class="error"></span>
        </div>

        <div class="item">
          <label>Security Question</label>
          <select class="w3-select" name="question" required>
            <option value="" disabled selected>Choose your question</option>
            <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
            <option value="What was the name of your first pet?">What was the name of your first pet?</option>
            <option value="What was the name of your high school?">What was the name of your high school?</option>
            <option value="What city were you born in?">What city were you born in?</option>
            <option value="What is the name of the street you grew up on?">What is the name of the street you grew up on?</option>
            <option value="What was the name of your favorite childhood teacher?">What was the name of your favorite childhood teacher?</option>
            <option value="What was the make of your first car?">What was the make of your first car?</option>
            <option value="What is your favorite color?">What is your favorite color?</option>
            <option value="What is your spouse's name?">What is your spouse's name?</option>
            <option value="What is your date of birth?">What is your date of birth?</option>
          </select>
        </div>

        <div class="item">
          <label>Your Answer</label>
          <input class="w3-input" type="text" name="answer" required />
        </div>

        <div class="item">
          <input type="submit" value="Submit" />
          <input type="reset" value="Reset" />
        </div>
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
  </div>
</body>
</html>
