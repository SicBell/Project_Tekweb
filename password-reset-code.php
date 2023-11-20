<?php
    include("db_connect.php");

    if(isset($_POST['password_reset_link']))
    {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $token = md5(rand());

        $check_email = "SELECT email FROM accounts WHERE email ='$email' LIMIT 1";
        $check_email_run = mysqli_query($con, $check_email);

        if(mysqli_num_rows($check_email_run)>0){
            $row = mysqli_fetch_array($check_email_run);
            $get_name = $row['username'];
            $get_email = $row['email'];

            $update_token = "UPDATE accounts set verify_token ='$token' WHERE email ='$get_email' LIMIT 1";
            $update_token_run = mysqli_query($con, $update_token);

            if($update_token_run){

            }else{

            }
        }
        else{
            
        }
    }
?>