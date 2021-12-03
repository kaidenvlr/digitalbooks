<?php
    session_start();
    $email_address = $_SESSION['email'];
    include('../../config/dbConnect.php');
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
                    <h4>Транзакции</h4>
                </div>
                <div class="view">
                    <table>
                        <tr>
                            <th>Название</th>
                            <th></th>
                            <th>Описание</th>
                            <th></th>
                        </tr>    
                        <?php
                        $sql = "SELECT name, description FROM transactions ORDER BY id DESC LIMIT 50";
                        $res = $conn -> query($sql);
                        if ($res -> num_rows > 0) {
                            while ($data = mysqli_fetch_assoc($res)){
                        ?>
                        <tr>
                            <td><?php echo $data['name']; ?></td>
                            <td colspan="3"><?php echo $data['description']; ?></td>
                        </tr>
                        <?php
                                }
                            } else {
                        ?>
                        <tr>
                            <td colspan="4">Нет данных о существующих транзакциях</td>
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