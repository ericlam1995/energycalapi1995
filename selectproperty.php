<?php
$json = array();
header('Content-Type:Application/json');
header('Access-Control-Allow-Origin: *');
include_once("include/db.php");
global $con;
if (isset($_POST['id'], $_POST['prop_id'])) {
    $id = $_POST['id'];
    $prop_id = $_POST['prop_id'];
    $query = "select * from property where userid=? and prop_id=? limit 1";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "is", $id, $prop_id);
    if (mysqli_stmt_execute($stmt)) {

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
        if (mysqli_stmt_store_result($stmt)) {
            $count = mysqli_stmt_num_rows($stmt);
            if ($count > 0) {
                while (mysqli_stmt_fetch($stmt)) {
                    $json['prop_id'] = $prop_id;
                    $json['dwell_type'] = $dwell_type;
                    $json['dwell_size'] = $dwell_size;
                    $json['room_no'] = $room_no;
                    $json['climate_location'] = $climate_location;
                    $json['legal_desc'] = $legal_desc;
                    $json['cert_title'] = $cert_title;
                    $json['address'] = $address;
                    $json['asstcomment'] = $asstcomment;
                    $json['userid'] = $userid;
                }
            } else {
                $json['error'] = true;
                $json['message'] = "Not found!";
            }
        }
    } else {
        $json['error'] = true;
        $json['message'] = "Error: " . mysqli_error($con);
    }
    //$result = mysqli_query($con, $query);
} else {
    $json['error'] = true;
    $json['message'] = "No permission to access!";
}
echo json_encode($json);
mysqli_close($con);
