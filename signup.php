<!DOCTYPE html>
<!link to mystyles>

    <div class="container w-75 mt-3">
    <h3>Sign Up Form</h3>
           
    <div class = "w3-container">
        
        <form name = "signup" action = "signupAction.php" method = "get">
    
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
            <input type = "password" name = "pswd" size = "40" required/>
            </div>

            <div class = "item">
            <label>Retype Password</label>
            <input type = "password" name = "pswd2" size = "40" required/>
            </div>

            <div class = "item">
            <input type = "submit" value = "Submit" />
            <input type = "reset" value = "Reset" />
            </div>
        
        </form>
    </div>        
    </div>
        
    
