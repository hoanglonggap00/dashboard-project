<?php   
    include '../../../../database/connect.php'; 

    $name = $_POST["category-name"];
    $parentID = $_POST["category-parentID"];

    if(empty($_POST['category-name']) || !isset($_POST['category-parentID'])) {
        header("Location: ../main-view/manage-products_categories.php?insertFail=1");
        exit();
    } else {
        $sql = "SELECT * FROM $MyProductsCategory WHERE $category__name LIKE '$name'";
        $result = ($conn->query($sql));
        if (mysqli_num_rows($result) > 0) {
            header("Location: ../main-view/manage-products_categories.php?insertFail=2");
            exit();
        } else {
            // insert data to table 
            $sql = "INSERT INTO $MyProductsCategory ($category__name, $category_parent__id)
            VALUES ('$name', '$parentID')";
            if ($conn->query($sql) == TRUE) {
                header("Location: ../main-view/manage-products_categories.php?insertSuccess=1");
                exit();
            }
        }
    }
?>