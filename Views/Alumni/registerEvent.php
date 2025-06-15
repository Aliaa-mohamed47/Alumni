<?php
session_start();

if (!isset($_SESSION["userRole"]) || $_SESSION["userRole"] !== "alumni") {
    header("location: ../Auth/login.php");
    exit();
}

require_once '../../Controlers/DBControler.php';
$db = new DBControler();
$db->openConnection();

$alumniId = $_SESSION['userId'];
$alumni = $db->select("SELECT * FROM alumnis WHERE id = '$alumniId'");
if (!$alumni || count($alumni) == 0) {
    $_SESSION["errMsg"] = "Alumni not found!";
    header("Location: ../Auth/login.php");
    exit();
}
$alumni = $alumni[0];

$successMsg = '';
$errMsg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventId = $_POST['event'];

    if (empty($alumniId) || empty($eventId)) {
        $errMsg = "All fields are required!";
    } else {
        $query = "INSERT INTO event_speakers (event_id, alumni_id, speaker_status) 
                VALUES ('$eventId', '$alumniId', 'pending')";

        if ($db->insert($query)) {
            $successMsg = "You have successfully registered as a speaker!";
        } else {
            $errMsg = "Error registering as a speaker.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register as Speaker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #16406d;">

<?php include 'headerAlumni.php'; ?>

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
            <h4 class="mb-0" style="color: white; padding-top: 15px; font-size: 25px;">Register as a Speaker for an Mentorship</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="registerEvent.php">
                <div class="mb-3">
                    <label for="fullName" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullName" value="<?= htmlspecialchars($alumni['name']); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" value="<?= htmlspecialchars($alumni['email']); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="field" class="form-label">Department</label>
                    <input type="text" class="form-control" id="field" value="<?= htmlspecialchars($alumni['department']); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="event" class="form-label">Select Mentorship</label>
                    <select class="form-select" id="event" name="event" required>
                        <option selected disabled value="">Choose an Mentorship...</option>
                        <?php
                        $events = $db->select("SELECT * FROM events");
                        foreach ($events as $event) {
                            echo "<option value='" . $event['id'] . "'>" . htmlspecialchars($event['title']) . " - " . htmlspecialchars($event['date']) . " (" . htmlspecialchars($event['location']) . ")</option>";
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">Register as Speaker</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
