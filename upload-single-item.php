<?php

include 'connect.php';

$item = $_POST['item'];
$auction = $_POST['auction'];
$loc = $_POST['location'];
$time_in = $_POST['timeIn'];
$item_row = $loc[0];
$item_col = preg_replace('/[^0-9]/', '', $loc);
$item_section = $loc[strlen($loc) - 1];
$bidder = "N/A";

if(isset($item)){

    if(mysqli_num_rows($db_connect->query("SELECT * FROM inventory WHERE auction_id  = '$auction' and item_number = '$item'")) > 0){
        echo "exists";
    } else {

        $sql = "INSERT INTO inventory (`auction_id`, `item_number`, `item_type`, `item_location`, `time_in`, `bidder_id`, `item_row`, `item_col`, `item_section`)";
        $sql .= "VALUES('$auction', '$item', 'Standard', '$loc', '$time_in', '$bidder', '$item_row', $item_col, '$item_section')";

        $db_connect->query($sql);

        $result = $db_connect->query("SELECT * FROM inventory WHERE auction_id  = '$auction' and 'item_number' = '$item'");
            if($result){
                echo "success";
            } else {
                echo "error";
            }
    }
}

?>