<?php 
session_start();

if (!isset($_SESSION["userRole"])) {
    header("location: ../Auth/login.php");
    exit();
}

$allowedRole = "admin";
if ($_SESSION["userRole"] !== $allowedRole) {
    header("location: ../Auth/login.php");
    exit();
}

require_once("../../Controlers/DBControler.php");

$db = new DBControler();
if (!$db->openConnection()) {
    die("database connection failed");
}

$alumniCountQuery = "SELECT COUNT(*) AS total FROM alumnis";
$alumniData = $db->select($alumniCountQuery);
$alumniCount = $alumniData[0]['total'];

$donationQuery = "SELECT SUM(amount) AS total FROM donations";
$donationData = $db->select($donationQuery);
$totalDonation = $donationData[0]['total'] ?? 0;

$jobsQuery = "SELECT COUNT(*) AS total FROM jobs";
$jobsData = $db->select($jobsQuery);
$jobCount = $jobsData[0]['total'];

$eventsQuery = "SELECT COUNT(*) AS total FROM events";
$eventsData = $db->select($eventsQuery);
$eventCount = $eventsData[0]['total'];

$latestAlumniQuery = "SELECT name FROM alumnis ORDER BY id DESC LIMIT 2";
$latestAlumniResult = $db->select($latestAlumniQuery);

$latestDonationQuery = "SELECT amount FROM donations ORDER BY id DESC LIMIT 2";
$latestDonationResult = $db->select($latestDonationQuery);

$db->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="../assets/images/alumni-removebg-preview.png" type="x-icon">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/versions.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <script src="../assets/js/modernizer.js"></script>

    <title>Admin Dashboard</title>
</head>

<body class="host_version">

    <div id="preloader">
        <div class="loader-container">
            <div class="progress-br float shadow">
                <div class="progress__item"></div>
            </div>
        </div>
    </div>

    <?php include 'headerAdmin.php'; ?>
    <?php include '../header.php'; ?>

    <div class="container my-5">
        <h2 class="mb-4">Admin Dashboard</h2>

        <div class="row mb-4" style="color: white;">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body" style="background-color: #16406d;">
                        <h5 class="card-title" style="color: white;">Number of Alumni</h5>
                        <p class="card-text"><?php echo $alumniCount; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body" style="background-color: #16406d;">
                        <h5 class="card-title" style="color: white;">Total Donation</h5>
                        <p class="card-text"><?php echo $totalDonation; ?> EGP</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body" style="background-color: #16406d;">
                        <h5 class="card-title" style="color: white;">Number of Events</h5>
                        <p class="card-text"><?php echo $eventCount; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body" style="background-color: #16406d;">
                        <h5 class="card-title" style="color: white;">Number of Job Opportunities</h5>
                        <p class="card-text"><?php echo $jobCount; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Recent Donation</div>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($latestDonationResult as $row) { ?>
                            <li class="list-group-item"><?php echo $row['amount']; ?> EGP</li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Latest Alumni</div>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($latestAlumniResult as $row) { ?>
                            <li class="list-group-item"><?php echo $row['name']; ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h4>Quick Actions</h4>
            <a href="addUser.php" class="btn btn-outline-primary m-2" style="background-color: #16406d;">Add Alumni</a>
            <a href="jobs.php" class="btn btn-outline-primary m-2" style="background-color: #16406d;">Post Job Opportunity</a>
            <a href="manageEvents.php" class="btn btn-outline-primary m-2" style="background-color: #16406d;">Create Mentorship</a>
        </div>
    </div>

    <?php include '../footer.php'; ?>

    <script src="../assets/js/all.js"></script>
    <script src="../assets/js/custom.js"></script>
    <script src="../assets/js/timeline.min.js"></script>
    <script>
        timeline(document.querySelectorAll('.timeline'), {
            forceVerticalMode: 700,
            mode: 'horizontal',
            verticalStartPosition: 'left',
            visibleItems: 4
        });

        function confirmLogout() {
            const userConfirmed = confirm("Are you sure you want to log out?");
            if (userConfirmed) {
                window.location.href = "../Auth/logout.php";
            }
        }
    </script>

</body>
</html>
