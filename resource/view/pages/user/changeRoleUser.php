<?php 
    include '../../../../database/connect.php'; 
    $id = $_POST['updateID'];
    $role = $_POST['role'];
    
    $sql = "UPDATE $MyUsers SET $user__role = '$role' WHERE $user__id = '$id'";
    if ($conn->query($sql)) {
        $_SESSION['acc_permission'] = $role;
        header("Location: ../main-view/manage-users.php?updateSuccess=1");
        exit();
    }
?>