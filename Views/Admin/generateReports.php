<?php
session_start();

if (!isset($_SESSION["userRole"]) || $_SESSION["userRole"] !== "admin") {
    header("location: ../Auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['reportType'], $_POST['format'])) {
        $_SESSION['error'] = 'Missing parameters. Please fill in all the fields.';
        header("Location: generateReports.php");
        exit();
    }

    $reportType = $_POST['reportType'];
    $format = $_POST['format'];

    require_once '../../Controlers/DBControler.php';
    require_once '../../Controlers/ReportsControler.php';

    $reportController = new ReportsControler();

    $response = $reportController->generateReports($reportType, $format);

    if ($response) {
        $_SESSION['success'] = 'Report generated successfully!';
    } else {
        $_SESSION['error'] = 'Failed to generate report.';
    }
    header("Location: generateReports.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/images/alumni-removebg-preview.png" type="x-icon">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body style="background-color: #16406d;">

<?php include 'headerAdmin.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center" style="color: white; font-size: 30px;">Generate Reports</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form action="generateReports.php" method="POST">
        <div class="mb-3">
            <label for="reportType" class="form-label" style="color: white;">Select Report Type:</label>
            <select class="form-select" id="reportType" name="reportType" required>
                <option selected disabled value="">Choose...</option>
                <option value="alumni">Alumni List</option>
                <option value="events">Events Summary</option>
                <option value="students">Students List</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="format" class="form-label" style="color: white;">Select Format:</label>
            <select class="form-select" id="format" name="format" required>
                <option selected disabled value="">Choose...</option>
                <option value="pdf">PDF</option>
            </select>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-success">Generate</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
