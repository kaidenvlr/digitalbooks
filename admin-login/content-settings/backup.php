<?php
    include("../../config/dbConnect.php");
    shell_exec("cd C:\Program Files\MySQL\MySQL Server 8.0\bin");
    $today = date("Y-m-d");
    $data = mysqli_fetch_assoc($conn -> query("SELECT id FROM backup ORDER BY id DESC LIMIT 1"));
    $id = $data['id'] + 1;
    echo $id;
    shell_exec("mysqldump --port=3307 -u dbadmin -p12345 digitalbook > c:/openserver/domains/digitalbooks/dumps/digitalbook_dump".$id.".sql");
    $sql = "INSERT INTO backup (date) VALUES ('".$today."')";
    if (!mysqli_query($conn, $sql)) {
        echo mysqli_error($conn);
    }
?>