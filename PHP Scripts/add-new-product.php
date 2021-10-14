<?php

$prodName = $_POST['product-name'];
$prodDesc = $_POST['product-desc'];
$prodPrice = $_POST['product-price'];
$prodImg = $_FILES['product-image']['name'];
$prodColor = $_POST['guitar-color'];
$prodType = $_POST['product-type'];


include('db-connect.php');

if ($db_connect->connect_error) {
    die("Connection failed: " 
        . $db_connect->connect_error);
}

$sql = "INSERT INTO products VALUES(DEFAULT,'$prodName', '$prodType', '$prodDesc', $prodPrice, '$prodColor', '$prodImg')";
if($db_connect->query($sql) === TRUE){
    echo "Record added successfully";
    echo '<br><a href="all-products.php">View All Products</a>';
} else {
    echo "An error occured";

}

$img_dir = 'product-images/';
$upload_img = $_FILES['product-image']['name'];
$upload_tmp_img = $_FILES['product-image']['tmp_name'];
move_uploaded_file($upload_tmp_img, $img_dir . $upload_img);
?>