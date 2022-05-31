<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <script>
            const validateAndSubmit = () => {
                const pass = document.getElementById("password");
                const cpass = document.getElementById("cpassword");
                const errorlabel = document.getElementById("errorlabel");
                const form = document.getElementById("form");
                const regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;

                if(!pass.value) {
                    errorlabel.innerText = "The password can't be empty";
                    return false;
                }

                if(!pass.value.match(regex)) {
                    errorlabel.innerText = "The password must: \nbe at least 8 characters long\nhave a number\nhave a lowercase letter\nhave an uppercase letter";
                    return false;
                }

                if(pass.value !== cpass.value) {
                    errorlabel.innerText = "The passwords don't match";
                    return false;
                }

                errorlabel.innerText = "";
                form.submit(true);
            }
        </script>
    </head>
    <body>
        <form id="form" action="signup.php" method="post" style="width: 400px;">
            <p>Username: <input type="text" name="Username" style="align-self: right;"/></p>
            <?php
                if(isset($_SESSION["UsernameExists"]) && $_SESSION["UsernameExists"]) {
                    echo "<p style=\"color: red;\">the username you tried to select already exists</p>";
                } 
            ?>
            <p>Password: <input type="password" name="Password" id="password" style="align-self: right;"/></p>
            <p>Confirm Password: <input type="password" name="ConfirmPassword" id="cpassword" style="align-self: right;"/></p>
            <input type="button" onclick="validateAndSubmit()" value="Create Account"/>
        </form>
        <div id="errorlabel" style="color: red;"></div>
        <p>or <a href="/hangman">back to login</a></p>
    </body>
</html>