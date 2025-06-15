<?php 
session_start();
require_once '../../Controlers/AlumniControler.php';
require_once '../../Controlers/DBControler.php';

$alumni = new AlumniControler();

if (!isset($_SESSION["userRole"])) {
    header("location: ../Auth/login.php");
    exit();
}

$allowedRole = "student";

if ($_SESSION["userRole"] !== $allowedRole) {
    header("location: ../Auth/login.php");
    exit();
}

$successMessage = $errorMessage = "";

$alumnis = $alumni->getAllAlumnis();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $alumniId = intval($_POST["alumniId"]);
    $rating = intval($_POST["rating"]);

    if ($alumniId > 0 && $rating >= 1 && $rating <= 5) {
        $updateResult = $alumni->updateAlumniRating($alumniId, $rating);

        if ($updateResult !== false) {
            $successMessage = "Alumni rating updated successfully!";
        } else {
            $errorMessage = "An error occurred while updating the rating.";
        }
    } else {
        $errorMessage = "Please fill in all fields correctly.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Rate Alumni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #16406d;">

<?php include 'headerStudent.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-lg rounded-4">
        <div class="card-body p-4">
            <h2 class="text-center mb-4">Rate Alumni</h2>

            <?php if ($successMessage): ?>
                <div class="alert alert-success"><?= $successMessage ?></div>
            <?php elseif ($errorMessage): ?>
                <div class="alert alert-danger"><?= $errorMessage ?></div>
            <?php endif; ?>

            <form method="POST" action="">
            <div class="mb-3">
                <label for="alumniId" class="form-label">Alumni Name</label>
                <select class="form-select" id="alumniId" name="alumniId" required>
                    <option value="" disabled selected>Select alumni</option>
                    <?php if (!empty($alumnis)): ?>
                        <?php foreach ($alumnis as $alumni): ?>
                            <option value="<?= $alumni['id'] ?>"><?= htmlspecialchars($alumni['name']) ?></option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option disabled>No alumni found</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <select class="form-select" id="rating" name="rating" required>
                    <option value="" disabled selected>Select rating</option>
                    <option value="5">5</option>
                    <option value="4">4</option>
                    <option value="3">3</option>
                    <option value="2">2</option>
                    <option value="1">1</option>
                    <option value="0">0</option>

                </select>
            </div>

            

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill">Submit Rating</button>
            </div>
            </form>
        </div>
        </div>
    </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
