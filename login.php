<?php
    include("authenticator.php");
    session_destroy();
    session_start();
    $username = $_POST["Username"]; 
    $password = $_POST["Password"];

    $_SESSION["Base"] = "/hangman";
    if(gethostname() === "yoriichi") {
        $_SESSION["Base"] = "";
    }
    
    $auth = authenticate($username, $password);

    if($auth) {
        $_SESSION["authenticated"] = true;
        $_SESSION["Username"] = $username;
        header("Location: " . $_SESSION["Base"] . "/hangman.php");
    } else {
        $_SESSION["authenticated"] = false;
        header("Location: " . $_SESSION["Base"]);
    }
?>
