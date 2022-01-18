<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function ParseCSV($fpAuction){

# Create value for desired columns from csv

    # Empty Auctions Table
    

    $main_table = array();
    # Loop through each line of the file and pick columns listed in desired column variable

    while($data = fgetcsv($fpAuction, 0, ',')){
        if($data[0] == "auction_id"){
            
            continue;
        } else {
            $_SESSION['auctionID'] = $data[0];
            $item_desc = str_replace("'", 'ft', $data[4]);
            $row = array($data[0], $data[3], $item_desc, $data[7], $data[8], $data[9], $data[10]);
        }
        
            array_push($main_table, $row);
    }
        return $main_table;
    }

/* Place all the rows of the inventory array into the inventory table */
function LoadInvtentoryTable($data){
    include 'connect.php';

    $curr_result = $db_connect->query("SELECT * FROM inventory");
    $curr_rows = mysqli_num_rows($curr_result);

    array_shift($data);
    foreach($data as $row){
        if($row[0] != ''){
        $auction_id = $row[0];
        $item_number = $row[2];
        $item_type = $row[3];
        $item_location = $row[4];
        $time_in = date("Y-m-d H:m:s", strtotime($row[5]));
        $bidder_id = $row[1];
        $item_row = $row[7];
        $item_col = $row[8];
        $item_section = $row[9];

        $sql = "INSERT INTO inventory (`auction_id`, `item_number`, `item_type`, `item_location`, `time_in`, `bidder_id`, `item_row`, `item_col`, `item_section`)";
        $sql .= "VALUES('$auction_id', '$item_number', '$item_type', '$item_location', '$time_in', '$bidder_id', '$item_row', $item_col, '$item_section');";

        $db_connect->query($sql);
        
        }
    }

    $new_result = $db_connect->query("SELECT * FROM inventory");
    $new_rows = mysqli_num_rows($new_result);

    if($new_rows > $curr_rows){
        return 'Success';
    } else {
        return 'Failure';
    }
}

function LoadStorageTable($data){
    include 'connect.php';
    foreach($data as $row){
        $bidder_id = $row[0];
        $bidder_name = $row[1];
        $storage_loc = $row[2];
        $storage_date = date("Y-m-d H:m:s", strtotime($row[3]));
        $storage_signed = $row[4];

    $sql = "INSERT INTO storage(`bidder_id`, `bidder_name`, `storage_location`, `start_date`, `storage_agreement_signed`)";
    $sql .= " VALUES('$bidder_id','$bidder_name','$storage_loc','$storage_date','$storage_signed');";

    $db_connect->query($sql);
    }
    header('Location: index.php');
}

function LoadAuctionTable($data){
    include 'connect.php';
    $auction = $data[0][0];
    $_SESSION['auctionID'] = $auction;
    $_SESSION["auction"] = $data[0][0];
    $db_connect->query("DELETE FROM auctions WHERE `auction_id` = $auction");
    $db_connect->query("DELETE FROM auction_details WHERE `auction_id` = $auction");
    
    foreach($data as $row){
        
        $auction_id = $row[0];
        $item_number = $row[1];
        $item_desc = $row[2];

        if($row[4] == ""){
            $winning_bid = 0; 
             $winner_id = 'No Bidder';
             $winner_f_name = "None";
             $winner_l_name = "None";
         } else {
            $winning_bid = $row[3];
            $winner_id = $row[4];
            $winner_f_name = $row[5];
            $winner_l_name = $row[6];
        }

        $sql = "INSERT INTO auctions(`auction_id`, `item_id`, `item_desc`, `winning_bid`, `winner_id`, `winner_f_name`,`winner_l_name`)";
        $sql .= " VALUES('$auction_id','$item_number','$item_desc','$winning_bid','$winner_id','$winner_f_name','$winner_l_name');";

        $db_connect->query($sql);

        $load_inventory = "UPDATE inventory SET bidder_id ='$winner_id' WHERE auction_id = '$auction_id' and item_number = '$item_number'";
        $db_connect->query($load_inventory);

    }
    /* Load bidder ids into inventory based on item_id and auction_id */
    header("Location: reports.php");
}

function GetBidderOrder($auction){
    $sql = "SELECT distinct(winner_id) AS bidder, count(winner_id) AS item_qty
    FROM auctions
    WHERE auction_id = '$auction'
    GROUP BY winner_id
    ORDER BY item_qty ASC;";
}

