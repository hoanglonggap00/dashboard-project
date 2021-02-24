<!doctype html>
<html lang="en">
    <head>
        <title>Register</title>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link href="../../../../public/assets/style/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
                                        <form action="verifyRegister.php" method="post">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputFirstName">First Name</label>
                                                        <input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter first name" name="registerFirstName"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputLastName">Last Name</label>
                                                        <input class="form-control py-4" id="inputLastName" type="text" placeholder="Enter last name" name="registerLastName"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input type="email" class="form-control py-4" id="inputEmailAddress" name="registerEmail" placeholder="Enter email address" aria-describedby="emailHelp">
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputPassword">Password</label>
                                                        <input type="password" class="form-control py-4" id="inputPassword" name="registerPwd" placeholder="Enter password">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">Confirm Password</label>
                                                        <input type="password" class="form-control py-4" id="inputConfirmPassword" name="registerPwdConfirm" placeholder="Confirm password">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4 mb-0">
                                                <button type="submit" class="btn btn-primary btn-block" id="btn-register-submit">Create Account</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="login.php">Have an account? Go to login</a></div>
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
        <script src="js/scripts.js"></script>

        <script> 
            $('#btn-register-submit').on("click",function(event) {
                event.preventDefault();
                var registerFirstName = $('#inputFirstName').val();
                var registerLastName = $('#inputLastName').val();
                var registerEmail = $('#inputEmailAddress').val();
                var registerPwd = $('#inputPassword').val();
                var registerPwdConfirm = $('#inputConfirmPassword').val();
                $('.alert').remove();
                $("body").append('<div class="modal__loading"><div class="lds-circle"></div></div>');
                $.ajax({
                    method: 'POST',
                    url: "verifyRegister.php",
                    data:{
                        registerFirstName: registerFirstName,
                        registerLastName: registerLastName,
                        registerEmail: registerEmail,
                        registerPwd: registerPwd,
                        registerPwdConfirm: registerPwdConfirm
                    },
                    success:function(response){
                        if (response.status == 'success') {
                            $(".modal__loading").remove();
                            location.replace("login.php?registerSuccess=1");
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