<?php 
session_start();

if (!isset($_SESSION["userRole"]) || $_SESSION["userRole"] !== "admin") {
    header("location: ../Auth/login.php");
    exit();
}

require_once '../../Controlers/AlumniControler.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $alumni = new AlumniControler();
    
    $result = $alumni->deleteAlumni($id);

    if ($result) {
        $_SESSION['success'] = "Alumni deactivated successfully!";
    } else {
        $_SESSION['error'] = "Failed to deactivate alumni.";
    }

    header("Location: deactiveAlumni.php"); 
    exit();
}

$auth = new AlumniControler();
$alumnis = $auth->getAllAlumnis();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Deactivate Alumni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #16406d;"> 

    <?php include 'headerAdmin.php'; ?>

    <div class="container mt-5">
        <h2 class="mb-4 text-center text-white">Deactivate Alumni</h2>

        <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="font-size: 20px;">Name</th>
                        <th style="font-size: 20px;">Graduation Year</th>
                        <th style="font-size: 20px;">Status</th>
                        <th style="font-size: 20px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alumnis as $alumni): ?>
                        <tr>
                            <td><?= htmlspecialchars($alumni['name']) ?></td>
                            <td><?= htmlspecialchars($alumni['graduation_year']) ?></td>
                            <td><span class="badge bg-success fs-6">Active</span></td>
                            <td>
                                <a href="deactiveAlumni.php?id=<?= $alumni['id'] ?>" class="btn btn-danger btn-sm">Deactivate</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
