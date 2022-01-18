

path = window.location.pathname
page = path.split("/").pop();

if (page == "index.php") {
    let fileNameAuc = document.getElementById('fileUploadAuction')
    let fNameHoldAuc = document.getElementById('fileNameAuction')
    fileNameAuc.addEventListener('change', () => {   
        fNameHoldAuc.innerHTML = fileNameAuc.files[0].name
        fNameHoldAuc.classList.toggle('hidden')
    })
}

if (page == 'reports.php') {
    let maxItems = document.getElementById('maxItems');
    let groupedBtn = document.getElementById('groupList');
    maxItems.addEventListener('change', () => {
        groupedBtn.value = "Grouped Items List (Max " + maxItems.value + " items)"
    })
}


if (page == 'add-inventory.php') {
    
    // Create array to hold form fields


    // Add row to item list to upload
    $('#ajax_form').submit(function (evt) {
        evt.preventDefault();
        let itemId = $('#itemID').val();
        let itemLoc = $('#itemLoc').val();
    
        $('#itemToUpload').append("<div class='item-row'><span class='item-row-detail'>" +
            itemId + "</span><span class='item-row-detail'>" + itemLoc +
            "</span><span class='close-btn'>&times;</span></div>");
        $('#itemID').val("");
    })
 

    $(document).on('click', '.close-btn', function () {
        $(this).closest("div").remove();
    });

    $('#formUpload').click(function () {

        let formArray = {}; // Create empty object
        // Create a time stamp based on current time
        let dt = new Date();
        let y = dt.getFullYear();
        let monthNow = dt.getMonth() + 1;
        let dayNow = dt.getDate();
        let hoursNow = dt.getHours();
        let minsNow = dt.getMinutes();
        let secsNow = dt.getSeconds();
        mo = monthNow > 0 ? (monthNow < 10 ? "0" + monthNow : monthNow) : "00";
        d = dayNow > 0 ? (dayNow < 10 ? "0" + dayNow : dayNow) : "00";
        h = hoursNow > 0 ? (hoursNow < 10 ? "0" + hoursNow : hoursNow) : "00";
        mi = minsNow > 0 ? (minsNow < 10 ? "0" + minsNow : minsNow) : "00";
        s = secsNow > 0 ? (secsNow < 10 ? "0" + secsNow : secsNow) : "00";
        let timeIn = y + '-' + mo + '-' + d + ' ' + h + ':' + mi + ':' + s;

        // Get auction ID from form
        let auction_id = $("#auctionID").val();

        // Make Array of items to uplaode itemNumber = itemLocation
        items = $('.item-row-detail');
        for (var i = 0; i < items.length; i += 2) {
            itemNum = items[i].textContent.toString();
            itemLoc = items[i + 1].textContent.toString();
            formArray[itemNum] = itemLoc;
        }
        
        // Send all items to inventory upload script
        $.ajax({
            type: "POST",
            url: "upload-inventory.php",
            data: {
                items: formArray,
                auction: auction_id,
                timeIn: timeIn
            },
            success: function (response) {
                if (response == 'success') {
                    $('.item-row-detail').remove();
                    $('.close-btn').remove()
                    $('#upload-success').html("<h3>Upload Successful</h3>")
                }
            }
        });
    })
}

if (page == 'add-storage.php') {
    
    let fileNameLts = document.getElementById('fileUploadLts');
    let fNameHoldLts = document.getElementById('fileNameLts');
    fileNameLts.addEventListener('change', () => {
        fNameHoldLts.innerHTML = fileNameLts.files[0].name;
        fNameHoldLts.classList.toggle('hidden');
    })
}

  
if (page == 'login.php') {

    $('#loginForm').submit(function(e) {
        e.preventDefault();
        let userName = $('#userName').val();
        let pword = $('#password').val();
        $.ajax({
            type: "POST",
            url: "check-login.php",
            data:
            {
                user: userName,
                pw: pword
            },
            success: function (response) {
                console.log(response);
                if (response == 'fail') {
                    $('#userName').css("border", "1px solid red");
                } else if (response == 'success') {

                    window.location.href = "index.php";
                }
            }
        })
    })
}

