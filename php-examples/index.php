<?php

include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';

$uploadedFiles = scandir($_SERVER['DOCUMENT_ROOT'] . '/upload');
sort($uploadedFiles);
$uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';

?>

    <h1>Gallery of loadded images</h1>
    <a href="/upload_image.php" class="add-image-link">
        <button class="add-image-btn" type="button">
            Upload image
        </button>
    </a>

    <div id="gallery">
        <form action="" method="post" name="deleteFilesForm" id="deleteFilesForm">
            <ul class="gallery-list">
                <?php foreach ($uploadedFiles as $key => $file):
                    $filePath = $uploadPath . $file;
                    $createdDate = date('Y-m-d', filectime($filePath));
                    if (!is_dir($filePath)): ?>
                        <li class="gallery-item">
                            <a href="/upload/<?= urlencode($file) ?>" target="_blank">
                                <img src="/upload/<?= urlencode($file) ?>" alt="">
                            </a>
                            <div class="gallery-item-data">
                                <span class="gallery-item-title">Title: <?= rawurldecode($file) ?></span>
                                <span>Time of upload: <?= $createdDate ?></span>
                                <span>Size: <?= convertFileSize(stat($filePath)['size']) ?></span>
                                <div>
                                    <label for="delFile<?= $key ?>">Remove file: </label>
                                    <input type="checkbox" name="files[<?= $file ?>]" id="delFile<?= $key ?>" class="gallery-item-checkbox">
                                </div>
                            </div>
                        </li>
                    <?php endif ?>
                <?php endforeach ?>
            </ul>
            <input type="submit" class="gallery-remove-btn" name="deleteFiles" value="Remove Files">
            <div class="notice-message"></div>
        </form>
    </div>

    <script type="text/javascript">
      $(document).ready(function () {
        $("#deleteFilesForm").on("submit", function (e) {
          e.preventDefault();
          let files = $(':checkbox:checked');
          let filesParents = $(':checkbox:checked').parent().parent().parent();

          $.ajax({
            url: "/include/remove_files.php",
            type: "POST",
            data: files,
            context: document.body,
            success: function (data) {
              filesParents.remove();
              $('.notice-message').empty().show().append(data).hide(2000);
            }, error: function (response) {
              $('.notice-message').empty().show();
              $('.notice-message').append(response);
              $('.notice-message').hide(2000);
            }
          });
        });
      });
    </script>

<?php

include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
