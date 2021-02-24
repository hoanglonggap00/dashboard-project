<?php   
    include '../../../../database/connect.php'; 

    $oldName = $_POST["oldName"];
    $name = $_POST["updateName"];
    $description = $_POST["updateDescription"];
    $category = $_POST["updateCategory"];
    $content = $_POST["updateContent"];
    $updateId = $_POST['updateID'];
    $randomNumber = rand();

    //check change name 
    if ($name !== $oldName) {
        // check exists product 
        $sql = "SELECT * FROM $MyProducts WHERE $product__name = '$name'";
        $result = ($conn->query($sql));
        if (mysqli_num_rows($result) > 0) {
            header("Location: ../main-view/manage-products.php?updateFail=3");
            exit();
        } 
    }

    if (empty($_FILES["updateImg"]["name"])) {
        $sql = "UPDATE $MyProducts 
                SET $product__name='$name',
                    $product__category='$category',
                    $product__description='$description',
                    $product__content='$content'
                WHERE $product__id='$updateId'";
    } else {

        $target_dir = "../../../../public/assets/img/product/";
        $target_file = basename($_FILES["updateImg"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $target_file = $target_dir.$randomNumber.".".$imageFileType;

        $check = getimagesize($_FILES["updateImg"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            header("Location: ../main-view/manage-products.php?updateFail=1");
            exit();
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            header("Location: ../main-view/manage-products.php?updateFail=2");
            exit();
        }

        if ($uploadOk == 1) {
            $updateimg__url = "";
            move_uploaded_file($_FILES["updateImg"]["tmp_name"], $target_file); 
            $updateimg__url = $target_file;

            $sql = "UPDATE $MyProducts 
                    SET $product__name='$name',
                        $product__description='$description',
                        $product__content='$content',
                        $product__category='$category',
                        $product__img='$updateimg__url' 
                    WHERE $product__id='$updateId'";
        }
    }

    $addTag = true;

    if ($conn->query($sql)) {
        $sql = "SELECT $link__tag FROM $MyProductsTagsLink WHERE $link__product='$name'";
        $result = ($conn->query($sql));
        $currentTag = mysqli_fetch_assoc($result);
        if (is_array($currentTag) && is_array($_POST['tag'])) {
            foreach($_POST['tag'] as $value){
                if (!in_array($value,$currentTag)) {
                    $sql = "INSERT INTO $MyProductsTagsLink ($link__product, $link__tag)
                                     VALUES ('$name', '$value')";
                             if (!($conn->query($sql))) {
                                 $addTag = false;
                            }
                }
            }
            foreach($currentTag as $tag){
                if (!in_array($tag,$_POST['tag'])) {
                    $sql = "DELETE FROM $MyProductsTagsLink WHERE $link__product = '$name' AND $link__tag = '$tag'";
                             if (!($conn->query($sql))) {
                                 $addTag = false;
                            }
                }
            }
        } else if (is_array($_POST['tag']) && !is_array($currentTag)){
            foreach($_POST['tag'] as $value){
                $sql = "INSERT INTO $MyProductsTagsLink ($link__product, $link__tag)
                        VALUES ('$name', '$value')";
                if (!($conn->query($sql))) {
                    $addTag = false;
                }
            }
        } else if (!is_array($_POST['tag']) && is_array($currentTag)){
            $sql = "DELETE FROM $MyProductsTagsLink WHERE $link__product = '$name'";
            if (!($conn->query($sql))) {
                $addTag = false;
            }
        }
        
        if ($addTag) {
            header("Location: ../main-view/manage-products.php?updateSuccess=1");
            exit();
        }
    }
?>