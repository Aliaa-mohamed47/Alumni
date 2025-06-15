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
	<!-- Start header -->
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
						<!-- <li class="nav-item"><a class="nav-link" href="about.php">Donate online</a></li> -->
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown">Profile</a>
							<div class="dropdown-menu" aria-labelledby="dropdown-a">
							<a class="dropdown-item" href="notification.php">My Notification</a>
								<a class="dropdown-item" href="profile.php">View/Edit Profile</a> </a>
								<a class="dropdown-item" href="https://flowcv.io/" target="_blank">Generate CV</a>

								</div>

						</li>
                        <li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown">Mentorship</a>
							<div class="dropdown-menu" aria-labelledby="dropdown-a">
								<a class="dropdown-item" href="registerEvent.php">Register</a>
							</div>
						</li>

                        <li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown">Community</a>
							<div class="dropdown-menu" aria-labelledby="dropdown-a">
								<a class="dropdown-item" href="searchAlumni.php">Search Alumni</a>
                                <a class="dropdown-item" href="contactAdmin.php">contact Admin</a>
							</div>
						</li>
                        
                        <li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown">Donations</a>
							<div class="dropdown-menu" aria-labelledby="dropdown-a">
								<a class="dropdown-item" href="donate.php">Donate(Fawry)</a>
							</div>
						</li>

                        <li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown">help</a>
							<div class="dropdown-menu" aria-labelledby="dropdown-a">
                                <a class="dropdown-item" href="contactAdmin.php">contact Admin</a>
								<a class="dropdown-item" href="feedback.php">Send Feedback</a>
							</div>
						</li>

                        <li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown-a" data-toggle="dropdown">Account</a>
							<div class="dropdown-menu" aria-labelledby="dropdown-a">
                                <a class="dropdown-item" href="../Auth/login.php">Login</a>
                                <a class="dropdown-item" href="../Auth/register.php">Register</a>
                                <a class="dropdown-item" href="../Auth/update.php">Update Password</a>
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

            <!-- ALL JS FILES -->
    <script src="../assets/js/all.js"></script>
    <!-- ALL PLUGINS -->
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