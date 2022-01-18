<?php

include 'functions.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$bidder = $_POST['bidder'];
$auction = $_POST['auction'];

echo $bidder . ' ' . $auction;

    // $get_items = "SELECT a.auction_id, a.item_id, a.item_desc, i.item_location, i.bidder_id
    // FROM auctions as a
    // JOIN inventory as i
    // ON a.auction_id = i.auction_id and a.winner_id = i.bidder_id
    // WHERE a.auction_id = '$auction' AND a.winner_id = '$bidder';";

    // $result = $db_connect->query($get_items);

    // while($row = mysqli_fetch_array($result)){
    //     echo 'Auction ID: ' . $row['auction_id'] . ' Bidder: ' . $row['bidder_id'];
    // }

?>