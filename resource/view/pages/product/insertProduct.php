<?php   
    include '../../../../database/connect.php'; 

    $name = $_POST["product-name"];
    $description = $_POST["product-description"];
    $content = $_POST["product-content"];
    $category = $_POST["product-category"];

    $img__url = "";

    $randomNumber = rand();
    $target_dir = "../../../../public/assets/img/product/";
    $target_file = basename($_FILES["product-img"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $target_file = $target_dir.$randomNumber.".".$imageFileType;

    if(empty($_POST['product-name']) || empty($_POST['product-description']) || empty($_POST['product-content']) || empty($_FILES["product-img"]["name"])) {
        header("Location: ../main-view/manage-products.php?insertFail=1");
        exit();
    } else {
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["product-img"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            header("Location: ../main-view/manage-products.php?insertFail=2");
            exit();
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            header("Location: ../main-view/manage-products.php?insertFail=3");
            exit();
        }

        if ($uploadOk == 1) {
        // if everything is ok, try to upload file
            move_uploaded_file($_FILES["product-img"]["tmp_name"], $target_file); 
            $img__url = $target_file;
        }

        // check exists product 
        $sql = "SELECT * FROM $MyProducts WHERE $product__name = '$name'";
        $result = ($conn->query($sql));
        if (mysqli_num_rows($result) > 0) {
            header("Location: ../main-view/manage-products.php?insertFail=4");
            exit();
        } else {
            // insert data to table 
            $sql = "INSERT INTO $MyProducts ($product__name, $product__description, $product__content, $product__img, $product__category)
                    VALUES ('$name', '$description', '$content', '$img__url','$category')";
            if ($conn->query($sql)) {
                $addTag = true;
                if(isset($_POST['tag'])){
                    if (is_array($_POST['tag'])) {
                        foreach($_POST['tag'] as $value){
                            $sql = "INSERT INTO $MyProductsTagsLink ($link__product, $link__tag)
                                    VALUES ('$name', '$value')";
                            if (!($conn->query($sql))) {
                                $addTag = false;
                            }
                        }
                    } else {
                        $value = $_POST['tag'];
                        $sql = "INSERT INTO $MyProductsTagsLink ($link__product, $link__tag)
                                    VALUES ('$name', '$value')";
                        if (!($conn->query($sql))) {
                            $addTag = false;
                        }
                    }
                }
                if ($addTag) {
                    header("Location: ../main-view/manage-products.php?insertSuccess=1");
                    exit();
                }
            }
        }
    }
?>