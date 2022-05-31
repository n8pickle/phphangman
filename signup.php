<?php
    require("database.php");
    session_destroy();
    session_start();
    $_SESSION["Base"] = "/hangman";
    if(gethostname() === "yoriichi") {
        $_SESSION["Base"] = "";
    }
    require("authenticator.php");
    $username = $_POST["Username"];
    if(usernameAlreadyExists($username)) {
        $_SESSION["UsernameExists"] = true;
        echo "true";
        header("Location: " . $_SESSION["Base"] . "/signupPage.php");
        return;
    }
    $password = $_POST["Password"];
    $_SESSION["authenticated"] = false;
    echo "hello friend";
    $_SESSION["authenticated"] = createUser($username, $password);
    $_SESSION["Username"] = $username;
    header("Location: " . $_SESSION["Base"] . "/hangman.php");

    function usernameAlreadyExists($username) {
        $usernameQuery = "SELECT username FROM User WHERE username = \"" . $username . "\"";
        $conn = get_connection();
        $result = $conn->query($usernameQuery);
        $row = $result->fetch_assoc();
        if($row["username"] !== null) {
            return true;
        }
        return false;
    }
?>