<?php

include $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';

if (isset($_POST['files'])) {
    foreach ($_POST['files'] as $key => $file) {
        $filePath = $uploadPath . $key;
        if (strpos(realpath($filePath), realpath($uploadPath)) === 0) {
            unlink($filePath);
        }
    }

    echo '<div class="success-message error-show">Файлы успешно удалены</div>';
} else {
    echo '<div class="error-message error-show">Выберите хотя бы один файл для удаления</div>';
}
