<?php
$json = array();
header('Content-Type:Application/json');
header('Access-Control-Allow-Origin: *');
include_once("include/db.php");
global $con;
if (isset($_POST['id'], $_POST['prop_id'])) {
    $id = $_POST['id'];
    $prop_id = $_POST['prop_id'];
    $query = "select * from wateruse where userid=? and prop_id=? limit 1";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "is", $id, $prop_id);
    if (mysqli_stmt_execute($stmt)) {
        $row = array();
        mysqli_stmt_bind_result(
            $stmt,
            $wateruseid,
            $kitchen_tap,
            $kitchen_tap_points,
            $kitchen_tap_img,
            $basin_tap,
            $basin_tap_points,
            $basin_tap_img,
            $shower,
            $shower_points,
            $shower_img,
            $rates_inspect,
            $worst_wc,
            $worst_wc_points,
            $doc_by_inspect,
            $total_points,
            $asstcomment,
            $prop_id,
            $userid
        );
        if (mysqli_stmt_store_result($stmt)) {
            $count = mysqli_stmt_num_rows($stmt);
            if ($count > 0) {
                while (mysqli_stmt_fetch($stmt)) {
                    $json['wateruseid'] = $wateruseid;
                    $json['kitchen_tap'] = $kitchen_tap;
                    $json['kitchen_tap_points'] = $kitchen_tap_points;
                    $json['kitchen_tap_img'] = $kitchen_tap_img;
                    $json['basin_tap'] = $basin_tap;
                    $json['basin_tap_points'] = $basin_tap_points;
                    $json['basin_tap_img'] = $basin_tap_img;
                    $json['shower'] = $shower;
                    $json['shower_points'] = $shower_points;
                    $json['shower_img'] = $shower_img;
                    $json['rates_inspect'] = $rates_inspect;
                    $json['worst_wc'] = $worst_wc;
                    $json['worst_wc_points'] = $worst_wc_points;
                    $json['doc_by_inspect'] = $doc_by_inspect;
                    $json['total_points'] = $total_points;
                    $json['asstcomment'] = $asstcomment;
                    $json['prop_id'] = $prop_id;
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
} else {
    $json['error'] = true;
    $json['message'] = "No permission to access!";
}
echo json_encode($json);
mysqli_close($con);
