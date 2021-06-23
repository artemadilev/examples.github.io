<?php

include $_SERVER['DOCUMENT_ROOT'] . '/include/functions.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
$file_ary = reArrayFiles($_FILES['file']);
$success = false;
$filesWithError = [];
$textError = '';

if (count($file_ary) === 0) {
    echo '<br>Выберите хотя бы один файл для загрузки';
} elseif (count($file_ary) <= $maxCountFiles) {
    foreach ($file_ary as $file) {
        if (!empty($file['error'])) {
            $textError = 'Ошибка файла';
            $filesWithError[] = $file['name'] . " ({$textError})";
            continue;
        }

        if (!in_array(mime_content_type($file['tmp_name']), $types)) {
            $textError = 'Некорректный формат файла, допустимы только: *.gif, *.png, *.jpg';
            $filesWithError[] = $file['name'] . " ({$textError})";
            continue;
        }

        if ($file['size'] < $maxFileSize) {
            $success = move_uploaded_file($file['tmp_name'], $uploadPath . rawurlencode($file['name']));
        } else {
            $textError = 'Слишком большой размер файла. Размер не должен превышать 5Mb';
            $filesWithError[] = $file['name'] . " ({$textError})";
        }
    }
} else {
    echo '<br>Максимальное количество загружаемых файлов 5';
}

if ($success === true) {
    echo '<div class="success-message error-show">Загрузка успешно завершена</div>';
} else {
    echo '<div class="error-message error-show">Загрузка не завершена</div>';
}

if (count($filesWithError) > 0) {
    echo '<br>Следующие файлы не были загружены:<br>';
    foreach ($filesWithError as $row) {
        echo $row . "<br>\r\n";
    }
}