function GetPickListOrder($auction){
    # Gets the quantity of the order for each bidder by counting the bidder_ids in the table. Each bidder instances is one item.
    
    $bid_list_by_agreement = array();
    include 'connect.php';
    $sql = "SELECT * FROM
    (SELECT a.auction_id, a.item_id, a.item_desc, a.winning_bid, a.winner_id, CONCAT(a.winner_f_name, ' ', a.winner_l_name) as bidder_name, i.item_location, i.item_row, i.item_col, i.item_section
    FROM auctions a
    LEFT OUTER JOIN inventory i
    ON a.auction_id = i.auction_id AND a.item_id = i.item_number AND a.winner_id != 'No Bidder'
    WHERE a.auction_id = '$auction'
    GROUP BY winner_id
    ) t1

   LEFT OUTER JOIN
    (SELECT s.storage_location, s.storage_agreement_signed, s.bidder_id
    FROM storage s
    ORDER BY storage_agreement_signed DESC) t2
    ON t1.winner_id = t2.bidder_id
   JOIN
    (SELECT winner_id, COUNT(winner_id) as item_qty
     FROM auctions
     WHERE auction_id = '$auction' and winner_id != 'No Bidder'
     GROUP BY winner_id
    ) c1
    ON t1.winner_id = c1.winner_id
    ORDER BY storage_agreement_signed DESC, item_qty ASC, item_row, item_col, item_section ASC";

    $result = $db_connect->query($sql);

    while($bid_list = mysqli_fetch_array($result)){
        array_push($bid_list_by_agreement, $bid_list);
    }

    return $bid_list_by_agreement;
}

function PrintGrp($bidders, $auction){

    $items = array();
    $bidder_list = '';
    $items = GetGrpBidderItems($bidders, $auction);
    $last = array_pop($bidders);
    
    echo '<div class="content">';
    echo '<div class="centered">';
    foreach($bidders as $bidder){
        $bidder_list .= $bidder . ', ';
    }
            echo '<div class="grp-item-header">Bidders: ';
            echo $bidder_list . $last ;
            echo '</div>';

            echo '<div class="grp-item-details">';
                echo '<span class="grp-item-details-header">Item Number</span><span class="grp-item-details-header">Item Location</span><span class="grp-item-details-header">Bidder ID</span>';
                echo '<span class="grp-item-details-header">Item Description</span><span class="grp-item-details-header">Item Price</span>';
                foreach($items as $i){
                    echo '<span class="grp-item-detail">' . $i['item_id'] . '</span><span class="grp-item-detail">' . $i['item_location'] . '</span><span class="grp-item-detail">'. $i['winner_id'] . '</span>';
                    echo '<span class="grp-item-detail item-desc">' . $i['item_desc'] . '</span><span class="grp-item-detail">$ ' . $i['winning_bid'] . '</span>';
                }
            echo '</div>';
        echo '</div>';
    echo '</div>';
}

function MakePickList($master_list){
    $items = array();
    echo '<div class="content">';
    foreach($master_list as $val){
        echo '<div class="centered">';
        echo '<div class="table-header">Bidder ID #' . $val['bidder_id'] . '</div>';
        echo '<div class="table-header bidder-name">Winner Name: ' . $val['bidder_name'] . '</div>';
        echo '<div class="table-header">Storage Location: ' . $val['storage_location'] . '</div>';
        echo '<div class="table-header">Item Qty - ' . ItemQty($val['bidder_id']) . '</div>'; 
        echo '<div class="item-details">';
        echo '<span class="item-detail-header">Item Number</span><span class="item-detail-header">Item Location</span><span class="item-detail-header">Item Description</span>';
        echo '<span class="item-detail-header">Item Price<span>';
        echo '</div>';
            echo '<div class="item-details">';
                /* Get Rows of items for this bidder */
                $items = GetSingleBidderItems($val['bidder_id']);
                    foreach($items as $i){
                    echo '<span class="item-detail">' . $i['item_id'] . '</span><span class="item-detail">' . $i['item_location'] . '</span>';
                    echo '<span class="item-detail">' . $i['item_desc'] . '</span><span class="item-detail">$ ' . $i['item_price'] . '</span>';
                    }

            echo '</div>';
        echo '<div class="barcode">*' . $val['auction_id'] . '-' . $val['bidder_id'] . '*</div>';
        
        echo '</div>';
    }

    echo '</div>';
}

