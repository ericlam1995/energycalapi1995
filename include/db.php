<?php
    $con = mysqli_connect("localhost", "root", "mentalomega1", "energycaldb");

    if(mysqli_connect_errno()){
        die("Connection failed: " . $con->connect_error);
    }


?>