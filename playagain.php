<?php
session_start();

$_SESSION["Guesses"] = 0;
$_SESSION["Lives"] = 12;
$_SESSION["Stage"] = "start";
$_SESSION["WrongLettersGuessed"] = "";

header("Location: " . $_SESSION["Base"] . "/hangman.php");
?>