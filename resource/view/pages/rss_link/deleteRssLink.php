<?php   
    include '../../../../database/connect.php'; 

    $deleteId = $_POST['deleteID'];

    $sql = "DELETE FROM $MyRssNews WHERE $rss__id='$deleteId'";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../main-view/manage-rss_links.php?deleteSuccess=1");
        exit();
    }
?>