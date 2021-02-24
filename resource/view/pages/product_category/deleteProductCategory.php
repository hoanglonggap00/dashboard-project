<?php   
    include '../../../../database/connect.php'; 

    $deleteId = $_POST['deleteID'];

    $sql = "DELETE FROM $MyProductsCategory WHERE $category__id='$deleteId'";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../main-view/manage-products_categories.php?deleteSuccess=1");
        exit();
    }
?>