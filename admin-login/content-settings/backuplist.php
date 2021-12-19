<?php
    session_start();
    $email_address = $_SESSION['email'];
    $hostname = "localhost:3307";
    $username = "dbadmin";
    $password = "12345";
    $databasename = "backupdigitalbook";

    $conn = new mysqli($hostname, $username, $password, $databasename);
    
    if (empty($email_address)) {
        header("Location: digitalbooks/admin-panel/index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wrapper">
        <?php
        include('../partials/header.php');
        ?>
        <div class="page">
            <?php
            include('../partials/sidebar.php');
            ?>
            <div class="ves-action">
                <div class="hheader">
                    <h4>Резервные копии</h4>
                    <a href="backup.php"><button class="right">Create Backup</button></a>
                </div>
                <div class="view">
                    <table>
                        <tr>
                            <th>Дата</th>
                            <th></th>
                            <th>Откат</th>
                        </tr>    
                        <?php
                        $sql = "SELECT * FROM backup ORDER BY id DESC LIMIT 50";
                        $res = $conn -> query($sql);
                        if ($res -> num_rows > 0) {
                            while ($data = mysqli_fetch_assoc($res)){
                        ?>
                        <tr>
                            <td><?php echo $data['date']; ?></td>
                            <td></td>
                            <td>
                                <a href="backupexecute.php?id=<?php echo $data['id']; ?>">
                                    <i class="fas fa-undo"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                                }
                            } else {
                        ?>
                        <tr>
                            <td colspan="3">Нет данных о существующих резервных копиях</td>
                        </tr>
                        <?php
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/a9f6196afa.js" crossorigin="anonymous"></script>
</body>
</html>