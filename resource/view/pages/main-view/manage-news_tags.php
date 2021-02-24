<?php 
    include '../../../../database/connect.php'; 
    require '../../../../function/function.php';
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['acc']);
        header("location: login.php");
    }
    if (!isset($_SESSION['acc']) || (!getPermission($_SESSION['acc_permission'],'addNewsTag') && !getPermission($_SESSION['acc_permission'],'deleteNewsTag')  && !getPermission($_SESSION['acc_permission'],'editNewsTag')  && !getPermission($_SESSION['acc_permission'],'inspectNewsTag'))) {
        if (!getPermission($_SESSION['acc_permission'],'addNewsTag') && !getPermission($_SESSION['acc_permission'],'deleteNewsTag')  && !getPermission($_SESSION['acc_permission'],'editNewsTag')  && !getPermission($_SESSION['acc_permission'],'inspectNewsTag')){
            header("location:dashboard.php?noPermission=1");
            exit();
        }
        header("location:../error/401.php");
        exit();
    }

    if (isset($_GET['insertFail'])) {
        if ($_GET['insertFail'] == 1) {
            echo '<script type="text/javascript">alert("Error: pls fill all the fields")</script>';
        } else if ($_GET['insertFail'] == 2 ) {
            echo '<script type="text/javascript">alert("Error: Tag name already exists")</script>';
        }
    } else if (isset($_GET['updateFail'])) {
        if ($_GET['updateFail'] == 1) {
            echo '<script type="text/javascript">alert("Error: Pls fill all the fields")</script>';
        } else if ($_GET['updateFail'] == 2) {
            echo '<script type="text/javascript">alert("Error: Tag name already exists")</script>';
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
        <title>Manage News Tag</title>
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
                        <h1 class="mt-4">Manage News Tag</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage News Tag</li>
                        </ol>
                        <?php 
                            $insert = getPermission($_SESSION['acc_permission'],'addNewsTag') ?  
                                '<button type="button" class="btn btn-primary mt-5 mb-3" data-toggle="modal" data-target="#modalInsert">'
                                    .'Insert News Tag'
                                .'</button>' : '';
                            echo $insert;
                        ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                News Tag DataTable 
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
<?php 

$query = "SELECT * 
        FROM $MyNewsTags";

$result = mysqli_query($conn, $query);

$inspectTableHead = getPermission($_SESSION['acc_permission'],'inspectNewsTag') ?  
                '<th>'
                    ."ID "
                .'</th>'
                .'<th>'
                    ."Tag Name"
                .'</th>' : '';

$editTableHead = getPermission($_SESSION['acc_permission'],'editNewsTag') ?  
                '<th>'
                    ."Action Edit"
                .'</th>' : '';

$deleteTableHead = getPermission($_SESSION['acc_permission'],'deleteNewsTag') ?  
                '<th>'
                    ."Action Delete"
                .'</th>' : '';

$output = "";

if (mysqli_num_rows($result) > 0) {
                        $output.='<table class="table" id="dataTable">'
                                    .'<thead>'
                                        .'<tr>'
                                            .$inspectTableHead
                                            .$editTableHead
                                            .$deleteTableHead
                                        .'</tr>'
                                    .'</thead>'
                                    .'<tbody>';
                        while ($row = mysqli_fetch_assoc($result)) {

$inspectTableBody = getPermission($_SESSION['acc_permission'],'inspectNewsTag') ?  
                '<td>'
                    .$row["$tag__id"]
                ."</td>"
                ."<td>"
                    .$row["$tag__name"]
                .'</td>' : '';

$editTableBody = getPermission($_SESSION['acc_permission'],'editNewsTag') ?   
                '<td>'
                    .'<button type="button" class="btn btn-primary editbtn orange" data-toggle="modal" data-target="#modalModify">'
                        .'Edit'
                    .'</button>'
                .'</td>' : '';

$deleteTableBody = getPermission($_SESSION['acc_permission'],'deleteNewsTag') ?  
                '<td>'
                    .'<button type="button" class="btn btn-primary delbtn red" data-toggle="modal" data-target="#modalDelete">'
                        .'Delete' 
                    .'</button>'
                .'</td>' : '';

                                    $output.='<tr id='.$row["id"].' class="tableRow">'
                                                .$inspectTableBody
                                                .$editTableBody
                                                .$deleteTableBody
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

        if (getPermission($_SESSION['acc_permission'],'addNewsTag')) {
        echo '<!-- Modal Insert -->
        <div class="modal fade" id="modalInsert" tabindex="-1" role="dialog" aria-labelledby="Modal">
            <div class="modal-dialog" role="document" style="top:50%; transform:translateY(-50%);">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Insert news Tag</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="../news_tags/insertNewsTags.php">
                        <div class="modal-body">
                            <div class="form-group mb-5">
                                <label for="name"> Tag Name : </label>
                                <input type="text" class="form-control" name="tag-name">
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

        if (getPermission($_SESSION['acc_permission'],'editNewsTag')) {
        echo '<!-- Modal Modify -->
        <div class="modal fade" id="modalModify" tabindex="-1" role="dialog" aria-labelledby="Modal">
            <div class="modal-dialog" role="document" style="top:50%; transform:translateY(-50%);">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="../news_tags/updateNewsTags.php" method="post">
                        <div class="modal-body">
                            <input type="hidden" name="oldName" id="oldName">
                            <input type="hidden" class="form-control" name="updateID" id="updateID">
                            <div class="form-group mb-5">
                                <label for="name">Tag Name :</label>
                                <input type="text" class="form-control" name="updateName" id="updateName">
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

        if (getPermission($_SESSION['acc_permission'],'deleteNewsTag')) {
        echo '<!-- Modal Delete -->
        <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="Modal">
            <div class="modal-dialog" role="document" style="top:50%; transform:translateY(-50%);">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="../news_tags/deleteNewsTags.php" method="post">
                            <input type="hidden" name="deleteID" id="deleteID" >
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
                $('#updateCategoryParentID > option').each(function() {
                    $(this).attr('disabled', false);
                })

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() { 
                    return $(this).text();
                }).get();

                $('#updateID').val(data[0]);           
                $('#updateName').val(data[1]);
                $('#oldName').val(data[1]);   
                $('#updateCategoryParentID > option').each(function() {
                    if($(this).prop('id') == data[1]) {
                        $(this).attr('disabled', true);
                    }
                })
            })

            $('.delbtn').on('click', function() {
                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() { 
                    return $(this).text();
                }).get();

                $('#deleteID').val(data[0]);           
            })
        </script>
    </body>
</html>
