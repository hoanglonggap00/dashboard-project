<?php 
    include '../../../../database/connect.php'; 

    $id = $_GET['id'];
    $sql = "SELECT $user__status FROM $MyUsers where $product__id = '$id'";
    $result = $conn->query($sql);
    $status = mysqli_fetch_assoc($result);

    if ($status[$user__status]==1) {
        $updateStatus = "0";
    } else {
        $updateStatus = "1";
    }

    $sql = "UPDATE  $MyUsers SET $user__status = '$updateStatus' WHERE $user__id ='$id'";
    die($sql);
    if ($conn->query($sql) === TRUE) {
        header("location:../main-view/manage-users.php");
    }

?>