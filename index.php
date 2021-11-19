<?php
    session_start();
    include('config/dbConnect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="partials/css/footer.css">
    <link rel="stylesheet" href="partials/css/header.css">
    <title>DigitalBook</title>
</head>
<body>
    <div class="wrapper">
        <?php include('partials/header.php'); ?>
        <div class="page">
            <div class="filter">
                <form name="form" method="get">
                    <ul>
                        <li>Genre
                            <ul>
                                <?php
                                    $sqlgenres = "SELECT * FROM genre WHERE flag = 1 ORDER BY name";
                                    $res = $conn -> query($sqlgenres);
                                    while ($data = mysqli_fetch_assoc($res)) {
                                    ?>
                                    <li><input type="checkbox" name="genres[]" value="<?php echo $data['id']; ?>" id="genre-<?php echo $data['id']; ?>" <?php if (isset($_GET['genres'])) { 
                                        if (in_array($data['id'], $_GET['genres'])) echo "checked";
                                    } ?>><label for="genre-<?php echo $data['id']; ?>"><?php echo $data['name'] ?></label></li>
                                    <?php } ?>
                            </ul>
                        </li>
                        <li>Author
                            <ul>
                                <?php
                                    if (isset($_GET['genres'])) {
                                        $genretoauthor = "";
                                        foreach ($_GET['genres'] as $n => $row) {
                                            $genretoauthor .= $row;
                                            if ($n < count($_GET['genres']) - 1) {
                                                $genretoauthor .= ", ";
                                            }
                                        }
                                        $sqlauthors = "SELECT a.name as name, a.id as id from author as a where a.id in (select b.id from book as b where b.genreId in (".$genretoauthor."))";
                                    } else {
                                        $sqlauthors = "SELECT * FROM author WHERE flag = 1 ORDER BY name";
                                    }
                                    $res = $conn -> query($sqlauthors);
                                    if (!$res) echo mysqli_error($conn);
                                    while ($data = mysqli_fetch_assoc($res)) {
                                ?>
                                    <li><input type="checkbox" name="authors[]" value="<?php echo $data['id']; ?>" id="author-<?php echo $data['id'] ?>" <?php if (isset($_GET['authors'])) {
                                        if (in_array($data['id'], $_GET['authors'])) echo "checked";
                                    }
                                    ?>><label for="author-<?php echo $data['id']; ?>"><?php echo $data['name']; ?></label></li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                    <input type="submit" value="Filter!" name="filter" class="filterbutton">
                </form>
                <?php
                    function addFilterCondition($where, $add, $and = true) {
                        if ($where) {
                            if ($and) $where .= " AND $add";
                            else $where .= " OR $add";
                        } else $where = $add;
                        return $where;
                    }

                    if (!empty($_GET["filter"])) {
                        $where = "";
                        if ($_GET["genres"]) {
                            $idsgenres = $_GET["genres"];
                            $genrestring = "";
                            foreach ($idsgenres as $n => $row) {
                                $genrestring .= $row;
                                if ($n < count($idsgenres) - 1) {
                                    $genrestring .= ", ";
                                }
                            }
                            $where = addFilterCondition($where, 'g.id IN ('. $genrestring .')');
                        }
                        if ($_GET["authors"]) {
                            $idauthors = $_GET["authors"];
                            $authorstring = "";
                            foreach ($idauthors as $n => $row) {
                                $authorstring .= $row;
                                if ($n < count($idauthors) - 1) {
                                    $authorstring .= ", ";
                                }
                            }
                            $where = addFilterCondition($where, 'a.id IN ('. $authorstring .')');
                        }
                    }
                        $sql = 'SELECT b.id AS bookid, b.name AS bookname, a.name AS authorname, g.name AS genrename FROM (
                            SELECT id, name, genreId, authorId
                            FROM book WHERE flag = 1
                        ) AS b
                        LEFT JOIN author AS a ON b.authorId = a.id
                        LEFT JOIN genre AS g ON b.genreId = g.id';
                    
                        if ($where) $sql .= " WHERE $where";
                        $res = $conn -> query($sql);
                        $result = array();
                ?>
            </div>
            <div class="library">
                <p>Catalog</p>
                <?php 
                if ($res -> num_rows > 0) {
                    while ($data = mysqli_fetch_assoc($res)) {
                        array_push($result, $data);
                ?>
                <div class="container-book">
                    <div class="bookimage">
                        <img src=<?php echo "media/bookimages/".$data['bookid'].".jpg" ?> alt="bookimage">
                    </div>
                    <div class="information">
                        <h4><?php echo $data['bookname'] ?></h4>
                        <p>Genre: <?php echo $data['genrename'] ?></p>
                        <p>Author: <?php echo $data['authorname'] ?></p>
                    </div>
                </div>
                <?php
                        }
                    } else {
                ?>
                <p>Не найдены книги по вашему запросу.</p>
                <?php } ?>
            </div>
        </div>
        <?php include('partials/footer.php'); ?>
    </div>
    <script src="https://kit.fontawesome.com/a9f6196afa.js" crossorigin="anonymous"></script>
</body>
</html>

