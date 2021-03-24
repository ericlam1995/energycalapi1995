<?php
$json = array();
header('Content-Type:Application/json');
header('Access-Control-Allow-Origin: *');
include_once("include/db.php");
global $con;
if (isset($_POST['id'], $_POST['prop_id'])) {
    $id = $_POST['id'];
    $prop_id = $_POST['prop_id'];
    $query = "select * from daylightlighting where userid=? and prop_id=? limit 1";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "is", $id, $prop_id);
    if (mysqli_stmt_execute($stmt)) {

        if (mysqli_stmt_store_result($stmt)) {
            mysqli_stmt_bind_result(
                $stmt,
                $daylightid,
                $lux_meter,
                $no_led,
                $no_led_img,
                $no_fluo,
                $no_fluo_img,
                $no_halog,
                $no_halog_img,
                $total_in_watt,
                $total_in_watt_img,
                $total_in_light,
                $total_out_watt,
                $total_out_watt_img,
                $watt_sensor,
                $watt_sensor_img,
                $total_out_light,
                $light_inspect,
                $light_points,
                $asstcomment,
                $propid,
                $userid
            );
            $count = mysqli_stmt_num_rows($stmt);
            if ($count > 0) {
                while (mysqli_stmt_fetch($stmt)) {
                    $json['daylightid'] = $daylightid;
                    $json['lux_meter'] = $lux_meter;
                    $json['no_led'] = $no_led;
                    $json['no_led_img'] = $no_led_img;
                    $json['no_fluo'] = $no_fluo;
                    $json['no_fluo_img'] = $no_fluo_img;
                    $json['no_halog'] = $no_halog;
                    $json['no_halog_img'] = $no_halog_img;
                    $json['total_in_watt'] = $total_in_watt;
                    $json['total_in_watt_img'] = $total_in_watt_img;
                    $json['total_in_light'] = $total_in_light;
                    $json['total_out_watt'] = $total_out_watt;
                    $json['total_out_watt_img'] = $total_out_watt_img;
                    $json['watt_sensor'] = $watt_sensor;
                    $json['watt_sensor_img'] = $watt_sensor_img;
                    $json['total_out_light'] = $total_out_light;
                    $json['light_inspect'] = $light_inspect;
                    $json['light_points'] = $light_points;
                    $json['asstcomment'] = $asstcomment;
                    $json['prop_id'] = $propid;
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
?>