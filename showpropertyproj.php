<?php

header('Content-Type:Application/json');
header('Access-Control-Allow-Origin: *');
include_once("include/db.php");
$json = array();

global $con;
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $query = "select * from property where userid=?";
    //Retrieving the contents of the table
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    //Executing the statement

    if (mysqli_stmt_execute($stmt)) {

        //$res = mysqli_stmt_get_result($stmt);
        $propertyarray = array();


        if (mysqli_stmt_store_result($stmt)) {
            mysqli_stmt_bind_result(
                $stmt,
                $prop_id,
                $dwell_type,
                $dwell_size,
                $room_no,
                $climate_location,
                $legal_desc,
                $cert_title,
                $address,
                $asstcomment,
                $userid
            );
            $count = mysqli_stmt_num_rows($stmt);
            if ($count > 0) {

                while (mysqli_stmt_fetch($stmt)) {
                    $row = array();
                    $row['prop_id'] = $prop_id;
                    $row['dwell_type'] = $dwell_type;
                    $row['dwell_size'] = $dwell_size;
                    $row['room_no'] = $room_no;
                    $row['climate_location'] = $climate_location;
                    $row['legal_desc'] = $legal_desc;
                    $row['cert_title'] = $cert_title;
                    $row['address'] = $address;
                    $row['asstcomment'] = $asstcomment;
                    $row['userid'] = $userid;
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
} else {
    $json['error'] = true;
    $json['message'] = "No permission to access!";
}


echo json_encode($json);
mysqli_close($con);
