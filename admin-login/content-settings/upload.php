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
            foreach ($_FILES as $key => $data) {
                echo $key.' => '.$data."\n";
            }
            $name = $_FILES['id'];
            $extension = image_type_to_extension($image[2]);
            echo $name;
            $format = str_replace('jpeg', 'jpg', $extension);

            if (!move_uploaded_file($fileTmpName, __DIR__.'/bookimages/'.$name.$format)) {
                foreach ($_POST as $key => $data) {
                    echo $key." =>  ".$data."\n";
                }
                echo 'nn';
                echo $name.$format;
                die('При записи изображения на диск произошла ошибка.');
            }

            echo 'Картинка успешно загружена';
        }
    }
?>