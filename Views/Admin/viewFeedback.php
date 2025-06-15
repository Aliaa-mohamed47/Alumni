<?php
session_start();

if (!isset($_SESSION["userRole"]) || $_SESSION["userRole"] !== "admin") {
    header("location: ../Auth/login.php");
    exit();
}

require_once '../../Controlers/FeedbackControler.php';

$feedbackCtrl = new FeedbackControler();
$feedbackList = $feedbackCtrl->getAllFeedback();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #16406d;">

<?php include 'headerAdmin.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4" style="color:white">Feedback List</h2>

    <?php if (count($feedbackList) === 0): ?>
        <div class="alert alert-info">No feedback available.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Feedback</th>
                        <th>Sender Name</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feedbackList as $index => $fb): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($fb['feedback']) ?></td>
                            <td><?= htmlspecialchars($fb['sender_name']) ?></td>
                            <td>
                                <span class="badge <?= $fb['role'] === 'student' ? 'bg-primary' : 'bg-success' ?>">
                                    <?= ucfirst($fb['role']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($fb['email']) ?></td>
                            <td><?= htmlspecialchars($fb['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
