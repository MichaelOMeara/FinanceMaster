<!DOCTYPE html>
<!link to mystyles>
<?php include 'header.php';?>
    <div class="container w-75 mt-3">
    <h3>Sign Up Form</h3>
           
    <div class = "w3-container">
        
        <form name = "signup" action = "signupAction.php" method = "get"
              onsubmit="return validatePasswords()"> 
    
            <div class = "item">
            <label>first name</label>
            <input type = "text" name = "fname" size = "40" required />
            </div>

            <div class = "item">
            <label>last name</label>
            <input type = "text" name = "lname" size = "40" required />
            </div>

            <div class = "item">
            <label>Email</label>
            <input type = "text" name = "email" size = "40" required />
            </div>

            <div class = "item">
            <label>Password</label>
            <input type = "password" id= "pswd" name = "pswd" size = "40" required/>
            </div>

            <div class = "item">
            <label>Retype Password</label>
            <input type = "password" id= "pswd2" name = "pswd2" size = "40" required 
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
        
    
