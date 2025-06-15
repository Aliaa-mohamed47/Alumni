<?php
session_start();
require_once '../../Controlers/DBControler.php';

if (!isset($_SESSION["userRole"]) || $_SESSION["userRole"] !== "alumni") {
    header("location: ../Auth/login.php");
    exit();
}

$alumniId = $_SESSION['userId'];

$db = new DBControler();
$notifications = [];

if ($db->openConnection()) {
    $conn = $db->getConnection();

    $stmt = mysqli_prepare($conn, "SELECT * FROM notifications WHERE alumni_id = ? ORDER BY created_at DESC");
    mysqli_stmt_bind_param($stmt, "i", $alumniId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $notifications[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Notifications</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #16406d;
            color: white;
            font-family: Arial, sans-serif;
        }
        .notification-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .notification-box {
            background-color: #ffffff;
            color: #000000;
            width: 80%;
            max-width: 600px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .notification-box .card-header {
            background-color: #16406d;
            color: white;
            font-weight: bold;
        }
        .alert-info {
            background-color: #e0f7fa;
            color: #00695c;
        }
        .alert-warning {
            background-color: #ffecb3;
            color: #ff9800;
        }
    </style>
</head>
<body>


<div class="notification-container">
    <div class="notification-box">
        <div class="card">
            <div class="card-header">
                New Notifications
            </div>
            <div class="card-body">
                <?php if (!empty($notifications)) : ?>
                    <ul class="list-group">
                        <?php foreach ($notifications as $notification) : ?>
                            <li class="list-group-item">
                                <div class="alert alert-info mb-0">
                                    <?php echo $notification['message']; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <div class="alert alert-warning" role="alert">
                        No new notifications.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
