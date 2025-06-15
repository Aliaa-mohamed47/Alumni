<?php
session_start();

if (!isset($_SESSION["userRole"]) || $_SESSION["userRole"] !== "admin") {
    header("location: ../Auth/login.php");
    exit();
}

require_once '../../Controlers/EventControler.php';

$eventController = new EventControler();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $event_attendance = 0;

    $result = $eventController->addEvent($title, $description, $date, $location, $event_attendance);
    
    if ($result) {
        header("Location: manageEvents.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Event</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="../assets/images/alumni-removebg-preview.png" />
</head>
<body style="background-color: #16406d;">
<?php include 'headerAdmin.php'; ?>


  <div class="container py-5">
    <h2 class="mb-4 text-center" style="color: white;">Add New Mentorship</h2>

    <form method="POST" action="addEvent.php">
      <div class="mb-3">
        <label for="eventName" class="form-label" style="color: white;">Mentorship Name</label>
        <input type="text" name="title" class="form-control" id="eventName" placeholder="Enter event name" required>
      </div>

      <div class="mb-3">
        <label for="eventDate" class="form-label" style="color: white;">Date</label>
        <input type="date" name="date" class="form-control" id="eventDate" required>
      </div>

      <div class="mb-3">
        <label for="eventLocation" class="form-label" style="color: white;">Location</label>
        <input type="text" name="location" class="form-control" id="eventLocation" placeholder="Enter location" required>
      </div>

      <div class="mb-3">
        <label for="eventDescription" class="form-label" style="color: white;">Description</label>
        <textarea name="description" class="form-control" id="eventDescription" rows="3" placeholder="Enter event description" required></textarea>
      </div>

      <button type="submit" class="btn btn-success">Save Mentorship</button>
      <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
