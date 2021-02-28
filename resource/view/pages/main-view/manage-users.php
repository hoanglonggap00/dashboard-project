<?php 
    include '../../../../database/connect.php'; 
    require '../../../../function/function.php';
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['acc']);
        header("location: login.php");
    }
    if (!isset($_SESSION['acc']) || (!getPermission($_SESSION['acc_permission'],'addUser') && !getPermission($_SESSION['acc_permission'],'deleteUser')  && !getPermission($_SESSION['acc_permission'],'editUser')  && !getPermission($_SESSION['acc_permission'],'inspectUser') && !getPermission($_SESSION['acc_permission'],'updateUserStatus'))) {
        if (!getPermission($_SESSION['acc_permission'],'addUser') && !getPermission($_SESSION['acc_permission'],'deleteUser')  && !getPermission($_SESSION['acc_permission'],'editUser')  && !getPermission($_SESSION['acc_permission'],'inspectUser') && !getPermission($_SESSION['acc_permission'],'updateUserStatus')) {
            header("location:dashboard.php?noPermission=1");
            exit();
        }
        header("location:../error/401.php");
        exit();
    }

    if (isset($_GET['insertFail'])) {
        if ($_GET['insertFail'] == 1) {
            echo '<script type="text/javascript">alert("Error: Pls fill all the form")</script>';
        } else if ($_GET['insertFail'] == 2 ) {
            echo '<script type="text/javascript">alert("Error: User email already exists")</script>';
        } else if ($_GET['insertFail'] == 3 ){
            echo '<script type="text/javascript">alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';
        }
    } else if (isset($_GET['updateFail'])) {
        if ($_GET['updateFail'] == 1) {
            echo '<script type="text/javascript">alert("Error: File is not an image.")</script>';
        } else if ($_GET['updateFail'] == 2) {
            echo '<script type="text/javascript">alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';
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
        <title>Manage Users</title>
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
                        <h1 class="mt-4">Manage Users</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage Users</li>
                        </ol>
                        <?php 
                            $insert = getPermission($_SESSION['acc_permission'],'addUser') ?  
                                '<button type="button" class="btn btn-primary mt-5 mb-3" data-toggle="modal" data-target="#modalInsert">'
                                    .'Insert User'
                                .'</button>' : '';
                            echo $insert;
                        ?>
                        <div class="card mt-5">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Users table 
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
<?php 

$query = "SELECT * 
        FROM $MyUsers";

$result = mysqli_query($conn, $query);

$inspectTableHead = getPermission($_SESSION['acc_permission'],'inspectUser') ?  
                '<th>'
                    ."ID "
                .'</th>'
                .'<th>'
                    .'User Avatar'
                .'</th>'
                .'<th>'
                    ."User Name"
                .'</th>'
                .'<th>'
                    ."User Email"
                .'</th>'
                .'<th>'
                    ."User Password"
                .'</th>'
                .'<th>'
                    ."User Role"
                .'</th>' : '';

$editTableHead = getPermission($_SESSION['acc_permission'],'editUser') ?  
                '<th>'
                    ."Action Edit"
                .'</th>' : '';

$deleteTableHead = getPermission($_SESSION['acc_permission'],'deleteUser') ?  
                '<th>'
                    ."Action Delete"
                .'</th>' : '';

$statusTableHead = getPermission($_SESSION['acc_permission'],'updateUserStatus') ?  
                '<th>'
                    ."User Status"
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

                            if($row["user__status"] == 0) {
                                $status = "Deactive";
                                $color = "red";
                            } else {
                                $status = "Active";
                                $color = "green";
                            }
$inspectTableBody = getPermission($_SESSION['acc_permission'],'inspectRole') ?  
                '<td>'
                    .$row["id"]
                ."</td>"
                .'<td>'
                    .'<img src="'.$row['user__img'].'" class="img-custom" alt="Avatar" id="user__avatar">'
                .'</td>'  
                ."<td>"
                    .$row["user__username"]
                ."</td>"
                ."<td>"
                    .$row["user__email"]
                ."</td>"
                ."<td>"
                    .$row["user__password"]
                ."</td>"
                .'<td>'
                    .$row["user__role"]
                .'</td>' : '';

$editTableBody = getPermission($_SESSION['acc_permission'],'editUser') ?   
                '<td>'
                    .'<button type="button" class="btn btn-primary editbtn orange" data-toggle="modal" data-target="#modalModify">'
                        .'Edit'
                    .'</button>'
                .'</td>' : '';

$deleteTableBody = getPermission($_SESSION['acc_permission'],'deleteUser') ?  
                '<td>'
                    .'<button type="button" class="btn btn-primary delbtn red" data-toggle="modal" data-target="#modalDelete">'
                        .'Delete' 
                    .'</button>'
                .'</td>' : '';

$statusTableBody = getPermission($_SESSION['acc_permission'],'updateUserStatus') ?  
                '<td>'
                    .'<a href="../user/updateStatusUser.php'.'?id='.$row["id"].'" class="btn btn-primary '.$color.'"> '
                        .$status
                    .'</a>'
                .'</td>'  : '';

                                    $output.='<tr id='.$row["id"].' class="tableRow">'
                                                .$inspectTableBody
                                                .$editTableBody
                                                .$deleteTableBody
                                                .$statusTableBody                              
                                            .'</tr>';
                        }
                                            $output.= "
                                            </tbody>
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

        if(getPermission($_SESSION['acc_permission'],'addUser')) {
            $role = '';
            $query = "SELECT * 
                    FROM $MyUsersRoles ";
                    
            $result = mysqli_query($conn, $query);
            
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $role .= '<option value="'.$row["$role__name"].'">'.$row["$role__name"].'</option>';
                }
            }
            echo '<!-- Modal Insert -->
        <div class="modal fade" id="modalInsert" tabindex="-1" role="dialog" aria-labelledby="Modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Insert User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="../user/insertUser.php" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group mb-5">
                                <label for="user-name"> User Name : </label>
                                <input type="text" class="form-control" name="user-name" id="user-name">
                            </div>
                            <div class="form-group mb-5">
                                <label for="user-email"> User Email : </label>
                                <input type="text" class="form-control" name="user-email" id="user-email">
                            </div>
                            <div class="form-group mb-5">
                                <label for="user-password"> User Password : </label>
                                <input type="text" class="form-control" name="user-password" id="user-password">
                            </div>
                            <div class="form-group mb-5">
                                <label for="role"> Role : </label>
                                <select class="form-control" name="role" id="role">'
                                    .$role
                                .'</select>
                            </div>
                            <div class="form-group mb-5">
                                <label for="user-avatar"> Avatar : </label>
                                <input type="file" id="user-avatar" name="user-avatar" onchange="loadFile(event)" class="form-control border-0">
                            </div>
                            <div class="form-group mb-5">
                                <img src="#" id="demo-img" class="border-0 img-fluid d-none">
                            </div>
                            <div class="form-group mb-5">
                                <input type="submit" class="form-control btn btn-primary">
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

        if(getPermission($_SESSION['acc_permission'],'editUser')) {
        echo '<!-- Modal Modify -->
        <div class="modal fade" id="modalModify" tabindex="-1" role="dialog" aria-labelledby="Modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Edit Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="../user/updateUser.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" class="form-control" name="oldPassword" id="oldPassword">
                            <input type="hidden" class="form-control" name="oldEmail" id="oldEmail">
                            <input type="hidden" class="form-control" name="updateID" id="updateID">
                            <div class="form-group mb-5">
                                <label for="updateName"> User Name : </label>
                                <input type="text" class="form-control" name="updateName" id="updateName">
                            </div>
                            <div class="form-group mb-5">
                                <label for="updateEmail"> User Email : </label>
                                <input type="text" class="form-control" name="updateEmail" id="updateEmail">
                            </div>
                            <div class="form-group mb-5">
                                <label for="updatePassword"> User Password : </label>
                                <input type="text" class="form-control" name="updatePassword" id="updatePassword">
                            </div>
                            <div class="form-group mb-5">
                                <label for="role"> Role : </label>
                                <select class="form-control" name="role" id="role">'
                                    .$role
                                .'</select>
                            </div>
                            <div class="form-group mb-5">
                                <label for="updateAvatar"> Avatar : </label>
                                <input type="file" name="updateAvatar" class="form-control border-0">
                                <img src="#" alt="" id="updateAvatar" class="img-fluid">
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

        if(getPermission($_SESSION['acc_permission'],'deleteUser')) {
        echo '<!-- Modal Delete -->
        <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="Modal">
            <div class="modal-dialog" role="document" style="top:50%; transform:translateY(-50%);">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Delete User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="../user/deleteUser.php" method="post">
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

                $('#role > option').each(function() {
                    $(this).attr('selected', false);
                })

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() { 
                    return $(this).text();
                }).get();

                $('#updateID').val(data[0]);           
                $('#updateName').val(data[2]);
                $('#updateEmail').val(data[3]);
                $('#oldEmail').val(data[3]);
                $('#updatePassword').val(data[4]);
                $('#oldPassword').val(data[4]);
                $('#role > option').each(function() {
                    if(this.value == data[5]) {
                        $(this).attr('selected', true);
                    }
                })
                $('#updateAvatar').attr("src",$(this).closest('tr').children("td").find("img").attr("src"));
            })

            $('.delbtn').on('click', function() {
                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() { 
                    return $(this).text();
                }).get();

                $('#deleteID').val(data[0]); 
                $('#deleteName').val(data[2]);              
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
