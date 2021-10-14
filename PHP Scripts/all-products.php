<?php

include('header-bar.php');
include('db-connect.php');

$sql = "SELECT * FROM products";

$result = $db_connect->query($sql);


while($row = mysqli_fetch_array($result)){
    $id = $row['product_id'];
    $name = $row['product_name'];
    $desc = $row['product_desc'];
    $price = $row['product_price'];
    $color = $row['product_color'];
    $type = $row['product_type'];
    $link = '<a href="product-detail.php?id=' . $id . '">' . $name . '</a>';

    echo "<div class='data-row'>";
    echo 'Product ID: ' . $id . '<br>Product Name: '. $link . '<br>Product Description: ' . $desc . '<br>Product Price: $' . $price;
    echo "</div>";
    
}

?>