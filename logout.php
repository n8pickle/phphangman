<?php 
session_start();
$redirectURL = "Location: " . $_SESSION["Base"] . "/";
session_abort();
session_destroy();
header($redirectURL);
?>