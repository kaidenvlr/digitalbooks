<?php
    $hostname     = "localhost:3307"; // Enter Your Host Name
    $username     = "dbadmin";      // Enter Your Table username
    $password     = "12345";          // Enter Your Table Password
    $databasename = "digitalbook"; // Enter Your database Name


    $conn = new mysqli($hostname, $username, $password, $databasename);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>