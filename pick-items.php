<?php
include 'header.php';
?>

<div class="content">
    <div class="centered">
        <div class="form-center">
            <form id="uploadScanForm">
                <label for ="scan-picked-item">Scan Picked Item:</label>
                <br>
                <input name="scan-picked-item" id="scanPickedItem" type="text" class="form-control middle">
                <br>
                <input name="submit" class="btn btn-success hidden" type="submit">
            </form>
        </div>
            <div class="scan-picked-items" id="displayPickedItems">
                <div class="inventory-item" id="InventoryItem"></div>
            </div>
        </div>
    </div>
</div>


<!-- javascript to remove pick item from inventory by time stamp out -->

<script>
            let dt = new Date();
            let y = dt.getFullYear();
            let monthNow = dt.getMonth() + 1;
            let dayNow =  dt.getDate();
            let hoursNow = dt.getHours();
            let minsNow = dt.getMinutes();
            let secsNow = dt.getSeconds();

            // Get auction and item number from barcode 
            
    
    $('#uploadScanForm').submit(function(evt){
    evt.preventDefault();
    let scanName = document.getElementById('scanPickedItem');
    let itemScanned = scanPickedItem.value;
    let dashIndex = itemScanned.indexOf('-')
    let bidder = itemScanned.substring(0, dashIndex)
    let auctionId = itemScanned.substring(dashIndex + 1, itemScanned.length)
    
        mo = monthNow > 0 ? (monthNow < 10 ? "0" + monthNow : monthNow) : "00";
        d = dayNow > 0 ? (dayNow < 10 ? "0" + dayNow : dayNow) : "00";
        h = hoursNow > 0 ? (hoursNow < 10 ? "0" + hoursNow : hoursNow) : "00";
        mi = minsNow > 0 ? (minsNow < 10 ? "0" + minsNow : minsNow) : "00";
        s = secsNow > 0 ? (secsNow < 10 ? "0" + secsNow : secsNow) : "00";
        let thisDateNow = y + '-' + mo + '-' + d + ' ' + h + ':' + mi + ':' + s
        handleBarcode(bidder, auctionId, thisDateNow)
    
})

function handleBarcode(bidder, auctionId, timeOut){
        $.ajax({
                type: 'POST',
                url: 'pick-item-scanned.php',
                data: {
                    bidder: bidder, 
                    auction: auctionId,
                    timeOut: timeOut
                    },
                    success: function(response){
                        if(response){
                            $('#InventoryItem').html(response);
                        }
                        // if(response == 'success'){
                        //     $('#InventoryItem').html('Item number ' + bidder + " successfully added to inventory")
                        // } else if(response == 'failure'){
                        //     $('#InventoryItem').html('Item number ' + bidder + " is already in the database in auction #" + auctionId)
                        // } else if(response == 'error'){
                        //     $('#InventoryItem').html('There was a connection error. Try again.')
                        // }
                    }
        });
    }

</script>