<?php

header('Content-Type:Application/json');
header('Access-Control-Allow-Origin: *');
include_once("include/db.php");
$json = array();

global $con;

$query = "select * from property";
//Retrieving the contents of the table
$stmt = mysqli_prepare($con, $query);
//Executing the statement

if (mysqli_stmt_execute($stmt)) {

    //$res = mysqli_stmt_get_result($stmt);
    $propertyarray = array();
    $row = array();
    mysqli_stmt_bind_result(
        $stmt,
        $row['prop_id'],
        $row['dwell_type'],
        $row['dwell_size'],
        $row['room_no'],
        $row['climate_location'],
        $row['legal_desc'],
        $row['cert_title'],
        $row['address'],
        $row['asstcomment'],
        $row['userid']
    );
    if (mysqli_stmt_store_result($stmt)) {
        $count = mysqli_stmt_num_rows($stmt);
        if ($count > 0) {
            //$result = mysqli_stmt_fetch($stmt);
            while (mysqli_stmt_fetch($stmt)) {
                $propertyarray[] = $row;
            }
            $json['projects'] = $propertyarray;
        } else {
            $json['error'] = true;
            $json['message'] = "Not found!";
        }
    }

    mysqli_stmt_free_result($stmt);
} else {
    $json['error'] = true;
    $json['message'] = "Error: " . mysqli_error($con);
}



echo json_encode($json);
mysqli_close($con);
