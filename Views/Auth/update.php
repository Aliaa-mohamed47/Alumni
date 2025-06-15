<?php
session_start();
require_once '../../Controlers/AuthControler.php';
require_once '../../Controlers/UserControler.php';
require_once '../../Controlers/DBControler.php';

$message = '';

if (!isset($_SESSION["userId"]) || !isset($_SESSION["userRole"])) {
    header("Location: ../Auth/login.php");
    exit();
}

$userId = $_SESSION['userId'];
$userRole = $_SESSION['userRole'];

$userControler = new UserControler();
$userProfile = $userControler->getUserProfile($userId, $userRole);
$email = $userProfile['email'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];

    if ($oldPassword && $newPassword && $email && $userRole) {
        $db = new DBControler();
        $auth = new AuthControler();
        if ($db->openConnection()) {
            $updateSuccess = $auth->updatePassword($email, $oldPassword, $newPassword, $userRole);

            if ($updateSuccess) {
                $message = "<span class='text-success'>Password updated successfully.</span>";
            } else {
                $message = "<span class='text-danger'>Incorrect old password or update failed.</span>";
            }
        }
    } else {
        $message = "<span class='text-danger'>Please fill in all fields.</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #16406d;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="card">
    <h4 class="text-center mb-3">Update Password</h4>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Your Email</label>
            <input type="email" class="form-control" value="<?= htmlspecialchars($email) ?>" readonly>
        </div>
        <div class="mb-3">
            <input type="password" name="old_password" class="form-control" placeholder="Old Password" required>
        </div>
        <div class="mb-3">
            <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
        </div>
        <!-- الدور هنا نأخذه من السيشن ونرسله كـ hidden -->
        <input type="hidden" name="role" value="<?= htmlspecialchars($userRole) ?>">
        <button type="submit" class="btn btn-primary w-100">Update Password</button>
    </form>

    <?php if ($message): ?>
        <div class="mt-3 text-center">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
