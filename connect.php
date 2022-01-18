<?php


$host = 'localhost';
$user = 'root';
$pw = '';

$db_connect = mysqli_connect($host,$user,$pw,"ebid_multi");

if(!$db_connect){
    die("Unable to complete request" . mysqli_connect_error());
}


?>