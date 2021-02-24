<?php   
    include "connect.php";

    $acc=$_POST['account'];

    if (empty($_POST['newPassword']) || empty($_POST['newConfirmPassword'])) {
        header("Location:resetPassword.php?emptyForm=1");
        exit();
    } else {
        $newPwd=$_POST['newPassword'];
        $newConfirmPwd=$_POST['newConfirmPassword'];

        if($newPwd !== $newConfirmPwd) {
            header("Location:resetPassword.php?pwdDiff=1");
            exit();
        } else {
            $pwd=md5($newPwd);

            $sql = "UPDATE $MyUsers 
                    SET $user__password='$pwd'
                    WHERE $user__email='$acc'";

            if ($conn->query($sql) == TRUE) {
                header("Location: login.php?changeSuccess=1");
                exit();
            }
        }
    }
?>