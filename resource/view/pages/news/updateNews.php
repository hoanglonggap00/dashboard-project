<?php   
    include '../../../../database/connect.php'; 

    $name = $_POST["updateName"];
    $oldName = $_POST["oldName"];
    $description = $_POST["updateDescription"];
    $content = $_POST["updateContent"];
    $updateId = $_POST['updateID'];
    $category = $_POST['updateCategory'];
    $randomNumber = rand();

    if ($name !== $oldName) {
        // check exists product 
        $sql = "SELECT * FROM $MyNews WHERE $news__name = '$name'";
        $result = ($conn->query($sql));
        if (mysqli_num_rows($result) > 0) {
            header("Location: ../main-view/manage-news.php?updateFail=3");
            exit();
        } 
    }

    if (empty($_FILES["updateImg"]["name"])) {
        $sql = "UPDATE $MyNews
                SET $news__name='$name',
                    $news__description='$description',
                    $news__content='$content',
                    $news__category='$category'
                WHERE $news__id='$updateId'";
    } else {

        $target_dir = "../../../../public/assets/img/news/";
        $target_file = basename($_FILES["updateImg"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $target_file = $target_dir.$randomNumber.".".$imageFileType;

        $check = getimagesize($_FILES["updateImg"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            header("Location: ../main-view/manage-news.php?updateFail=1");
            exit();
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            header("Location: ../main-view/manage-news.php?updateFail=2");
            exit();
        }

        if ($uploadOk == 1) {
            $updateimg__url = "";
            move_uploaded_file($_FILES["updateImg"]["tmp_name"], $target_file); 
            $updateimg__url = $target_file;

            $sql = "UPDATE $MyNews 
                    SET $news__name='$name',
                        $news__description='$description',
                        $news__content='$content',
                        $news__img='$updateimg__url',
                        $news__category='$category' 
                    WHERE $news__id='$updateId'";
        }
    }

    $addTag = true;

    if ($conn->query($sql)) {
        $sql = "SELECT $link__tag FROM $MyNewsTagsLink WHERE $link__news='$name'";
        $result = ($conn->query($sql));
        $currentTag = mysqli_fetch_assoc($result);
        if (is_array($currentTag) && is_array($_POST['tag'])) {
            foreach($_POST['tag'] as $value){
                if (!in_array($value,$currentTag)) {
                    $sql = "INSERT INTO $MyNewsTagsLink ($link__news, $link__tag)
                                     VALUES ('$name', '$value')";
                             if (!($conn->query($sql))) {
                                 $addTag = false;
                            }
                }
            }
            foreach($currentTag as $tag){
                if (!in_array($tag,$_POST['tag'])) {
                    $sql = "DELETE FROM $MyNewsTagsLink WHERE $link__news = '$name' AND $link__tag = '$tag'";
                             if (!($conn->query($sql))) {
                                 $addTag = false;
                            }
                }
            }
        } else if (is_array($_POST['tag']) && !is_array($currentTag)){
            foreach($_POST['tag'] as $value){
                $sql = "INSERT INTO $MyNewsTagsLink ($link__news, $link__tag)
                        VALUES ('$name', '$value')";
                if (!($conn->query($sql))) {
                    $addTag = false;
                }
            }
        } else if (!is_array($_POST['tag']) && is_array($currentTag)){
            $sql = "DELETE FROM $MyNewsTagsLink WHERE $link__news = '$name'";
            if (!($conn->query($sql))) {
                $addTag = false;
            }
        }
        
        if ($addTag) {
            header("Location: ../main-view/manage-news.php?updateSuccess=1");
            exit();
        }
    }
?>