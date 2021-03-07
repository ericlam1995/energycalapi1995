<?php
$json = array();
header('Content-Type:Application/json');
header('Access-Control-Allow-Origin: *');
include_once("include/db.php");
global $con;


// if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['company']) && isset($_POST['website']) &&
// isset($_POST['mobile']) && isset($_POST['password'])){
//     $username = trim(mysqli_real_escape_string($con, $_POST['username']));
//     $email = trim(mysqli_real_escape_string($con, $_POST['email']));
//     $company = trim(mysqli_real_escape_string($con,$_POST['company']));
//     $website = trim(mysqli_real_escape_string($con,$_POST['website']));
//     $mobile = trim(mysqli_real_escape_string($con,$_POST['mobile']));
//     $password = trim(mysqli_real_escape_string($con,$_POST['password']));

//     $querycheck = "select * from usertb where mobile=?";
//     $stmt = mysqli_prepare($con, $querycheck);
//     mysqli_stmt_bind_param($stmt, "s", $mobile);
//     if(mysqli_stmt_execute($stmt)){
//         $result = mysqli_stmt_get_result($stmt);
//         if($result){
//             if(mysqli_stmt_num_rows($result) > 0){
//                 $json['error'] = true;
//                 $json['message'] = "Already Registered!";
//             }else{
//                 $encryptpassword = base64_encode($password);

//                 $queryuser = "insert into usertb (username, email, company, website, mobile, password) 
//                 values (?, ?, ?, ?, ?, ?)";
//                 $stmt1 = mysqli_prepare($con, $queryuser);
//                 mysqli_stmt_bind_param($stmt1, "ssssss", $username, $email, $company, $website, $mobile, $encryptpassword);
//                 if(mysqli_stmt_execute($stmt1)){
//                     $json['error'] = false;
//                     $json['message'] = "Successfully Registered!";

//                 }else{
//                     $json['error'] = true;
//                     $json['message'] = "Something Wrong: " .mysqli_error($con);       
//                 }

//             }
//         }

//     }else{
//         $json['error'] = true;
//         $json['message'] = "Something Wrong:" .mysqli_error($con);
//     }


// }else{
//     $json['error'] = true;
//     $json['message'] = "No permission to access!";

// }

if (
    isset($_POST['username']) && isset($_POST['email']) && isset($_POST['company']) && isset($_POST['website']) &&
    isset($_POST['mobile']) && isset($_POST['password'])
) {
    $username = trim(mysqli_real_escape_string($con, $_POST['username']));
    $email = trim(mysqli_real_escape_string($con, $_POST['email']));
    $company = trim(mysqli_real_escape_string($con, $_POST['company']));
    $website = trim(mysqli_real_escape_string($con, $_POST['website']));
    $mobile = trim(mysqli_real_escape_string($con, $_POST['mobile']));
    $password = trim(mysqli_real_escape_string($con, $_POST['password']));

    $querycheck = "select * from usertb where mobile=?";
    $stmt = mysqli_prepare($con, $querycheck);
    mysqli_stmt_bind_param($stmt, "s", $mobile);
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        $count = mysqli_stmt_num_rows($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $json['error'] = true;
            $json['message'] = "Already Registered!";
        } else {
            $encryptpassword = base64_encode($password);

            $queryuser = "insert into usertb (username, email, company, website, mobile, password) 
                values (?, ?, ?, ?, ?, ?)";
            $stmt1 = mysqli_prepare($con, $queryuser);
            mysqli_stmt_bind_param($stmt1, "ssssss", $username, $email, $company, $website, $mobile, $encryptpassword);
            if (mysqli_stmt_execute($stmt1)) {
                $json['error'] = false;
                $json['message'] = "Successfully Registered!";
            } else {
                $json['error'] = true;
                $json['message'] = "Something Wrong: " . mysqli_error($con);
            }
        }
        mysqli_stmt_free_result($stmt);
    } else {
        $json['error'] = true;
        $json['message'] = "Something Wrong:" . mysqli_error($con);
    }
} else {
    $json['error'] = true;
    $json['message'] = "No permission to access!";
}
echo json_encode($json);
mysqli_close($con);
