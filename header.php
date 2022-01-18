<?php
session_start();

$page =  basename($_SERVER['PHP_SELF']);

    if($_SESSION['logged_in'] != 'True'){
        if($page != 'login.php'){
            header("Location: login.php");
        }
    }
?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="script.js" defer></script>
    <script src="onscan.min.js" defer></script>
    <link href="style.css?=v1" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128+Text&display=swap" rel="stylesheet"> 

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39&display=swap" rel="stylesheet"> 
    <title>Equip-Bid Pick List Generator</title>
</head>

<body>



<div class="header"></div>
    <nav class="navbar navbar-dark" style="background-color: hsl(127, 51%, 47%);">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler">
            <!-- <span class="navbar-toggler-icon"></span> -->
            <span class="bar"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="eb-ul">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Upload CSV Files</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add-inventory.php">Enter Inventory</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add-storage.php">Enter Storage Agreement</a>
                </li>
                <li>
                    <a class="nav-link" href="reports.php">Pick Lists and Reports</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pick-items.php">Scan Picked Items</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="window.print()" href="#">Print</a>
                </li>
            </ul>
        </div>
    </nav>

