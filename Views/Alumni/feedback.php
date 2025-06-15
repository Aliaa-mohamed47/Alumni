<?php
session_start();
require_once '../../Controlers/FeedbackControler.php';
require_once '../../Controlers/UserControler.php';

$successMessage = '';
$errorMessage = '';

if (!isset($_SESSION["userRole"]) || $_SESSION["userRole"] !== "alumni") {
    header("Location: ../Auth/login.php");
    exit();
}

$userId = $_SESSION["userId"];
$userRole = $_SESSION["userRole"];
$userName = $_SESSION["userName"];

$userControler = new UserControler();
$userProfile = $userControler->getUserProfile($userId, $userRole);
$userEmail = $userProfile['email'] ?? '';
$feedbackControler = new FeedbackControler();
if (empty($userEmail)) {
    $errorMessage = "Email not found for user!";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $message = trim($_POST["message"]);

    if (empty($message)) {
        $errorMessage = "Feedback message is required!";
    } else {
        $feedbackSuccess = $feedbackControler->sendFeedback($userId, $userRole, $message, $userEmail);

        if ($feedbackSuccess) {
            $successMessage = "Feedback submitted successfully!";
        } else {
            $errorMessage = "Error submitting feedback!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Send Feedback</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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

</head>
<body style="background-color: #16406d;">

<?php include 'headerAlumni.php'; ?>
<br>
<?php if (!empty($errorMessage)) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="text-align: center;">
        <?= $errorMessage ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif (!empty($successMessage)) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="text-align: center;">
        <?= $successMessage ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg rounded-4">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Send Feedback</h2>
                    <form method="POST" action="feedback.php">
                        <input type="hidden" name="user_type" value="alumni">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($userName) ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($userEmail) ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Your Feedback</label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Write your feedback here..." required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">Submit Feedback</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
