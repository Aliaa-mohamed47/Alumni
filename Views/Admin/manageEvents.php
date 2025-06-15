<?php 
    session_start();

    if (!isset($_SESSION["userRole"]) || $_SESSION["userRole"] !== "admin") {
        header("location: ../Auth/login.php");
        exit();
    }

    require_once '../../Controlers/EventControler.php';

    $event = new EventControler();

    if (isset($_GET['delete'])) {
        $eventId = intval($_GET['delete']);
        $event->deleteEvent($eventId);
        header("Location: manageEvents.php");
        exit();
    }

    $events = $event->getAllEvents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #16406d;">

<?php include 'headerAdmin.php'; ?>

<div class="container py-5">
    <h2 class="mb-4 text-center text-white">Manage Mentorships</h2>

    <div class="d-flex justify-content-end mb-3">
        <a href="addEvent.php" class="btn btn-primary">Add New Mentorship</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Mentorship Name</th>
            <th>Date</th>
            <th>Location</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($events) > 0): ?>
            <?php foreach ($events as $index => $event): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($event['title']) ?></td>
                    <td><?= htmlspecialchars($event['date']) ?></td>
                    <td><?= htmlspecialchars($event['location']) ?></td>
                    <td>
                        <a href="editEvent.php?id=<?= $event['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="manageEvents.php?delete=<?= $event['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center">No Mentorships found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
