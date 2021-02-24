<?php   
    include '../../../../database/connect.php'; 

    $name = $_POST["updateName"];
    $email = $_POST["updateEmail"];
    $oldEmail = $_POST["oldEmail"];
    $password = $_POST["updatePassword"];
    $oldPassword = $_POST["oldPassword"];
    $role = $_POST["role"];
    $updateID = $_POST['updateID'];

    $avatar__url = "";

    $randomNumber = rand();
    $target_dir = "../../../../public/assets/img/user/";
    $target_file = basename($_FILES["updateAvatar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $target_file = $target_dir.$randomNumber.".".$imageFileType;

    if(empty($_POST['updateName']) || empty($_POST['updateEmail']) || empty($_POST['updatePassword']) || empty($_POST['role'])) {
        header("Location:../main-view/manage-users.php?updateFail=1");
        exit();
    } else {
        if ($email != $oldEmail) {
            // check existed account 
            $sql = "SELECT * 
                    FROM $MyUsers
                    WHERE $user__email LIKE '$email'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                header("Location:../main-view/manage-users.php?updateFail=2");
                exit(); 
            }
        } 
        if ($password != $oldPassword) {
            $password = md5($password);
        }

        if (empty($_FILES["updateAvatar"]["name"])) { 
            $sql = "UPDATE $MyUsers 
                    SET $user__username = '$name',
                        $user__email = '$email',
                        $user__password = '$password',
                        $user__role = '$role'
                    WHERE $user__id='$updateID'";
        } else {
            move_uploaded_file($_FILES["updateAvatar"]["tmp_name"], $target_file); 
            $avatar__url = $target_file;
            $sql = "UPDATE $MyUsers 
                    SET $user__username = '$name',
                        $user__email = '$email',
                        $user__password = '$password',
                        $user__role = '$role',
                        $user__img = '$avatar__url'
                    WHERE $user__id='$updateID'";
        }

        if ($conn->query($sql)) {
            header("Location:../main-view/manage-users.php?updateSuccess=1");
            exit();
        }
    }
?>