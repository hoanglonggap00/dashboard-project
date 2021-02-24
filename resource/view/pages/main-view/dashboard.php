<?php 
    include '../../../../database/connect.php'; 
    require '../../../../function/function.php';
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['acc']);
        header("location: ../authentication/login.php");
        exit();
    }
    if (!isset($_SESSION['acc'])) {
        header("location:../error/401.php");
        exit();
    }

    $acc = $_SESSION['acc'];
    $permission = $_SESSION['acc_permission'];
	$sql = "SELECT *
			FROM $MyUsers
			WHERE $user__email LIKE '$acc'";
	$result = mysqli_query($conn, $sql);
	$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="../../../../public/assets/style/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>
    <body class="sb-nav-fixed">
        <?php 
        include '../../partials/header.php';
        ?>
        <div id="layoutSidenav">
            <?php 
            include '../../partials/layoutSideNav.php';
            ?>
            <div id="layoutSidenav_content">
                <main>
                    <?php 
                    if (isset($_GET['noPermission'])) {
                        echo '<div class="alert alert-danger alert-dismissible fade show text-center w-25 position-absolute">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Danger!</strong> You do not have permission to access to the page.
                            </div>';
                    }
                    ?>
                    <div class="container-fluid">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body text-center">
                                        <i class="far fa-user"></i>
                                        <?php 
                                            $sql = "SELECT COUNT($user__id) FROM MyUsers WHERE $user__status = '1'";
                                            $result = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<div>'.$row["COUNT($user__id)"].'</div>';
                                                } 
                                            }
                                        ?>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="manage-users.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body text-center">
                                        <i class="fas fa-atom"></i>
                                        <?php 
                                            $sql = "SELECT COUNT($product__id) FROM MyProducts WHERE $product__status = '1'";
                                            $result = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<div>'.$row["COUNT($product__id)"].'</div>';
                                                } 
                                            }
                                        ?>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="manage-products.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body text-center">
                                        <i class="fas fa-newspaper"></i>
                                        <?php 
                                            $sql = "SELECT COUNT($news__id) FROM MyNews WHERE $news__status = '1'";
                                            $result = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<div>'.$row["COUNT($news__id)"].'</div>';
                                                } 
                                            }
                                        ?>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="manage-news.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="rssOutput">
                            <div class="heading-block border-bottom-0 text-center pt-4 mb-3">
                                <h3>RSS NEWS</h3>
                            </div>
                        <?php

                        $sql = "SELECT * FROM $MyRssNews WHERE $rss__status = '1' ORDER BY $rss__rank ASC";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $xml = $row[$rss__link];
                                $xmlDoc = new DOMDocument();
                                $xmlDoc->load($xml);

                                //get elements from "<channel>"
                                $channel=$xmlDoc->getElementsByTagName('channel')->item(0);
                                $channel_generator = $channel->getElementsByTagName('generator')
                                ->item(0)->childNodes->item(0)->nodeValue;
                                $channel_link = $channel->getElementsByTagName('link')
                                ->item(0)->childNodes->item(0)->nodeValue;
                                $channel_desc = $channel->getElementsByTagName('description')
                                ->item(0)->childNodes->item(0)->nodeValue;

                                echo(" <div class='row grid-container infinity-wrapper clearfix align-align-items-start has-init-isotope'>");

                                //get and output "<item>" elements
                                $x=$xmlDoc->getElementsByTagName('item');
                                for ($i=0; $i<3*2; $i++) {
                                $item_title=$x->item($i)->getElementsByTagName('title')
                                ->item(0)->childNodes->item(0)->nodeValue;
                                $item_link=$x->item($i)->getElementsByTagName('link')
                                ->item(0)->childNodes->item(0)->nodeValue;
                                $item_desc=$x->item($i)->getElementsByTagName('description')
                                ->item(0)->childNodes->item(0)->nodeValue;
                                $item_time=$x->item($i)->getElementsByTagName('pubDate')
                                ->item(0)->childNodes->item(0)->nodeValue;
                                $img = '';
                                $content = '';
                                $time = '';
                                preg_match('/, (.*) /', $item_time, $time);
                                preg_match('/<img(.*)" >/', $item_desc, $img);
                                preg_match('/<\/br>(.*)/', $item_desc, $content);
                                $myDateTime = DateTime::createFromFormat('d M Y H:i:s', $time[1]);
                                $newDateString = $myDateTime->format('d/m/Y H:i:s');
                                ($newDateString);
                                //   echo ( "</p>");

                                echo '<div class="col-md-6 col-lg-4 p-3"">
                                        <div class="entry mb-1 clearfix">
                                            <div class="entry-image mb-3">
                                                <a href="'.$item_link.'" data-lightbox="image">
                                                    <img '.$img[1].'" style="display:block;" class="img-fluid"/>
                                                </a>
                                            </div>
                                            <div class="entry-title">
                                                <h3><a href="'.$item_link.'" target="_blank">'.$item_title.'</a></h3>
                                            </div>
                                            <div class="entry-content">
                                                '.$content[0].'
                                            </div>
                                            <div class="entry-meta no-separator nohover">
                                                <ul class="justify-content-between mx-0 p-0">
                                                    <li><i class="icon-calendar2"></i>'.$newDateString.'</li>
                                                    <li>'.$channel_generator.'</li>
                                                </ul>
                                            </div>
                                            <div class="entry-meta no-separator hover">
                                                <ul class="mx-0  p-0">
                                                    <li><a href="'.$item_link.'" target="_blank">Xem →</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>';
                                }
                                echo '</div>';
                            }
                        }

?>
                        </div>
                    </div>
                </main>
                <?php 
                include '../../partials/footer.php';
                ?>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../../../../public/assets/js/main.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="../../../../public/assets/demo/chart-area-demo.js"></script>
        <script src="../../../../public/assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="../../../../public/assets/demo/datatables-demo.js"></script>

        <script>
            $('.alert').alert();
        </script>
    </body>
</html>
