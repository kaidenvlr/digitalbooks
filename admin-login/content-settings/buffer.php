<?php
    require_once('../../config/dbConnect.php');

    if (!empty($_GET['deleteId']) && !empty($_GET['deleteData'])) {
        if ($_GET['deleteData'] == 'delete-author') {
            $sql = "SELECT name FROM author WHERE id=".$_GET['deleteId'];
            $res = $conn -> query($sql);
            $data = mysqli_fetch_assoc($res);
            $sqlTransaction = "INSERT INTO transactions (name, description) VALUES ('Delete author', 'Delete author ".$data['name']."')";
            $stmt = mysqli_prepare($conn, $sqlTransaction);
            $stmt -> execute();

            $sql = "UPDATE author SET flag = 0 WHERE id=".$_GET['deleteId'];
            $stmt = mysqli_prepare($conn, $sql);
            $stmt -> execute();
            
            $sqlbook = "UPDATE book SET flag = 3 WHERE authorId=".$_GET['deleteId'];
            $stmtbook = mysqli_prepare($conn, $sqlbook);
            $stmtbook -> execute();
        } else if ($_GET['deleteData'] == 'delete-genre') {
            $sql = "SELECT name FROM genre WHERE id=".$_GET['deleteId'];
            $res = $conn -> query($sql);
            $data = mysqli_fetch_assoc($res);
            $sqlTransaction = "INSERT INTO transactions (name, description) VALUES ('Delete genre', 'Delete genre ".$data['name']."')";
            $stmt = mysqli_prepare($conn, $sqlTransaction);
            $stmt -> execute();

            $sql = "UPDATE genre SET flag = 0 WHERE id=".$_GET['deleteId'];
            $stmt = mysqli_prepare($conn, $sql);
            $stmt -> execute();
            
            $sqlbook = "UPDATE book SET flag = 2 WHERE genreId=".$_GET['deleteId'];
            $stmtbook = mysqli_prepare($conn, $sqlbook);
            $stmtbook -> execute();
        } else if ($_GET['deleteData'] == 'delete-book') {
            $sql = "SELECT name FROM book WHERE id=".$_GET['deleteId'];
            $res = $conn -> query($sql);
            $data = mysqli_fetch_assoc($res);
            
            $sqlTransaction = "INSERT INTO transactions (name, description) VALUES ('Delete book', 'Delete book ".$data['name']."')";
            $stmt = mysqli_prepare($conn, $sqlTransaction);
            $stmt -> execute();

            $sqlbook = "UPDATE book SET flag = 0 WHERE id=".$_GET['deleteId'];
            $stmtbook = mysqli_prepare($conn, $sqlbook);
            $stmtbook -> execute();
        }
    }

    if (!empty($_GET['restoreId']) && !empty($_GET['restoreData'])) {
        if ($_GET['restoreData'] == 'restore-author') {
            $sql = "SELECT name FROM author WHERE id=".$_GET['restoreId'];
            $res = $conn -> query($sql);
            $data = mysqli_fetch_assoc($res);
            $sqlTransaction = "INSERT INTO transactions (name, description) VALUES ('Restore author', 'Restore author ".$data['name']."')";
            $stmt = mysqli_prepare($conn, $sqlTransaction);
            $stmt -> execute();

            $sql = "UPDATE author SET flag = 1 WHERE id=".$_GET['restoreId'];
            $stmt = mysqli_prepare($conn, $sql);
            $stmt -> execute();
            
            $sqlbook = "UPDATE book SET flag = 1 WHERE authorId=".$_GET['restoreId']." AND flag = 3";
            $stmtbook = mysqli_prepare($conn, $sqlbook);
            $stmtbook -> execute();
        } else if ($_GET['restoreData'] == 'restore-genre') {
            $sql = "SELECT name FROM genre WHERE id=".$_GET['restoreId'];
            $res = $conn -> query($sql);
            $data = mysqli_fetch_assoc($res);

            $sqlTransaction = "INSERT INTO transactions (name, description) VALUES ('Restore genre', 'Restore genre ".$data['name']."')";
            $stmt = mysqli_prepare($conn, $sqlTransaction);
            $stmt -> execute();
            
            $sql = "UPDATE genre SET flag = 1 WHERE id=".$_GET['restoreId'];
            $stmt = mysqli_prepare($conn, $sql);
            $stmt -> execute();
            
            $sqlbook = "UPDATE book SET flag = 1 WHERE genreId=".$_GET['restoreId']." AND flag = 2";
            $stmtbook = mysqli_prepare($conn, $sqlbook);
            $stmtbook -> execute();
        } else if ($_GET['restoreData'] == 'restore-book') {
            $sql = "SELECT name FROM book WHERE id=".$_GET['restoreId'];
            $res = $conn -> query($sql);
            $data = mysqli_fetch_assoc($res);

            $sqlTransaction = "INSERT INTO transactions (name, description) VALUES ('Restore book', 'Restore book ".$data['name']."')";
            $stmt = mysqli_prepare($conn, $sqlTransaction);
            $stmt -> execute();

            $sqlbook = "UPDATE book SET flag = 1 WHERE id=".$_GET['restoreId'];
            $stmtbook = mysqli_prepare($conn, $sqlbook);
            $stmtbook -> execute();
            
            $sqlauthor = "UPDATE author SET flag = 1 WHERE id = (SELECT authorId FROM book WHERE id=".$_GET['restoreId'].")";
            $stmtauthor = mysqli_prepare($conn, $sqlauthor);
            $stmtauthor -> execute();
            
            $sqlgenre = "UPDATE genre SET flag = 1 WHERE id = (SELECT genreId FROM book WHERE id=".$_GET['restoreId'].")";
            $stmtgenre = mysqli_prepare($conn, $sqlgenre);
            $stmtgenre -> execute();
        }
    }


?>