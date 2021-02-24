<?php 
    include '../../../../database/connect.php'; 

    $id = $_GET['id'];
    $sql = "SELECT $news__status FROM $MyNews where $news__id = '$id'";
    $result = $conn->query($sql);
    $status = mysqli_fetch_assoc($result);

    if ($status[$news__status]==1) {
        $updateStatus = "0";
    } else {
        $updateStatus = "1";
    }

    $sql = "UPDATE  $MyNews SET $news__status = '$updateStatus' WHERE $news__id ='$id'";
    if ($conn->query($sql) === TRUE) {
        header("location:../main-view/manage-news.php");
    }

?>