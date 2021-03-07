<?php
    $json = array();
    header('Content-Type:Application/json');
    header('Access-Control-Allow-Origin: *');
    include_once("include/db.php");
    global $con;

    if(isset($_POST['wateruseid'],$_POST['kitchen_tap'], $_POST['kitchen_tap_points'],$_POST['basin_tap']
    ,$_POST['basin_tap_points'], $_POST['shower'], $_POST['shower_points']
    ,$_POST['rates_inspect'], $_POST['worst_wc'],$_POST['worst_wc_points'],$_POST['doc_by_inspect']
    ,$_POST['total_points'],$_POST['asstcomment'], $_POST['prop_id']
    ,$_POST['userid'])){
        $wateruseid = intval($_POST['wateruseid']);
        $kitchen_tap = floatval($_POST['kitchen_tap']);
        $kitchen_tap_points = floatval($_POST['kitchen_tap_points']);
        $kitchen_tap_img = null;
        if(isset($_FILES['kitchen_tap_img'])){
            if(is_uploaded_file($_FILES['kitchen_tap_img']['tmp_name'])){
                $kitchen_tap_img = base64_encode(file_get_contents(addslashes($_FILES['kitchen_tap_img']['tmp_name'])));
            }
        }
        else{
            $kitchen_tap_img = null;
        }
        

        $basin_tap = floatval($_POST['basin_tap']);
        $basin_tap_points = floatval($_POST['basin_tap_points']);
        $basin_tap_img = null;
        if(isset($_FILES['basin_tap_img'])){
            if(is_uploaded_file($_FILES['basin_tap_img']['tmp_name'])){
                $basin_tap_img = base64_encode(file_get_contents(addslashes($_FILES['basin_tap_img']['tmp_name'])));
            }
        }
        else{
            $basin_tap_img = null;
        }
        

        $shower = floatval($_POST['shower']);
        $shower_points = floatval($_POST['shower_points']);
        $shower_img = null;
        if(isset($_FILES['shower_img'])){
            if(is_uploaded_file($_FILES['shower_img']['tmp_name'])){    
                $shower_img = base64_encode(file_get_contents(addslashes($_FILES['shower_img']['tmp_name'])));
            }
        }
        else{
            $shower_img = null;
        }
        
        $rates_inspect = trim($_POST['rates_inspect']);
        $worst_wc = trim($_POST['worst_wc']);
        $worst_wc_points = floatval($_POST['worst_wc_points']);
        $doc_by_inspect = trim($_POST['doc_by_inspect']);
        $total_points = floatval($_POST['total_points']);
        $asstcomment = $_POST['asstcomment'];
        $prop_id = trim($_POST['prop_id']);
        $userid = intval($_POST['userid']);
        
        $updatequery = "update wateruse set kitchen_tap=?,kitchen_tap_points=?,kitchen_tap_img=?,
        basin_tap=?,basin_tap_points=?,basin_tap_img=?,shower=?,shower_points=?,
        shower_img=?,rates_inspect=?,worst_wc=?,worst_wc_points=?,doc_by_inspect=?
        , total_points=?, asstcomment=? where prop_id=? and userid=? and wateruseid=?";
        $stmt = mysqli_prepare($con, $updatequery);
        mysqli_stmt_bind_param($stmt,"ddbddbddbssdsdssii", $kitchen_tap, $kitchen_tap_points, $kitchen_tap_img, $basin_tap,
        $basin_tap_points, $basin_tap_img, $shower,$shower_points, $shower_img, $rates_inspect,
        $worst_wc, $worst_wc_points, $doc_by_inspect,$total_points, $asstcomment, $prop_id, $userid, $wateruseid);
        mysqli_stmt_send_long_data($stmt, 2, $kitchen_tap_img);
        mysqli_stmt_send_long_data($stmt, 5, $basin_tap_img);
        mysqli_stmt_send_long_data($stmt, 8, $shower_img);
        $result = mysqli_stmt_execute($stmt);
        if($result){
            $json['error'] = false;
            $json['message'] = "Updated wateruse Successfully!";
        }else{
            $json['error'] = true;
            $json['message'] = "Updated wateruse failed! ". mysqli_error($con);
        }

    }
    else{

        $json['error'] = true;
        $json['message'] = "No permission to access!";

    }
    echo json_encode($json);
    mysqli_close($con);

    function ifwaterexist(){
        
    }

    function ifwateradded(){
        
    }
?>