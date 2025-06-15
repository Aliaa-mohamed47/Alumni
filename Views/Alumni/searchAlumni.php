<?php 
  session_start();
  require_once '../../Controlers/AlumniControler.php';

  if (!isset($_SESSION["userRole"])) {
      header("location: ../Auth/login.php");
      exit();
  }

  $allowedRole = "alumni";
  if ($_SESSION["userRole"] !== $allowedRole) {
      header("location: ../Auth/login.php");
      exit();
  }

  $alumniControler = new AlumniControler();

  $searchTerm = "";
  $alumniResults = [];

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $searchTerm = $_POST['searchTerm'] ?? "";

      $alumniResults = $alumniControler->searchAlumni($searchTerm);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Search Alumni</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Site Icons -->
  <link rel="shortcut icon" href="../assets/images/alumni-removebg-preview.png" type="x-icon">
</head>
<body style="background-color: #16406d;">

<?php include 'headerAlumni.php'; ?>

  <div class="container mt-5">
    <h2 class="mb-4 text-center" style="color: white;">Search Alumni</h2>

    <!-- Search Form -->
    <form class="row g-3 mb-4" method="POST">
      <div class="col-md-4">
        <input type="text" class="form-control" name="searchTerm" placeholder="Search by Name or Email" value="<?= htmlspecialchars($searchTerm) ?>">
      </div>
      <div class="col-md-4">
        <button type="submit" class="btn btn-primary w-100">Search</button>
      </div>
    </form>

    <!-- Results Table -->
    <div class="table-responsive">
      <table class="table table-bordered text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Graduation Year</th>
            <th>Department</th>
            <th>Job Title</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($alumniResults)): ?>
            <?php foreach ($alumniResults as $index => $alumni): ?>
              <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($alumni['name']) ?></td>
                <td><?= htmlspecialchars($alumni['email']) ?></td>
                <td><?= htmlspecialchars($alumni['graduation_year']) ?></td>
                <td><?= htmlspecialchars($alumni['department']) ?></td>
                <td><?= htmlspecialchars($alumni['job_title']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center">No alumni found matching your search.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
