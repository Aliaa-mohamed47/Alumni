<?php 
session_start();
require_once '../../Controlers/DBControler.php';
require_once '../../Models/UserFactory.php';
require_once '../../Models/alumni.php';

if (!isset($_SESSION["userRole"]) || $_SESSION["userRole"] !== "alumni") {
    header("location: ../Auth/login.php");
    exit();
}

$alumniId = $_SESSION['userId'];

$db = new DBControler();
$notifications = [];

if ($db->openConnection()) {
    $conn = $db->getConnection();

    $stmt = mysqli_prepare($conn, "SELECT * FROM notifications WHERE alumni_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $alumniId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $notifications[] = $row;
    }

    $jobApplicationsQuery = "SELECT COUNT(*) AS total FROM jobs";
    $stmt = mysqli_prepare($conn, $jobApplicationsQuery);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $totalJobs = $row['total'];

    $upcomingEventsQuery = "SELECT COUNT(*) AS total FROM events WHERE date >= CURDATE()";
    $stmt = mysqli_prepare($conn, $upcomingEventsQuery);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $upcomingEventsCount = $row['total'];

    $jobApplicationsPendingQuery = "SELECT COUNT(*) AS total FROM jobs WHERE alumni_id = ? ";
    $stmt = mysqli_prepare($conn, $jobApplicationsPendingQuery);
    mysqli_stmt_bind_param($stmt, "i", $alumniId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $pendingApplications = $row['total'];

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alumni Dashboard</title>  

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
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

    <?php include 'headerAlumni.php'; ?>
    <?php include '../header.php'; ?>
    
    <div class="container py-5">
        <h2 class="mb-4">Welcome, <?= $_SESSION['userName']; ?>!</h2>

        <div class="card mb-4">
            <div class="card-header" style="background-color: #16406d; color:white">News & Announcements</div>
            <div class="card-body">
                <ul>
                    <li>New internship opportunities are available!</li>
                    <li>Graduation ceremony next month. Don't miss out!</li>
                    <li>Join the alumni webinar on AI this weekend.</li>
                </ul>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header" style="background-color: #16406d; color:white">Quick Access</div>
            <div class="card-body">
                <ul>
                    <li><a href="notification.php">View Job Opportunities</a></li>
                    <li><a href="profile\.php">Update Your Profile</a></li>
                    <li><a href="registerEvent.php">Register for Mentorship</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card stats-card">
                    <div class="card-header" style="background-color: #16406d; color:white">Total Job Opportunities</div>
                    <div class="card-body">
                        <p><?= $totalJobs ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card stats-card">
                    <div class="card-header" style="background-color: #16406d; color:white">Upcoming Events</div>
                    <div class="card-body">
                        <p><?= $upcomingEventsCount ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card stats-card">
                    <div class="card-header" style="background-color: #16406d; color:white">Your Applications</div>
                    <div class="card-body">
                        <p><?= $pendingApplications ?> Pending</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header" style="background-color: #16406d; color:white">Upcoming Events</div>
            <div class="card-body">
                <ul>
                    <li>Alumni Networking Event – June 15, 2025</li>
                    <li>Webinar: The Future of AI – May 10, 2025</li>
                    <li>Workshop: Career Development – April 30, 2025</li>
                </ul>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header" style="background-color: #16406d; color:white">Need Help?</div>
            <div class="card-body">
                <p>If you're having trouble, please visit our <a href="#">Support Center</a> or <a href="contactAdmin.php">Contact Us</a>.</p>
            </div>
        </div>

    </div>


<?php if (!empty($notifications)) : ?>
    <div class="position-fixed top-0 end-0 m-3">
        <div class="card" style="width: 300px;">
            <div class="card-header text-white" style="background-color: #16406d;">
                <strong>New Notifications</strong>
            </div>
            <ul class="list-group list-group-flush">
                <?php foreach ($notifications as $notification) : ?>
                    <li class="list-group-item">
                        <div class="alert alert-info mb-0">
                            <?php echo $notification['message']; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php else : ?>
    <div class="position-fixed top-0 end-0 m-3">
        <div class="alert alert-warning" role="alert">
            No new notifications.
        </div>
    </div>
<?php endif; ?>


    <?php include '../footer.php'; ?>

    <script src="../assets/js/all.js"></script>
    <script src="../assets/js/custom.js"></script>
</body>
</html>
