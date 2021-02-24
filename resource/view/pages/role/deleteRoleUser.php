<?php   
    include '../../../../database/connect.php'; 

    $deleteId = $_POST['deleteID'];

    $sql = "DELETE FROM $MyUsersRoles WHERE $role__id='$deleteId'";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../main-view/manage-user_roles.php?deleteSuccess=1");
        exit();
    }
?>