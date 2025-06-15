<?php
session_start();

if (!isset($_SESSION["userRole"]) || $_SESSION["userRole"] !== "admin") {
    header("location: ../Auth/login.php");
    exit();
}

require_once '../../Controlers/DBControler.php';
require_once '../../Controlers/EventControler.php';

$db = new DBControler();
$db->openConnection();
$admin = new EventControler($db);
$speakers = $db->select("SELECT es.id, a.name, a.rating, e.title as event_title, es.speaker_status 
                    FROM event_speakers es
                    JOIN alumnis a ON es.alumni_id = a.id
                    JOIN events e ON es.event_id = e.id
                    ORDER BY a.rating DESC");

if (isset($_GET['confirm'])) {
    $speakerId = intval($_GET['confirm']);
    $admin->updateSpeakerStatus($speakerId);
    header("Location: manageSpeakers.php");
    exit();
}

if (isset($_GET['delete'])) {
    $speakerId = intval($_GET['delete']);
    $admin->deleteSpeaker($speakerId);
    header("Location: manageSpeakers.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Speakers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #16406d;">

<?php include 'headerAdmin.php'; ?>

<div class="container py-5">
    <h2 class="mb-4 text-center text-white">Manage Speakers</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Speaker Name</th>
                <th>Rating</th>
                <th>Mentorship Title</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($speakers) > 0): ?>
            <?php foreach ($speakers as $index => $speaker): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($speaker['name']) ?></td>
                    <td><?= htmlspecialchars($speaker['rating']) ?></td>
                    <td><?= htmlspecialchars($speaker['event_title']) ?></td>
                    <td id="status-<?= $speaker['id'] ?>"><?= htmlspecialchars($speaker['speaker_status']) ?></td>
                    <td>
                        <?php if ($speaker['speaker_status'] != 'confirmed'): ?>
                            <a href="manageSpeakers.php?confirm=<?= $speaker['id'] ?>" class="btn btn-sm btn-secondary">Confirm</a>
                        <?php else: ?>
                            <span class="badge bg-success">Confirmed</span>
                        <?php endif; ?>
                        <a href="manageSpeakers.php?delete=<?= $speaker['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this speaker?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" class="text-center">No speakers found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
