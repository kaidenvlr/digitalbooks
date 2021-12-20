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
                <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="id" placeholder="<?php echo $_GET['id']; ?>" disabled>
                    <label for="image">Загрузить изображение: </label><input type="file" name="image">
                    <button onclick="document.cookie = 'id=<?php echo $id; ?>'" type="submit">Загрузить</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>