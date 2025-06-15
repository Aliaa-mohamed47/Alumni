<?php
session_start();
require_once '../../Controlers/DBControler.php';
require_once '../../Controlers/DonationControler.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $donorName = $_POST['donorName'];
    $email = $_POST['email'];
    $amount = $_POST['amount'];

    if (empty($amount)) {
        $message = "Error: Missing donation amount.";
    } else {
        $alumniController = new DonationControler();
        $result = $alumniController->donate($donorName, $email, $amount);

        if ($result["status"] === "success") {
            $message = "Donation recorded successfully.";
        } else {
            $message = "Donation failed: " . $result["message"];
        }
    }
}

if (isset($_SESSION["userId"])) {
    $alumniId = $_SESSION["userId"];

    $db = new DBControler();

    if ($db->openConnection()) {
        $conn = $db->getConnection();
        $sql = "SELECT name, email FROM alumnis WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $alumniId);
        $stmt->execute();
        $stmt->bind_result($donorName, $email);
        $stmt->fetch();
        $stmt->close();
    } else {
        die("Error: Could not connect to database.");
    }
} else {
    die("Error: Alumni not logged in.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Donate via Fawry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/images/alumni-removebg-preview.png" type="x-icon">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background-color: #f4f4f4;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #16406d;
            font-size: 1.5rem;
        }

        .card-body {
            background-color: white;
            padding: 30px;
        }
    </style>
</head>

<body style="background-color: #16406d;">
    <?php include 'headerAlumni.php'; ?>

    <div class="container" style="padding-top: 30px;">
        <div class="card shadow">
            <div class="card-header text-white" style="background-color: #16406d;">
                <h4 class="mb-0" style="font-size: 25px;color: white;">Donate to Support Our Alumni Community</h4>
            </div>
            <div class="card-body">
                <?php if ($message): ?>
                    <div class="alert alert-info"><?php echo $message; ?></div>
                <?php endif; ?>

                <form method="POST" action="donate.php">
                    <div class="mb-3">
                        <label for="donorName" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="donorName" name="donorName" value="<?php echo htmlspecialchars($donorName); ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label">Donation Amount (EGP)</label>
                        <input type="number" class="form-control" id="amount" name="amount" min="5" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Donate via Fawry</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
