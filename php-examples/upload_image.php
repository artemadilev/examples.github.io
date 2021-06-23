<?php

include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';

$rootPath = $_SERVER['DOCUMENT_ROOT'];

?>

<h1>Upload images</h1><a href="/" class="link">Back to Gallery</a>

<div id="upload-wrapper">
    <form action="" method="post" enctype="multipart/form-data" id="uploadFilesForm" name="uploadFilesForm">
        <input type="file" name="myFiles" value="Upload files" id="myFiles" accept="<?= implode(', ', $types); ?>" multiple required>
        <input type="submit" value="Upload" name="upload">
    </form>
    <div class="notice-message"></div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//malsup.github.io/min/jquery.form.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    $("#uploadFilesForm").on('submit', function(e) {

      let formData = new FormData();
      $.each($("#myFiles")[0].files,function(key, input){
        formData.append('file[]', input);
      });

      e.preventDefault();
      $.ajax({
        url: "/include/save_files.php",
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        success: function (data) {
          $('.notice-message').append(data);
        }, error: function (response) {
          $('.notice-message').append(response);
        }
      });
    });
  });
</script>
