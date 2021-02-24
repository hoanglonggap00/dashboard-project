<?php   
    include '../../../../database/connect.php'; 

    $deleteId = $_POST['deleteID'];
    $deleteName = $_POST['deleteName'];

    $sql = "DELETE FROM $MyProducts WHERE $product__id='$deleteId'";
    if ($conn->query($sql) === TRUE) {
        $sql = "DELETE FROM $MyProductsTagsLink WHERE $link__product='$deleteName'";
        if ($conn->query($sql) === TRUE) {
            header("Location: ../main-view/manage-products.php?deleteSuccess=1");
            exit();
        }
    }
?>