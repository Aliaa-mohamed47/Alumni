<?php
session_start();

require_once '../../Models/admin.php';
require_once '../../Models/alumni.php';
require_once '../../Models/student.php';
require_once '../../Controlers/DBControler.php';
require_once '../../Controlers/UserControler.php';

if (!isset($_SESSION["userRole"])) {
    header("location: ../Auth/login.php");
    exit();
}

$userRole = $_SESSION["userRole"];
$userId = $_SESSION["userId"];

$userController = new UserControler;

$user = $userController->getUserProfile($userId, $userRole);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $department = ($userRole === 'alumni') ? $_POST['major'] : null; 
    $jobTitle = isset($_POST['jobs']) ? $_POST['jobs'] : $user['job_title'];

    if ($userController->updateUserProfile($userId, $fullName, $email, $department, $jobTitle, $userRole)) {
        $message = "Profile updated successfully!";
        $user = $userController->getUserProfile($userId, $userRole);
    } else {
        $message = "Failed to update profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View/Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #16406d;"> 

<?php include 'headerAlumni.php'; ?>

<div class="container py-5" style="color: white;">
    <h2 class="mb-4" style="color: white;">View / Edit Profile</h2>

    <?php if (isset($message)): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" name="fullName" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Sex</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['sex']); ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Graduation Year</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['graduation_year']); ?>" readonly>
        </div>

		<?php if ($userRole === 'alumni'): ?>
			<div class="mb-3">
				<label class="form-label">Department</label>
				<select class="form-control" name="major" required>
					<option value="CS" <?php echo isset($user['major']) && $user['major'] == 'CS' ? 'selected' : ''; ?>>CS</option>
					<option value="AI" <?php echo isset($user['major']) && $user['major'] == 'AI' ? 'selected' : ''; ?>>AI</option>
					<option value="IS" <?php echo isset($user['major']) && $user['major'] == 'IS' ? 'selected' : ''; ?>>IS</option>
					<option value="IT" <?php echo isset($user['major']) && $user['major'] == 'IT' ? 'selected' : ''; ?>>IT</option>
				</select>
			</div>
		<?php endif; ?>


        <?php if ($userRole === 'alumni'): ?>
            <div class="mb-3">
                <label class="form-label">Job Title</label>
                <input type="text" class="form-control" name="jobs" value="<?php echo htmlspecialchars($user['job_title']); ?>" required>
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label class="form-label">Rating</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['rating']); ?>" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>