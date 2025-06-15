<?php
require_once '../../Controlers/DBControler.php';

$linkMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $role = $_POST['role'];

    $db = new DBControler();
    if ($db->openConnection()) {
        $conn = $db->getConnection();
        $table = $role === 'student' ? 'students' : 'alumnis';

        $token = bin2hex(random_bytes(16)); // رمز عشوائي
        $query = mysqli_prepare($conn, "UPDATE $table SET reset_token = ? WHERE email = ?");
        mysqli_stmt_bind_param($query, "ss", $token, $email);
        mysqli_stmt_execute($query);

        if (mysqli_stmt_affected_rows($query) > 0) {
            $resetLink = "http://localhost/Alumni/Views/Auth/reset.php?email=$email&role=$role&token=$token";
            $linkMessage = "<a href='$resetLink' class='btn btn-success mt-3'>Enter To Reset Password</a>";
        } else {
            $linkMessage = "<span class='text-danger mt-3'>Email not found.</span>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forget Password</title>
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
    <h4 class="text-center mb-3">Forgot Password</h4>
    <form method="POST">
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Your email" required>
        </div>
        <div class="mb-3">
            <select name="role" class="form-select" required>
                <option value="student">Student</option>
                <option value="alumni">Alumni</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
    </form>

    <?php if ($linkMessage): ?>
        <div class="mt-3 text-center">
            <?php echo $linkMessage; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
