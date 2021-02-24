<?php 
    include '../../../../database/connect.php'; 
    require '../../../../function/function.php';
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['acc']);
        header("location: login.php");
    }
    if (!isset($_SESSION['acc']) || (!getPermission($_SESSION['acc_permission'],'addRole') && !getPermission($_SESSION['acc_permission'],'deleteRole')  && !getPermission($_SESSION['acc_permission'],'editRole')  && !getPermission($_SESSION['acc_permission'],'inspectRole'))) {
        if (!getPermission($_SESSION['acc_permission'],'addRole') && !getPermission($_SESSION['acc_permission'],'deleteRole')  && !getPermission($_SESSION['acc_permission'],'editRole')  && !getPermission($_SESSION['acc_permission'],'inspectRole')){
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
            echo '<script type="text/javascript">alert("Error: role name already exists")</script>';
        }
    } else if (isset($_GET['updateFail'])) {
        if ($_GET['updateFail'] == 1) {
            echo '<script type="text/javascript">alert("Error: Pls fill all the fields")</script>';
        } else if ($_GET['updateFail'] == 2) {
            echo '<script type="text/javascript">alert("Error: role name already exists")</script>';
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
        <title>Manage User Roles</title>
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
                        <h1 class="mt-4">Manage User Roles</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage User Roles</li>
                        </ol>
                        <?php 
                            $insert = getPermission($_SESSION['acc_permission'],'addRole') ?  
                                '<button type="button" class="btn btn-primary mt-5 mb-3" data-toggle="modal" data-target="#modalInsert">'
                                    .'Insert Role'
                                .'</button>' : '';
                            echo $insert;
                        ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                User Roles DataTable 
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
<?php 

$query = "SELECT * 
        FROM $MyUsersRoles";

$result = mysqli_query($conn, $query);

$inspectTableHead = getPermission($_SESSION['acc_permission'],'inspectRole') ?  
                    '<th>'
                        ."ID "
                    .'</th>'
                    .'<th>'
                        ."Role Name"
                    .'</th>'
                    .'<th>'
                        ."Role Description"
                    .'</th>' : '';

$editTableHead = getPermission($_SESSION['acc_permission'],'editRole') ?  
                '<th>'
                    ."Action Edit"
                .'</th>' : '';

$deleteTableHead = getPermission($_SESSION['acc_permission'],'deleteRole') ?  
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

$inspectTableBody = getPermission($_SESSION['acc_permission'],'inspectRole') ?  
                    '<td>'
                        .$row["$role__id"]
                    ."</td>"
                    ."<td>"
                        .$row["$role__name"]
                    .'</td>'
                    .'<td>'
                        .$row["$role__description"]
                    .'</td>'
                    .'<td style="display:none;">'
                        .permissionOutputRender($MyUsersRolesLink,$link__role,$MyUsersRoles,$role__name,$row["$role__name"])
                    .'</td>' : '';

$editTableBody = getPermission($_SESSION['acc_permission'],'editRole') ?   
                '<td>'
                    .'<button type="button" class="btn btn-primary editbtn orange" data-toggle="modal" data-target="#modalModify">'
                        .'Edit'
                    .'</button>'
                .'</td>' : '';

$deleteTableBody = getPermission($_SESSION['acc_permission'],'deleteRole') ?  
                '<td>'
                    .'<button type="button" class="btn btn-primary delbtn red" data-toggle="modal" data-target="#modalDelete">'
                        .'Delete' 
                    .'</button>'
                .'</td>' : '';

                                    $output.='<tr id='.$row["$role__id"].' class="tableRow">'
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

        if (getPermission($_SESSION['acc_permission'],'addRole')) {
        echo '<!-- Modal Insert -->
        <div class="modal fade" id="modalInsert" tabindex="-1" role="dialog" aria-labelledby="Modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Insert Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="../role/insertRoleUser.php">
                        <div class="modal-body">
                            <div class="form-group mb-5">
                                <label for="name"> Role Name : </label>
                                <input type="text" class="form-control" name="role-name">
                            </div>
                            <div class="form-group mb-5">
                                <label for="name"> Role Description : </label>
                                <input type="text" class="form-control" name="role-description">
                            </div>
                            <div class="form-group mb-5">
                                <label for="name"> Role Permissions : </label>
                                <div>
                                    <div class="listPermission">
                                        <input class="selectAll" type="checkbox" id="TitleUser" name="Title[]">
                                        <label for="TitleUser">User :</label>
                                        <ul style="list-style:none;">
                                            <li>
                                                <input type="checkbox" id="addUser" name="permission[]" value="addUser">
                                                <label for="addUser">Add User</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="deleteUser" name="permission[]" value="deleteUser">
                                                <label for="deleteUser">Delete User</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="editUser" name="permission[]" value="editUser">
                                                <label for="editUser">Edit User</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="updateUserStatus" name="permission[]" value="updateUserStatus">
                                                <label for="updateUserStatus">Update User Status</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="inspectUser" name="permission[]" value="inspectUser">
                                                <label for="inspectUser">Inspect User</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="listPermission">
                                        <input class="selectAll" type="checkbox" id="TitleProduct" name="Title[]">
                                        <label for="TitleProduct">Product :</label>
                                        <ul style="list-style:none;">
                                            <li>
                                                <input type="checkbox" id="addProduct" name="permission[]" value="addProduct">
                                                <label for="addProduct">Add Product</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="deleteProduct" name="permission[]" value="deleteProduct">
                                                <label for="deleteProduct">Delete Product</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="editProduct" name="permission[]" value="editProduct">
                                                <label for="editProduct">Edit Product</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="inspectProduct" name="permission[]" value="inspectProduct">
                                                <label for="inspectProduct">Inspect Product</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="updateUserStatus" name="permission[]" value="updateProductStatus">
                                                <label for="updateProductStatus">Update Product Status</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="listPermission">
                                        <input class="selectAll" type="checkbox" id="TitleProductCategory" name="Title[]">
                                        <label for="TitleProductCategory">Product Category :</label>
                                        <ul style="list-style:none;">
                                            <li>
                                                <input type="checkbox" id="addProductCategory" name="permission[]" value="addProductCategory">
                                                <label for="addProductCategory">Add Product Category</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="deleteProductCategory" name="permission[]" value="deleteProductCategory">
                                                <label for="deleteProductCategory">Delete Product Category</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="editProductCategory" name="permission[]" value="editProductCategory">
                                                <label for="editProductCategory">Edit Product Category</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="inspectProductCategory" name="permission[]" value="inspectProductCategory">
                                                <label for="inspectProductCategory">Inspect Product Category</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="listPermission">
                                        <input class="selectAll" type="checkbox" id="TitleProductTag" name="Title[]">
                                        <label for="TitleProductTag">Product Tag :</label>
                                        <ul style="list-style:none;">
                                            <li>
                                                <input type="checkbox" id="addProductTag" name="permission[]" value="addProductTag">
                                                <label for="addProductTag">Add Product Tag</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="deleteProductTag" name="permission[]" value="deleteProductTag">
                                                <label for="deleteProductTag">Delete Product Tag</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="editProductTag" name="permission[]" value="editProductTag">
                                                <label for="editProductTag">Edit Product Tag</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="inspectProductTag" name="permission[]" value="inspectProductTag">
                                                <label for="inspectProductTag">Inspect Product Tag</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="listPermission">
                                        <input class="selectAll" type="checkbox" id="TitleNews" name="Title[]">
                                        <label for="TitleNews">News :</label>
                                        <ul style="list-style:none;">
                                            <li>
                                                <input type="checkbox" id="addNews" name="permission[]" value="addNews">
                                                <label for="addNews">Add News</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="deleteNews" name="permission[]" value="deleteNews">
                                                <label for="deleteNews">Delete News</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="editNews" name="permission[]" value="editNews">
                                                <label for="editNews">Edit News</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="inspectNews" name="permission[]" value="inspectNews">
                                                <label for="inspectNews">Inspect News</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="updateUserStatus" name="permission[]" value="updateNewsStatus">
                                                <label for="updateNewsStatus">Update User Status</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="listPermission">
                                        <input class="selectAll" type="checkbox" id="TitleNewsCategory" name="Title[]">
                                        <label for="TitleNewsCategory">News Category :</label>
                                        <ul style="list-style:none;">
                                            <li>
                                                <input type="checkbox" id="addNewsCategory" name="permission[]" value="addNewsCategory">
                                                <label for="addNewsCategory">Add News Category</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="deleteNewsCategory" name="permission[]" value="deleteNewsCategory">
                                                <label for="deleteNewsCategory">Delete News Category</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="editNewsCategory" name="permission[]" value="editNewsCategory">
                                                <label for="editNewsCategory">Edit News Category</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="inspectNewsCategory" name="permission[]" value="inspectNewsCategory">
                                                <label for="inspectNewsCategory">Inspect News Category</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="listPermission">
                                        <input class="selectAll" type="checkbox" id="TitleNewsTag" name="Title[]">
                                        <label for="TitleNewsTag">News Tag :</label>
                                        <ul style="list-style:none;">
                                            <li>
                                                <input type="checkbox" id="addNewsTag" name="permission[]" value="addNewsTag">
                                                <label for="addNewsTag">Add News Tag</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="deleteNewsTag" name="permission[]" value="deleteNewsTag">
                                                <label for="deleteNewsTag">Delete News Tag</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="editNewsTag" name="permission[]" value="editNewsTag">
                                                <label for="editNewsTag">Edit News Tag</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="inspectNewsTag" name="permission[]" value="inspectNewsTag">
                                                <label for="inspectNewsTag">Inspect News</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="listPermission">
                                        <input class="selectAll" type="checkbox" id="TitleRole" name="Title[]">
                                        <label for="TitleRole">Role :</label>
                                        <ul style="list-style:none;">
                                            <li>
                                                <input type="checkbox" id="addRole" name="permission[]" value="addRole">
                                                <label for="addRole">Add Role</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="deleteRole" name="permission[]" value="deleteRole">
                                                <label for="deleteRole">Delete Role</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="editRole" name="permission[]" value="editRole">
                                                <label for="editRole">Edit Role</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="inspectRole" name="permission[]" value="inspectRole">
                                                <label for="inspectRole">Inspect Role</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
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

        if (getPermission($_SESSION['acc_permission'],'editRole')) {
            echo '<!-- Modal Modify -->
        <div class="modal fade" id="modalModify" tabindex="-1" role="dialog" aria-labelledby="Modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="../role/updateRoleUser.php" method="post">
                        <div class="modal-body">
                            <input type="hidden" name="oldName" id="oldName">
                            <input type="hidden" class="form-control" name="updateID" id="updateID">
                            <div class="form-group mb-5">
                                <label for="name"> Role Name : </label>
                                <input type="text" class="form-control" name="updateName" id="updateName">
                            </div>
                            <div class="form-group mb-5">
                                <label for="name"> Role Description : </label>
                                <input type="text" class="form-control" name="updateDescription" id="updateDescription">
                            </div>
                            <div class="form-group mb-5" id="listPermission">
                                <label for="name"> Role Permissions : </label>
                                <div>
                                    <div class="listPermission">
                                        <input class="selectAll" type="checkbox" id="TitleUser" name="Title[]">
                                        <label for="TitleUser">User :</label>
                                        <ul style="list-style:none;">
                                            <li>
                                                <input type="checkbox" id="addUser" name="permission[]" value="addUser">
                                                <label for="addUser">Add User</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="deleteUser" name="permission[]" value="deleteUser">
                                                <label for="deleteUser">Delete User</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="editUser" name="permission[]" value="editUser">
                                                <label for="editUser">Edit User</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="updateUserStatus" name="permission[]" value="updateUserStatus">
                                                <label for="updateUserStatus">Update User Status</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="inspectUser" name="permission[]" value="inspectUser">
                                                <label for="inspectUser">Inspect User</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="listPermission">
                                        <input class="selectAll" type="checkbox" id="TitleProduct" name="Title[]">
                                        <label for="TitleProduct">Product :</label>
                                        <ul style="list-style:none;">
                                            <li>
                                                <input type="checkbox" id="addProduct" name="permission[]" value="addProduct">
                                                <label for="addProduct">Add Product</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="deleteProduct" name="permission[]" value="deleteProduct">
                                                <label for="deleteProduct">Delete Product</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="editProduct" name="permission[]" value="editProduct">
                                                <label for="editProduct">Edit Product</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="inspectProduct" name="permission[]" value="inspectProduct">
                                                <label for="inspectProduct">Inspect Product</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="listPermission">
                                        <input class="selectAll" type="checkbox" id="TitleProductCategory" name="Title[]">
                                        <label for="TitleProductCategory">Product Category :</label>
                                        <ul style="list-style:none;">
                                            <li>
                                                <input type="checkbox" id="addProductCategory" name="permission[]" value="addProductCategory">
                                                <label for="addProductCategory">Add Product Category</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="deleteProductCategory" name="permission[]" value="deleteProductCategory">
                                                <label for="deleteProductCategory">Delete Product Category</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="editProductCategory" name="permission[]" value="editProductCategory">
                                                <label for="editProductCategory">Edit Product Category</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="inspectProductCategory" name="permission[]" value="inspectProductCategory">
                                                <label for="inspectProductCategory">Inspect Product Category</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="listPermission">
                                        <input class="selectAll" type="checkbox" id="TitleProductTag" name="Title[]">
                                        <label for="TitleProductTag">Product Tag :</label>
                                        <ul style="list-style:none;">
                                            <li>
                                                <input type="checkbox" id="addProductTag" name="permission[]" value="addProductTag">
                                                <label for="addProductTag">Add Product Tag</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="deleteProductTag" name="permission[]" value="deleteProductTag">
                                                <label for="deleteProductTag">Delete Product Tag</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="editProductTag" name="permission[]" value="editProductTag">
                                                <label for="editProductTag">Edit Product Tag</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="inspectProductTag" name="permission[]" value="inspectProductTag">
                                                <label for="inspectProductTag">Inspect Product Tag</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="listPermission">
                                        <input class="selectAll" type="checkbox" id="TitleNews" name="Title[]">
                                        <label for="TitleNews">News :</label>
                                        <ul style="list-style:none;">
                                            <li>
                                                <input type="checkbox" id="addNews" name="permission[]" value="addNews">
                                                <label for="addNews">Add News</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="deleteNews" name="permission[]" value="deleteNews">
                                                <label for="deleteNews">Delete News</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="editNews" name="permission[]" value="editNews">
                                                <label for="editNews">Edit News</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="inspectNews" name="permission[]" value="inspectNews">
                                                <label for="inspectNews">Inspect News</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="listPermission">
                                        <input class="selectAll" type="checkbox" id="TitleNewsCategory" name="Title[]">
                                        <label for="TitleNewsCategory">News Category :</label>
                                        <ul style="list-style:none;">
                                            <li>
                                                <input type="checkbox" id="addNewsCategory" name="permission[]" value="addNewsCategory">
                                                <label for="addNewsCategory">Add News Category</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="deleteNewsCategory" name="permission[]" value="deleteNewsCategory">
                                                <label for="deleteNewsCategory">Delete News Category</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="editNewsCategory" name="permission[]" value="editNewsCategory">
                                                <label for="editNewsCategory">Edit News Category</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="inspectNewsCategory" name="permission[]" value="inspectNewsCategory">
                                                <label for="inspectNewsCategory">Inspect News Category</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="listPermission">
                                        <input class="selectAll" type="checkbox" id="TitleNewsTag" name="Title[]">
                                        <label for="TitleNewsTag">News Tag :</label>
                                        <ul style="list-style:none;">
                                            <li>
                                                <input type="checkbox" id="addNewsTag" name="permission[]" value="addNewsTag">
                                                <label for="addNewsTag">Add News Tag</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="deleteNewsTag" name="permission[]" value="deleteNewsTag">
                                                <label for="deleteNewsTag">Delete News Tag</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="editNewsTag" name="permission[]" value="editNewsTag">
                                                <label for="editNewsTag">Edit News Tag</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="inspectNewsTag" name="permission[]" value="inspectNewsTag">
                                                <label for="inspectNewsTag">Inspect News</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="listPermission">
                                        <input class="selectAll" type="checkbox" id="TitleRole" name="Title[]">
                                        <label for="TitleRole">Role :</label>
                                        <ul style="list-style:none;">
                                            <li>
                                                <input type="checkbox" id="addRole" name="permission[]" value="addRole">
                                                <label for="addRole">Add Role</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="deleteRole" name="permission[]" value="deleteRole">
                                                <label for="deleteRole">Delete Role</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="editRole" name="permission[]" value="editRole">
                                                <label for="editRole">Edit Role</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
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

        if (getPermission($_SESSION['acc_permission'],'deleteRole')) {
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
                        <form action="../role/deleteRoleUser.php" method="post">
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
            
            $(".selectAll").on("click",function() {
                var checked = $(this).is(":checked") ? true : false;
                $(this).parent().find("ul li input").each(function() {
                    $(this).prop('checked', checked);
                });
            });


            $('.editbtn').on('click', function() {

                $('#listPermission div div ul li input').each(function() {
                    $(this).attr('checked', false);
                });

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function() { 
                    return $(this).text();
                }).get();

                $('#updateID').val(data[0]);           
                $('#updateName').val(data[1]);
                $('#oldName').val(data[1]);   
                $('#updateDescription').val(data[2]);
                $('#listPermission div div ul li input').each(function() {
                    if(data[3].trim().split(" ").includes(this.value)) {
                        $(this).attr('checked', true);
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
