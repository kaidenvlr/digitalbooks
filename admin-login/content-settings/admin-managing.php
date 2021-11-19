<?php
    session_start();
    $email_address = $_SESSION['email'];
    include('../../config/dbConnect.php');
    if (empty($email_address))
    {
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
                <?php
                    if ($_GET['cat'] =='add-admin') {
                        if (!empty($_GET['edit'])) {
                            $editId = $_GET['edit'];
                            $query = "SELECT * FROM admins WHERE id=$editId";
                            $res = $conn -> query($query);
                            $editData = mysqli_fetch_assoc($res);
                            $firstName = $editData['firstName'];
                            $lastName = $editData['lastName'];
                            $password = $editData['password'];
                            $email = $editData['email'];
                            $gender = $editData['gender'];

                            $idAttr = "updateAdminForm";
                        } else {
                            $firstName = "";
                            $lastName = "";
                            $password = "";
                            $email = "";
                            $gender = "";

                            $editId = "";
                            $idAttr = "adminForm";

                        }
                ?>

                <?php
                    if (isset($_POST['save'])) {
                        if (empty($_GET['edit'])) {
                            $sql = "INSERT INTO admins (password,email,gender,firstName,lastName) VALUES (?,?,?,?,?)";
                            $stmt = mysqli_prepare($conn, $sql);
                            mysqli_stmt_bind_param($stmt, "sssss", $_POST['password'], $_POST['email'], $_POST['gender'], $_POST['firstName'], $_POST['lastName']);
                            mysqli_stmt_execute($stmt);
                        } else {
                            $sql = "UPDATE admins SET password=?, email=?, gender=?, firstName=?, lastName=? WHERE id=".$_GET['edit'];
                            $stmt = mysqli_prepare($conn, $sql);
                            mysqli_stmt_bind_param($stmt, "sssss", $_POST['password'], $_POST['email'], $_POST['gender'], $_POST['firstName'], $_POST['lastName']);
                            mysqli_stmt_execute($stmt);
                            echo $_POST['gender'];
                        }
                    }
                ?>
                <div class="hheader">
                    <?php
                        if (empty($_GET['edit'])) {
                            echo "<h4 class='adding-admin'>Adding Admin</h4>";
                        } else {
                            echo "<h4 class='editing-admin'>Editing Admin</h4>";
                        }
                    ?>
                    <a href="admin-managing.php"><button class="right">Go to Admin Overview</button></a>
                </div>
                <div class="view">
                    <form id="<?php echo $idAttr; ?>" rel="<?php echo $editId; ?>" name="admin_profile" method="POST">
                        <div class="row">
                            <div class="containr">
                                <input type="text" placeholder="First Name" name="firstName" value="<?php echo $firstName; ?>" required>
                            </div>
                            <div class="containr">
                                <input type="text" placeholder="Last Name" name="lastName" value="<?php echo $lastName; ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="containr">
                                <input type="text" placeholder="E-mail" name="email" value="<?php echo $email ?>" required>
                            </div>
                            <div class="containr">
                                <div class="gender">
                                    <div class="select">
                                        <span>Male</span>
                                        <i class="fa fa-chevron-left"></i>
                                    </div>
                                    <input type="hidden" name="gender" value="male">
                                    <ul class="dropdown-menu">
                                        <li id="male">Male</li>
                                        <li id="female">Female</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="containr">
                                <input type="password" placeholder="Password" name="password" value="" required>
                            </div>
                            <div class="containr">
                                <input type="password" placeholder="Confirm password" name="cpassword" value="" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="submit-button" name="save">Save</button>
                    </form>
                </div>
                <?php  } else {?>
                <div class="hheader">
                    <h4 class="managing-admin">Managing administrators</h4>
                    <a href="admin-managing.php?cat=add-admin"><button class="right">Add admin</button></a>
                </div>
                <div class="view">
                    <table>
                        <tr>
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th></th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        <?php
                            $sql = "SELECT * FROM admins ORDER BY id";
                            $res = $conn -> query($sql);
                            if ($res -> num_rows > 0) {
                                while ($data = mysqli_fetch_assoc($res)) {
                        ?>
                        <tr>
                            <td><?php echo $data['firstName']; ?></td>
                            <td><?php echo $data['lastName']; ?></td>
                            <td><?php echo $data['email']; ?></td>
                            <td><?php echo $data['gender']; ?></td>
                            <td></td>
                            <td><a href="admin-managing.php?cat=add-admin&edit=<?php echo $data['id']; ?>"><i class="far fa-edit"></i></a></td>
                            <td><a href="admin-managing.php?cat=delete-admin&id=<?php echo $data['id']; ?>" class="delete" name="admin_profile" id="<?php echo $data['id']; ?>"><i class="far fa-trash-alt"></i></a></td>
                        </tr>
                        <?php
                                }
                            } else {
                        ?>
                        <tr>
                            <td colspan="7">There is no data about existing admins.</td>
                        </tr>
                        <?php
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <script src="https://kit.fontawesome.com/a9f6196afa.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).on('click', '.delete', function(e) {
            var el = $(this);
            var id = $(this).attr('id');
            if ($('#confirmBox').css('display') == 'none') {
                $('#confirmBox').fadeIn();

                $('#confirmBox').find('button').on('click', function() {
                    if ($(this).val() == 1) {
                        <?php
                            $sql = "DELETE FROM admins WHERE id=".$_GET['id'];
                            $res = mysqli_query($conn, $sql);
                        ?>
                    }
                    $('#confirmBox').fadeOut();
                });
            }
        });
        $('.gender').click(function () {
            $(this).attr('tabindex', 1).focus();
            $(this).toggleClass('active');
            $(this).find('.dropdown-menu').slideToggle(300);
        });
        $('.gender').focusout(function () {
            $(this).removeClass('active');
            $(this).find('.dropdown-menu').slideUp(300);
        });
        $('.gender .dropdown-menu li').click(function () {
            $(this).parents('.gender').find('span').text($(this).text());
            $(this).parents('.gender').find('input').attr('value', $(this).attr('id'));
        });
    </script>
</body>
</html>