<?php
session_start();

if (!isset($_SESSION["userRole"])) {
    header("location: ../Auth/login.php");
    exit();
}

$allowedRole = "admin";

if ($_SESSION["userRole"] !== $allowedRole) {
    header("location: ../Auth/login.php");
    exit();
}

require_once '../../Controlers/AlumniControler.php';
require_once '../../Controlers/DBControler.php';

$successMessage = '';
$errorMessage = '';

// جلب بيانات الخريجين من قاعدة البيانات
$db = new DBControler();
$alumniList = [];
if ($db->openConnection()) {
    $conn = $db->getConnection();
    $query = "SELECT id, name, rating FROM alumnis";  // استعلام لجلب اسم الخريج والتقييم
    $result = mysqli_query($conn, $query);

    if ($result) {
        $alumniList = mysqli_fetch_all($result, MYSQLI_ASSOC);  // تخزين الخريجين في مصفوفة
    } else {
        $errorMessage = "Error fetching alumni data.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jobTitle = $_POST['jobTitle'];
    $company = $_POST['company'];
    $location = $_POST['location'];
    $jobType = $_POST['jobType'];
    $description = $_POST['description'];
    $applyLink = $_POST['applyLink'];
    $_SESSION['adminId'] = 1;

    $alumniId = $_POST['alumniId'];
    $adminId = $_SESSION['adminId'];

    // تحقق هل الـ alumniId موجود
    if ($db->openConnection()) {
        $conn = $db->getConnection();
        $checkStmt = mysqli_prepare($conn, "SELECT * FROM alumnis WHERE id = ?");
        mysqli_stmt_bind_param($checkStmt, "i", $alumniId);
        mysqli_stmt_execute($checkStmt);
        $result = mysqli_stmt_get_result($checkStmt);

        if (mysqli_num_rows($result) === 0) {
            $errorMessage = "Alumni not found.";
        } else {
            // أضف الوظيفة لو الخريج موجود
            $alumni = new AlumniControler();
            $result = $alumni->sendJobs($jobTitle, $company, $location, $jobType, $description, $applyLink, $alumniId, $adminId);

            if ($result) {
                $successMessage = "Job opportunity sent successfully!";

                // إرسال إشعار للخريج
                $message = "New job posted for you: $jobTitle at $company";  // نص الإشعار

                // إدخال الإشعار في جدول notifications
                $insertNotifStmt = mysqli_prepare($conn, "INSERT INTO notifications (alumni_id, message) VALUES (?, ?)");
                mysqli_stmt_bind_param($insertNotifStmt, "is", $alumniId, $message);  // ربط الإشعار بالخريج باستخدام alumni_id
                mysqli_stmt_execute($insertNotifStmt);

                if (mysqli_stmt_affected_rows($insertNotifStmt) > 0) {
                    // تم إضافة الإشعار بنجاح
                } else {
                    $errorMessage = "Failed to send notification.";
                }
            } else {
                $errorMessage = $_SESSION['errMsg'] ?? "An error occurred.";
            }
        }
    } else {
        $errorMessage = "Database connection failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Opportunities</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #16406d;">

    <?php include 'headerAdmin.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4" style="color: white;">Send Job Opportunities</h2>

        <?php if (!empty($successMessage)) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $successMessage ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (!empty($errorMessage)) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $errorMessage ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="jobTitle" class="form-label" style="color: white;">Job Title:</label>
                <input type="text" class="form-control" id="jobTitle" name="jobTitle" placeholder="ex: Frontend Developer" required>
            </div>

            <div class="mb-3">
                <label for="company" class="form-label" style="color: white;">Company Name:</label>
                <input type="text" class="form-control" id="company" name="company" placeholder="ex: Google" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label" style="color: white;">Location:</label>
                <input type="text" class="form-control" id="location" name="location" placeholder="ex: Cairo, Egypt" required>
            </div>

            <div class="mb-3">
                <label for="jobType" class="form-label" style="color: white;">Job Type:</label>
                <select class="form-select" id="jobType" name="jobType" required>
                    <option selected disabled>Select Type</option>
                    <option value="fulltime">Full-time</option>
                    <option value="parttime">Part-time</option>
                    <option value="internship">Internship</option>
                    <option value="remote">Remote</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label" style="color: white;">Job Description:</label>
                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Details about the job..." required></textarea>
            </div>

            <div class="mb-3">
                <label for="applyLink" class="form-label" style="color: white;">Application Link or Email:</label>
                <input type="text" class="form-control" id="applyLink" name="applyLink" placeholder="ex: careers@company.com or https://..." required>
            </div>

            <div class="mb-3">
                <label for="alumniId" class="form-label" style="color: white;">Select Alumni:</label>
                <select class="form-select" id="alumniId" name="alumniId" required>
                    <option selected disabled>Select Alumni</option>
                    <?php if (isset($alumniList)) : ?>
                        <?php foreach ($alumniList as $alumni) : ?>
                            <option value="<?= $alumni['id'] ?>"><?= $alumni['name'] ?> - <?= $alumni['rating'] ?>/5</option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Send Opportunity</button>
            </div>
        </form>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
