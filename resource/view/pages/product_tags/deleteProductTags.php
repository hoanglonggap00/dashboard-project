<?php   
    include '../../../../database/connect.php'; 

    $deleteId = $_POST['deleteID'];

    $sql = "DELETE FROM $MyProductsTags WHERE $tag__id='$deleteId'";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../main-view/manage-products_tags.php?deleteSuccess=1");
        exit();
    }
?>