function GetGrpBidderItems($bidders, $auction){
    include 'connect.php';
    $items = array();
    foreach($bidders as $bidder){
        $get_items = "SELECT a.item_id, i.item_location, a.item_desc, a.winning_bid, a.winner_id, i.item_row, i.item_col, i.item_section
                      FROM auctions as a
                      LEFT OUTER JOIN inventory as i
                      ON a.auction_id = i.auction_id AND a.item_id = i.item_number
                      WHERE a.winner_id = '$bidder' and a.auction_id = '$auction'
                      ORDER BY i.item_row, i.item_col, i.item_section ASC";

        $result = $db_connect->query($get_items);
        while($row = mysqli_fetch_array($result)){
            array_push($items, $row);
        }
    }

    for($i = 0; $i < count($items); $i++){
        if(!empty($items[$i + 1])){
            if($items[$i][5] > $items[$i + 1][5]){
                $temp = $items[$i + 1];
                $items[$i + 1] = $items[$i];
                $items[$i] = $temp;
            }
        }
    }

    for($i = 0; $i < count($items); $i++){
        for($j = $i + 1; $j < count($items); $j++){
            if(!empty($items[$j])){
                if($items[$i][6] > $items[$j][6]){
                    if($items[$i][5] >= $items[$j][5]){
                        $temp = $items[$j];
                        $items[$j] = $items[$i];
                        $items[$i] = $temp;
                    }
                }
            }
        }
    }

    for($i = 0; $i < count($items); $i++){
        for($j = $i + 1; $j < count($items); $j++){
            if(!empty($items[$j])){
                if($items[$i][7] > $items[$j][7]){
                    if(($items[$i][5] >= $items[$j][5]) && ($items[$i][6] >= $items[$j][6])){
                        $temp = $items[$j];
                        $items[$j] = $items[$i];
                        $items[$i] = $temp;
                    }
                }
            }
        }
    }

    for($i = 0; $i < count($items); $i++){
        if($items[$i][5] == ''){
            $temp = array();
            $temp = $items[$i];
            unset($items[$i]);
            array_push($items, $temp);
            $temp = array();
        }
    }

    return $items;

}

function GetSingleBidderItems($bidder, $auction){

    include 'connect.php';
    $items = array();
    $get_items = "SELECT a.item_id, i.item_location, a.item_desc, a.winning_bid, a.winner_id, a.auction_id
    FROM auctions as a
    LEFT OUTER JOIN inventory as i
    ON a.winner_id = i.bidder_id and a.item_id = i.item_number
    WHERE a.winner_id = '$bidder' and a.auction_id = '$auction'
    GROUP BY item_id
    ORDER BY i.item_row, i.item_col, i.item_section
    ";
    $result = $db_connect->query($get_items);
    while($row = mysqli_fetch_array($result)){
        array_push($items, $row);
    }

    for($i = 0; $i < count($items); $i++){
        if($items[$i][1] == ''){
            $temp = array();
            $temp = $items[$i];
            unset($items[$i]);
            array_push($items, $temp);
            $temp = array();
        }
    }

    return $items;
}

function NoBidList($auction){
    include 'connect.php';
    $sql = "SELECT a.*, i.item_location, i.item_row, i.item_col, i.item_section
            FROM auctions as a
            LEFT OUTER JOIN inventory as i
            ON a.auction_id = i.auction_id AND a.item_id = i.item_number
            WHERE a.winner_id = 'No Bidder' AND a.auction_id = '$auction' AND item_id NOT LIKE '%DELETED%'
            GROUP BY a.item_id
            ORDER BY i.item_row, i.item_col, i.item_section ASC;";
    $result = $db_connect->query($sql);
    while($row = mysqli_fetch_array($result)){
        echo '<div class="no-bid-detail">';
            echo '<p>' . $row['item_desc'] . '</p>';
        echo '</div>';
    }

}

function JoinAuctionsInventory($auction){
    include 'connect.php';
    $auction_rows = array();
    $auction_data = "SELECT A.auction_id, A.item_id, A.item_desc, A.winning_bid, A.winner_id, I.item_location, I.item_row, I.item_col, I.item_section, CONCAT(A.winner_f_name, ' ', A.winner_l_name) AS bidder_name, S.storage_location
                     FROM auctions AS A
                     JOIN inventory AS I
                     ON A.auction_id = I.auction_id AND A.item_id = I.item_number
                     LEFT OUTER JOIN storage AS S
                     ON A.winner_id = S.bidder_id
                     WHERE A.auction_id = '$auction'
                     GROUP BY I.item_number
                     ORDER BY A.winner_id;";

    $result = $db_connect->query($auction_data);
    
    while($row = mysqli_fetch_array($result)){
        array_push($auction_rows, $row);
    }

    return $auction_rows;
}

function ItemQty($bidder, $auction){
    include 'connect.php';
    $sql = "SELECT count(winner_id) as item_qty
          FROM auctions
          WHERE auction_id = '$auction' AND winner_id = '$bidder'
          GROUP by winner_id";

    $result = $db_connect->query($sql);
    if($qty = mysqli_fetch_array($result)){
        return $qty['item_qty'];
    }

}

?>