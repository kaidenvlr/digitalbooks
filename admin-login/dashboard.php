<?php
session_start();
$email_address = $_SESSION['email'];
include('../config/dbConnect.php');
if (empty($email_address))
{
    header("location:index.php");
}

$cat = !empty($_GET['cat'])?$_GET['cat']:'';
$subcat = !empty($_GET['subcat'])?$_GET['subcat']:'';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dashboard</title>

    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="wrapper">
        <?php
            include('partials/header.php');
        ?>
        <div class="page">
            <?php
                include('partials/sidebar.php');
            ?>
            <div class="ves-action">
                <h4>Welcome to the Admin panel</h4>
            </div>
        </div>
        <?php
            include('partials/footer.php');
        ?>
    </div>
    <script src="https://kit.fontawesome.com/a9f6196afa.js" crossorigin="anonymous"></script>
</body>
</html>