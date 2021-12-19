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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).on('click', '.delete', function(e) {
            var el = $(this);
            var id=$(this).attr('id');
            var name = $(this).attr('name');
            $.ajax({
                type: "GET",
                url: "buffer.php",
                data: {
                    deleteId: id,
                    deleteData: name
                },
                dataType: "html",
                success: function(data) {
                    alert('deleted!');
                }
            })
        });

        $(document).on('click', '.restore', function(e) {
            var el = $(this);
            var id = $(this).attr('id');
            var name = $(this).attr('name');
            $.ajax({
                type: "GET",
                url: "buffer.php",
                data: {
                    restoreId: id,
                    restoreData: name
                },
                dataType: "html",
                success: function(data) {
                    alert('restored!');
                }
            })
        });

        $(document).on('click', '.full-delete', function(e) {
            var el = $(this);
            var id = $(this).attr('id');
            var name = $(this).attr('name');
            $.ajax({
                type: "GET",
                url: "buffer.php",
                data: {
                    fullDeleteId: id,
                    fullDeleteData: name
                },
                dataType: "html",
                success: function(data) {
                    alert("Full deleted!");
                }
            })
        });
    </script>
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
                    if ($_GET['cat'] =='add-author') {
                        if (!empty($_GET['edit'])) {
                            $editId = $_GET['edit'];
                            $query = "SELECT * FROM author WHERE id=$editId";
                            $res = $conn -> query($query);
                            $editData = mysqli_fetch_assoc($res);
                            $name = $editData['name'];
                            $dateBirth = $editData['date_birth'];
                            $dateDeath = $editData['date_death'];

                            $idAttr = "updateAuthorForm";
                        } else {
                            $name = "";
                            $dateBirth = "2021-10-19";
                            $dateDeath = "1900-01-01";

                            $editId = "";
                            $idAttr = "authorForm";

                        }
                ?>

                <?php
                    if (isset($_POST['save'])) {
                        if (empty($_GET['edit'])) {
                            $sql = "INSERT INTO author (name,date_birth,date_death) VALUES (?,?,?)";
                            $stmt = mysqli_prepare($conn, $sql);
                            mysqli_stmt_bind_param($stmt, "sss", $_POST['name'], $_POST['dateBirth'], $_POST['dateDeath']);
                            mysqli_stmt_execute($stmt);
                            $sqlTransaction = "INSERT INTO transactions (name, description) VALUES ('Add author', 'Add author ".$_POST['name']."')";
                            $stmt = mysqli_prepare($conn, $sqlTransaction);
                            $stmt -> execute();
                        } else {
                            $sql = "UPDATE author SET name=?, date_birth=?, date_death=? WHERE id=".$_GET['edit'];
                            $stmt = mysqli_prepare($conn, $sql);
                            $stmt -> bind_param("sss", $_POST['name'], $_POST['dateBirth'], $_POST['dateDeath']);
                            $stmt -> execute();
                            $sqlTransaction = "INSERT INTO transactions (name, description) VALUES ('Edit Author', 'Edit author ".$_POST['name']."')";
                            if (!mysqli_query($conn, $sqlTransaction)) {
                                echo ("Error:".mysqli_error($conn));
                            }
                        }
                    }
                ?>
                <div class="hheader">
                    <?php
                        if (empty($_GET['edit'])) {
                            echo "<h4>Добавление автора</h4>";
                        } else {
                            echo "<h4>Редактирование автора</h4>";
                        }
                    ?>
                    <a href="author.php"><button class="right">Перейти к обзору авторов</button></a>
                </div>
                <div class="view">
                    <form id="<?php echo $idAttr; ?>" rel="<?php echo $editId; ?>" name="author_profile" method="POST">
                        <div class="name">
                            <span>Фамилия и имя</span>
                            <input type="text" placeholder="Фамилия и имя" name="name" value="<?php echo $name ?>" required>
                        </div>
                        <div class="date-birth">
                            <span>Дата рождения</span>
                            <input type="date" name="dateBirth" value="<?php echo $dateBirth ?>" max="2021-10-19" required>
                        </div>
                        <div class="date-death">
                            <span>Дата смерти</span>
                            <input type="date" name="dateDeath" value="<?php echo $dateDeath ?>">
                        </div>
                        <button type="submit" class="submit-button" name="save">Сохранить</button>
                    </form>
                </div>
                <?php  } else {?>
                <div class="hheader">
                    <h4>Управление авторами</h4>
                    <button type="button" class="export" name="export-author">Export to Excel</button>
                    <a href="author.php?cat=add-author"><button class="right">Добавить автора</button></a>
                </div>
                <div class="view">
                    <table>
                        <tr>
                            <th>Фамилия и имя</th>
                            <th>Дата рождения</th>
                            <th>Дата смерти</th>
                            <th></th>
                            <th>Редактировать</th>
                            <th>Удалить</th>
                        </tr>
                        <?php
                            $sql = "SELECT * FROM author WHERE flag = 1 ORDER BY id";
                            $res = $conn -> query($sql);
                            if ($res -> num_rows > 0) {
                                while ($data = mysqli_fetch_assoc($res)) {
                        ?>
                        <tr>
                            <td><?php echo $data['name']; ?></td>
                            <td><?php echo $data['date_birth']; ?></td>
                            <td><?php 
                                if ($data['date_death'] == '1900-01-01') {
                                    echo ' ';
                                } else {
                                    echo $data['date_death'];
                                }
                            ?></td>
                            <td></td>
                            <td><a href="author.php?cat=add-author&edit=<?php echo $data['id']; ?>"><i class="far fa-edit"></i></a></td>
                            <td><a class="delete" name="delete-author" id="<?php echo $data['id']; ?>" href="javascript:void(0)"><i class="far fa-trash-alt"></i></a></td>
                        </tr>
                        <?php
                                }
                            } else {
                        ?>
                        <tr>
                            <td colspan="6">Нет данных о существующих авторах.</td>
                        </tr>
                        <?php
                            }
                        ?>
                    </table>
                </div>
                <div class="hheader">
                    <h4>Удаленные авторы</h4>
                </div>
                <div class="view">
                    <table>
                        <tr>
                            <th>Фамилия и имя</th>
                            <th>Дата рождения</th>
                            <th>Дата смерти</th>
                            <th></th>
                            <th>Удалить</th>
                            <th>Восстановить</th>
                        </tr>
                        <?php
                            $sql = "SELECT * FROM author WHERE flag = 0 ORDER BY id";
                            $res = $conn -> query($sql);
                            if ($res -> num_rows > 0) {
                                while ($data = mysqli_fetch_assoc($res)) {
                        ?>
                        <tr>
                            <td><?php echo $data['name']; ?></td>
                            <td><?php echo $data['date_birth']; ?></td>
                            <td><?php 
                                if ($data['date_death'] == '1900-01-01') {
                                    echo ' ';
                                } else {
                                    echo $data['date_death'];
                                }
                            ?></td>
                            <td></td>
                            <td><a href="javascript:void(0)" class="full-delete" name="full-delete-author" id="<?php echo $data['id']; ?>"><i class="far fa-trash-alt"></i></a></td>
                            <td><a href="javascript:void(0)" class="restore" name="restore-author" id="<?php echo $data['id']; ?>"><i class="far fa-trash-alt"></i></a></td>
                        </tr>
                        <?php
                                }
                            } else {
                        ?>
                        <tr>
                            <td colspan="6">Нет данных об удаленных авторах.</td>
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
        $(document).on('click', '.export', function(e) {
            var el = $(this);
            var name=$(this).attr('name');
            $.ajax({
                url: "partials/export.php",
                type: "GET",
                data: {
                    operation: name
                },
                success: function(result) {
                    alert("Exported!");
                }
            })
        });
    </script>
</body>
</html>