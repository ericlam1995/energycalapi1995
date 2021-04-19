<?php
    $json = array();
    header('Content-Type:Application/json');
    header('Access-Control-Allow-Origin: *');
    include_once("include/db.php");
    global $con;
    if(isset($_POST['thermalindex'], $_POST['thermalpoint'], $_POST['prop_id']
    ,$_POST['userid'])){
        $thermalindex = trim($_POST['thermalindex']);
        $thermalpoint = intval($_POST['thermalpoint']);
        $asstcomment = "";
        if(empty($_POST['asstcomment'])){
            $asstcomment = "";
        }else{
            $asstcomment = $_POST['asstcomment'];
        }
        $prop_id = trim($_POST['prop_id']);
        $userid = intval($_POST['userid']);

        $insertquery = "insert into thermal (thermalindex, thermalpoint, asstcomment, prop_id, userid) 
        values (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $insertquery);
        mysqli_stmt_bind_param($stmt,"sissi", $thermalindex, $thermalpoint, $asstcomment, $prop_id, $userid);
        $result = mysqli_stmt_execute($stmt);
        if($result){
            $json['error'] = false;
            $json['message'] = "Inserted thermal Successfully!";
        }else{
            $json['error'] = true;
            $json['message'] = "Inserted thermal failed! ". mysqli_error($con);
        }
        mysqli_stmt_close($stmt);
    }else{
        $json['error'] = true;
        $json['message'] = "No permission to access!";
    }
    echo json_encode($json);
    mysqli_close($con);
?>