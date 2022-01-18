<?php
session_start();
include 'functions.php';
$dir = 'csv/';

$upLoadAuction = $_FILES['file-upload-auction']['name'];
$tempFile = $_FILES['file-upload-auction']['tmp_name'];
$newFileAuction = $dir . basename($upLoadAuction);
move_uploaded_file($tempFile, $newFileAuction);
$fpAuction = fopen($newFileAuction, 'r');

    # Parse csv file into an associative array, each line of csv per row of data
    $table_rows = ParseCSV($fpAuction);
    
    LoadAuctionTable($table_rows);
    

?>