<?php
$json = array();
header('Content-Type:Application/json');
header('Access-Control-Allow-Origin: *');
include_once("include/db.php");
global $con;
if (isset($_POST['id'], $_POST['prop_id'])) {
    $id = intval($_POST['id']);
    $prop_id = $_POST['prop_id'];
    $query = "select * from thermal where userid=? and prop_id=? limit 1";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "is", $id, $prop_id);
    if (mysqli_stmt_execute($stmt)) {
        //$row = array();

        if (mysqli_stmt_store_result($stmt)) {
            mysqli_stmt_bind_result(
                $stmt,
                $thermalid,
                $thermalindex,
                $thermalpoint,
                $asstcomment,
                $prop_id,
                $userid,
            );
            $count = mysqli_stmt_num_rows($stmt);
            if ($count > 0) {
                while (mysqli_stmt_fetch($stmt)) {
                    $json['thermalid'] = $thermalid;
                    $json['thermalindex'] = $thermalindex;
                    $json['thermalpoint'] = $thermalpoint;
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
