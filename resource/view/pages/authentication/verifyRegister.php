<?php   
    include '../../../../database/connect.php'; 
    require '../../../../function/function.php';

    $userFirstName = $_POST['registerFirstName'];
    $userLastName = $_POST['registerLastName'];
    $email = $_POST["registerEmail"];
    $pwd = $_POST["registerPwd"];
    $pwd_confirm = $_POST["registerPwdConfirm"];
    $username="";

    $response_array['status'] = '';
    $response_array['message'] = '';  

    if(empty($_POST['registerFirstName']) || empty($_POST['registerLastName']) || empty($_POST['registerEmail']) || empty($_POST['registerPwd']) || empty($_POST['registerPwdConfirm'])) {
        $response_array['status'] = 'error';
        $response_array['message'] = 'Error: pls fill all the form';  
    } else {
        $username = $userFirstName." ".$userLastName;
        if ($pwd !== $pwd_confirm) {
            $response_array['status'] = 'error';
            $response_array['message'] = 'Error: Password diffirent from password confirm';  
        } else {
            // check existed account 
            $sql = "SELECT * 
                    FROM $MyUsers
                    WHERE $user__email LIKE '$email'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $response_array['status'] = 'error';
                $response_array['message'] = 'Error: Email already existed';  
            } else {
                // create default user role  
                $sql = "SELECT * 
                        FROM $MyUsersRoles
                        WHERE $role__name = 'Visitor'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) == 0) {
                    $sql = "INSERT INTO $MyUsersRoles ($role__name,$role__description) VALUE ('Visitor','inspect product, news')";
                    if ($conn->query($sql) == TRUE) {
                        $sql = "INSERT INTO $MyUsersRolesLink ($link__role, $link__permission) VALUE ('Visitor','inspectProduct'),('Visitor','inspectNews')";
                        if ($conn->query($sql) !== TRUE) {
                        }
                    }
                }

                // Hash password 
                $pwd = md5($pwd);
                // insert data to table 
                $sql = "INSERT INTO $MyUsers ($user__username, $user__email, $user__password, $user__img, $user__role)
                VALUES ('$username', '$email', '$pwd','../../../../public/assets/img/user/default.png','Visitor')";

                if ($conn->query($sql) !== TRUE) {
                }
                
                $sql = "SELECT * FROM $MyUsers WHERE $user__email = '$email'";
                $result = mysqli_query($conn, $sql);
                $idRes = mysqli_fetch_assoc($result)["$user__id"];

                $adminEmail = "nhatlinh161232@gmail.com";

                $server = $_SERVER['HTTP_HOST'];

                $to = $email;
                $subject = "Welcome User";
                $body = '<!doctype html>
                <html>
                  <head>
                    <style type="text/css">
                        .btn {
                            display: inline-block;
                            font-weight: 400;
                            color: #212529;
                            text-align: center;
                            vertical-align: middle;
                            -webkit-user-select: none;
                            -moz-user-select: none;
                            -ms-user-select: none;
                            user-select: none;
                            background-color: transparent;
                            border: 1px solid transparent;
                            padding: 0.375rem 0.75rem;
                            font-size: 1rem;
                            line-height: 1.5;
                            border-radius: 0.25rem;
                            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                            outline: none;
                            border: none !important;
                            text-transform: none;
                        }
                        .btn:not(:disabled):not(.disabled) {
                            cursor: pointer;
                        }
                        .btn:hover {
                            color: #212529;
                            text-decoration: none;
                        }
                        .btn-primary {
                            color: #fff;
                            background-color: #007bff;
                            border-color: #007bff;
                        }
                        .btn-primary:hover {
                            color: #fff;
                            background-color: #0069d9;
                            border-color: #0062cc;
                        }

                        a {
                            color:#fff !important;
                            text-decoration: none !important;
                        }
                    </style>
                  </head>
                  <body>
                    <p>Chào mừng đến với website! hãy click vào đường link để active tài khoản </p><a href="http://'.$server.'/resource/view/pages/authentication/activeAccount.php?id='.$idRes.'" class="btn btn-primary">active account</a>
                  </body>
                </html>';

                $response_array['status'] = sentEmail($to,$subject,$body)==1 ? "success" : "error";
                $response_array['message'] = 'Error: email sent failed'; 
            }
        }
    }

    header('Content-type: application/json');
    echo json_encode($response_array);
?>