<?php
    include '../../../../database/connect.php'; 

    require '../../../../function/function.php';

    $adminEmail = "nhatlinh161232@gmail.com";

    $response_array['status'] = '';
    $response_array['message'] = '';  

    if(empty($_POST["forgetEmail"])) { 
        $response_array['status'] = 'error';
        $response_array['message'] = 'Error: Mời nhập đủ vào form';  
    } else {
        $targetEmail = $_POST['forgetEmail'];
        // check existed account 
        $sql = "SELECT * 
                FROM $MyUsers
                WHERE $user__email LIKE '$targetEmail'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 0){
            $response_array['status'] = 'error';
            $response_array['message'] = 'Error: email chưa được đăng ký';  
        }else {
            $server = $_SERVER['HTTP_HOST'];

            $to = $targetEmail;
            $subject = "Forget password";
            $body = "Click vào link để reset mật khẩu ";
            $body .= '<a href="'.$server.'/resource/view/pages/authentication/resetPassword.php?acc='.$targetEmail.'">reset password</a>';
            $response_array['status'] = sentEmail($to,$subject,$body)==1 ? "success" : "error";
            $response_array['message'] = 'Error: Lỗi gửi email';  
        }
    }

    header('Content-type: application/json');
    echo json_encode($response_array);
?>