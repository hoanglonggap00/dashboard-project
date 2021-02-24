<?php   
    include '../../../../database/connect.php'; 

    $name = $_POST["rss-link"];
    $rank = $_POST["rss-rank"];

    if(empty($_POST['rss-link'])) {
        header("Location: ../main-view/manage-rss_links.php?insertFail=1");
        exit();
    } else {
        $rssPatern = '/(.rss)\z/';
        if (preg_match($rssPatern, $name)) {
            $sql = "SELECT * FROM $MyRssNews WHERE $rss__link LIKE '$name'";
            $result = ($conn->query($sql));
            if (mysqli_num_rows($result) > 0) {
                header("Location: ../main-view/manage-rss_links.php?insertFail=2");
                exit();
            } else {
                // insert data to table 
                $sql = "INSERT INTO $MyRssNews ($rss__link,$rss__rank)
                VALUES ('$name','$rank')";
                if ($conn->query($sql) == TRUE) {
                    header("Location: ../main-view/manage-rss_links.php?insertSuccess=1");
                    exit();
                }
            }
        } else {
            header("Location: ../main-view/manage-rss_links.php?insertFail=3");
            exit();
        }
        
    }
?>