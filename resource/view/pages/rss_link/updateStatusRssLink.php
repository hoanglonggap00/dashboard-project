<?php 
    include '../../../../database/connect.php'; 

    $id = $_GET['id'];
    $sql = "SELECT $rss__status FROM $MyRssNews where $rss__id = '$id'";
    $result = $conn->query($sql);
    $status = mysqli_fetch_assoc($result);

    if ($status[$rss__status]==1) {
        $updateStatus = "0";
    } else {
        $updateStatus = "1";
    }

    $sql = "UPDATE  $MyRssNews SET $rss__status = '$updateStatus' WHERE $rss__id ='$id'";
    if ($conn->query($sql) === TRUE) {
        header("location:../main-view/manage-rss_links.php");
    }

?>