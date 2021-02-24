<?php   
    include '../../../../database/connect.php'; 

    $name = $_POST["updateName"];
    $updateId = $_POST["updateID"];
    $oldName = $_POST["oldName"];

    //check change name 
    if ($name !== $oldName) {
        // check exists product 
        $sql = "SELECT * FROM $MyProductsTags WHERE $tag__name = '$name'";
        $result = ($conn->query($sql));
        if (mysqli_num_rows($result) > 0) {
            header("Location: ../main-view/manage-products_tags.php?updateFail=2");
            exit();
        } else {
            $sql = "UPDATE $MyProductsTagsLink 
                    SET $link__tag = '$name' 
                    WHERE $link__tag = '$oldName'";
            if ($conn->query($sql) == TRUE) {
            }
        }
    }

    if(empty($_POST['updateName'])) {
        header("Location: ../main-view/manage-products_tags.php?updateFail=1");
        exit();
    } else {
        $sql = "UPDATE $MyProductsTags 
                SET $tag__name='$name'
                WHERE $tag__id='$updateId'";
        if ($conn->query($sql) == TRUE) {
            header("Location: ../main-view/manage-products_tags.php?updateSuccess=1");
            exit();
        }
    }
?>