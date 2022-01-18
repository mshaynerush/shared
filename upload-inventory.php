<?php

include 'connect.php';
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$items = $_POST['items'];
$auction = $_POST['auction'];
$timeIn = $_POST['timeIn'];
$item_count = 0;
$item_row = '';
$item_section = '';


foreach($items as $item => $loc){

    $item_col = preg_replace('/[^0-9]/', '', $loc);

    if(is_numeric($item_col)){
        $item_row = $loc[0];
        $item_section = $loc[strlen($loc) - 1];

        $sql = "INSERT INTO inventory( `auction_id`, `item_number`, `item_location`, `time_in`, `item_row`, `item_col`, `item_section`) ";
        $sql .= "VALUES('$auction', '$item', '$loc', '$timeIn', '$item_row', $item_col, '$item_section')";
    } else {
        $sql = "INSERT INTO inventory( `auction_id`, `item_number`, `item_location`, `time_in`) ";
        $sql .= "VALUES('$auction', '$item', '$loc', '$timeIn')";
    }

    if($db_connect->query($sql)){
        $item_count++;
    }
}

    
    if(($item_count == count($items)) && ($item_count > 0)){
        echo 'success';
    } else {
        echo 'something didn\'t work';
    }
?>