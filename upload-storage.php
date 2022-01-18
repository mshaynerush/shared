<?php
include 'header.php';
include 'functions.php';
include 'connect.php';

$dir = 'csv/';
$storage_upload_array = array();
    
    $upLoadStorage = $_FILES['file-upload-lts']['name'];
    $tempFile = $_FILES['file-upload-lts']['tmp_name'];
    $newFileStorage = $dir . basename($upLoadStorage);
    move_uploaded_file($tempFile, $newFileStorage);
    $fStorage = fopen($newFileStorage, 'r');
    while($row = fgetcsv($fStorage, 0, ',')){
        array_push($storage_upload_array, $row);
    }
    LoadStorageTable($storage_upload_array);
    fclose($newFileStorage);
?>
