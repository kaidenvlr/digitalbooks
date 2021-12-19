<?php
    $hostname = "localhost:3307";
    $username = "dbadmin";
    $password = "12345";
    $databasename = "backupdigitalbook";

    $conn = new mysqli($hostname, $username, $password, $databasename);
    
    shell_exec("cd C:\Program Files\MySQL\MySQL Server 8.0\bin");
    $cmd = "mysql --user=dbadmin --password=12345 --port=3307 -D digitalbook < c:\openserver\domains\digitalbooks\dumps\digitalbook_dump".$_GET['id'].".sql";
    shell_exec($cmd);
    header("Location: backuplist.php");
?>