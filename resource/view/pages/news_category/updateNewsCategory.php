<?php   
    include '../../../../database/connect.php'; 

    $name = $_POST["updateName"];
    $oldName = $_POST["oldName"];
    $parentID = $_POST["updateParentID"];
    $updateId = $_POST["updateID"];

    //check change name 
    if ($name !== $oldName) {
        // check exists product 
        $sql = "SELECT * FROM $MyProductsCategory WHERE $category__name = '$name'";
        $result = ($conn->query($sql));
        if (mysqli_num_rows($result) > 0) {
            header("Location: ../main-view/manage-products_categories.php?updateFail=2");
            exit();
        } else {
            $sql = "UPDATE $MyProducts 
                    SET $product__category = '$name' 
                    WHERE $product__category = '$oldName'";
            if ($conn->query($sql) == TRUE) {
            }
        }
    }

    if(empty($_POST['updateName']) || !isset($_POST['updateParentID'])) {
        header("Location: ../main-view/manage-news_categories.php?updateFail=1");
        exit();
    } else {
        $sql = "SELECT * FROM $MyNewsCategory WHERE $category__name LIKE '$name'";
        $result = ($conn->query($sql));
        if (mysqli_num_rows($result) > 0) {
            header("Location: ../main-view/manage-news_categories.php?updateFail=2");
            exit();
        } else {
            $sql = "UPDATE $MyNewsCategory 
                    SET $category__name='$name',
                        $category_parent__id='$parentID'
                    WHERE $category__id='$updateId'";
            if ($conn->query($sql) == TRUE) {
                $sql = "UPDATE $MyNews 
                        SET $news__category = '$name' 
                        WHERE $news__category = '$oldName'";
                if ($conn->query($sql) == TRUE) {
                    header("Location: ../main-view/manage-news_categories.php?updateSuccess=1");
                    exit();
                }
            }
        }
    }
?>