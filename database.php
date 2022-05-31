<?php

function get_connection() {
    $servername = "sql102.epizy.com";
    $username = "epiz_31690252";
    $password = "xz2V3JS6SkJdPVR";
    $dbname = "epiz_31690252_npickle";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    return $conn;
}

function query($query) {
    return $connection->query($query);
}

?>