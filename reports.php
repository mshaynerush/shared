
<?php

include 'header.php';

?>

<div class="contetn">
    <div class="centered">
        <h2>Choose List</h2>
        <br>
        <form method="POST" action='run-reports.php' enctype="multipart/form-data">

                <!-- Create Auction Data upload field -->
                <button name="pick-list" id="pickList" type="submit" class="btn btn-success">Pick List Generator</button>

                <br>
                <br>
                <br>
                <br>

                <button name="no-bid-list" id="noBidList" type="submit" class="btn btn-success">No Bid Description Sheet</button>

                <br>
                <br>
                <br>
                <br>

                <div class="max-item-report">
                    <label for="max-item">Max items</label>
                    <input type="text" name="max-item" id="maxItems">
                </div>
                <br>
                <br>
                <div class="max-item-report">
                    <input name="grouped-list" id="groupList" type="submit" class="btn btn-success" value="Group Picked List">
                </div>

        </form>
    </div>
</div>