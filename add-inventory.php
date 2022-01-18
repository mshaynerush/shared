<?php

include 'header.php';
?>

<div class="content">
    <div class="centered">
        <h2>Add Inventory</h2>
        <div class="form-center">
        <form id="ajax_form" enctype="multipart/form-data">
            <label for="auction-id">Auction ID</label><br>
            <input type="text" name="auction-id" id="auctionID" class="user-input"><br><br>
            <label for="item-loc">Item Location:</label><br>
            <input type="text" name="item-loc" id="itemLoc" class="user-input"><br><br>
            <label for="item-id">Item Number</label><br>
            <input type="text" name="item-id" id="itemID" class="user-input"><br><br>
            <button type="submit" class="item-submit hidden" id="itemSubmit">Submit</button>
            <div id="upload-success"></div> 
        </form>
        </div>
        <div class="item-to-upload" id="itemToUpload">
            <div class="item-row">
                <span class="item-to-load-header">Item Number</span>
                <span class="item-to-load-header">Item Location</span>
            </div>
        </div>
        <br>
        <button class="btn btn-success upload-button" id="formUpload">Upload</button>

     <!-- <div class="form-center">
        <form method = "POST" action="upload-inventory.php" enctype='multipart/form-data'>
            <h4>Or upload inventory from CSV file</h4>
            <label for="file-upload-inventory">Upload Inventory CSV</label>
            <br>
            <input name="file-upload-inventory" id="fileUploadInventory" type="file" accept="csv">
            <br>
            <div name="fileNameInventory" id="fileNameInventory" class="hidden fileNameHolder"></div>
            <br>
            <br>
            <!-- Create csv upload buttons for picklist generator
            <input name="submit" type="submit" class="btn btn-success" id="btnUpload" value="Upload">   
        </form>
    </div>  -->
    </div>
</div>
<script>
// Get the field that triggers the barcode handler
// let scanName = document.getElementById('scanItemNumber');
// var interval;
// var barcode = '';


//     scanName.addEventListener('keydown', function(evt){ // Check the key down event
//         evt.preventDefault();

//         if(evt.code == 'Enter'){
//             handleBarcode();
//             scanName.value = ''
//         } 
//     })

    // function handleBarcode(barcode){
    //     var item = ''
    //     var auction = ''
    //     var locaation = ''
    //     var timeIn = ''
        
    //     $('#scanItemNumber').html = barcode;
    //     let dt = new Date();
    //         let y = dt.getFullYear();
    //         let monthNow = dt.getMonth() + 1;
    //         let dayNow =  dt.getDate();
    //         let hoursNow = dt.getHours();
    //         let minsNow = dt.getMinutes();
    //         let secsNow = dt.getSeconds();
    //         let scanAuction = document.getElementById('scanAuctionNumber').value;
    //         let scanLoc = document.getElementById('scanItemLoc').value;

            
    //         mo = monthNow > 0 ? (monthNow < 10 ? "0" + monthNow : monthNow) : "00";
    //         d = dayNow > 0 ? (dayNow < 10 ? "0" + dayNow : dayNow) : "00";
    //         h = hoursNow > 0 ? (hoursNow < 10 ? "0" + hoursNow : hoursNow) : "00";
    //         mi = minsNow > 0 ? (minsNow < 10 ? "0" + minsNow : minsNow) : "00";
    //         s = secsNow > 0 ? (secsNow < 10 ? "0" + secsNow : secsNow) : "00";

    //         let thisDateNow = y + '-' + mo + '-' + d + ' ' + h + ':' + mi + ':' + s
    //         console.log(thisDateNow)


/* Add each scanned element to the table as scanned, allowing removal for any dupes or incorrect values */

// Create array to hold form fields


// function handleBarcode(){
//     $('#uploadScanForm').submit(function(evt){
//         evt.preventDefault();
//         let itemId = $('#scanItemNumber').val();
//         let itemLoc = $('#scanItemLoc').val();
//         $('#scanUploadItems').append("<div class='item-row'><span class='item-number-to-upload'>" +
//         itemId + "</span><span class='item-loc-to-upload'>" + itemLoc +
//         "</span><span class='close-btn' >&times;</span></div>"); 
//     })


//     $(document).on('click','.close-btn',function() {
//         $(this).closest("div").remove();
//     });

//     $('#formUpload').click(function(){
//         var formArray = [];
//         let auction = $("#scanAuctionNumber").val();
//         let items = $(".item-number-to-upload");
//         let loc = $(".item-loc-to-upload");
//         for(var i = 0; i < items.length; i++){
//             $.ajax({
//                 type: "POST",
//                 url: "ajax.php",
//                 data:{
//                     itemNum: items[i].textContent,
//                     itemLoc: loc[i].textContent,
//                     auctionId: auction
//                 },
//                 success: function(response){
//                     console.log(response);
//                 }
//             });
//         }

// })
// }
// OLD upload handling process to do each item as they are uplaoded
/*
        $('#scanItemNumber').text = '';
            
        $.ajax({
                type: 'POST',
                url: 'upload-single-item.php',
                data: {
                    item: barcode, 
                    auction: scanAuction,
                    location: scanLoc,
                    timeIn: thisDateNow
                    },
                    success: function(response){
                        
                        if(response == 'success'){
                            $('#InventoryItem').html('<div class="centered">Item number ' + barcode + ' successfully added to inventory</div>')
                            $('#scanItemNumber').html = '';
                        } else if(response == 'exists'){
                            $('#InventoryItem').html('Item number ' + barcode + ' is already in the database in auction #' + scanAuction)
                        } else if(response == 'error'){
                            $('#InventoryItem').html('There was a connection error. Try again.')
                        }
                    }
        });
        
    }
*/
</script>
