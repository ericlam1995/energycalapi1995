<?php
    $con = mysqli_connect("localhost", "root", "Bxg123", "energycaldb");

    if(mysqli_connect_errno()){
        die("Connection failed: " . $con->connect_error);
    }


?>