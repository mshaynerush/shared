<?php

include('header-bar.php');
include('db-connect.php');

$productID = htmlspecialchars($_GET["id"]);

$sql = 'SELECT * FROM products WHERE product_id =' . $productID;

$result = $db_connect->query($sql);

while($row = mysqli_fetch_array($result)){
$name = $row['product_name'];
$desc = $row['product_desc'];
$price = $row['product_price'];
$color = $row['product_color'];
echo "<div class='data-row'>";
echo $name;
echo "<br>";
echo $desc;
echo "<br>";
echo "$ " . $price;
echo "<br>";
echo $color;
echo "</div>";
}

?>