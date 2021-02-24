<?php 
    include '../../../../database/connect.php'; 

    $id = $_GET['id'];
    $sql = "SELECT $product__status FROM $MyProducts where $product__id = '$id'";
    $result = $conn->query($sql);
    $status = mysqli_fetch_assoc($result);

    if ($status[$product__status]==1) {
        $updateStatus = "0";
    } else {
        $updateStatus = "1";
    }

    $sql = "UPDATE  $MyProducts SET $product__status = '$updateStatus' WHERE $product__id ='$id'";
    if ($conn->query($sql) === TRUE) {
        header("location:../main-view/manage-products.php");
    }

?>