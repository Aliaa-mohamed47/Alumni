<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   

<!-- Mobile Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Site Metas -->
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
    <title>Document</title>
</head>
<body>
	<header class="top-navbar">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container-fluid">
				<a class="navbar-brand" href="index.php">
					<img src="../assets/images/alumni-removebg-preview.png" style="height: 80px; width: 80px;" alt="" />
                    <span style="color: white; font-size: 30px;">Alumni</span>
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-host" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
					<span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbars-host">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown" style="font-size: 13px;">Alumni Management</a>
							<div class="dropdown-menu" aria-labelledby="dropdown-a">
								<a class="dropdown-item" href="addUser.php">Add User </a>
								<a class="dropdown-item" href="deactiveAlumni.php">Deactive Alumni </a>
								<a class="dropdown-item" href="filterAlumni.php">Filter Alumni </a>
								<a class="dropdown-item" href="searchAlumni.php">Search Alumni</a>
								<a class="dropdown-item" href="rateAlumni.php">Rate Alumni</a>
							</div>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown" style="font-size: 13px;">Mentorships</a>
							<div class="dropdown-menu" aria-labelledby="dropdown-a">
								<a class="dropdown-item" href="manageEvents.php">Manage Mentorships </a>
								<a class="dropdown-item" href="checkAttendance.php">Check Attendance </a>
								<a class="dropdown-item" href="manageSpeakers.php">Manage Speakers</a>

							</div>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown" style="font-size: 13px;">Reports & Jobs</a>
							<div class="dropdown-menu" aria-labelledby="dropdown-a">
								<a class="dropdown-item" href="generateReports.php">Generate Reports </a>
								<a class="dropdown-item" href="jobs.php">Send Job Opportunities</a>
								<a class="dropdown-item" href="viewFeedback.php">View Feedback</a>

							</div>
						</li>

                        <li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown" style="font-size: 13px;">Donations & Integrations</a>
							<div class="dropdown-menu" aria-labelledby="dropdown-a">
								<a class="dropdown-item" href="fawry.php">Collect Donation (Fawry)</a>
							</div>
						</li>
                        
                        <li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown" style="font-size: 13px;">Authentication</a>
							<div class="dropdown-menu" aria-labelledby="dropdown-a">
							<a class="dropdown-item" href="../Auth/login.php">Login</a>
							<a class="dropdown-item" href="../Auth/loggedOut.php">Logout</a>
							</div>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
							</ul>
					</div>
				</div>
				</nav>
			</header>
			<!-- End header -->

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
	</script>
</body>
</html>