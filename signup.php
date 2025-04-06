<!DOCTYPE html>
<!link to mystyles>
<?php include 'header.php';?>
<head>
  <title>Register - Finance Master</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="mystyle.css">
</head>

    <div class="container w-75 mt-3">     
        
           
    <div class = "w3-container w3-padding-64 w3-card-4 w3-white w3-margin">
        
        <form name = "signup" action = "signupAction.php" method = "get"
              onsubmit="return validatePasswords()"> 
                <h2>Sign Up Form</h2>
            <div class = "item">
            <label>First Name</label>
            <input class="w3-input" type = "text" name = "fname" size = "40" required />
            </div>

            <div class = "item">
            <label>Last Name</label>
            <input class ="w3-input" type = "text" name = "lname" size = "40" required />
            </div>

            <div class = "item">
            <label>Username</label>
            <input class="w3-input" type = "text" name = "username" size = "40" required />
            </div>    
                
            <div class = "item">
            <label>Email</label>
            <input class="w3-input" type = "text" name = "email" size = "40" required />
            </div>

            <div class = "item">
            <label>Password</label>
            <input class="w3-input" type = "password" id= "pswd" name = "pswd" size = "40" required/>
            </div>

            <div class = "item">
            <label>Retype Password</label>
            <input class="w3-input" type = "password" id= "pswd2" name = "pswd2" size = "40" required 
                   onkeyup=""checkPasswordMatch()"/>
            <span id="message" class="error"></span>
            </div>

            <div class = "item">
            <input type = "submit" value = "Submit" />
            <input type = "reset" value = "Reset" />
            </div>
        
        </form>
        
            <script>
            function checkPasswordMatch() {
                let password = document.getElementById("pswd").value;
                let confirmPassword = document.getElementById("pswd2").value;
                let message = document.getElementById("message");

                if (password === confirmPassword && password !== "") {
                    message.textContent = "Passwords match!";
                } else {
                    message.textContent = "Passwords do not match!";
                }
            }

            function validatePasswords() {
                let password = document.getElementById("pswd").value;
                let confirmPassword = document.getElementById("pswd2").value;

                if (password === "") {
                    alert("Password field is empty.");
                    return false;
                }

                if (password !== confirmPassword) {
                    alert("Passwords didn't match.");
                    return false;
                }

                return true;
            }
        </script>

    </div>        
    </div>
        
    
