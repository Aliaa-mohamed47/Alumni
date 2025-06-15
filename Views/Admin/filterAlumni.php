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

    $sortOrder = isset($_POST['sortOrder']) ? $_POST['sortOrder'] : 'desc';

    $alumniController = new AlumniControler();
    $alumniList = $alumniController->getAlumniByRating($sortOrder);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Filter Alumni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../assets/images/alumni-removebg-preview.png" />
    <script src="../assets/js/modernizer.js"></script>
</head>
<body style="background-color: #16406d;">
    <?php include 'headerAdmin.php'; ?>

    <div class="container">
        <h2 class="mb-4 text-center" style="color: white; padding-top: 70px; font-size: 30px;">Filter Alumni by Student Rating</h2>

        <div class="row justify-content-center mb-4">
            <div class="col-md-6">
                <form method="Post" action="#">
                    <div class="input-group">
                        <label class="input-group-text" for="sortOrder">Sort by:</label>
                        <select class="form-select" id="sortOrder" name="sortOrder">
                            <option value="desc" <?php echo $sortOrder === 'desc' ? 'selected' : ''; ?>>Highest Rating</option>
                            <option value="asc" <?php echo $sortOrder === 'asc' ? 'selected' : ''; ?>>Lowest Rating</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="container mb-5">
            <?php if ($alumniList): ?>
                <div class="row justify-content-center">
                    <?php foreach ($alumniList as $alumni): ?>
                        <div class="col-md-8 mb-4">
                            <div class="card shadow rounded p-3">
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size: 16px;"><?php echo htmlspecialchars($alumni['name']); ?></h5>
                                    <p class="card-text" style="font-size: 16px;">Email: <?php echo htmlspecialchars($alumni['email']); ?></p>
                                    <p class="card-text" style="font-size: 16px;">Rating: <?php echo htmlspecialchars($alumni['rating']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-center text-white">No alumni found matching the selected criteria.</p>
            <?php endif; ?>
        </div>


    </div>
</body>
</html>
