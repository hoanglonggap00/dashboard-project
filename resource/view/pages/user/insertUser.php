<?php   
    include '../../../../database/connect.php'; 

    $name = $_POST["user-name"];
    $email = $_POST["user-email"];
    $password = $_POST["user-password"];
    $role = $_POST["role"];

    $avatar__url = "";

    $randomNumber = rand();
    $target_dir = "../../../../public/assets/img/user/";
    $target_file = basename($_FILES["user-avatar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $target_file = $target_dir.$randomNumber.".".$imageFileType;

    if(empty($_POST['user-name']) || empty($_POST['user-email']) || empty($_POST['user-password']) || empty($_POST['role'])) {
        header("Location:../main-view/manage-users.php?insertFail=1");
        exit();
    } else {
        if (empty($_FILES["user-avatar"]["name"])) { 
            $avatar__url = '../../../../public/assets/img/user/default.png';
        } else {
            move_uploaded_file($_FILES["user-avatar"]["tmp_name"], $target_file); 
            $avatar__url = $target_file;
        }
        // check existed account 
        $sql = "SELECT * 
                FROM $MyUsers
                WHERE $user__email LIKE '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            header("Location:../main-view/manage-users.php?insertFail=2");
            exit(); 
        } else {
            // Hash password 
            $password = md5($password);
            // insert data to table 
            $sql = "INSERT INTO $MyUsers ($user__username, $user__email, $user__password, $user__img, $user__role)
            VALUES ('$name', '$email', '$password','$avatar__url','$role')";
            if ($conn->query($sql)) {
                header("Location:../main-view/manage-users.php?insertSuccess=1");
                exit();
            }
        } 
    }
    
?>