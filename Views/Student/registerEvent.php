<?php 
session_start();

if (!isset($_SESSION["userRole"])) {
    header("location: ../Auth/login.php");
    exit();
}

$allowedRole = "student";

if ($_SESSION["userRole"] !== $allowedRole) {
    header("location: ../Auth/login.php");
    exit();
}

require_once '../../Controlers/DBControler.php';
$db = new DBControler();
$db->openConnection();

$studentId = $_SESSION['userId'];
$student = $db->select("SELECT * FROM students WHERE id = '$studentId'");
if (!$student || count($student) == 0) {
    $_SESSION["errMsg"] = "Student not found!";
    header("Location: ../Auth/login.php");
    exit();
}
$student = $student[0];

$successMsg = '';
$errMsg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventId = $_POST['event'];

    if (empty($studentId) || empty($eventId)) {
        $errMsg = "All fields are required!";
    } else {
        $query = "INSERT INTO event_attendance (event_id, student_id, attended) 
                  VALUES ('$eventId', '$studentId', 'pending')";

        if ($db->insert($query)) {
            $successMsg = "You have successfully registered for the event!";
        } else {
            $errMsg = "Error registering for the event.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register for an Event</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

<?php include 'headerStudent.php'; ?>

<div class="container" style="padding-top: 30px;">
    <?php if ($successMsg): ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($successMsg); ?>
        </div>
    <?php endif; ?>

    <?php if ($errMsg): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($errMsg); ?>
        </div>
    <?php endif; ?>

    <div class="card shadow">
      <div class="card-header text-white" style="background-color: #16406d;">
        <h4 class="mb-0" style="color: white; padding-top: 15px; font-size: 25px;">Register for an Mentorship</h4>
      </div>
      <div class="card-body">
        <form method="POST" action="registerEvent.php">
          <div class="mb-3">
            <label for="fullName" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullName" value="<?= htmlspecialchars($student['name']); ?>" disabled>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" value="<?= htmlspecialchars($student['email']); ?>" disabled>
          </div>

          <div class="mb-3">
            <label for="event" class="form-label">Select Mentorship</label>
            <select class="form-select" id="event" name="event" required>
              <option selected disabled value="">Choose an Mentorship...</option>
              <?php
              $events = $db->select("SELECT * FROM events");
              foreach ($events as $event) {
                  echo "<option value='" . $event['id'] . "'>" . htmlspecialchars($event['title']) . "</option>";
              }
              ?>
            </select>
          </div>

          <button type="submit" class="btn btn-primary w-100">Register for Mentorship</button>
        </form>
      </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
