<?php
    require_once('../../../config/dbConnect.php');
    function cleanData(&$str) {
        if ($str == 't') $str = 'TRUE';
        if ($str == 'f') $str = 'FALSE';
        if (preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) $str = "'$str";
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }
    if (!empty($_GET['operation'])) {
        if ($_GET['operation'] == 'export-author') {
            $filename = "author_data_".date('Ymd').".csv";

            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Content-Type: text/csv");
            $out = fopen($filename, 'w+');

            $flag = false;
            $sql = "SELECT * FROM author WHERE flag = 1 ORDER BY id";
            $res = $conn -> query($sql);
            while ($data = mysqli_fetch_assoc($res)) {
                if (!$flag) {
                    fputcsv($out, array_keys($data), ',', '"');
                    $flag = true;
                }
                array_walk($data, __NAMESPACE__.'\cleanData');
                fputcsv($out, array_values($data), ',', '"');
            }
            fclose($out);
            exit;
        } else if ($_GET['operation'] == 'export-genre') {
            $filename = "genre_data_".date('Ymd').".csv";

            header("Content-Disposition: attachment; filename=\"$fileName\"");
            header("Content-Type: text/csv");
            $out = fopen($filename, 'w+');

            $flag = false;
            $sql = "SELECT * FROM genre WHERE flag = 1 ORDER BY id";
            $res = $conn -> query($sql);
            while ($data = mysqli_fetch_assoc($res)) {
                if (!$flag) {
                    fputcsv($out, array_keys($data), ',', '"');
                    $flag = true;
                }
                array_walk($data, __NAMESPACE__.'\cleanData');
                fputcsv($out, array_values($data), ',', '"');
            }
            fclose($out);
            exit;
        } else if ($_GET['operation'] == 'export-book') {
            $filename = "book_data_".date('Ymd').".csv";

            header("Content-Disposition: attachment; filename=\"$fileName\"");
            header("Content-Type: text/csv");
            $out = fopen($filename, 'w+');

            $flag = false;
            $sql = "SELECT * FROM book WHERE flag = 1 ORDER BY id";
            $res = $conn -> query($sql);
            while ($data = mysqli_fetch_assoc($res)) {
                if (!$flag) {
                    fputcsv($out, array_keys($data), ',', '"');
                    $flag = true;
                }
                array_walk($data, __NAMESPACE__.'\cleanData');
                fputcsv($out, array_values($data), ',', '"');
            }
            fclose($out);
            exit;
        }
    }
?>