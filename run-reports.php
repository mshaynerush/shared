<?php
session_start();
$auction = $_SESSION['auctionID'];
$auction_rows = array();
$join_auctions_inventory = array();
include 'header.php';
include 'functions.php';
include 'connect.php';


    $bidder_list = GetPickListOrder($auction);
    if(isset($_POST['pick-list'])){
    
        echo '<div class="content">'; // Begins content div
        
        foreach($bidder_list as $b){ // Each uniqe bidder
            $items = GetSingleBidderItems($b['winner_id'], $auction);
            echo '<div class="centered">'; // Begins centered div;
            echo '<div class="content-print-wrapper">';
            echo '<h3>Bidder Name: ' . $b['bidder_name'] . '</h3>';
            echo '<h3>Item Qty - ' . $b['item_qty'] . '</h3>';
            
            if(($b['storage_location'] != '0') && ($b['storage_location'] != '') && ($b['storage_location'] != NULL)){
                echo '<h3>Storage Location: ' . $b['storage_location'] . '</h3>';
            }
            echo '<div class="item-details">';
                echo '<span class="item-detail-header">Num</span><span class="item-detail-header">Loc</span>';
                echo '<span class="item-detail-header">Desc</span><span class="item-detail-header">Price</span>';
                foreach($items as $i){
                    echo '<span class="item-detail">' . $i['item_id'] . '</span><span class="item-detail">' . $i['item_location'] . '</span>';
                    echo '<span class="item-detail-desc">' . $i['item_desc'] . '</span><span class="item-detail"> $ ' . $i['winning_bid'] . '</span>';
                }
            echo '</div>'; // Ends Item Details div
            echo '<h1 class="bidder-name">Bidder #: ' . $b['winner_id'] . '</h1>';
            echo '<div class="barcode">*' . $b['winner_id'] . '-' . $auction . '*</div>';
            echo '<div class="barcode-not-coded">' . $b['winner_id'] . '-' . $auction . '</div>';
            echo '</div>';
            echo '</div>'; // Ends centered div;
        }
        PrtNoBidList($auction, $db_connect);
        echo '</div>'; // Ends content div;
    }

    function PrtNoBidList($auction, $db_connect){
        $no_bid_count = "SELECT COUNT(winner_id) as qty 
        FROM auctions 
        WHERE winner_id = 'No Bidder' AND auction_id = '$auction' AND item_id NOT LIKE '%DELETED%'
        GROUP BY auction_id";
        $result = $db_connect->query($no_bid_count);
        $item_qty = mysqli_fetch_array($result);

        echo '<div class="centered">';
        echo '<h1>Pallet Bid Lot</h1><br><br>';
        echo '<h2>Total Items - ' . $item_qty['qty'] . '<br><br>';
        echo 'Items are sold in as-is condition. Items are sold as a bulk lot for one bid</h2><br><br>';
        echo '<p>';
            NoBidList($auction);
        echo '</p>';
        echo '</div>';

    }

    if(isset($_POST['grouped-list'])){
       
        $max_item = $_POST['max-item']; // Get max rows from user
        $item_count = 0; // Set item count;
        $bidder = array(); // set empty array to hold bidder ids

        while(!empty($bidder_list)){
            $curr_bidder_row = array_shift($bidder_list);
            $item_count += $curr_bidder_row['item_qty'];
            if($item_count <= $max_item){
                array_push($bidder, $curr_bidder_row['winner_id']);
            } elseif(($item_count > $max_item) && (COUNT($bidder) == 0)){
                array_push($bidder, $curr_bidder_row['winner_id']);
                PrintGrp($bidder, $auction);
                $item_count = 0;
                $bidder = array();
            } else {
                $item_count = 0;
                PrintGrp($bidder, $auction);
                $bidder = array();
            }
        }

    }
?>