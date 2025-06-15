<?php
session_start();

if (!isset($_SESSION["userRole"]) || $_SESSION["userRole"] !== "admin") {
    header("location: ../Auth/login.php");
    exit();
}

require_once '../../Controlers/EventControler.php';
$adminControler = new EventControler();

$eventId = 1; // هنا يتم تحديد event_id
$eventSpeakers = $adminControler->getEventSpeakersWithAttendance($eventId);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['attendance_id'])) {
    $attendanceId = $_POST['attendance_id'];
    $newStatus = $_POST['new_status'];
    
    // تحديث حالة الحضور
    $adminControler->updateAttendanceStatus($attendanceId, $newStatus);
    
    $_SESSION['successMsg'] = "The attendance status has been updated successfully!";
    header("Location: checkAttendance.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../assets/images/alumni-removebg-preview.png" />
    <script src="../assets/js/modernizer.js"></script>
</head>
<body style="background-color: #16406d;">
    <?php include 'headerAdmin.php'; ?>

    <div class="container mt-5">
        <h2 class="mb-4 text-center" style="color: white;">Check Attendance - Alumni Meetup 2025</h2>

        <?php if (isset($_SESSION['successMsg'])): ?>
            <div class="alert alert-success"><?= $_SESSION['successMsg']; ?></div>
            <?php unset($_SESSION['successMsg']); ?>
        <?php endif; ?>

        <form method="POST">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Participant Name</th>
                        <th>Email</th>
                        <th>Speaker Status</th>
                        <th>Attendance Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($eventSpeakers as $index => $speaker): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($speaker['alumni_name']) ?></td>
                            <td><?= htmlspecialchars($speaker['alumni_email']) ?></td>
                            <td><?= htmlspecialchars($speaker['speaker_status']) ?></td>
                            <td><?= htmlspecialchars($speaker['attended']) ?></td>
                            <td>
                                <!-- زر لتغيير حالة الحضور -->
                                <?php if ($speaker['attended'] == 'not attended'): ?>
                                    <button type="submit" name="event_id" value="<?= $speaker['event_id'] ?>" 
                                            name="alumni_id" value="<?= $speaker['alumni_id'] ?>" 
                                            class="btn btn-success" 
                                            onclick="this.form.new_status.value='attended';">Mark as Attended</button>
                                <?php else: ?>
                                    <button type="submit" name="event_id" value="<?= $speaker['event_id'] ?>" 
                                            name="alumni_id" value="<?= $speaker['alumni_id'] ?>" 
                                            class="btn btn-danger" 
                                            onclick="this.form.new_status.value='not attended';">Mark as Not Attended</button>
                                <?php endif; ?>
                                <input type="hidden" name="new_status" value=""/>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['event_id']) && isset($_POST['alumni_id'])) {
        $eventId = $_POST['event_id'];
        $alumniId = $_POST['alumni_id'];
        $newStatus = $_POST['new_status'];
        
        // تحديث حالة الحضور باستخدام event_id و alumni_id
        $adminControler->updateAttendanceStatus($eventId, $alumniId, $newStatus);
        
        $_SESSION['successMsg'] = "Attendance status updated successfully!";
        header("Location: checkAttendance.php");
        exit();
    }
    ?>

</body>
</html>
