<?php include("../connections/connection.php"); ?>
<?php include("../connections/functions.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - LMS</title>
    <link rel="stylesheet" href="../assets/css/main/app.css">
    <link rel="stylesheet" href="../assets/css/pages/auth.css">
    <link rel="shortcut icon" href="../assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/images/logo/favicon.png" type="image/png">
</head>

<body>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.html"><img src="../assets/images/logo/logo.svg" alt="Logo"></a>
                    </div>

                    <?php
                    if (@$_GET['status'] == 1) {
                        echo "<div class='row'><div class='col-md-12 btn btn-success mb-4'>You can now login to your account!</div></div>";
                    }
                    $reg = @$_POST['reg'];
                    if ($reg) {
                        $email = security_check(@$_POST['email']);
                        $username = security_check(@$_POST['username']);
                        $password = security_check(@$_POST['password']);
                        $re_pass = security_check(@$_POST['re-pass']);
                        $user_type = security_check(@$_POST['user_type']);
                        $ip = getenv("REMOTE_ADDR");
                        Register($user_type, $username, $password, $re_pass, $conn, $email, $ip);
                    }
                    ?>
                    <h1 class="auth-title">Sign Up</h1>
                    <p class="auth-subtitle mb-5">Input your data to register to our website.</p>

                    <form method="POST" action="./register.php">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input name="email" type="text" class="form-control form-control-xl" placeholder="Email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="username" class="form-control form-control-xl" placeholder="Username">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" class="form-control form-control-xl" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="re-pass" class="form-control form-control-xl" placeholder="Confirm Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <select name="user_type" class="form-control form-control-xl">
                                <option value="">Select User Type ...</option>
                                <option value="Operation Manager">Operation Manager</option>
                                <option value="Lawyer">Lawyer</option>
                                <option value="Bank">Bank</option>
                            </select>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <input value="Sign Up" type="submit" name="reg" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Already have an account? <a href="login.php" class="font-bold">Log
                                in</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>

    </div>
</body>

</html>