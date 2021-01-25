<?php
    include "connect.php";

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['acc']);
        header("location: login.php");
    }
    if (!isset($_SESSION['acc'])) {
        exit('
        <!doctype html>
            <html lang="en">
                <head>
                    <title>Dashboard</title>
                    <!-- Required meta tags -->
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                    <!-- Style CSS -->
                    <link rel="stylesheet" href="assets/style/style.css" >
                    <!-- Bootstrap CSS -->
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
                    <!-- Optional JavaScript -->
                    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                    <!-- Main JS -->
                    <!-- <script src="assets/js/main.js"></script> -->
                </head>
                <body>
                    <div class="container">
                        <div class="col home mt-5">
                            <p>Pls login to access</p>
                            <a href="login.php" class="btn btn-primary">Đăng nhập</a>
                        </div>
                    </div>
                </body>
            </html>
        ');
    } else  {

        $acc = $_SESSION['acc'];

        $sql = "SELECT user__username FROM myUsers WHERE user__email LIKE '$acc'";
        $result = mysqli_query($conn, $sql);

        $username = mysqli_fetch_assoc($result)["user__username"];

        if(isset($_GET['limit'])) {
            $limit = $_GET['limit'];
        } else {
            $limit = 5;
        }
    
        if(isset($_GET['search'])) {
            $search = $_GET['search'];
        } else {
            $search = "";
        }
    
        if (isset($_GET['page_no'])) {
            $page_no = $_GET['page_no'];
        }else{
            $page_no = 1;
        }
    
        if(isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        } else {
            $sort = "product__name ASC";
        }

        if (isset($_GET['inserFail'])) {
            if ($_GET['insertFail'] == 1) {
                echo '<script type="text/javascript">alert("Error: Cần điền hết vào form")</script>';
            } else if ($_GET['insertFail'] == 2 ) {
                echo '<script type="text/javascript">alert("Error: File is not an image.")</script>';
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

    }
?>
    <!doctype html>
    <html lang="en">
    <head>
        <title>Dashboard</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Style CSS -->
        <link rel="stylesheet" href="assets/style/style.css" >
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="col">
                <div class="my-5 d-flex justify-content-around">
                    <h3>
                        Hi, 
                        <?php echo $username ?>
                    </h3>
                    <a href="dashboard.php?logout='1'" class="btn btn-primary">Log out</a>
                </div>
                <div class="input">
                    <div class="input__box my-5">
                        <form method="post" action="insert.php" enctype="multipart/form-data">
                            <div class="form-group mb-5">
                                <label for="name"> Tên sản phẩm : </label>
                                <input type="text" class="form-control" name="product-name">
                            </div>
                            <div class="form-group mb-5">
                                <label for="description"> Mô tả sản phẩm : </label>
                                <input type="text" class="form-control" name="product-description">
                            </div>
                            <div class="form-group mb-5">
                                <label for="content"> Nội dung sản phẩm: </label>
                                <input type="text" class="form-control" name="product-content">
                            </div>
                            <div class="form-group mb-5">
                                <label for="content"> Ảnh sản phẩm: </label>
                                <input type="file" name="product-img" class="form-control border-0">
                            </div>
                            <div class="form-group mb-5">
                                <input type="submit" class="form-control btn btn-primary">
                            </div>
                        </form>
                    </div>
                    <div class="input__table table-responsive">
                        <form class="d-flex justify-content-between align-items-center" action="dashboard.php" method="GET">
                            <div class="form-group">
                                <select class="form-control" id="tableSize" name="limit">
                                    <option value="5" <?php if($limit == 5 ) {echo "selected";} ?> >5</option>
                                    <option value="10" <?php if($limit == 10 ) {echo "selected";} ?>>10</option>
                                    <option value="15" <?php if($limit == 15 ) {echo "selected";} ?>>15</option>
                                    <option value="20" <?php if($limit == 20 ) {echo "selected";} ?>>20</option>
                                    <option value="25" <?php if($limit == 25 ) {echo "selected";} ?>>25</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="searchInput" name="search" value="<?php echo$search;?>" placeholder="Nhập để tìm">
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="tableSort" name="sort">
                                    <option value="product__name ASC" <?php if($sort == "product__name ASC" ) {echo "selected";} ?>>Thứ tự từ A->Z</option>
                                    <option value="product__name DESC" <?php if($sort == "product__name DESC" ) {echo "selected";} ?>>Thứ tự từ Z->A</option>
                                    <option value="id ASC" <?php if($sort == "id ASC" ) {echo "selected";} ?>>Thứ tự ID tăng dần</option>
                                    <option value="id DESC" <?php if($sort == "id DESC" ) {echo "selected";} ?>>Thứ tự ID nhỏ dần</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="form-control btn btn-primary" value="Tìm" id="searchSubmit">
                            </div>
                        </form>
                        <div id="table-data">
                
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Modify -->
        <div class="modal fade" id="modalModify" tabindex="-1" role="dialog" aria-labelledby="Modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Modify Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="update.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" class="form-control" name="updateID" id="updateID">
                            <div class="form-group mb-5">
                                <label for="name"> Tên sản phẩm : </label>
                                <input type="text" class="form-control" name="updateName" id="updateName">
                            </div>
                            <div class="form-group mb-5">
                                <label for="description"> Mô tả sản phẩm : </label>
                                <input type="text" class="form-control" name="updateDescription" id="updateDescription">
                            </div>
                            <div class="form-group mb-5">
                                <label for="content"> Nội dung sản phẩm: </label>
                                <input type="text" class="form-control" name="updateContent" id="updateContent">
                            </div>
                            <div class="form-group mb-5">
                                <label for="content"> Ảnh sản phẩm: </label>
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
        </div>

        <!-- Modal Delete -->
        <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="Modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Delete Row</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="delete.php" method="post">
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
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- Main JS -->
        <script src="assets/js/main.js"></script>
        <script>
            $(document).ready(function(){
                function loadData(page){
                    var search = $("#searchInput").val();
                    var limit = $("select#tableSize option:checked").val();
                    var sort = $("select#tableSort option:checked").val();

                    $.ajax({
                        url  : "getData.php",
                        type : "GET",
                        cache: false,
                        data : {page_no:page, 
                                limit:limit,
                                search:search,
                                sort:sort
                        },
                        success:function(response){
                            $("#table-data").html(response);
                        }
                    });
                }
                loadData(); 

                $("select#tableSize").change(function() {
                    loadData();
                })

                $("#searchSubmit").on("click", function() {
                    loadData();
                })

        
                // Pagination code
                $(document).on("click", ".pagination li a", function(e){
                    e.preventDefault();
                    var pageId = $(this).attr("id");
                    loadData(pageId);
                });
            });
        </script>
  </body>
</html>