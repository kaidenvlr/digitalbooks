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
                    if ($_GET['cat'] =='add-genre') {
                        if (!empty($_GET['edit'])) {
                            $editId = $_GET['edit'];
                            $query = "SELECT * FROM genre WHERE id=$editId";
                            $res = $conn -> query($query);
                            $editData = mysqli_fetch_assoc($res);
                            $name = $editData['name'];

                            $idAttr = "updateGenreForm";
                        } else {
                            $name = "";

                            $editId = "";
                            $idAttr = "genreForm";

                        }
                ?>

                <?php
                    if (isset($_POST['save'])) {
                        if (empty($_GET['edit'])) {
                            $sql = "INSERT INTO genre (name) VALUES (?)";
                            $stmt = mysqli_prepare($conn, $sql);
                            mysqli_stmt_bind_param($stmt, "s", $_POST['name']);
                            mysqli_stmt_execute($stmt);
                            $sqlTransaction = "INSERT INTO transactions (name, description) VALUES ('Add genre', 'Add genre ".$_POST['name']."')";
                            $stmt = mysqli_prepare($conn, $sqlTransaction);
                            $stmt -> execute();
                        } else {
                            $sql = "UPDATE genre SET name=? WHERE id=".$_GET['edit'];
                            $stmt = mysqli_prepare($conn, $sql);
                            $stmt -> bind_param("s", $_POST['name']);
                            $stmt -> execute();
                            $sqlTransaction = "INSERT INTO transactions (name, description) VALUES ('Edit genre', 'Edit genre ".$_POST['name']."')";
                            $stmt = mysqli_prepare($conn, $sqlTransaction);
                            $stmt -> execute();
                        }
                    }
                ?>
                <div class="hheader">
                    <?php
                        if (empty($_GET['edit'])) {
                            echo "<h4>Добавление жанра</h4>";
                        } else {
                            echo "<h4>Редактирование жанра</h4>";
                        }
                    ?>
                    <a href="genre.php"><button class="right">Перейти к обзору жанров</button></a>
                </div>
                <div class="view">
                    <form id="<?php echo $idAttr; ?>" rel="<?php echo $editId; ?>" name="genre_profile" method="POST">
                        <div class="name">
                            <span>Название жанра</span>
                            <input type="text" placeholder="Название жанра" name="name" value="<?php echo $name ?>" required>
                        </div>
                        <button type="submit" class="submit-button" name="save">Сохранить</button>
                    </form>
                </div>
                <?php  } else {?>
                <div class="hheader">
                    <h4>Управление жанрами</h4>
                    <button type="button" class="export" name="export-genre">Export to Excel</button>
                    <a href="genre.php?cat=add-genre"><button class="right">Добавить жанр</button></a>
                </div>
                <div class="view">
                    <table>
                        <tr>
                            <th>Название жанра</th>
                            <th></th>
                            <th>Редактировать</th>
                            <th>Удалить</th>
                        </tr>
                        <?php
                            $sql = "SELECT * FROM genre WHERE flag=1 ORDER BY id";
                            $res = $conn -> query($sql);
                            if ($res -> num_rows > 0) {
                                while ($data = mysqli_fetch_assoc($res)) {
                        ?>
                        <tr>
                            <td><?php echo $data['name']; ?></td>
                            <td></td>
                            <td><a href="genre.php?cat=add-genre&edit=<?php echo $data['id']; ?>"><i class="far fa-edit"></i></a></td>
                            <td><a href="javascript:void(0)" class="delete" name="delete-genre" id="<?php echo $data['id']; ?>"><i class="far fa-trash-alt"></i></a></td>
                        </tr>
                        <?php
                                }
                            } else {
                        ?>
                        <tr>
                            <td colspan="6">Нет данных о существующих жанрах.</td>
                        </tr>
                        <?php
                            }
                        ?>
                    </table>
                </div>
                <div class="hheader">
                    <h4>Удаленные жанры</h4>
                </div>
                <div class="view">
                    <table>
                        <tr>
                            <th>Название жанра</th>
                            <th></th>
                            <th>Редактировать</th>
                            <th>Восстановить</th>
                        </tr>
                        <?php
                            $sql = "SELECT * FROM genre WHERE flag=0 ORDER BY id";
                            $res = $conn -> query($sql);
                            if ($res -> num_rows > 0) {
                                while ($data = mysqli_fetch_assoc($res)) {
                        ?>
                        <tr>
                            <td><?php echo $data['name']; ?></td>
                            <td></td>
                            <td><a href="javascript:void(0)" class="full-delete" name="full-delete-author" id="<?php echo $data['id']; ?>"><i class="far fa-trash-alt"></i></a></td>
                            <td><a href="javascript:void(0)" class="restore" name="restore-genre" id="<?php echo $data['id']; ?>"><i class="far fa-trash-alt"></i></a></td>
                        </tr>
                        <?php
                                }
                            } else {
                        ?>
                        <tr>
                            <td colspan="6">Нет данных о существующих жанрах.</td>
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