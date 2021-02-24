<?php   
    include '../../../../database/connect.php'; 

    $deleteId = $_POST['deleteID'];
    $deleteName = $_POST['deleteName'];

    $sql = "DELETE FROM $MyNews WHERE $news__id='$deleteId'";
    if ($conn->query($sql) === TRUE) {
        $sql = "DELETE FROM $MyNewsTagsLink WHERE $link__news='$deleteName'";
        if ($conn->query($sql) === TRUE) {
            header("Location: ../main-view/manage-news.php?deleteSuccess=1");
            exit();
        }
    }
?>