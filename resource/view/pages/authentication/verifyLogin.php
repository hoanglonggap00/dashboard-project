<?php   
    include '../../../../database/connect.php'; 

    $acc = $_POST["loginAcc"];
    $pwd = $_POST["loginPwd"];

    $response_array['status'] = '';
    $response_array['message'] = '';  

    if(empty($_POST['loginAcc']) || empty($_POST['loginPwd'])) {
        $response_array['status'] = 'error';
        $response_array['message'] = 'Error: pls fill all the form'; 
    } else {
        // check existed account 
        $sql = "SELECT * 
                FROM $MyUsers
                WHERE $user__email LIKE '$acc'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 0) {
            $response_array['status'] = 'error';
            $response_array['message'] = "Error: Email wasn't exist"; 
        } else {
            // check valid password  
            $sql = "SELECT $user__password 
                    FROM $MyUsers
                    WHERE $user__email LIKE '$acc'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_fetch_assoc($result)["user__password"] !== md5($pwd)) {
                $response_array['status'] = 'error';
                $response_array['message'] = 'Error: wrong password'; 
            } else {
                $sql = "SELECT * 
                    FROM $MyUsers
                    WHERE $user__email LIKE '$acc'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                if ($row["$user__status"] == 0) {
                    $response_array['status'] = 'error';
                    $response_array['message'] = 'Error: Pls active your account'; 
                } else {
                    $_SESSION['acc'] = $acc;
                    $_SESSION['acc_permission'] = $row["$user__role"];

                    if (!empty($_POST["remember"])) {
                        setcookie("cookie__email", $acc, $cookie_expiration_time);

                        setcookie("cookie__password", $pwd, $cookie_expiration_time);
                        
                        $expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);

                    } else {
                        setcookie("cookie__email", "", time() - 3600); 
                        setcookie("cookie__password", "", time() - 3600); 
                    }
                    $response_array['status'] = 'success';
                }
            }
        }
    }

    header('Content-type: application/json');
    echo json_encode($response_array);
?>