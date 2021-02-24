<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Reset Password</title>
        <link href="../../../../public/assets/style/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <?php
            if (isset($_GET['emptyForm'])) {
                echo '<script type="text/javascript">alert("Error: Mời nhập đủ vào form")</script>';
            } else if (isset($_GET['pwdDiff'])) {
                echo '<script type="text/javascript">alert("Error: Password và password confirm không giống nhau")</script>';
            }
        ?>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Reset password</h3></div>
                                    <div class="card-body">
                                        <form action="updateResetPassword.php" method="post">
                                            <input type="hidden" name="account" value="<?php echo $_GET['acc']?>">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">New password</label>
                                                <input type="password" class="form-control py-4" id="newPassword" name="newPassword" placeholder="New Password">
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">New confirm password</label>
                                                <input type="password" class="form-control py-4" id="newConfirmPassword" name="newConfirmPassword" placeholder="Confirm Password">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Xác nhận</button>
                                            </div>
                                        </form>
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
    </body>
</html>