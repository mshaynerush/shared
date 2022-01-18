<?php

include 'functions.php';
include 'connect.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$bidder = $_POST['bidder'];
$auction = $_POST['auction'];
$time_out = $_POST['timeOut'];

    $get_items = "SELECT a.auction_id, a.item_id, a.item_desc, i.item_location, i.bidder_id
    FROM auctions as a
    JOIN inventory as i
    ON a.auction_id = i.auction_id and a.winner_id = i.bidder_id and a.item_id = i.item_number
    WHERE a.auction_id = '$auction' AND a.winner_id = '$bidder';";

    $result = $db_connect->query($get_items);

    $res = mysqli_num_rows($result);
    if($res > 0){
        echo '<h3>Bidder ID: ' . $bidder . '</h3>';
            while($row = mysqli_fetch_array($result)){
                echo '<div></span>Item Number: ' . $row['item_id'] . '</span><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span></span><span>Location: ' . $row['item_location'] . '</span></div>';
            }
    } else {
            echo 'failure';
    }

?>