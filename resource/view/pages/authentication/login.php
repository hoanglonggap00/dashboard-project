<?php 
    include '../../../../database/connect.php'; 
    if (isset($_SESSION['acc'])) { 
        header("Location:../main-view/dashboard.php");
        exit();                   
    }
?>
<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <link href="../../../../public/assets/style/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form action="verifyLogin.php" method="post">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input type="email" class="form-control py-4" id="inputEmailAddress" name="loginAcc" placeholder="Enter email address" value="<?php if(isset($_COOKIE["cookie__email"])) { echo $_COOKIE["cookie__email"]; } ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input type="password" class="form-control py-4" id="inputPassword" name="loginPwd" placeholder="Enter password" value="<?php if(isset($_COOKIE["cookie__password"])) { echo $_COOKIE["cookie__password"]; } ?>">
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" <?php if(isset($_COOKIE["cookie__email"])) { echo "checked";} ?> id="rememberPasswordCheck" name="remember">
                                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="forgetPassword.php">Forgot Password?</a>
                                                <button type="submit" id="btn-login-submit" class="btn btn-primary">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <?php 
            if (isset($_GET['changeSuccess'])) {
                echo '<script type="text/javascript">alert("Reset mật khẩu thành công")</script>';
            } else if (isset($_GET['registerSuccess'])) {
                echo '<script type="text/javascript">alert("Tạo tài khoản thành công mời check email để active tài khoản ")</script>';
            } else if (isset($_GET['emailSent'])) {
                echo '<script type="text/javascript">alert("Check email để lấy link reset mật khẩu ")</script>';
            } else if (isset($_GET['activeAccount'])) {
                echo '<script type="text/javascript">alert("Tài khoản đã được active ")</script>';
            }
        ?>

        <script> 
            $('#btn-login-submit').on("click",function(event) {
                event.preventDefault();
                var loginAcc = $('#inputEmailAddress').val();
                var loginPwd = $('#inputPassword').val();
                var remember = $('#rememberPasswordCheck').val();
                $('.alert').remove();
                $("body").append('<div class="modal__loading"><div class="lds-circle"></div></div>');
                $.ajax({
                    method: 'POST',
                    url: "verifyLogin.php",
                    data:{
                        loginAcc: loginAcc,
                        loginPwd: loginPwd,
                        remember: remember
                    },
                    success:function(response){
                        if (response.status == 'success') {
                            $(".modal__loading").remove();
                            location.replace("../main-view/dashboard.php");
                        } else {
                            $(".card-header").prepend('<p class="alert red text-center">'+response.message+'</p>');
                            $(".modal__loading").remove();
                        }
                    }
                })
            })
        </script>
    </body>
</html>