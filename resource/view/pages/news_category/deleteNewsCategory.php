<?php   
    include '../../../../database/connect.php'; 

    $deleteId = $_POST['deleteID'];

    $sql = "DELETE FROM $MynewssCategory WHERE $category__id='$deleteId'";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../main-view/manage-newss_categories.php?deleteSuccess=1");
        exit();
    }
?>