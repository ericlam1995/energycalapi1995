<?php
  $json = array();
  header('Content-Type:Application/json');
  header('Access-Control-Allow-Origin: *');
  include_once("include/db.php");
  global $con;

if(isset($_POST['mobile']) && isset($_POST['password'])){
  $mobile = trim(mysqli_real_escape_string($con, $_POST['mobile']));
  $password = trim(mysqli_real_escape_string($con, $_POST['password']));
  $queryuser = "select * from usertb where mobile=? limit 1";

  $stmt = mysqli_prepare($con, $queryuser);
  mysqli_stmt_bind_param($stmt,"s", $mobile);
  if(mysqli_stmt_execute($stmt)){
    mysqli_stmt_store_result($stmt);
    $count = mysqli_stmt_num_rows($stmt);
    if($count > 0){
      mysqli_stmt_bind_result($stmt, $userid, $username, $email, $company, $website, $mobile, $encryptpassword);
      while(mysqli_stmt_fetch($stmt)){
        $decryptpass = base64_decode($encryptpassword);
        if($password === $decryptpass){
              $json['userid'] = $userid;
              $json['username'] = $username;
              $json['email'] = $email;
              $json['company'] = $company;
              $json['website'] = $website;
              $json['mobile'] = $mobile;
              $json['password'] = $encryptpassword;
        }else{
              $json['error'] = true;
              $json['message'] = "Wrong Password";
        }
      }
    }else{
      $json['error'] = true;
      $json['message'] = "No account available!";
    }
    mysqli_stmt_free_result($stmt);

  }else{
      $json['error'] = true;
      $json['message'] = "Something wrong: " .mysqli_error($con);
  }
  

} else{
  $json['error'] = true;
  $json['message'] = "No permission to access!";
}
echo json_encode($json);
mysqli_close($con);
