<?php   
    include '../../../../database/connect.php'; 

    $name = $_POST["updateName"];
    $updateId = $_POST["updateID"];
    $oldName = $_POST["oldName"];

    //check change product name 
    if ($name !== $oldName) {
        // check exists product 
        $sql = "SELECT * FROM $MyNewsTags WHERE $tag__name LIKE '$name'";
        $result = ($conn->query($sql));
        if (mysqli_num_rows($result) > 0) {
            header("Location: ../main-view/manage-news_tags.php?updateFail=2");
            exit();
        } 
    }

    if(empty($_POST['updateName'])) {
        header("Location: ../main-view/manage-news_tags.php?updateFail=1");
        exit();
    } else {
        $sql = "UPDATE $MyNewsTags 
                SET $tag__name='$name'
                WHERE $tag__id='$updateId'";
        if ($conn->query($sql) == TRUE) {
            $sql = "UPDATE $MyNewsTagsLink 
                    SET $link__tag = '$name' 
                    WHERE $link__tag = '$oldName'";
            if ($conn->query($sql) == TRUE) {
                header("Location: ../main-view/manage-news_tags.php?updateSuccess=1");
                exit();
            }
        }
    }
?>