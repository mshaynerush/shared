<?php
session_start();
include 'header.php';


?>

<div class="content">
    <div class="centered">
        <div class="form-center">

            <form id="loginForm" method="POST" enctype="multipart/form-data">

                <label for="user-name">User Name</label><br>
                <input type="text" name="user-name" id="userName" class="form-control"><br><br>

                <label for="password">Password</label><br>
                <input type="password" name="password" id="password" class="form-control"><br><br>

                <input type="submit" name="submit" id="submit" value="Login" class="btn btn-success">
                <input type="reset" value="Reset" class="btn btn-success">
                
            </form>

        </div>
    </div>
</div>