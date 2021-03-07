<?php
    $json = array();
    header('Content-Type:Application/json');
    header('Access-Control-Allow-Origin: *');
    include_once("include/db.php");
    global $con;
    if(isset($_POST['prop_id'], $_POST['dwell_type'],$_POST['dwell_size'],$_POST['room_no']
    ,$_POST['climate_location'],$_POST['legal_desc'], $_POST['cert_title'], $_POST['address'], 
    $_POST['asstcomment'], $_POST['userid'])){
        
        $prop_id = trim($_POST['prop_id']);
        $dwell_type = trim($_POST['dwell_type']);
        $dwell_size = trim($_POST['dwell_size']);
        $room_no = intval($_POST['room_no']);
        $climate_location = trim($_POST['climate_location']);
        $legal_desc = trim($_POST['legal_desc']);
        $cert_title = trim($_POST['cert_title']);
        $address = trim($_POST['address']);
        $asstcomment = $_POST['asstcomment'];
        $userid = intval($_POST['userid']);

        $updatequery = "update property set dwell_type=?, dwell_size=?, 
        room_no=?, climate_location=?, legal_desc=?,
        cert_title=?, address=?, asstcomment=? where prop_id=? and userid=?";
        $stmt = mysqli_prepare($con, $updatequery);
        mysqli_stmt_bind_param($stmt, "ssissssssi", $dwell_type, $dwell_size, $room_no, $climate_location, 
        $legal_desc, $cert_title, $address,$asstcomment,$prop_id, $userid);
        $result = mysqli_stmt_execute($stmt);
        if($result){
            $json['error'] = false;
            $json['message'] = "Updated property Successfully!";
        }else{
            $json['error'] = true;
            $json['message'] = "Updated property failed! ". mysqli_error($con);
        }

    }else{

        $json['error'] = true;
        $json['message'] = "No permission to access!";

    }

    echo json_encode($json);
    mysqli_close($con);


    function ifpropertyexist(){
        
    }

    function ifpropertyadded(){
        
    }
?>