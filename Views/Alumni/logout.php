<?php 
session_start();


if (!isset($_SESSION["userRole"])) {
    header("location: ../Auth/login.php");
    exit();
}

$allowedRole = "alumni";

if ($_SESSION["userRole"] !== $allowedRole) {
    header("location: ../Auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Logging Out</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Site Icons -->
    <!-- Site Icons -->
    <link rel="shortcut icon" href="../assets/images/alumni-removebg-preview.png" type="x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- Site CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- ALL VERSION CSS -->
    <link rel="stylesheet" href="../assets/css/versions.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/custom.css">

<!-- Modernizer for Portfolio -->
<script src="../assets/js/modernizer.js"></script>


<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJX3hTRODbG26p+I5w5XjRZYXLBb6iYhBhRzx85eptfaDtpMXuAqkhUb1/B3" crossorigin="anonymous">


    <style>
        body {
        background-color: rgba(0, 0, 0, 0.3);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        }

        .logout-box {
        background-color: #fff;
        border-radius: 10px;
        padding: 30px;
        max-width: 400px;
        box-shadow: 0 0 20px rgba(0,0,0,0.2);
        text-align: center;
        }
    </style>
    </head>
    <body>

    <div class="logout-box">
        <h4 class="mb-3">Are you sure you want to logout?</h4>
        <form method="POST" action="logout.php">
        <button type="submit" class="btn btn-danger">Yes, Logout</button>
        <a href="index.php" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>