<?php
    session_start();

    if (!isset($_SESSION["userRole"]) || $_SESSION["userRole"] !== "admin") {
        header("location: ../Auth/login.php");
        exit();
    }

    require_once '../../Controlers/EventControler.php';

    $eventController = new EventControler();

    if (!isset($_GET['id'])) {
        header("Location: manageEvents.php");
        exit();
    }

    $eventId = intval($_GET['id']);
    $event = $eventController->getEventById($eventId);

    if (!$event) {
        $_SESSION['errMsg'] = "Event not found.";
        header("Location: manageEvents.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $date = $_POST['date'];
        $location = $_POST['location'];

        if ($eventController->editEvent($eventId, $title, $description, $date, $location)) {
            $_SESSION['successMsg'] = "Event updated successfully!";
        } else {
            $_SESSION['errMsg'] = "Failed to update event.";
        }
        header("Location: manageEvents.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #16406d;">

<?php include 'headerAdmin.php'; ?>

<div class="container py-5">
    <h2 class="mb-4 text-center text-white">Edit Mentorship</h2>

    <form method="post" class="bg-light p-4 rounded">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($event['title']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($event['date']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($event['location']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($event['description']) ?></textarea>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="manageEvents.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
