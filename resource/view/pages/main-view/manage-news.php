<?php 
    include '../../../../database/connect.php'; 
    require '../../../../function/function.php';
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['acc']);
        header("location: ../authentication/login.php");
    }
    if (!isset($_SESSION['acc']) || (!getPermission($_SESSION['acc_permission'],'addNews') && !getPermission($_SESSION['acc_permission'],'deleteNews')  && !getPermission($_SESSION['acc_permission'],'editNews')  && !getPermission($_SESSION['acc_permission'],'inspectNews'))) {
        if (!getPermission($_SESSION['acc_permission'],'addNews') && !getPermission($_SESSION['acc_permission'],'deleteNews')  && !getPermission($_SESSION['acc_permission'],'editNews')  && !getPermission($_SESSION['acc_permission'],'inspectNews')){
            header("location:dashboard.php?noPermission=1");
            exit();
        }
        header("location:../error/401.php");
        exit();
    }

    // || !getPermission($_SESSION['acc_permission'],'editNews')


    if (isset($_GET['insertFail'])) {
        if ($_GET['insertFail'] == 1) {
            echo '<script type="text/javascript">alert("Error: Cần điền hết vào form")</script>';
        } else if ($_GET['insertFail'] == 2 ) {
            echo '<script type="text/javascript">alert("Error: File is not an image.")</script>';
        } else if ($_GET['insertFail'] == 3 ){
            echo '<script type="text/javascript">alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';
        } else if ($_GET['insertFail'] == 4 ){
            echo '<script type="text/javascript">alert("News name already exists")</script>';
        }
    } else if (isset($_GET['updateFail'])) {
        if ($_GET['updateFail'] == 1) {
            echo '<script type="text/javascript">alert("Error: File is not an image.")</script>';
        } else if ($_GET['updateFail'] == 2) {
            echo '<script type="text/javascript">alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';
        } else if ($_GET['updateFail'] == 3) {
            echo '<script type="text/javascript">alert("News name already exists")</script>';
        }
    } else if (isset($_GET['insertSuccess'])) {
        echo '<script type="text/javascript">alert("Insert success")</script>';
    } else if (isset($_GET['updateSuccess'])) {
        echo '<script type="text/javascript">alert("Update success")</script>';
    } else if (isset($_GET['deleteSuccess'])) {
        echo '<script type="text/javascript">alert("Delete success")</script>';
    } 

    $acc = $_SESSION['acc'];
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
        <title>Manage News</title>
        <link href="../../../../public/assets/style/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
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
                    <div class="container-fluid">
                        <h1 class="mt-4">Manage News</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage News</li>
                        </ol>
                        <?php 
                            $insert = getPermission($_SESSION['acc_permission'],'addNews') ?  
                                '<button type="button" class="btn btn-primary mt-5 mb-3" data-toggle="modal" data-target="#modalInsert">'
                                    .'Insert News'
                                .'</button>' : '';
                            echo $insert;
                        ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                News DataTable
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
<?php 

$status = getPermission($_SESSION['acc_permission'],'updateNewsStatus') ?  
                '' : ' WHERE '.$news__status.' = "1"';

$query = "SELECT * 
        FROM $MyNews
        INNER JOIN $MyNewsCategory ON $MyNews.$news__category = $MyNewsCategory.$category__id".$status;

$result = mysqli_query($conn, $query);

$inspectTableHead = getPermission($_SESSION['acc_permission'],'inspectNews') ?  
                '<th>'
                    ."ID "
                .'</th>'
                .'<th>'
                    .'News Img'
                .'</th>'
                .'<th>'
                    ."News Name"
                .'</th>'
                .'<th>'
                    ."News Description"
                .'</th>'
                .'<th>'
                    ."News Content"
                .'</th>'
                .'<th>'
                    ."News Category"
                .'</th>'
                .'<th>'
                    ."News Tags"
                .'</th>' : '';

$editTableHead = getPermission($_SESSION['acc_permission'],'editNews') ?  
                '<th>'
                    ."Action Edit"
                .'</th>' : '';

$deleteTableHead = getPermission($_SESSION['acc_permission'],'deleteNews') ?  
                '<th>'
                    ."Action Delete"
                .'</th>' : '';

