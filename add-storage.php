<?php

include 'header.php';

?>

<div class="content">
   
    <div class="centered">
    <h2>Upload Storage Agreement</h2>
        <form method="POST" action='upload-storage.php' enctype="multipart/form-data">
            <!-- Create Long Term Storage file upload field -->
            <label for="file-upload-lts">Upload Long Term Storage CSV</label>
            <br>
            <input name="file-upload-lts" id="fileUploadLts" type="file" accept="csv">
            <br>
            <div name="fileNameLts" id="fileNameLts" class="hidden fileNameHolder"></div>
            <br>
            <!-- Create csv upload buttons for picklist generator -->
            <input name="submit" type="submit" class="btn btn-success" id="btnUpload" value="Upload">
        </form>
    </div>
</div>
