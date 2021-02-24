<?php   
    include '../../../../database/connect.php'; 

    $name = $_POST["updateName"];
    $updateId = $_POST['userID'];
    $randomNumber = rand();

    if (empty($_FILES["profile_avatar"]["name"])) {
        $sql = "UPDATE $MyUsers 
                    SET $user__username='$name'
                    WHERE $product__id='$updateId'";
    } else {
        $target_dir = "../../../../public/assets/img/user/";
        $target_file = basename($_FILES["profile_avatar"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $target_file = $target_dir.$randomNumber.".".$imageFileType;

        $check = getimagesize($_FILES["profile_avatar"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            header("Location: ../main-view/account.php?updateFail=1");
            exit();
        }

        if ($uploadOk == 1) {
            $updateimg__url = "";
            move_uploaded_file($_FILES["profile_avatar"]["tmp_name"], $target_file); 
            $updateimg__url = $target_file;

            $sql = "UPDATE $MyUsers 
                    SET $user__username='$name',
                        $user__img='$updateimg__url' 
                    WHERE $product__id='$updateId'";
        }
    }

    if ($conn->query($sql) == TRUE) {
        header("Location: ../main-view/account.php?changeAccountInfoSuccess=1");
        exit();
    }
?>