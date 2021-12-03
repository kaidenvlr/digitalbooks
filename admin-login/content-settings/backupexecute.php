<?php
    include("../../config/dbConnect.php");
    shell_exec("cd C:\Program Files\MySQL\MySQL Server 8.0\bin");
    $cmd = "mysql --user=dbadmin --password=12345 --port=3307 -D digitalbook < c:\openserver\domains\digitalbooks\dumps\digitalbook_dump".$_GET['id'].".sql";
    shell_exec($cmd);
    header("Location: backuplist.php");
?>