$statusTableHead = getPermission($_SESSION['acc_permission'],'updateNewsStatus') ?  
                '<th>'
                    ."News Status"
                .'</th>' : '';

$output = "";

if (mysqli_num_rows($result) > 0) {
                        $output.='<table class="table" id="dataTable">'
                                    .'<thead>'
                                        .'<tr>'
                                            .$inspectTableHead 
                                            .$editTableHead
                                            .$deleteTableHead
                                            .$statusTableHead
                                        .'</tr>'
                                    .'</thead>'
                                    .'<tbody>';
                        while ($row = mysqli_fetch_assoc($result)) {

                            if($row["news__status"] == 0) {
                                $status = "Deactive";
                                $color = "red";
                            } else {
                                $status = "Active";
                                $color = "green";
                            }

$inspectTableBody = getPermission($_SESSION['acc_permission'],'inspectNews') ?  
                '<td>'
                    .$row["$news__id"]
                ."</td>"
                .'<td>
                    <img src="'.$row['news__img'].'" class="img-custom" alt="Ảnh sản phẩm" id="news__img">'
                .'</td>'
                .'<td>'
                    .$row["news__name"]
                ."</td>"
                ."<td>"
                    .$row["news__description"]
                ."</td>"
                ."<td>"
                    .$row["news__content"]
                ."</td>"
                .'<td>'
                    .$row["$category__name"]
                .'</td>'
                .'<td>'
                    .tagsOutputRender($MyNewsTagsLink,$link__news,$MyNews,$news__name,$row["news__name"],$MyNewsTags)
                .'</td>' : '';

$editTableBody = getPermission($_SESSION['acc_permission'],'editNews') ?  
                '<td>'
                    .'<button type="button" class="btn btn-primary editbtn orange" data-toggle="modal" data-target="#modalModify">'
                        .'Edit'
                    .'</button>'
                .'</td>' : '';

$deleteTableBody = getPermission($_SESSION['acc_permission'],'deleteNews') ?  
                '<td>'
                    .'<button type="button" class="btn btn-primary delbtn red" data-toggle="modal" data-target="#modalDelete">'
                        .'Delete' 
                    .'</button>'
                .'</td>' : '';

$statusTableBody = getPermission($_SESSION['acc_permission'],'updateNewsStatus') ?  
                '<td>'
                    .'<a href="../news/updateStatusNews.php?id='.$row["$news__id"].'" class="btn btn-primary '.$color.'">'
                        .$status
                    .'</a>'
                .'</td>' : '';

                                    $output.='<tr id='.$row["id"].' class="tableRow">'
                                                .$inspectTableBody
                                                .$editTableBody
                                                .$deleteTableBody
                                                .$statusTableBody
                                            .'</tr>';
                                    } 
                                $output.="</tbody>
                                    </table>";

echo $output;
}

