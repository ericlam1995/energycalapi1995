<?php
$json = array();
header('Content-Type:Application/json');
header('Access-Control-Allow-Origin: *');
include_once("include/db.php");
global $con;
if (isset($_POST['id'], $_POST['prop_id'])) {
    $id = $_POST['id'];
    $prop_id = $_POST['prop_id'];
    $query = "select * from heatsystem where userid=? and prop_id=? limit 1";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "is", $id, $prop_id);
    if (mysqli_stmt_execute($stmt)) {
        if (mysqli_stmt_store_result($stmt)) {
            mysqli_stmt_bind_result(
                $stmt,
                $heatid,
                $air_perc,
                $air_kw,
                $air_image,
                $hyd_perc,
                $hyd_kw,
                $hyd_image,
                $lpg_gas_perc,
                $lpg_gas_kw,
                $lpg_gas_image,
                $natural_gas_perc,
                $natural_gas_kw,
                $natural_gas_image,
                $wood_perc,
                $wood_kw,
                $wood_image,
                $ele_h_perc,
                $ele_h_kw,
                $ele_h_image,
                $back_boosted,
                $back_boosted_points,
                $back_boosted_image,
                $heat_points,
                $asstcomment,
                $propid,
                $userid
            );
            $count = mysqli_stmt_num_rows($stmt);
            if ($count > 0) {
                while (mysqli_stmt_fetch($stmt)) {
                    $json['heatid'] = $heatid;
                    $json['air_perc'] = $air_perc;
                    $json['air_kw'] = $air_kw;
                    $json['air_image'] = $air_image;
                    $json['hyd_perc'] = $hyd_perc;
                    $json['hyd_kw'] = $hyd_kw;
                    $json['hyd_image'] = $hyd_image;
                    $json['lpg_gas_perc'] = $lpg_gas_perc;
                    $json['lpg_gas_kw'] = $lpg_gas_kw;
                    $json['lpg_gas_image'] = $lpg_gas_image;
                    $json['natural_gas_perc'] = $natural_gas_perc;
                    $json['natural_gas_kw'] = $natural_gas_kw;
                    $json['natural_gas_image'] = $natural_gas_image;
                    $json['wood_perc'] = $wood_perc;
                    $json['wood_kw'] = $wood_kw;
                    $json['wood_image'] = $wood_image;
                    $json['ele_h_perc'] = $ele_h_perc;
                    $json['ele_h_kw'] = $ele_h_kw;
                    $json['ele_h_image'] = $ele_h_image;
                    $json['back_boosted'] = $back_boosted;
                    $json['back_boosted_points'] = $back_boosted_points;
                    $json['back_boosted_image'] = $back_boosted_image;
                    $json['heat_points'] = $heat_points;
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
    mysqli_stmt_close($stmt);
} else {
    $json['error'] = true;
    $json['message'] = "No permission to access!";
}
echo json_encode($json);
mysqli_close($con);
?>