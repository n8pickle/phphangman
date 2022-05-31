<?php
include_once("database.php");

function authenticate($username, $password) {
    $authenticateQuery = "SELECT password FROM User WHERE username = '$username'";
    $saltQuery = "SELECT salt FROM User WHERE username = '$username'";

    $conn = get_connection();
    $result = $conn->query($saltQuery);
    $salt = "";
    if($result->num_rows > 0) {
        $salt = $result->fetch_assoc();
    }
    $result = $conn->query($authenticateQuery);
    $passHash = "";
    if($result->num_rows > 0) {
        $passHash = $result->fetch_assoc();
    }
    $conn->close();

    $saltedPass = $password . $salt["salt"];
    $hashedPass = hash("sha256", $saltedPass, false);

    // get results from $passHash
    if($passHash["password"] === $hashedPass) {
        $_SESSION["Username"] = $username;
        return true;
    }
    return false;
}

function createUser($username, $password) {
    $created = FALSE;
    $salt = getGUID();
    $saltedPass = $password . $salt;
    $hashedPass = hash("sha256", $saltedPass, false);
    $length = strlen($hashedPass);
    $insertUser = "INSERT INTO User (username, password, salt) VALUES('$username', '$hashedPass', '$salt')";

    // query to ensure user doesn't exist already
    
    $conn = get_connection();
    if($conn->query($insertUser) === TRUE) {
        $created = TRUE;
    }
    $conn->close();
    
    return $created;
}

function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }
    else {
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
        return $uuid;
    }
}