<?php   
    include '../../../../database/connect.php'; 

    $acc=$_POST['account'];

    if (empty($_POST['newPassword']) || empty($_POST['newConfirmPassword']) || empty($_POST['currentPassword'])) {
        header("Location:../main-view/account.php?emptyPasswordForm=1");
        exit();
    } else {
        $newPwd=$_POST['newPassword'];
        $newConfirmPwd=$_POST['newConfirmPassword'];
        $currentPwd=$_POST['currentPassword'];
        $acc = $_SESSION['acc'];

        $sql = "SELECT *
                FROM $MyUsers
                WHERE $user__email LIKE '$acc'";
        $result = mysqli_query($conn, $sql);
        $correctPassword = mysqli_fetch_assoc($result)["$user__password"];

        if ($correctPassword !== md5($currentPwd)) {
            header("Location:../main-view/account.php?wrongCurrentPwd=1");
            exit();
        } else {
            if($newPwd !== $newConfirmPwd) {
                header("Location:../main-view/account.php?pwdDiff=1");
                exit();
            } else {
                $pwd=md5($newPwd);
    
                $sql = "UPDATE $MyUsers 
                        SET $user__password='$pwd'
                        WHERE $user__email='$acc'";
    
                if ($conn->query($sql) == TRUE) {
                    header("Location: ../main-view/account.php?changeAccountPasswordSuccess=1");
                    exit();
                }
            }
        }
    }
?>