?>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <?php 
                include '../../partials/footer.php';
                ?>
            </div>
        </div>
        <?php
        if (getPermission($_SESSION['acc_permission'],'addNews')) {
        echo '<!-- Modal Insert -->
        <div class="modal fade" id="modalInsert" tabindex="-1" role="dialog" aria-labelledby="Modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Insert News</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="../news/insertNews.php" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group mb-5">
                                <label for="news-name"> News Name : </label>
                                <input type="text" class="form-control" name="news-name" id="news-name">
                            </div>
                            <div class="form-group mb-5">
                                <label for="news-description"> News Description : </label>
                                <input type="text" class="form-control" name="news-description" id="news-description">
                            </div>
                            <div class="form-group mb-5">
                                <label for="news-content"> News Content : </label>
                                <input type="text" class="form-control" name="news-content" id="news-content">
                            </div>
                            <div class="form-group mb-5">
                                <label for="news-category"> News Category : </label>
                                <select type="text" class="form-control" name="news-category" id="news-category">'
                                ;
                                echo categoryTree($MyNewsCategory);
                             echo '</select>
                            </div>
                            <div> News Tags : </div>'
                            .tagsInputRender($MyNewsTags)
                            .'</div>
                            <div class="form-group mb-5">
                                <label for="content"> Img: </label>
                                <input type="file" name="news-img" onchange="loadFile(event)" class="form-control border-0">
                            </div>
                            <div class="form-group mb-5">
                                <img src="#" id="demo-img" class="border-0 img-fluid d-none">
                            </div>
                            <div class="form-group mb-5">
                                <input type="submit" class="form-control btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>';
        }

        if (getPermission($_SESSION['acc_permission'],'editNews')) {
        echo '<!-- Modal Modify -->
        <div class="modal fade" id="modalModify" tabindex="-1" role="dialog" aria-labelledby="Modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Edit News</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="../news/updateNews.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" class="form-control" name="oldName" id="oldName">
                            <input type="hidden" class="form-control" name="updateID" id="updateID">
                            <div class="form-group mb-5">
                                <label for="updateName"> News Name : </label>
                                <input type="text" class="form-control" name="updateName" id="updateName">
                            </div>
                            <div class="form-group mb-5">
                                <label for="updateDescription"> News Description : </label>
                                <input type="text" class="form-control" name="updateDescription" id="updateDescription">
                            </div>
                            <div class="form-group mb-5">
                                <label for="updateContent"> News Content : </label>
                                <input type="text" class="form-control" name="updateContent" id="updateContent">
                            </div>
                            <div class="form-group mb-5">
                                <label for="updateCategory"> News Category : </label>
                                <select type="text" class="form-control" name="updateCategory" id="updateCategory">'
                                ;
                                echo categoryTree($MyNewsCategory);
                             echo '</select>
                            </div>
                            <div id="updateTag">
                                <div> News Tags : </div>'
                                .tagsInputRender($MyNewsTags)
                            .'</div>
                            <div class="form-group mb-5">
                                <label for="content"> Img: </label>
                                <input type="file" name="updateImg" class="form-control border-0">
                                <img src="#" alt="" id="updateImg" class="img-fluid">
                            </div>
                            <div class="form-group mb-5">
                                <input type="submit" class="form-control btn btn-primary" id="editSubmit" value="Update">
                            </div>
                            <div class="form-group mb-5">
                                <button type="button" class="close btn btn-primary form-control" data-dismiss="modal" aria-label="Close">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>';
        }

        if (getPermission($_SESSION['acc_permission'],'deleteNews')) {
        echo '<!-- Modal Delete -->
        <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="Modal">
            <div class="modal-dialog" role="document" style="top:50%; transform:translateY(-50%);">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Delete News</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="../news/deleteNews.php" method="post">
                            <input type="hidden" name="deleteID" id="deleteID" >
                            <input type="hidden" name="deleteName" id="deleteName" >
                            <div class="form-group mb-5">
                                <input type="submit" value="Delete" class="form-control btn btn-primary">
                            </div>
                        </form>
                        <button type="button" class="close btn btn-primary form-control" data-dismiss="modal" aria-label="Close">
                                Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>';
        } 

        ?>

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
            $('.editbtn').on('click', function() {

                $('#updateCategory > option').each(function() {
                    $(this).attr('selected', false);
                })

                $('#updateTag input').each(function() {
                    $(this).attr('checked', false);
                })

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() { 
                    return $(this).text();
                }).get();

                $('#updateID').val(data[0]);           
                $('#updateName').val(data[2]);
                $('#oldName').val(data[2]);   
                $('#updateDescription').val(data[3]);
                $('#updateContent').val(data[4]);
                $('#updateCategory > option').each(function() {
                    if($(this).prop('id') == data[5].trim()) {
                        $(this).attr('selected', true);
                    }
                })
                $('#updateTag input').each(function() {
                    if(data[6].trim().split(" ").includes($(this).prop('id').trim())) {
                        $(this).attr('checked', true);
                    }
                })
                $('#updateImg').attr("src",$(this).closest('tr').children("td").find("img").attr("src"));
            })

            $('.delbtn').on('click', function() {
                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() { 
                    return $(this).text();
                }).get();

                $('#deleteID').val(data[0]); 
                $('#deleteName').val(data[1]);              
            })
        </script>
        <script>
			function loadFile(event) {
                $('#demo-img').addClass('d-block');
                var selectedFile = event.target.files[0];
                var reader = new FileReader();
				
                var imgtag = document.getElementById("demo-img");
                imgtag.title = selectedFile.name;

                reader.onload = function(event) {
                    imgtag.src = event.target.result;
                };

                reader.readAsDataURL(selectedFile);
			};
		</script>
    </body>
</html>
