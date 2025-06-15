<?php
session_start();
require_once '../../Controlers/AlumniControler.php';

if (!isset($_SESSION["userRole"]) || $_SESSION["userRole"] !== "student") {
    header("location: ../Auth/login.php");
    exit();
}

$alumniControler = new AlumniControler();
$alumniList = $alumniControler->getAllAlumnis();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>All Alumni</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #16406d;">

<?php include 'headerStudent.php'; ?>

<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="contactModalLabel">Contact Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <span id="contactPhone"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="container mt-5">
  <h2 class="mb-4 text-center" style="color: white;">All Alumni</h2>

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
          <th>Contact</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($alumniList)): ?>
          <?php foreach ($alumniList as $index => $alumni): ?>
            <tr>
              <td><?= $index + 1 ?></td>
              <td><?= htmlspecialchars($alumni['name']) ?></td>
              <td><?= htmlspecialchars($alumni['email']) ?></td>
              <td><?= htmlspecialchars($alumni['graduation_year']) ?></td>
              <td><?= htmlspecialchars($alumni['department']) ?></td>
              <td><?= htmlspecialchars($alumni['job_title']) ?></td>
              <td>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contactModal" onclick="setContactPhone('<?= htmlspecialchars($alumni['phone']) ?>')">Contact</button>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="text-center">No alumni found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  function setContactPhone(phone) {
    document.getElementById('contactPhone').innerText = 'Phone: ' + phone;
  }
</script>

</body>
</html>
