<?php 
session_start();
require_once '../../Controlers/DBControler.php';  // تأكد من مسار ملف الاتصال بالقاعدة

if (!isset($_SESSION["userRole"])) {
    header("location: ../Auth/login.php");
    exit();
}

$allowedRole = "student";
if ($_SESSION["userRole"] !== $allowedRole) {
    header("location: ../Auth/login.php");
    exit();
}

$studentId = $_SESSION['userId'];  // نفترض أن المستخدم متصل (studentId موجود في الجلسة)

$db = new DBControler();

if ($db->openConnection()) {
    // جلب بيانات الطالب باستخدام DBControler
    $query = "SELECT * FROM students WHERE id = ?";
    $params = [$studentId];
    $studentResult = $db->selectt($query, $params);
    $student = $studentResult->fetch_assoc(); // افترض أن نتيجة الاستعلام هي صف واحد

    // جلب الأحداث التي يشارك فيها الطالب
    $eventsQuery = "SELECT e.title, e.date FROM events e JOIN event_attendance ea ON e.id = ea.event_id WHERE ea.student_id = ?";
    $eventsResult = $db->selectt($eventsQuery, $params);
    $events = [];
    while ($row = $eventsResult->fetch_assoc()) {
        $events[] = $row;
    }

    // إغلاق الاتصال بعد العمل
    $db->closeConnection();
} else {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Dashboard</title>  
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/versions.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <script src="../assets/js/modernizer.js"></script>
</head>
<body class="host_version">
    <div id="preloader">
        <div class="loader-container">
            <div class="progress-br float shadow">
                <div class="progress__item"></div>
            </div>
        </div>
    </div>

    <?php include 'headerStudent.php'; ?>
    <?php include '../header.php'; ?>

    <section class="py-5 text-center bg-light">
        <div class="container">
            <h1 class="display-5 fw-bold">Welcome to the Student Portal</h1>
            <p class="lead text-muted">Hello, <?php echo htmlspecialchars($student['name']); ?>! Here you can participate in Mentorships, generate your CV, give feedback, and connect with alumni!</p>
        </div>
    </section>

    <!-- Feature Cards -->
    <section class="py-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title" style="font-size: 20px;">Generate CV</h5>
                            <p class="card-text">Easily generate your professional CV with just a few clicks.</p>
                            <a href="https://flowcv.io/" class="btn btn-outline-primary" style="background-color: #16406d;">Go</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title" style="font-size: 20px;">Participate in Mentorships</h5>
                            <p class="card-text">Stay updated and participate in university Mentorships.</p>
                            <a href="registerEvent.php" class="btn btn-outline-primary" style="background-color: #16406d;">View Events</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title" style="font-size: 20px;">Feedback & Rating</h5>
                            <p class="card-text">Give your feedback and rate alumni for their support.</p>
                            <a href="feedback.php" class="btn btn-outline-primary" style="background-color: #16406d;">Send Feedback</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4">
        <div class="container">
            <h3>Upcoming Events</h3>
            <ul>
                <?php foreach ($events as $event): ?>
                    <li><?php echo htmlspecialchars($event['title']); ?> - <?php echo htmlspecialchars($event['date']); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <?php include '../footer.php'; ?>

    <script src="../assets/js/all.js"></script>
    <script src="../assets/js/custom.js"></script>
</body>
</html>
