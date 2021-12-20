<?php
    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];

        $fileTmpName = $_FILES['image']['tmp_name'];
        $errorCode = $_FILES['image']['error'];

        $fileInfo = $image['type'];

        if (strpos($fileInfo, 'image') === false) {
            echo $fileInfo;
            die("Можно загружать только изображения.");
        }
        
        if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($fileTmpName)) {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
                UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
                UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
                UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
                UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
                UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
                UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
            ];

            $unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';

            $outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;

            die($outputMessage);
        } else {
            $image = getimagesize($fileTmpName);
            echo php_ini_loaded_file()."\n";
            echo print_r($_FILES);
            echo print_r($_FILES['image']);
            $name = $_COOKIE['id'];
            $extension = image_type_to_extension($image[2]);
            echo $name;
            $format = str_replace('jpeg', 'jpg', $extension);

            if (!move_uploaded_file($fileTmpName, __DIR__.'/../../media/bookimages/'.$name.$format)) {
                echo $format;
                die('При записи изображения на диск произошла ошибка.');
            }

            echo 'Картинка успешно загружена';
        }
    } else if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $fileTmpName = $file['tmp_name'];
        $errorCode = $file['error'];
        $fileInfo = $file['type'];
        if (strpos($fileInfo, 'pdf') === false) {
            echo $fileInfo;
            die("Можно загружать только pdf или txt форматы книг.");
        }

        if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($fileTmpName)) {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
                UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
                UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
                UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
                UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
                UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
                UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
            ];

            $unknownMessage = "При загрузке файла произошла неизвестная ошибка.";
            $outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;

            die($outputMessage);
        } else {
            $name = $_COOKIE['id'];
            $format = substr($file['name'], strpos($file['name'], ".") + 1);
            $extension = image_type_to_extension($file[2]);
            if (!move_uploaded_file($fileTmpName, __DIR__.'/../../media/books/'.$name.'.'.$format)) {
                die('При записи изображения на диск произошла ошибка.');
            }
            echo 'Файл успешно загружен';
        }
    }
?>