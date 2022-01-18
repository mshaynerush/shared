<?php
session_start();

    include 'connect.php';

    $user_name = $_POST['user'];
    $pw = $_POST['pw'];


    $get_user = $db_connect->query("SELECT `user_name`, `pass` FROM users WHERE `user_name` = '$user_name' AND `pass` = '$pw'");
    if(mysqli_num_rows($get_user) > 0){
        $_SESSION['logged_in'] = 'True';

        echo 'success';
    } else {
        $_SESSION['logged_in'] == 'False';
        echo 'fail';
    }




?>