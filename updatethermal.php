<?php
    $json = array();
    header('Content-Type:Application/json');
    header('Access-Control-Allow-Origin: *');
    include_once("include/db.php");
    global $con;

    if(isset($_POST['thermalid'],$_POST['thermalindex'], $_POST['thermalpoint'], $_POST['prop_id']
    ,$_POST['userid'])){

        $thermalid = $_POST['thermalid'];
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


        $updatequery = "update thermal set thermalindex=?, thermalpoint=?, 
        asstcomment=? where prop_id=? and userid=? and thermalid=?";
        $stmt = mysqli_prepare($con, $updatequery);
        mysqli_stmt_bind_param($stmt,"sissii", $thermalindex, $thermalpoint, $asstcomment, $prop_id, $userid, $thermalid);
        $result = mysqli_stmt_execute($stmt);
        if($result){
            $json['error'] = false;
            $json['message'] = "Updated thermal Successfully!";
        }else{
            $json['error'] = true;
            $json['message'] = "Updated thermal failed! ". mysqli_error($con);
        }

    }else{

        $json['error'] = true;
        $json['message'] = "No permission to access!";

    }
    echo json_encode($json);
    mysqli_close($con);

    function ifthermalexist(){
        
    }

    function ifthermaladded(){
        
    }
?>