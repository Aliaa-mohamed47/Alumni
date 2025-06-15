<?php
session_start();

require_once('../../Controlers/AuthControler.php');

$errMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['role'])) 
    {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $role = $_POST["role"];

        $controller = new AuthControler();

        if ($controller->login($email, $password, $role)) 
        {
            switch ($role) 
            {
                case 'admin':
                    header("Location: ../Admin/index.php");
                    break;
                case 'alumni':
                    header("Location: ../Alumni/index.php");
                    break;
                case 'student':
                    header("Location: ../Student/index.php");
                    break;
            }
            exit();
        } 
        else 
        {
            $errMsg = $_SESSION["errMsg"] ?? "Login failed. Please try again.";
        }
    } 
    else 
    {
        $errMsg = "Please fill all fields.";
    }
}
?>



<!doctype html>

<html
    lang="en"
    class="light-style layout-wide customizer-hide"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free"
    data-style="light">
    <head>
        <meta charset="utf-8" />
        <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <title>Login</title>

        <meta name="description" content="" />

        <!-- Favicon -->
        <link rel="shortcut icon" href="../assets/images/alumni-removebg-preview.png" type="x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />


        <link rel="shortcut icon" href="../assets/images/alumni-removebg-preview.png" type="x-icon">

        <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
        <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="../assets/css/demo.css" />

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

        <!-- Page -->
        <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />

        <!-- Helpers -->
        <script src="../assets/vendor/js/helpers.js"></script>
        <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
        <script src="../assets/js/config.js"></script>
    </head>

    <body>
        


        <div class="container-xxl" style="background-color: #16406d;">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
            <!-- Register -->
            <div class="card px-sm-6 px-0">
                <div class="card-body">
                <!-- Logo -->
                <div class="app-brand justify-content-center">
                    
                    <a class="navbar-brand" href="index.html">
                    <img src="../assets/images/alumni-removebg-preview.png" style="height: 80px; width: 80px;" alt="" />
                                <span style="color:black; font-size: 30px;">Alumni</span>
                    </a>

                </div>
                <!-- /Logo -->
                <h4 class="mb-1">Welcome! 👋</h4>
                    
                <?php
                    
                    if($errMsg!="")
                    {

                    ?>
                        <div class="alert alert-danger" role="alert"><?php echo $errMsg ?></php></div>
                    <?php

                    }  

                ?>

                <form id="formAuthentication" class="mb-6" action="login.php" method="POST">
                    <div class="mb-6">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="text"
                        class="form-control"
                        id="email"
                        name="email"
                        placeholder="Enter your email or username"
                        autofocus />
                    </div>
                    <div class="mb-6 form-password-toggle">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group input-group-merge">
                        <input
                        type="password"
                        id="password"
                        class="form-control"
                        name="password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="password" />
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                    </div><div class="mb-6">
                    <label for="role" class="form-label">Select Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">Choose role</option>
                        <option value="admin">Admin</option>
                        <option value="alumni">Alumni</option>
                        <option value="student">Student</option>
                    </select>
                    </div>

                    <div class="mb-6">
                    <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                    </div>

                    
                </form>

                <p class="text-center">
                    <span>New on our platform?</span>
                    <a href="register.php">
                    <span>Create an account</span>
                    </a>
                </p>
                
                <p class="text-center">
                    <a href="forget.php">
                    <span>Forget Password</span>
                    </a>
                </p>
                </div>
            </div>
            </div>
        </div>
        </div>
    

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
