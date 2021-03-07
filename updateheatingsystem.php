<?php
    $json = array();
    header('Content-Type:Application/json');
    header('Access-Control-Allow-Origin: *');
    include_once("include/db.php");
    global $con;

    if(isset($_POST['heatid'],$_POST['air_perc'], $_POST['hyd_perc'], $_POST['lpg_gas_perc'], $_POST['natural_gas_perc'], 
    $_POST['wood_perc'], $_POST['ele_h_perc'], $_POST['back_boosted'],$_POST['back_boosted_points'],
    $_POST['heat_points'], $_POST['asstcomment'], $_POST['prop_id']
    ,$_POST['userid'])){



        $heatid = $_POST['heatid'];
        $air_perc;
        if(empty($_POST['air_perc'])){
            $air_perc = 0;
        }else{
            $air_perc = floatval($_POST['air_perc']);
        }

        $air_kw;
        if(empty($_POST['air_kw'])){
            $air_kw = 0;
        }else{
            $air_kw = floatval($_POST['air_kw']);
        }

        $air_image = null;
        if(isset($_FILES['air_image'])){
            if(is_uploaded_file($_FILES['air_image']['tmp_name'])){
                $air_image = base64_encode(file_get_contents(addslashes($_FILES['air_image']['tmp_name'])));
            }
        }
        else{
            $air_image = null;
        }
        $hyd_perc;
        if(empty($_POST['hyd_perc'])){
            $hyd_perc = 0;
        }else{
            $hyd_perc = floatval($_POST['hyd_perc']);
        }

        $hyd_kw;
        if(empty($_POST['hyd_kw'])){
            $hyd_kw = 0;
        }else{
            $hyd_kw = floatval($_POST['hyd_kw']);
        }

        $hyd_image = null;
        if(isset($_FILES['hyd_image'])){
            if(is_uploaded_file($_FILES['hyd_image']['tmp_name'])){
                $hyd_image = base64_encode(addslashes(file_get_contents($_FILES['hyd_image']['tmp_name'])));
            }
        }
        else{
            $hyd_image = null;
        }
        $lpg_gas_perc;

        if(empty($_POST['lpg_gas_perc'])){
            $lpg_gas_perc = 0;
        }else{
            $lpg_gas_perc = floatval($_POST['lpg_gas_perc']);
        }

        $lpg_gas_kw;
        if(empty($_POST['lpg_gas_kw'])){
            $lpg_gas_kw = 0;
        }else{
            $lpg_gas_kw = floatval($_POST['lpg_gas_kw']);
        }

        $lpg_gas_image = null;
        if(isset($_FILES['lpg_gas_image'])){
            if(is_uploaded_file($_FILES['lpg_gas_image']['tmp_name'])){
            
                $lpg_gas_image = base64_encode(file_get_contents(addslashes($_FILES['lpg_gas_image']['tmp_name'])));
            }
        }
        else{
            $lpg_gas_image = null;
        }
        $natural_gas_perc;
        if(empty($_POST['natural_gas_perc'])){
            $natural_gas_perc = 0;
        }else{
            $natural_gas_perc = floatval($_POST['natural_gas_perc']);
        }

        $natural_gas_kw;
        if(empty($_POST['natural_gas_kw'])){
            $natural_gas_kw = 0;
        }else{
            $natural_gas_kw = floatval($_POST['natural_gas_kw']);
        }

        $natural_gas_image;
        if(isset($_FILES['natural_gas_image'])){
            if(is_uploaded_file($_FILES['natural_gas_image']['tmp_name'])){
                $natural_gas_image = base64_encode(file_get_contents(addslashes($_FILES['natural_gas_image']['tmp_name'])));
            }
        }
        else{
            $natural_gas_image = null;
        }
        $wood_perc;
        if(empty($_POST['wood_perc'])){
            $wood_perc = 0;
        }else{
            $wood_perc = floatval($_POST['wood_perc']);;
        }
        
        $wood_kw;
        if(empty($_POST['wood_kw'])){
            $wood_kw = 0;
        }else{
            $wood_kw = floatval($_POST['wood_kw']);;
        }
        $wood_image = null;
        if(isset($_FILES['wood_image'])){
            if(is_uploaded_file($_FILES['wood_image']['tmp_name'])){
                $wood_image = base64_encode(file_get_contents(addslashes($_FILES['wood_image']['tmp_name'])));
            }
        }
        else{
            $wood_image = null;
        }
        $ele_h_perc;
        if(empty($_POST['ele_h_perc'])){
            $ele_h_perc = 0;
        }else{
            $ele_h_perc = floatval($_POST['ele_h_perc']);
        }

        $ele_h_kw;
        if(empty($_POST['ele_h_kw'])){
            $ele_h_kw = 0;
        }else{
            $ele_h_kw = floatval($_POST['ele_h_kw']);
        }
        $ele_h_image = null;
        if(isset($_FILES['ele_h_image'])){
            if(is_uploaded_file($_FILES['ele_h_image']['tmp_name'])){
                $ele_h_image = base64_encode(file_get_contents(addslashes($_FILES['ele_h_image']['tmp_name'])));
            }
        }
        else{
            $ele_h_image = null;
        }
        

        $back_boosted = trim($_POST['back_boosted']);

        $back_boosted_points = floatval($_POST['back_boosted_points']);
        $back_boosted_image;
        if(isset($_FILES['back_boosted_image'])){
            if(is_uploaded_file($_FILES['back_boosted_image']['name'])){
                $back_boosted_image = base64_encode(file_get_contents(addslashes($_FILES['back_boosted_image']['tmp_name'])));
            }
        }else{
            $back_boosted_image = null;
        }

        
        $heat_points = intval($_POST['heat_points']);

        $asstcomment = trim($_POST['asstcomment']);

        $prop_id = trim($_POST['prop_id']);

        $userid = intval($_POST['userid']);

        $updatequery = "update heatsystem set air_perc=?, air_kw=?, air_image=?, hyd_perc=?, 
        hyd_kw=?, hyd_image=?, lpg_gas_perc=?, lpg_gas_kw=?, lpg_gas_image=?, 
        natural_gas_perc=?, natural_gas_kw=?, natural_gas_image=?, 
        wood_perc=?, wood_kw=?, wood_image=?, ele_h_perc=?, ele_h_kw=?, ele_h_image=?,back_boosted=?,
        back_boosted_points=?, back_boosted_image=?, heat_points=?, 
        asstcomment=? where prop_id=? and userid=? and heatid=?";

        $stmt = mysqli_prepare($con, $updatequery);
        mysqli_stmt_bind_param($stmt, "ddbddbddbddbddbddbsdbdssii", $air_perc, $air_kw, $air_image, $hyd_perc, 
        $hyd_kw, $hyd_image, $lpg_gas_perc, $lpg_gas_kw,$lpg_gas_image, $natural_gas_perc, $natural_gas_kw, $natural_gas_image,
         $wood_perc, $wood_kw, $wood_image, $ele_h_perc, $ele_h_kw, $ele_h_image, $back_boosted,$back_boosted_points
        , $back_boosted_image, $heat_points, $asstcomment,$prop_id
        , $userid, $heatid);
        mysqli_stmt_send_long_data($stmt, 2, $air_image);
        mysqli_stmt_send_long_data($stmt, 5, $hyd_image);
        mysqli_stmt_send_long_data($stmt, 8, $lpg_gas_image);
        mysqli_stmt_send_long_data($stmt, 11, $natural_gas_image);
        mysqli_stmt_send_long_data($stmt, 14, $wood_image);
        mysqli_stmt_send_long_data($stmt, 17, $ele_h_image);
        mysqli_stmt_send_long_data($stmt, 20, $back_boosted_image);
        $result = mysqli_stmt_execute($stmt);
        if($result){
            $json['error'] = false;
            $json['message'] = "Updated heating Successfully!";
        }else{
            $json['error'] = true;
            $json['message'] = "Updated heating failed! ". mysqli_error($con);
        }
    }else{

        $json['error'] = true;
        $json['message'] = "No permission to access!";

    }
    echo json_encode($json);
    mysqli_close($con);

    function ifheatingexist(){
        
    }

    function ifheatingadded(){
        
    }
?>
