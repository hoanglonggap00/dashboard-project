<?php   
    include '../../../../database/connect.php'; 

    $name = $_POST["news-name"];
    $description = $_POST["news-description"];
    $content = $_POST["news-content"];
    $category = $_POST["news-category"];

    $img__url = "";

    $randomNumber = rand();
    $target_dir = "../../../../public/assets/img/news/";
    $target_file = basename($_FILES["news-img"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $target_file = $target_dir.$randomNumber.".".$imageFileType;

    if(empty($_POST['news-name']) || empty($_POST['news-description']) || empty($_POST['news-content']) || empty($_FILES["news-img"]["name"])) {
        header("Location: ../main-view/manage-news?insertFail=1");
        exit();
    } else {
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["news-img"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            header("Location: ../main-view/manage-news.php?insertFail=2");
            exit();
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            header("Location: ../main-view/manage-news.php?insertFail=3");
            exit();
        }

        if ($uploadOk == 1) {
        // if everything is ok, try to upload file
            move_uploaded_file($_FILES["news-img"]["tmp_name"], $target_file); 
            $img__url = $target_file;
        }

        // check exists product 
        $sql = "SELECT * FROM $MyNews WHERE $news__name = '$name'";
        $result = ($conn->query($sql));
        if (mysqli_num_rows($result) > 0) {
            header("Location: ../main-view/manage-news.php?insertFail=4");
            exit();
        } else {

            // insert data to table 
            $sql = "INSERT INTO $MyNews ($news__name, $news__description, $news__content, $news__img, $news__category)
                    VALUES ('$name', '$description', '$content', '$img__url','$category')";
            if ($conn->query($sql)) {
                $addTag = true;
                if(isset($_POST['tag'])){
                    if (is_array($_POST['tag'])) {
                        foreach($_POST['tag'] as $value){
                            $sql = "INSERT INTO $MyNewsTagsLink ($link__news, $link__tag)
                                    VALUES ('$name', '$value')";
                            if (!($conn->query($sql))) {
                                $addTag = false;
                            }
                        }
                    } else {
                        $value = $_POST['tag'];
                        $sql = "INSERT INTO $MyNewsTagsLink ($link__news, $link__tag)
                                    VALUES ('$name', '$value')";
                        if (!($conn->query($sql))) {
                            $addTag = false;
                        }
                    }
                }
                if ($addTag) {
                    header("Location: ../main-view/manage-news.php?insertSuccess=1");
                    exit();
                }
            }
        }
    }
?>