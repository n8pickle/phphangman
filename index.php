<?php
    session_start();
    $_SESSION["Base"] = "/hangman";
    if(gethostname() === "yoriichi") {
        $_SESSION["Base"] = "";
    }
?>

<!DOCTYPE html>
<html>
    <body>
        <form action="login.php" method="post">
            <p>Username: <input type="text" name="Username"/></p>
            <p>Password: <input type="password" name="Password"/></p>
            <input type="submit" name="Login"/>
        </form>
        <?php
            if(isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] == false) {
                echo '<p style="color: red;" >hello</p>' ;
            }
        ?>
        <p>or <a href="signupPage.php">create account</a></p>
    </body>
</html>