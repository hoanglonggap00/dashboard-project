<?php   
    include '../../../../database/connect.php'; 

    $name = $_POST["tag-name"];

    if(empty($_POST['tag-name'])) {
        header("Location: ../main-view/manage-products_tags.php?insertFail=1");
        exit();
    } else {
        $sql = "SELECT * FROM $MyProductsTags WHERE $tag__name LIKE '$name'";
        $result = ($conn->query($sql));
        if (mysqli_num_rows($result) > 0) {
            header("Location: ../main-view/manage-products_tags.php?insertFail=2");
            exit();
        } else {
            // insert data to table 
            $sql = "INSERT INTO $MyProductsTags ($tag__name)
            VALUES ('$name')";
            if ($conn->query($sql) == TRUE) {
                header("Location: ../main-view/manage-products_tags.php?insertSuccess=1");
                exit();
            }
        }
    }
?>