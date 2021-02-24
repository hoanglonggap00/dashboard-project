<?php 
    include '../../../../database/connect.php'; 
    require '../../../../function/function.php';
    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['acc']);
        header("location: ../authentication/login.php");
    }
    if ((!isset($_SESSION['acc'])) || (!getPermission($_SESSION['acc_permission'],'addProduct') && !getPermission($_SESSION['acc_permission'],'deleteProduct')  && !getPermission($_SESSION['acc_permission'],'editProduct')  && !getPermission($_SESSION['acc_permission'],'inspectProduct')  && !getPermission($_SESSION['acc_permission'],'updateProductStatus'))) {
        if (!getPermission($_SESSION['acc_permission'],'addProduct') && !getPermission($_SESSION['acc_permission'],'deleteProduct')  && !getPermission($_SESSION['acc_permission'],'editProduct')  && !getPermission($_SESSION['acc_permission'],'inspectProduct')  && !getPermission($_SESSION['acc_permission'],'updateProductStatus')){
            header("location:dashboard.php?noPermission=1");
            exit();
        }
        header("location:../error/401.php");
        exit();
    }

    if (isset($_GET['insertFail'])) {
        if ($_GET['insertFail'] == 1) {
            echo '<script type="text/javascript">alert("Error: Cần điền hết vào form")</script>';
        } else if ($_GET['insertFail'] == 2 ) {
            echo '<script type="text/javascript">alert("Error: File is not an image.")</script>';
        } else if ($_GET['insertFail'] == 3 ){
            echo '<script type="text/javascript">alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';
        }   else if ($_GET['insertFail'] == 4 ){
            echo '<script type="text/javascript">alert("Product name already exists")</script>';
        }
    } else if (isset($_GET['updateFail'])) {
        if ($_GET['updateFail'] == 1) {
            echo '<script type="text/javascript">alert("Error: File is not an image.")</script>';
        } else if ($_GET['updateFail'] == 2) {
            echo '<script type="text/javascript">alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';
        } else if ($_GET['updateFail'] == 3) {
            echo '<script type="text/javascript">alert("Product name already exists")</script>';
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
        <title>Manage Product</title>
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
                        <h1 class="mt-4">Manage Product</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage Product</li>
                        </ol>
                        <?php 
                            $insert = getPermission($_SESSION['acc_permission'],'addProduct') ?  
                                '<button type="button" class="btn btn-primary mt-5 mb-3" data-toggle="modal" data-target="#modalInsert">'
                                    .'Insert Product'
                                .'</button>' : '';
                            echo $insert;
                        ?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Product DataTable
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
<?php 

$status = getPermission($_SESSION['acc_permission'],'updateNewsStatus') ?  
                '' : ' WHERE '.$product__status.' = "1"';

$query = "SELECT * 
        FROM $MyProducts 
        INNER JOIN $MyProductsCategory ON $MyProducts.$product__category = $MyProductsCategory.$category__id".$status;
$result = mysqli_query($conn, $query);

$inspectTableHead = getPermission($_SESSION['acc_permission'],'inspectProduct') ?  
                '<th>'
                    ."ID "
                .'</th>'
                .'<th>'
                    .'Ảnh'
                .'</th>'
                .'<th>'
                    ."Product Name"
                .'</th>'
                .'<th>'
                    ."Product Description"
                .'</th>'
                .'<th>'
                    ."Product Content"
                .'</th>'
                .'<th>'
                    ."Product Category"
                .'</th>'
                .'<th>'
                    ."Product Tags"
                .'</th>' : '';

$editTableHead = getPermission($_SESSION['acc_permission'],'editProduct') ?  
                '<th>'
                    ."Action Edit"
                .'</th>' : '';

$deleteTableHead = getPermission($_SESSION['acc_permission'],'deleteProduct') ?  
                '<th>'
                    ."Action Delete"
                .'</th>' : '';

$statusTableHead = getPermission($_SESSION['acc_permission'],'updateProductStatus') ?  
                '<th>'
                    ."Product Status"
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

                            if($row["product__status"] == 0) {
                                $status = "Deactive";
                                $color = "red";
                            } else {
                                $status = "Active";
                                $color = "green";
                            }

$inspectTableBody = getPermission($_SESSION['acc_permission'],'inspectProduct') ?  
                '<td>'
                    .$row["$product__id"]
                ."</td>"
                .'<td>'
                    .'<img src="'.$row['product__img'].'" class="img-custom" alt="Ảnh sản phẩm" id="product__img">'
                .'</td>'
                ."<td>"
                    .$row["product__name"]
                ."</td>"
                ."<td>"
                    .$row["product__description"]
                ."</td>"
                ."<td>"
                    .$row["product__content"]
                ."</td>"
                .'<td>'
                    .$row["$category__name"]
                .'</td>'
                .'<td>'
                    .tagsOutputRender($MyProductsTagsLink,$link__product,$MyProducts,$product__name,$row["product__name"],$MyProductsTags)
                .'</td>' : '';

$editTableBody = getPermission($_SESSION['acc_permission'],'editProduct') ?  
                '<td>'
                    .'<button type="button" class="btn btn-primary editbtn orange" data-toggle="modal" data-target="#modalModify">'
                        .'Edit'
                    .'</button>'
                .'</td>' : '';

$deleteTableBody = getPermission($_SESSION['acc_permission'],'deleteProduct') ?  
                '<td>'
                    .'<button type="button" class="btn btn-primary delbtn red" data-toggle="modal" data-target="#modalDelete">'
                        .'Delete' 
                    .'</button>'
                .'</td>' : '';

$statusTableBody = getPermission($_SESSION['acc_permission'],'updateProductStatus') ?  
                '<td>'
                    .'<a href="../product/updateStatusProduct.php?id='.$row["$product__id"].'" class="btn btn-primary '.$color.'">'
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
        if (getPermission($_SESSION['acc_permission'],'addProduct')) {
        echo '<!-- Modal Insert -->
        <div class="modal fade" id="modalInsert" tabindex="-1" role="dialog" aria-labelledby="Modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Insert Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="../product/insertProduct.php" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group mb-5">
                                <label for="product-name"> Product Name : </label>
                                <input type="text" class="form-control" name="product-name" id="product-name">
                            </div>
                            <div class="form-group mb-5">
                                <label for="product-description"> Product Description : </label>
                                <input type="text" class="form-control" name="product-description" id="product-description">
                            </div>
                            <div class="form-group mb-5">
                                <label for="product-content"> Product Content : </label>
                                <input type="text" class="form-control" name="product-content" id="product-content">
                            </div>
                            <div class="form-group mb-5">
                                <label for="product-category"> Product Category : </label>
                                <select type="text" class="form-control" name="product-category" id="product-category">
                                    ';
                                    echo categoryTree($MyProductsCategory);
                                 echo '</select>
                            </div>
                            <div> Product Tags : </div>'
                            .tagsInputRender($MyProductsTags)
                            .'<div class="form-group mb-5">
                                <label for="product-img"> Img: </label>
                                <input type="file" id="product-img" name="product-img" onchange="loadFile(event)" class="form-control border-0">
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

        if (getPermission($_SESSION['acc_permission'],'editProduct')) {
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
                    <form action="../product/updateProduct.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" class="form-control" name="oldName" id="oldName">
                            <input type="hidden" class="form-control" name="updateID" id="updateID">
                            <div class="form-group mb-5">
                                <label for="updateName"> Product Name : </label>
                                <input type="text" class="form-control" name="updateName" id="updateName">
                            </div>
                            <div class="form-group mb-5">
                                <label for="updateDescription"> Product Description : </label>
                                <input type="text" class="form-control" name="updateDescription" id="updateDescription">
                            </div>
                            <div class="form-group mb-5">
                                <label for="updateContent"> Product Content : </label>
                                <input type="text" class="form-control" name="updateContent" id="updateContent">
                            </div>
                            <div class="form-group mb-5">
                                <label for="updateCategory"> Product Category : </label>
                                <select type="text" class="form-control" name="updateCategory" id="updateCategory">
                                    ';
                                    echo categoryTree($MyProductsCategory);
                                 echo '</select>
                            </div>
                            <div id="updateTag">
                                <div> Product Tags : </div>
                                '.tagsInputRender($MyProductsTags)
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

        if (getPermission($_SESSION['acc_permission'],'deleteProduct')) {
        echo '<!-- Modal Delete -->
        <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="Modal">
            <div class="modal-dialog" role="document" style="top:50%; transform:translateY(-50%);">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Delete Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="../product/deleteProduct.php" method="post">
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
                    if($(this).prop('id') == data[5]) {
                        $(this).attr('selected', true);
                    }
                })
                console.log(data[5]);
                console.log(data[6]);
                $('#updateTag input').each(function() {
                    if(data[6].trim().split(" ").includes($(this).prop('id'))) {
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
