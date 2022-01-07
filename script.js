// Create array to hold form fields


// Add row to item list to upload
$('#ajax_form').submit(function(evt){
    evt.preventDefault();
    let itemId = $('#itemID').val();
    let itemLoc = $('#itemLoc').val();
    $('#itemToUpload').append("<div class='item-row'><span class='item-number-to-upload'>" +
     itemId + "</span><span class='item-loc-to-upload'>" + itemLoc +
      "</span><span class='close-btn' >&times;</span></div>"); 
})


$(document).on('click','.close-btn',function() {
    $(this).closest("div").remove();
});

$('#formUpload').click(function(){
    var formArray = [];
    let auction = $("#auctionID").val();
    let items = $(".item-number-to-upload");
    let loc = $(".item-loc-to-upload");
    for(var i = 0; i < items.length; i++){
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data:{
                itemNum: items[i].textContent,
                itemLoc: loc[i].textContent,
                auctionId: auction
            },
            success: function(response){
                console.log(response);
            }
        });
    }

})



