<?php   
    include '../../../../database/connect.php'; 

    $name = $_POST["updateLink"];
    $updateId = $_POST["updateID"];
    $rank = $_POST["updateRank"];

    if(empty($_POST['updateLink']) || empty($_POST['updateRank'])) {
        header("Location: ../main-view/manage-rss_links.php?updateFail=1");
        exit();
    } else {
        $rssPatern = '/(.rss)\z/';
        if (preg_match($rssPatern, $name)) {
            $sql = "UPDATE $MyRssNews 
                    SET $rss__link='$name',
                        $rss__rank='$rank'
                    WHERE $rss__id='$updateId'";
            if ($conn->query($sql) == TRUE) {
                header("Location: ../main-view/manage-rss_links.php?updateSuccess=1");
                exit();
            }
        } else {
            header("Location: ../main-view/manage-rss_links.php?updateFail=2");
            exit();
        }
    }
?>