<?php
    session_start();
    $email_address = $_SESSION['email'];
    include("../../config/dbConnect.php");
    if (empty($email_address)) {
        header("Location: digitalbooks/admin-panel/index.php");
    }
    $id = $_GET['id'];
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
        <?php include("../partials/header.php"); ?>
        <div class="page">
            <?php include("../partials/sidebar.php"); ?>
            <div class="ves-action">
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <label style="font-size:12px; font-weight: 400;margin-right:10px;" for="id">id</label><input type="text" name="id" placeholder="<?php echo $id; ?>" disabled>
                    <hr>
                    <label style="font-size: 12px; font-weight: 400;margin-right:10px;" for="file">Загрузить файл:</label><input type="file" name="file">
                    <hr>
                    <button onclick="document.cookie = 'id=<?php echo $id; ?>'"style="background-color: inherit; color: white; border: 5px solid #eba4ba; border-radius: 32px; padding: 20px 10px; width: 300px; margin-top: 20px;" type="submit">Загрузить</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>