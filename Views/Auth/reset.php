<?php
require_once '../../Controlers/DBControler.php';

$email = $_GET['email'] ?? '';
$token = $_GET['token'] ?? '';
$role = $_GET['role'] ?? '';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['password'];
    $db = new DBControler();
    if ($db->openConnection()) {
        $conn = $db->getConnection();
        $table = $role === 'student' ? 'students' : 'alumnis';

        $check = mysqli_prepare($conn, "SELECT * FROM $table WHERE email = ? AND reset_token = ?");
        mysqli_stmt_bind_param($check, "ss", $email, $token);
        mysqli_stmt_execute($check);
        $result = mysqli_stmt_get_result($check);

        if (mysqli_fetch_assoc($result)) {
            $update = mysqli_prepare($conn, "UPDATE $table SET password = ?, reset_token = NULL WHERE email = ?");
            mysqli_stmt_bind_param($update, "ss", $new_password, $email);
            mysqli_stmt_execute($update);
            $message = "<span class='text-success'>Password has been reset. <a href='login.php'>Login now</a></span>";
        } else {
            $message = "<span class='text-danger'>Invalid or expired token.</span>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
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
<body style="background-color: #16406d;">

<div class="card">
    <h4 class="text-center mb-3">Reset Password</h4>
    <form method="POST">
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="New password" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Reset Password</button>
    </form>

    <?php if ($message): ?>
        <div class="mt-3 text-center">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
