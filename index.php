<?php
session_start();

include 'header.php';

?>

<div class="content">
    <div class="centered">
        <h2>Choose auction details file for uplaod</h2>
        <br>
            <form method="POST" action='upload-auction.php' enctype="multipart/form-data">
                <!-- Create Auction Data upload field -->
                <label for="file-upload-auction">Upload Auction Results CSV</label>
                <br>
                <input name="file-upload-auction" id="fileUploadAuction" type="file" accept="csv">
                <br>
                <div name="fileNameAuction" id="fileNameAuction" class="hidden fileNameHolder"></div>
                <br >
                <input name="submit" type="submit" class="btn btn-success" id="btnUpload" value="Upload">
            </form>

    </div>
</div>